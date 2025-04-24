<?php

class WebSocketMessagingUtil {
    public static function pingMessage(): array {
        $timestamp = new DateTime();
        return [
            "type" => "PING",
            "data" => [
                "timestamp" => $timestamp->format(DateTimeInterface::RFC3339_EXTENDED)
            ]
        ];
    }

    public static function animationMessage(Device $device): array {
        $deviceAnimation = $device->getDeviceAnimation();
        if(!$deviceAnimation instanceof DeviceAnimation) {
            $animationData = [
                "animation" => null,
                "power" => false
            ];
        } else {
            $animationData = $deviceAnimation->generateApiResponse();
        }

        return [
            "type" => "ANIMATION",
            "data" => $animationData
        ];
    }

    public static function pingAllDevices(): void {
        $devices = Device::dao()->getObjects([
            [
                "field" => "webSocketUuid",
                "filterType" => DAOFilterType::NOT_EQUALS,
                "filterValue" => null
            ]
        ]);

        $webSocketUuids = array_map(function($device) {
            return $device->getWebSocketUuid();
        }, $devices);

        $channel = SystemSetting::dao()->get("wsServerChannel");
        $token = SystemSetting::dao()->get("wsServerToken");

        if(count($webSocketUuids) === 0) {
            return;
        }

        WebSocketServerHandler::sendMessage($channel, $token, json_encode(self::pingMessage()), $webSocketUuids);
    }

    public static function sendAnimationMessage(Device $device): void {
        $message = self::animationMessage($device);
        $webSocketUuid = $device->getWebSocketUuid();
        if($webSocketUuid !== null) {
            $channel = SystemSetting::dao()->get("wsServerChannel");
            $token = SystemSetting::dao()->get("wsServerToken");
            WebSocketServerHandler::sendMessage($channel, $token, json_encode($message), [
                $webSocketUuid
            ]);
        }
    }
}
