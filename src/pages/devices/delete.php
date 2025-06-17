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
            ])
        ])->setErrorMessage(t("The device that should be deleted does not exist."))
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("device-overview"));
}

$device = $get["device"];
$deviceAnimation = $device->getDeviceAnimation();
if($deviceAnimation instanceof DeviceAnimation) {
    DeviceAnimation::dao()->delete($deviceAnimation);
}
Device::dao()->delete($device);

Logger::getLogger("Devices")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) deleted the device {$device->getId()} ({$device->getName()})");

new InfoMessage(t("The device has been deleted."), InfoMessageType::SUCCESS);
Router->redirect(Router->generate("device-overview"));
