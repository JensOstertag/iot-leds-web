<?php

if(Auth::isLoggedIn()) {
    Router->redirect(Router->generate("dashboard"));
} else {
    Router->redirect(Router->generate("auth-login"));
}
