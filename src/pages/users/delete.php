<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "user" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInDatabase::create(User::dao())
        ])->setErrorMessage(t("The user that should be deleted does not exist."))
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("user-overview"));
}

$account = $get["user"];

$devices = Device::dao()->getObjects(["userId" => $account->getId()]);
foreach($devices as $device) {
    $deviceAnimation = $device->getDeviceAnimation();
    if($deviceAnimation instanceof DeviceAnimation) {
        DeviceAnimation::dao()->delete($deviceAnimation);
    }
    Device::dao()->delete($device);
}
$animations = Animation::dao()->getObjects(["userId" => $account->getId()]);
foreach($animations as $animation) {
    Animation::dao()->delete($animation);
}
User::dao()->delete($account);

Logger::getLogger("Users")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) deleted the account {$account->getId()} ({$account->getUsername()})");

new InfoMessage(t("The user has been deleted."), InfoMessageType::SUCCESS);
Comm::redirect(Router::generate("user-overview"));
