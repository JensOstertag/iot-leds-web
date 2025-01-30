<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "user" => \validation\Validator::create([
            \validation\IsInDatabase::create(User::dao())->setErrorMessage(t("The user that should be edited does not exist."))
        ])
    ])
]);
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("user-overview"));
}

$account = $get["user"];

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router::generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("User management"),
        "link" => Router::generate("user-overview")
    ],
    [
        "name" => isset($account) ? t("Edit user \$\$name\$\$", ["name" => $account->getUsername()]) : t("Create user"),
        "link" => Router::generate(isset($account) ? "user-edit" : "user-create", isset($account) ? ["user" => $account->getId()] : [])
    ]
];

echo Blade->run("users.edit", [
    "breadcrumbs" => $breadcrumbs,
    "account" => $account ?? null
]);
