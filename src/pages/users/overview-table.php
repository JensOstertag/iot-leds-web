<?php

$user = Auth::enforceLogin(PermissionLevel::ADMIN->value, Router::generate("index"));

$accounts = User::dao()->getObjects();

$accounts = array_map(function(User $account) {
    $array = $account->toArray();
    $array["editHref"] = Router::generate("user-edit", ["user" => $account->getId()]);
    $array["emailVerified"] = $account->getEmailVerified() ? t("Yes") : t("No");
    $array["permissionLevel"] = $account->getPermissionLevel() === PermissionLevel::ADMIN->value ? t("Yes") : t("No");
    unset($array["id"]);
    unset($array["created"]);
    unset($array["updated"]);
    unset($array["password"]);
    unset($array["oneTimePassword"]);
    unset($array["oneTimePasswordExpiration"]);
    unset($array["personalUid"]);
    unset($array["personalApiKey"]);
    return $array;
}, $accounts);

Comm::sendJson($accounts);
