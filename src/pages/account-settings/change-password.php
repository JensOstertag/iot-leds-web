<?php

$user = Auth::enforceLogin(PermissionLevel::DEFAULT->value, Router->generate("index"));

echo Blade->run("accountsettings.changepassword");
