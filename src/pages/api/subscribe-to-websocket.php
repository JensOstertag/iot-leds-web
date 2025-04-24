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
        ]),
        "webSocketUuid" => \validation\Validator::create([
            \validation\IsRequired::create()->setErrorMessage("\"webSocketUuid\" is required"),
            \validation\IsString::create()->setErrorMessage("\"webSocketUuid\" must be a string"),
            \validation\MaxLength::create(64)->setErrorMessage("\"webSocketUuid\" must not be longer than 64 characters"),
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

$device->setWebSocketUuid($post["webSocketUuid"]);
Device::dao()->save($device);

WebSocketMessagingUtil::sendAnimationMessage($device);

Comm::apiSendJson(HTTPResponses::$RESPONSE_OK, []);
