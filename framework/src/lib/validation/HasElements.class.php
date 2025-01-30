<?php

namespace validation;

class HasElements extends GenericValidator implements ValidatorInterface {
    private ValidatorInterface $childrenValidator;

    public function __construct(ValidatorInterface $childrenValidator) {
        $this->childrenValidator = $childrenValidator;
    }

    public static function create(?ValidatorInterface $childrenValidator = null): ValidatorInterface {
        if($childrenValidator === null) {
            $childrenValidator = new Validator();
        }
        return new self($childrenValidator);
    }

    public function getValidatedValue(mixed &$input): mixed {
        $output = [];

        foreach($input as $key => $value) {
            try {
                $output[$key] = $this->childrenValidator->getValidatedValue($value);
            } catch(ValidationException $e) {
                if($e->getMessage() !== PHP_EOL) {
                    throw $e;
                } else {
                    parent::failValidation();
                }
            }
        }

        return $output;
    }
}
