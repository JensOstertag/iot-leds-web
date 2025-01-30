<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router::generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Devices"),
        "link" => Router::generate("device-overview")
    ]
];

echo Blade->run("devices.overview", [
    "breadcrumbs" => $breadcrumbs
]);
