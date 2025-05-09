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
                "power" => false,
                "deviceUid" => $device->getDeviceUid(),
            ];
        } else {
            $animationData = $deviceAnimation->generateApiResponse();
        }

        return [
            "type" => "ANIMATION",
            "data" => $animationData,
            "deviceUid" => $device->getDeviceUid()
        ];
    }

    public static function sendAnimationMessage(Device $device): void {
        $message = self::animationMessage($device);
        $encryptedMessage = json_encode($message);

        $channel = SystemSetting::dao()->get("wsServerChannel");
        $token = SystemSetting::dao()->get("wsServerToken");
        WebSocketServerHandler::broadcastMessage($channel, $token, $encryptedMessage);
    }
}
