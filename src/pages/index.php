<?php

if(Auth::isLoggedIn()) {
    Comm::redirect(Router::generate("dashboard"));
} else {
    Comm::redirect(Router::generate("auth-login"));
}
