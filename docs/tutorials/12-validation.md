# Validation
The framework provides a simple way to validate user input which you can use to ensure that the data you receive is in the expected format. The validation is implemented in an object-oriented way, meaning you can also create your own validation rules and use them in your application.

## Basic usage
The following example shows how to validate a POST request.

At first, you need to create a new instance of the `Validator` class. Its constructor takes an array of validation rules as an argument. The passed rules are executed in the order in which they are provided, and are conjunctions of each other, meaning that all rules must pass for the validation to succeed.

Note that for every validation rule, you can set a custom error message that will be displayed if the validation fails.
For the `HasChildren` validator, the error message is only displayed if the validation of the children does not provide a more detailed error message.
```php
$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "name" => \validation\IsString::create()->setErrorMessage(t("The name is invalid.")),
        "username" => \validation\Validator::create([
            \validation\IsRequired::create(),
            \validation\IsString::create()
        ])->setErrorMessage(t("The username is invalid."))
    ])
])->setErrorMessage(t("The input data is invalid."));
```

Then, you can test the actual input data against the validation rules:
```php
try {
    $post = $validation->getValidatedValue($_POST);
} catch (\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("index"));
}
```

Note that the `getValidatedValue` methods might alter the input data, e.g. if you use the `IsInteger` validator, the data is returned as an integer, and specially for the `IsInDatabase` validator, the returned data is an object of the requested type.

## Custom validators
You can create your own validation rules by creating a new class that extends the `GenericValidator` class and implements the `ValidatorInterface` interface.
