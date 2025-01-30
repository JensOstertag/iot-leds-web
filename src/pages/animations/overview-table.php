<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router::generate("index"));

$animations = Animation::dao()->getObjects([
    "userId" => $user->getId()
]);

$animations = array_map(function(Animation $animation) {
    $array = $animation->toArray();
    $array["editHref"] = Router::generate("animation-edit", ["animation" => $animation->getId()]);
    unset($array["id"]);
    unset($array["created"]);
    unset($array["updated"]);
    return $array;
}, $animations);

Comm::sendJson($animations);
