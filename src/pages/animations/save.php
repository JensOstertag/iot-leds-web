<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "animation" => \validation\Validator::create([
            \validation\IsInDatabase::create(Animation::dao(), [
                "userId" => $user->getId()
            ])->setErrorMessage(t("The animation that should be edited does not exist."))
        ]),
        "name" => \validation\Validator::create([
            \validation\IsRequired::create(true),
            \validation\IsString::create(),
            \validation\MaxLength::create(256)
        ]),
        "type" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInteger::create()
            // TODO: Check if the animation type exists
        ]),
        "colors" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsArray::create(),
            \validation\HasElements::create(
                \validation\Validator::create([
                    \validation\IsRequired::create(),
                    \validation\IsString::create(),
                    \validation\MaxLength::create(7)
                ])
            ),
            \validation\MinLength::create(1)
        ]),
        "durationPerColor" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsInteger::create(),
            \validation\MinValue::create(1)
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("animation-overview"));
}

$animation = new Animation();
if(isset($post["animation"])) {
    $animation = $post["animation"];
}

$animation->setUserId($user->getId());
$animation->setName($post["name"]);
$animation->setAnimationType($post["type"]);
$animation->setColors(json_encode($post["colors"]));
$animation->setDurationPerColor($post["durationPerColor"]);
Animation::dao()->save($animation);

Logger::getLogger("Animations")->info("User {$user->getId()} ({$user->getUsername()}, PL {$user->getPermissionLevel()}) saved the animation {$animation->getId()} ({$animation->getName()})");

new InfoMessage(t("The animation has been saved."), InfoMessageType::SUCCESS);
Comm::redirect(Router::generate("animation-overview"));
