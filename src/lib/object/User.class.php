<?php

class User extends \struktal\ORM\GenericUser {
    public ?string $personalUid = null;
    public ?string $personalApiKey = null;

    public function getPersonalUid(): ?string {
        return $this->personalUid;
    }

    public function setPersonalUid(?string $personalUid): void {
        $this->personalUid = $personalUid;
    }

    public function getPersonalApiKey(): ?string {
        return $this->personalApiKey;
    }

    public function setPersonalApiKey(?string $personalApiKey): void {
        $this->personalApiKey = $personalApiKey;
    }

    public function generateApiKeyPair(): void {
        $uid = "";
        do {
            $uid = uniqid("p$");
        } while(count(User::dao()->getObjects(["personalUid" => $uid])) > 0);
        $this->setPersonalUid($uid);

        $apiKey = "";
        $apiCharacterSet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,+-*/";
        do {
            $apiKey = "";
            for($i = 0; $i < 256; $i++) {
                $apiKey .= $apiCharacterSet[random_int(0, strlen($apiCharacterSet) - 1)];
            }
        } while(count(User::dao()->getObjects(["personalApiKey" => $apiKey])) > 0);
        $this->setPersonalApiKey($apiKey);
    }
}
