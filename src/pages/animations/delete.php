<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "animation" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInDatabase::create(Animation::dao(), [
                "userId" => $user->getId()
            ])
        ])->setErrorMessage(t("The animation that should be deleted does not exist."))
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("animation-overview"));
}

$animation = $get["animation"];
$deviceAnimations = DeviceAnimation::dao()->getObjects([
    "animationId" => $animation->getId()
]);
foreach($deviceAnimations as $deviceAnimation) {
    $deviceAnimation->setAnimationId(null);
    $deviceAnimation->setPower(false);
    DeviceAnimation::dao()->save($deviceAnimation);
}
Animation::dao()->delete($animation);

Logger::getLogger("Animations")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) deleted the animation {$animation->getId()} ({$animation->getName()})");

new InfoMessage(t("The animation has been deleted."), InfoMessageType::SUCCESS);
Router->redirect(Router->generate("animation-overview"));
