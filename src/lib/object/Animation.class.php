<?php

class Animation extends \struktal\ORM\GenericObject {
    public ?int $userId = null;
    public ?string $name = null;
    public int $animationType = AnimationType::STATIC->value;
    public string $colors = "[]";
    public int $durationPerColor = 5;

    private ?User $user = null;
    private ?array $parsedColors = null;

    public function getUser(): User {
        if($this->user === null) {
            $this->user = User::dao()->getObject([
                "id" => $this->userId
            ]);
        }
        return $this->user;
    }

    public function getParsedColors(): array {
        if($this->parsedColors === null) {
            $this->parsedColors = json_decode($this->colors, true);
        }
        return $this->parsedColors;
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

    public function getAnimationType(): int {
        return $this->animationType;
    }

    public function setAnimationType(int $animationType): void {
        $this->animationType = $animationType;
    }

    public function getColors(): string {
        return $this->colors;
    }

    public function setColors(string $colors): void {
        $this->colors = $colors;
    }

    public function getDurationPerColor(): int {
        return $this->durationPerColor;
    }

    public function setDurationPerColor(int $durationPerColor): void {
        $this->durationPerColor = $durationPerColor;
    }
}
