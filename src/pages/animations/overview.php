<?php

$user = Auth->enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router->generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Animations"),
        "link" => Router->generate("animation-overview")
    ]
];

echo Blade->run("animations.overview", [
    "breadcrumbs" => $breadcrumbs
]);
