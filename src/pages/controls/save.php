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
        ]),
        "animation" => \validation\Validator::create([
            \validation\IsInDatabase::create(Animation::dao(), [
                "userId" => $user->getId()
            ])->setErrorMessage(t("The selected animation does not exist."))
        ]),
        "power" => \validation\Validator::create([
            \validation\IsInteger::create()
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("control-overview"));
}

$device = $post["device"];
$animation = $post["animation"];

$deviceAnimation = $device->getDeviceAnimation();
$animationChanged = false;

if(!$deviceAnimation instanceof DeviceAnimation) {
    $deviceAnimation = new DeviceAnimation();
    $deviceAnimation->setDeviceId($device->getId());

    $animationChanged = true;
}

if($deviceAnimation->getAnimationId() !== $animation->getId()) {
    $animationChanged = true;
}
if($deviceAnimation->getPower() !== ($post["power"] === 1)) {
    $animationChanged = true;
}

if($animation instanceof Animation) {
    $deviceAnimation->setAnimationId($animation->getId());
} else {
    $deviceAnimation->setAnimationId(null);
}
$deviceAnimation->setPower($post["power"] === 1);
DeviceAnimation::dao()->save($deviceAnimation);

if($animationChanged) {
    WebSocketMessagingUtil::sendAnimationMessage($device);
}

new InfoMessage(t("The animation has been saved."), InfoMessageType::SUCCESS);
Router->redirect(Router->generate("control-overview"));
