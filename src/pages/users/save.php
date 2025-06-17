<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router->generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "user" => \validation\Validator::create([
            \validation\IsInDatabase::create(User::dao())->setErrorMessage(t("The user that should be edited does not exist."))
        ]),
        "email" => \validation\Validator::create([
            \validation\IsRequired::create(true),
            \validation\IsString::create(),
            \validation\MaxLength::create(256)
        ]),
        "username" => \validation\Validator::create([
            \validation\IsRequired::create(true),
            \validation\IsString::create(),
            \validation\MaxLength::create(256)
        ]),
        "password" => \validation\Validator::create([
            \validation\IsString::create()
        ]),
        "admin" => \validation\Validator::create([
            \validation\IsInteger::create()
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}

$account = new User();
if(isset($post["user"])) {
    $account = $post["user"];
} else {
    $account->generateApiKeyPair();
}

// Check whether username and email are valid
if(!preg_match("/^(?!.*\.\.)(?!.*\.$)\w[\w.]{2,15}$/", $post["username"])) {
    new InfoMessage(t("The specified username is invalid. Please follow the required username scheme."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}
if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    new InfoMessage(t("The specified email address is invalid. Please check for spelling errors and try again."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}

// Check for existing users with the specified username or email
$username = strtolower($post["username"]);
$email = strtolower($post["email"]);
$existingUsername = User::dao()->getObjects([
    "username" => $username,
    new \struktal\ORM\DAOFilter(
        \struktal\ORM\DAOFilterOperator::NOT_EQUALS,
        "id",
        $account->getId()
    )
]);
$existingEmail = User::dao()->getObjects([
    "email" => $email,
    new \struktal\ORM\DAOFilter(
        \struktal\ORM\DAOFilterOperator::NOT_EQUALS,
        "id",
        $account->getId()
    )
]);
if(!empty($existingUsername)) {
    new InfoMessage(t("An account with this username already exists. Please choose another one."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}
if(!empty($existingUsername) || !empty($existingEmail)) {
    new InfoMessage(t("An account with this email already exists. If that is your account, please log in instead."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}

// Check password
if(empty($post["user"]) && empty($post["password"])) {
    new InfoMessage(t("Please fill out all the required fields."), InfoMessageType::ERROR);
    Router->redirect(Router->generate("user-overview"));
}
if(!empty($post["password"])) {
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$/", $post["password"])) {
        new InfoMessage(t("The specified password doesn't fulfill the password requirements. Please choose a safer password."), InfoMessageType::ERROR);
        Router->redirect(Router->generate("user-overview"));
    }
}

// Save user
$account->setUsername($post["username"]);
$account->setEmail($post["email"]);
$account->setEmailVerified(true);
if(!empty($post["password"])) {
    $account->setPassword($post["password"]);
}
$account->setPermissionLevel($post["admin"] === 1 ? PermissionLevel::ADMIN->value : PermissionLevel::DEFAULT->value);
User::dao()->save($account);

Logger::getLogger("Users")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) saved the user {$account->getId()} ({$account->getUsername()})");

new InfoMessage(t("The user has been saved."), InfoMessageType::SUCCESS);
Router->redirect(Router->generate("user-overview"));
