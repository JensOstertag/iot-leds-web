<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router->generate("index"));

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router->generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("User management"),
        "link" => Router->generate("user-overview")
    ]
];

echo Blade->run("users.overview", [
    "breadcrumbs" => $breadcrumbs
]);
