<?php

require __DIR__ . "/.cronjob-setup.php";

Logger::getLogger("WS-PING")->info("Pinging WebSocket server...");

$channel = SystemSetting::dao()->get("wsServerChannel");
$token = SystemSetting::dao()->get("wsServerToken");
if(!$channel || !$token) {
    Logger::getLogger("WS-PING")->error("No channel or token set, skipping ping");
    exit(0);
}

$response = WebSocketServerHandler::pingChannel($channel, $token);
if($response) {
    Logger::getLogger("WS-PING")->info("Ping successful");
    exit(0);
}

Logger::getLogger("WS-PING")->error("Ping failed");

// Delete all subscribers
$subscribedDevices = Device::dao()->getObjects([
    [
        "field" => "webSocketUuid",
        "filterType" => DAOFilterType::NOT_EQUALS,
        "filterValue" => null
    ]
]);
foreach($subscribedDevices as $device) {
    $device->setWebSocketUuid(null);
    Device::dao()->save($device);
}

Logger::getLogger("WS-PING")->info("Attempting to recreate channel...");

$response = WebSocketServerHandler::createChannel($channel);
if($response) {
    Logger::getLogger("WS-PING")->info("Channel recreated successfully");
    exit(0);
}

Logger::getLogger("WS-PING")->fatal("Failed to recreate channel");
