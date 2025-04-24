<?php

require __DIR__ . "/.cronjob-setup.php";

Logger::getLogger("WS-PING")->info("Pinging WebSocket subscribers...");

$response = WebSocketMessagingUtil::pingAllDevices();
if($response) {
    Logger::getLogger("WS-PING")->info("Pinged all WebSocket subscribers");
} else {
    Logger::getLogger("WS-PING")->error("Failed to ping WebSocket subscribers");
    exit(1);
}
