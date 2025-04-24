<?php

class Device extends GenericObject {
    public ?int $userId = null;
    public ?string $name = null;
    public ?string $deviceUid = null;
    public ?string $deviceApiKey = null;
    public ?string $webSocketUuid = null;

    private ?User $user = null;
    private ?DeviceAnimation $deviceAnimation = null;

    public function getUser(): User {
        if($this->user === null) {
            $this->user = User::dao()->getObject([
                "id" => $this->userId
            ]);
        }
        return $this->user;
    }

    public function getDeviceAnimation(): ?DeviceAnimation {
        if($this->deviceAnimation === null) {
            $this->deviceAnimation = DeviceAnimation::dao()->getObject([
                "deviceId" => $this->id
            ]);
        }
        return $this->deviceAnimation;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    public function getDeviceUid(): ?string {
        return $this->deviceUid;
    }

    public function setDeviceUid(?string $deviceUid): void {
        $this->deviceUid = $deviceUid;
    }

    public function getDeviceApiKey(): ?string {
        return $this->deviceApiKey;
    }

    public function setDeviceApiKey(?string $deviceApiKey): void {
        $this->deviceApiKey = $deviceApiKey;
    }

    public function getWebSocketUuid(): ?string {
        return $this->webSocketUuid;
    }

    public function setWebSocketUuid(?string $webSocketUuid): void {
        $this->webSocketUuid = $webSocketUuid;
    }

    public function generateApiKeyPair(): void {
        $uid = "";
        do {
            $uid = uniqid("d$");
        } while(count(Device::dao()->getObjects(["deviceUid" => $uid])) > 0);
        $this->setDeviceUid($uid);

        $apiKey = "";
        $apiCharacterSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,+-*/";
        do {
            $apiKey = "";
            for($i = 0; $i < 256; $i++) {
                $apiKey .= $apiCharacterSet[random_int(0, strlen($apiCharacterSet) - 1)];
            }
        } while(count(Device::dao()->getObjects(["deviceApiKey" => $apiKey])) > 0);
        $this->setDeviceApiKey($apiKey);
    }
}
