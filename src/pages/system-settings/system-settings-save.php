<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "registrationEnabled" => \validation\Validator::create([
            \validation\IsInteger::create()
        ]),
    ])
])->setErrorMessage(t("Please fill out all the required fields."));

try {
    $post = $validation->getValidatedValue($_POST);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("system-settings"));
}

$registrationEnabled = $post["registrationEnabled"] === 1;
SystemSetting::dao()->set("registrationEnabled", $registrationEnabled ? "true" : "false");

new InfoMessage(t("The system settings have been saved."), InfoMessageType::SUCCESS);
Comm::redirect(Router::generate("dashboard"));
