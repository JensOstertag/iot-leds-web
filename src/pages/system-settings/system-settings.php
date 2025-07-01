<?php

$user = Auth->enforceLogin(PermissionLevel::ADMIN->value, Router->generate("index"));

$registrationEnabled = SystemSetting::dao()->get("registrationEnabled");

$webSocketHost = SystemSetting::dao()->get("wsServerHost");
$webSocketChannel = SystemSetting::dao()->get("wsServerChannel");
$webSocketToken = SystemSetting::dao()->get("wsServerToken");

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router->generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("System settings"),
        "link" => Router->generate("system-settings")
    ]
];

echo Blade->run("systemsettings.systemsettings", [
    "breadcrumbs" => $breadcrumbs,
    "registrationEnabled" => $registrationEnabled,
    "webSocketHost" => $webSocketHost,
    "webSocketChannel" => $webSocketChannel,
    "webSocketToken" => $webSocketToken,
]);
