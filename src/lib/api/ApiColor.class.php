<?php

class ApiColor {
    public string $htmlCode;
    public array $rgb;

    public static function fromHtmlCode(string $htmlCode): ApiColor {
        return new ApiColor($htmlCode);
    }

    private function __construct(string $htmlCode) {
        $this->htmlCode = $htmlCode;
        $this->rgb = $this->htmlToRgb($this->htmlCode);
    }

    public function jsonSerialize(): array {
        return [
            "htmlCode" => $this->htmlCode,
            "rgb" => $this->rgb
        ];
    }

    public function htmlToRgb(string $htmlCode): array {
        $htmlCode = str_replace("#", "", $htmlCode);
        return [
            "r" => hexdec(substr($htmlCode, 0, 2)),
            "g" => hexdec(substr($htmlCode, 2, 2)),
            "b" => hexdec(substr($htmlCode, 4, 2))
        ];
    }
}
