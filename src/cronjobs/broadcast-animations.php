<?php

require __DIR__ . "/.cronjob-setup.php";

$channel = SystemSetting::dao()->get("wsServerChannel");
$token = SystemSetting::dao()->get("wsServerToken");
if(!$channel || !$token) {
    Logger::getLogger("WS-PING")->error("No channel or token set, skipping ping");
    exit(0);
}

// Ping the WebSocket server
$response = WebSocketServerHandler::pingChannel($channel, $token);
if(!$response) {
    Logger::getLogger("WS-PING")->error("Could not ping WebSocket channel");
    Logger::getLogger("WS-PING")->info("Attempting to recreate channel...");

    $response = WebSocketServerHandler::createChannel($channel);
    if(!$response) {
        Logger::getLogger("WS-PING")->fatal("Failed to recreate channel");
        exit(0);
    }

    Logger::getLogger("WS-PING")->info("Channel recreated successfully");
}

// Broadcast device animations
$devices = Device::dao()->getObjects();
foreach($devices as $device) {
    WebSocketMessagingUtil::sendAnimationMessage($device);
}
