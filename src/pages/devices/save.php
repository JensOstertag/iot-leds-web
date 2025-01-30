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
        ]),
        "name" => \validation\Validator::create([
            \validation\IsRequired::create(true),
            \validation\IsString::create(),
            \validation\MaxLength::create(256)
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("device-overview"));
}

$device = new Device();
if(isset($post["device"])) {
    $device = $post["device"];
} else {
    $device->generateApiKeyPair();
}

$device->setUserId($user->getId());
$device->setName($post["name"]);
Device::dao()->save($device);

if(!$device->getDeviceAnimation() instanceof DeviceAnimation) {
    $deviceAnimation = new DeviceAnimation();
    $deviceAnimation->setDeviceId($device->getId());
    $deviceAnimation->setAnimationId(null);
    $deviceAnimation->setPower(false);
    DeviceAnimation::dao()->save($deviceAnimation);
}

Logger::getLogger("Devices")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) saved the device {$device->getId()} ({$device->getName()})");

new InfoMessage(t("The device has been saved."), InfoMessageType::SUCCESS);
Comm::redirect(Router::generate("device-overview"));
