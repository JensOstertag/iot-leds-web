<?php

$user = Auth->enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

$devices = Device::dao()->getObjects([
    "userId" => $user->getId()
]);

$devices = array_map(function(Device $device) {
    $array = $device->toArray();
    $array["editHref"] = Router->generate("control-edit", ["device" => $device->getId()]);
    unset($array["id"]);
    unset($array["created"]);
    unset($array["updated"]);
    return $array;
}, $devices);

Comm::sendJson($devices);
