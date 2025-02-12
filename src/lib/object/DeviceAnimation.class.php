<?php

class DeviceAnimation extends GenericObject {
    public ?int $deviceId = null;
    public ?int $animationId = null;
    public ?bool $power = false;

    private ?Device $device = null;
    private ?Animation $animation = null;

    public function getDevice(): Device {
        if($this->device === null) {
            $this->device = Device::dao()->getObject([
                "id" => $this->deviceId
            ]);
        }
        return $this->device;
    }

    public function getAnimation(): Animation {
        if($this->animation === null) {
            $this->animation = Animation::dao()->getObject([
                "id" => $this->animationId
            ]);
        }
        return $this->animation;
    }

    public function getDeviceId(): ?int {
        return $this->deviceId;
    }

    public function setDeviceId(?int $deviceId): void {
        $this->deviceId = $deviceId;
    }

    public function getAnimationId(): ?int {
        return $this->animationId;
    }

    public function setAnimationId(?int $animationId): void {
        $this->animationId = $animationId;
    }

    public function getPower(): ?bool {
        return $this->power;
    }

    public function setPower(?bool $power): void {
        $this->power = $power;
    }
}
