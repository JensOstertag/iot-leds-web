<?php

require __DIR__ . "/.cronjob-setup.php";

Logger::getLogger("WS-PING")->info("Pinging WebSocket subscribers...");

WebSocketMessagingUtil::pingAllDevices();

Logger::getLogger("WS-PING")->info("Pinged all WebSocket subscribers");
