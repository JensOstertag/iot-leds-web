<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router::generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Control panel"),
        "link" => Router::generate("control-overview")
    ]
];

echo Blade->run("controls.overview", [
    "breadcrumbs" => $breadcrumbs
]);
