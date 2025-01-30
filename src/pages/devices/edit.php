<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "device" => \validation\Validator::create([
            \validation\IsInDatabase::create(Device::dao(), [
                "userId" => $user->getId()
            ])->setErrorMessage(t("The device that should be edited does not exist."))
        ])
    ])
]);
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("device-overview"));
}

$device = $get["device"];

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router::generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Devices"),
        "link" => Router::generate("device-overview")
    ],
    [
        "name" => isset($device) ? t("Edit device \$\$name\$\$", ["name" => $device->getName()]) : t("Create device"),
        "link" => Router::generate(isset($device) ? "device-edit" : "device-create", isset($device) ? ["device" => $device->getId()] : [])
    ]
];

echo Blade->run("devices.edit", [
    "breadcrumbs" => $breadcrumbs,
    "device" => $device ?? null
]);
