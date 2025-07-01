<?php

$user = Auth->enforceLogin(PermissionLevel::ADMIN->value, Router->generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "registrationEnabled" => \validation\Validator::create([
            \validation\IsInteger::create()
        ]),
        "webSocketHost" => \validation\Validator::create([
            \validation\IsString::create()
        ]),
        "webSocketChannel" => \validation\Validator::create([
            \validation\IsString::create()
        ])
    ])
])->setErrorMessage(t("Please fill out all the required fields."));

try {
    $post = $validation->getValidatedValue($_POST);
} catch(validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Router->redirect(Router->generate("system-settings"));
}

$registrationEnabled = $post["registrationEnabled"] === 1;
SystemSetting::dao()->set("registrationEnabled", $registrationEnabled ? "true" : "false");

$oldWsHost = SystemSetting::dao()->get("wsServerHost");
$oldWsChannel = SystemSetting::dao()->get("wsServerChannel");
$webSocketHost = $post["webSocketHost"];
$webSocketChannel = $post["webSocketChannel"];
if($oldWsHost !== $webSocketHost || $oldWsChannel !== $webSocketChannel) {
    // Delete the old channel
    if($oldWsChannel) {
        WebSocketServerHandler::deleteChannel($oldWsChannel, SystemSetting::dao()->get("wsServerToken"));
    }

    // Set the new host
    SystemSetting::dao()->set("wsServerHost", $webSocketHost);

    // Create the new channel
    if(WebSocketServerHandler::createChannel($webSocketChannel)) {
        new InfoMessage(t("The WebSocket channel has been created."), InfoMessageType::SUCCESS);
    } else {
        new InfoMessage(t("Failed to create the WebSocket channel."), InfoMessageType::ERROR);
        Router->redirect(Router->generate("system-settings"));
    }
}

new InfoMessage(t("The system settings have been saved."), InfoMessageType::SUCCESS);
Router->redirect(Router->generate("dashboard"));
