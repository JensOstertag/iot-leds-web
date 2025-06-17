<?php

class WebSocketServerHandler {
    private static function sendRequest(string $host, string $path, array $payload) {
        $curl = new \struktal\Curl\Curl();
        $curl->setUrl($host . $path);
        $curl->setMethod(\struktal\Curl\Curl::$METHOD_POST);
        $curl->setHeaders([
            "Accept: application/json"
        ]);
        $curl->setPostFields($payload);

        $response = $curl->execute();
        $jsonResponse = json_decode($response, true);
        if(!$jsonResponse) {
            $jsonResponse = [];
        }
        $responseCode = $curl->getHttpCode();
        $curl->close();

        return [
            "response" => $jsonResponse,
            "responseCode" => $responseCode
        ];
    }

    public static function createChannel(string $channel): bool {
        $host = SystemSetting::dao()->get("wsServerHost");
        $path = "/channel/create";
        $payload = [
            "messageType" => "SERVER_ACTION",
            "action" => "CREATE_CHANNEL",
            "data" => [
                "channel" => $channel
            ]
        ];

        $response = self::sendRequest($host, $path, $payload);

        if(isset($response["response"]["code"]) && $response["response"]["code"] !== 200) {
            Logger::getLogger("WebSocketServerHandler")->error("Failed to create channel: " . $response["response"]["code"]);
            Logger::getLogger("WebSocketServerHandler")->error("Response: " . json_encode($response));
            return false;
        }

        $channelToken = $response["response"]["data"]["channelToken"];
        if($channelToken) {
            Logger::getLogger("WebSocketServerHandler")->info("Created channel: " . $channel);
            SystemSetting::dao()->set("wsServerChannel", $channel);
            SystemSetting::dao()->set("wsServerToken", $channelToken);
            return true;
        }

        return false;
    }

    public static function deleteChannel(string $channel, string $token): bool {
        $host = SystemSetting::dao()->get("wsServerHost");
        $path = "/channel/delete";
        $payload = [
            "messageType" => "SERVER_ACTION",
            "action" => "DELETE_CHANNEL",
            "data" => [
                "channel" => $channel,
                "channelToken" => $token
            ]
        ];

        $response = self::sendRequest($host, $path, $payload);

        if(isset($response["response"]["code"]) && $response["response"]["code"] !== 200) {
            Logger::getLogger("WebSocketServerHandler")->error("Failed to delete channel: " . $response["response"]["code"]);
            return false;
        }

        Logger::getLogger("WebSocketServerHandler")->info("Deleted channel: " . $channel);

        return true;
    }

    public static function pingChannel(string $channel, string $token): bool {
        $host = SystemSetting::dao()->get("wsServerHost");
        $path = "/channel/ping";
        $payload = [
            "messageType" => "SERVER_ACTION",
            "action" => "PING_CHANNEL",
            "data" => [
                "channel" => $channel,
                "channelToken" => $token
            ]
        ];

        $response = self::sendRequest($host, $path, $payload);

        if(isset($response["response"]["code"]) && $response["response"]["code"] !== 200) {
            return false;
        }

        return true;
    }

    public static function broadcastMessage(string $channel, string $token, string $message): bool {
        $host = SystemSetting::dao()->get("wsServerHost");
        $path = "/push";
        $payload = [
            "messageType" => "SERVER_ACTION",
            "action" => "PUSH_MESSAGE",
            "data" => [
                "channel" => $channel,
                "channelToken" => $token,
                "recipients" => [],
                "message" => $message
            ]
        ];

        $response = self::sendRequest($host, $path, $payload);

        if(isset($response["response"]["code"]) && $response["response"]["code"] !== 200) {
            return false;
        }

        return true;
    }

    public static function sendMessage(string $channel, string $token, string $message, array $recipients): bool {
        if($recipients === []) {
            return true;
        }

        $host = SystemSetting::dao()->get("wsServerHost");
        $path = "/push";
        $payload = [
            "messageType" => "SERVER_ACTION",
            "action" => "PUSH_MESSAGE",
            "data" => [
                "channel" => $channel,
                "channelToken" => $token,
                "recipients" => $recipients,
                "message" => $message
            ]
        ];

        $response = self::sendRequest($host, $path, $payload);

        if(isset($response["response"]["code"]) && $response["response"]["code"] !== 200) {
            return false;
        }

        return true;
    }
}
