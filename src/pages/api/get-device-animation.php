<?php

$jsonPost = json_decode(file_get_contents("php://input"), true);

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "deviceUid" => \validation\Validator::create([
            \validation\IsRequired::create()->setErrorMessage("\"deviceUid\" is required"),
            \validation\IsString::create()->setErrorMessage("\"deviceUid\" must be a string"),
            \validation\MaxLength::create(256)->setErrorMessage("\"deviceUid\" must not be longer than 256 characters"),
        ]),
        "deviceApiKey" => \validation\Validator::create([
            \validation\IsRequired::create()->setErrorMessage("\"deviceApiKey\" is required"),
            \validation\IsString::create()->setErrorMessage("\"deviceApiKey\" must be a string"),
            \validation\MaxLength::create(256)->setErrorMessage("\"deviceApiKey\" must not be longer than 256 characters"),
        ])
    ])
]);

try {
    $post = $validation->getValidatedValue($jsonPost);
} catch(\validation\ValidationException $e) {
    Comm::apiSendJson(HTTPResponses::$RESPONSE_BAD_REQUEST, [
        "error" => $e->getMessage()
    ]);
}

$device = Device::dao()->getObject(["deviceUid" => $post["deviceUid"], "deviceApiKey" => $post["deviceApiKey"]]);
if(!$device instanceof Device) {
    Comm::apiSendJson(HTTPResponses::$RESPONSE_NOT_FOUND, [
        "error" => "Device not found"
    ]);
}

$deviceAnimation = $device->getDeviceAnimation();
if(!$deviceAnimation instanceof DeviceAnimation) {
    Comm::apiSendJson(HTTPResponses::$RESPONSE_OK, [
        "animation" => null,
        "power" => false
    ]);
}

$animation = $deviceAnimation->getAnimation();
if(!$animation instanceof Animation) {
    Comm::apiSendJson(HTTPResponses::$RESPONSE_OK, [
        "animation" => null,
        "power" => false
    ]);
}

$animationType = AnimationType::from($animation->getAnimationType())->name;
$colors = $animation->getParsedColors();

$colorObjects = [];
foreach($colors as $color) {
    $colorObjects[] = ApiColor::fromHtmlCode($color);
}

Comm::apiSendJson(HTTPResponses::$RESPONSE_OK, [
    "animation" => [
        "id" => $animation->getId(),
        "name" => $animation->getName(),
        "type" => $animationType,
        "colors" => $colorObjects,
        "durationPerColor" => $animation->getDurationPerColor()
    ],
    "power" => $deviceAnimation->getPower()
]);
