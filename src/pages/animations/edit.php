<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$validation = \validation\Validator::create([
    \validation\IsRequired::create(),
    \validation\IsArray::create(),
    \validation\HasChildren::create([
        "animation" => \validation\Validator::create([
            \validation\IsInDatabase::create(Animation::dao(), [
                "userId" => $user->getId()
            ])->setErrorMessage(t("The animation that should be edited does not exist."))
        ])
    ])
]);
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\validation\ValidationException $e) {
    new InfoMessage($e->getMessage(), InfoMessageType::ERROR);
    Comm::redirect(Router::generate("animation-overview"));
}

$animation = $get["animation"];

$breadcrumbs = [
    [
        "name" => t("Dashboard"),
        "link" => Router::generate("dashboard"),
        "iconComponent" => "components.icons.dashboard"
    ],
    [
        "name" => t("Animations"),
        "link" => Router::generate("animation-overview")
    ],
    [
        "name" => isset($animation) ? t("Edit animation \$\$name\$\$", ["name" => $animation->getName()]) : t("Create animation"),
        "link" => Router::generate(isset($animation) ? "animation-edit" : "animation-create", isset($animation) ? ["animation" => $animation->getId()] : [])
    ]
];

echo Blade->run("animations.edit", [
    "breadcrumbs" => $breadcrumbs,
    "animation" => $animation ?? null
]);
