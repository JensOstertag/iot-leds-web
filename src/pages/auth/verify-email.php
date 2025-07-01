<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

// Check whether a one-time password has been specified
$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "otpid" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(1)
        ]),
        "otp" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(1)
        ])
    ])
])->setErrorMessage(t("An error has occurred. Please try again later."));
try {
    $get = $validation->getValidatedValue($_GET);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("auth-login"));
}

$otpId = base64_decode(urldecode($get["otpid"]));
$otp = urldecode($get["otp"]);

// Find the user from the one-time password
$user = User::dao()->getObject([
    "id" => $otpId,
    "emailVerified" => false,
    new \struktal\ORM\DAOFilter(
        \struktal\ORM\DAOFilterOperator::NOT_EQUALS,
        "oneTimePassword",
        null
    ),
    "oneTimePasswordExpiration" => null
]);
if(!$user instanceof User) {
    Logger::getLogger("Email-Verification")->info("Attempted to verify an email, but couldn't find user with otpid \"{$otpId}\"");
    new InfoMessage(t("The URL has already been invalidated. Please log in or request a new password recovery email."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("auth-login"));
}
if(!password_verify($otp, $user->getOneTimePassword())) {
    Logger::getLogger("Email-Verification")->info("Attempted to verify an email, but one-time password does not match");
    new InfoMessage(t("The URL has already been invalidated. Please log in or request a new password recovery email."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("auth-login"));
}

// Set the user to be an admin if there are no other users
if(count(User::dao()->getObjects(["emailVerified" => true])) === 0) {
    $user->setPermissionLevel(PermissionLevel::ADMIN->value);
    new InfoMessage(t("No users were registered yet. An administrator account has been created."), InfoMessageType::INFO);
    Logger::getLogger("Email-Verification")->info("An initial administrator account has been created.");
}

// Update the user object in the database
$user->setEmailVerified(true);
$user->setOneTimePassword(null);
$user->setOneTimePasswordExpiration(null);
$user->setUpdated(new DateTimeImmutable());
User::dao()->save($user);

Logger::getLogger("Email-Verification")->info("The email address \"{$user->getEmail()}\" (User ID \"{$user->getId()}\") has been verified");

Router->redirect(Router->generate("auth-verify-email-complete"));
