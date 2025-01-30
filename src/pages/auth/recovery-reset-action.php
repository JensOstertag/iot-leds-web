<?php

// Check whether the user is already logged in
if(Auth::isLoggedIn()) {
    Comm::redirect(Router::generate("index"));
}

// Check whether a one-time password has been specified
$sessionValidation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "authRecoveryOtpId" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInteger::create()
        ]),
        "authRecoveryOtp" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(1)
        ])
    ], true)
])->setErrorMessage(t("An error has occurred. Please try again later."));
try {
    $session = $sessionValidation->getValidatedValue($_SESSION);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

$otpId = $session["authRecoveryOtpId"];
$otp = $session["authRecoveryOtp"];

// Clear old session variables
unset($_SESSION["authRecoveryOtpId"]);
unset($_SESSION["authRecoveryOtp"]);

// Generate redirect link for error cases
$otpIdEncoded = urlencode(base64_encode($otpId));
$otpEncoded = urlencode($otp);
$resetLink = Router::generate("auth-recovery-reset") . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;

// Find the user from the one-time password
$user = User::dao()->getObject([
    "id" => $otpId,
    "emailVerified" => true,
    [
        "field" => "oneTimePassword",
        "filterType" => DAOFilterType::NOT_EQUALS,
        "filterValue" => null
    ],
    [
        "field" => "oneTimePasswordExpiration",
        "filterType" => DAOFilterType::GREATER_THAN_EQUALS,
        "filterValue" => new DateTime()
    ]
]);
if(!$user instanceof User) {
    Logger::getLogger("Recovery")->info("Attempted to recover password, but couldn't find user with otpid \"{$otpId}\"");
    new InfoMessage(t("The URL has already been invalidated. Please log in or request a new password recovery email."), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}
if(!password_verify($otp, $user->getOneTimePassword())) {
    Logger::getLogger("Recovery")->info("Attempted to recover password, but one-time password does not match");
    new InfoMessage(t("The URL has already been invalidated. Please log in or request a new password recovery email."), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

// Check whether form fields are given
$postValidation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "password" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(8),
            \validation\MaxLength::create(256)
        ]),
        "password-repeat" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(8),
            \validation\MaxLength::create(256)
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $post = $postValidation->getValidatedValue($_POST);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect($resetLink);
}

// Check passwords
if($post["password"] !== $post["password-repeat"]) {
    new InfoMessage(t("The specified passwords do not match. Please check for spelling errors and try again."), InfoMessageType::ERROR);
    Comm::redirect($resetLink);
}
if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$/", $post["password"])) {
    new InfoMessage(t("The specified password doesn't fulfill the password requirements. Please choose a safer password."), InfoMessageType::ERROR);
    Comm::redirect($resetLink);
}

// Change password
$user->setPassword($post["password"]);
$user->setOneTimePassword(null);
$user->setOneTimePasswordExpiration(null);
$user->setUpdated(new DateTimeImmutable());
User::dao()->save($user);

Logger::getLogger("Recovery")->info("Changed password for user with email \"{$user->getEmail()}\" (User ID \"{$user->getId()}\")");

Comm::redirect(Router::generate("auth-recovery-reset-complete"));
