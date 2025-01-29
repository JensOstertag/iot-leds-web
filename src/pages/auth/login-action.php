<?php

// Check whether the user is already logged in
if(Auth::isLoggedIn()) {
    Comm::redirect(Router::generate("index"));
}

// Check whether form fields are given
$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "username" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(5),
            \validation\MaxLength::create(256),
        ]),
        "password" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create(),
            \validation\MinLength::create(8),
            \validation\MaxLength::create(256),
        ])
    ])
])->setErrorMessage(t("Please log in with your account's credentials."));
try {
    $post = $validation->getValidatedValue($_POST);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

$user = User::dao()->login($post["username"], false, $post["password"]);

if(!$user instanceof GenericUser) {
    if($user === 2) {
        $message = t("Before logging in, please verify your account's email address.");
    } else {
        $message = t("An account with these credentials could not be found. Please check for spelling errors and try again.");
    }

    Logger::getLogger("Login")->info("User \"{$post["username"]}\" failed to log in: " . ($user === 0 ? "User not found" : ($user === 1 ? "Password incorrect" : "Email not verified")));
    new InfoMessage($message, InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

// Reset possibly existing one-time password
$user->setOneTimePassword(null);
$user->setOneTimePasswordExpiration(null);
User::dao()->save($user);

Logger::getLogger("Login")->info("User \"{$post["username"]}\" has logged in (User ID {$user->getId()})");
Auth::login($user);
Comm::redirect(Router::generate("index"));
