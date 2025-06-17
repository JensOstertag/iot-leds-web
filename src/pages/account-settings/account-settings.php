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
    ]
];

echo Blade->run("accountsettings.accountsettings", [
    "breadcrumbs" => $breadcrumbs,
]);
