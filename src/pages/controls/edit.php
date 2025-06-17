<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "device" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInDatabase::create(Device::dao(), [
                "userId" => $user->getId()
            ])->setErrorMessage(t("The device that should be controlled does not exist."))
        ])
    ])
]);
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("control-overview"));
}

$device = $get["device"];

$animations = Animation::dao()->getObjects([
    "userId" => $user->getId()
]);

$currentAnimation = null;
if($device->getDeviceAnimation() instanceof DeviceAnimation) {
    $currentAnimation = $device->getDeviceAnimation()->getAnimationId();
}

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router->generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Control panel"),
        "link" => Router->generate("control-overview")
    ],
    [
        "name" => t("\$\$name\$\$", ["name" => $device->getName()]),
        "link" => Router->generate("control-edit", ["device" => $device->getId()])
    ]
];

echo Blade->run("controls.edit", [
    "breadcrumbs" => $breadcrumbs,
    "device" => $device ?? null,
    "animations" => $animations,
    "currentAnimation" => $currentAnimation
]);
