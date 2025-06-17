<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router->generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Account settings"),
        "link" => Router->generate("account-settings")
    ],
    [
        "name" => t("Personal API key"),
        "link" => Router->generate("account-settings-api-key")
    ]
];

echo Blade->run("accountsettings.apikey", [
    "breadcrumbs" => $breadcrumbs,
    "user" => $user
]);
