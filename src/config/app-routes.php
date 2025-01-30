<?php

Router::addRoute("GET", "/", "index.php", "index");
Router::addRoute("GET|POST", "/404", "404.php", "404");
Router::addRoute("GET|POST", "/400", "400.php", "400");

Router::addRoute("POST", "/translations-api", "translations/api.php", "translations-api");

Router::addRoute("GET", "/dashboard", "dashboard.php", "dashboard");

// Account settings
Router::addRoute("GET", "/account-settings", "account-settings/account-settings.php", "account-settings");
Router::addRoute("GET", "/account-settings/change-password", "account-settings/change-password.php", "account-settings-change-password");
Router::addRoute("POST", "/account-settings/change-password", "account-settings/change-password-action.php", "account-settings-change-password-action");

// Animations
Router::addRoute("GET", "/animations", "animations/overview.php", "animation-overview");
Router::addRoute("POST", "/animations/table", "animations/overview-table.php", "animation-overview-table");
Router::addRoute("GET", "/animations/edit", "animations/edit.php", "animation-create");
Router::addRoute("GET", "/animations/edit/{i:animation}", "animations/edit.php", "animation-edit");
Router::addRoute("POST", "/animations/save", "animations/save.php", "animation-save");
Router::addRoute("GET", "/animations/delete/{i:animation}", "animations/delete.php", "animation-delete");

// Authentication
Router::addRoute("GET", "/auth/login", "auth/login.php", "auth-login");
Router::addRoute("POST", "/auth/login", "auth/login-action.php", "auth-login-action");
Router::addRoute("GET", "/auth/register", "auth/register.php", "auth-register");
Router::addRoute("POST", "/auth/register", "auth/register-action.php", "auth-register-action");
Router::addRoute("GET", "/auth/register/complete", "auth/register-complete.php", "auth-register-complete");
Router::addRoute("GET", "/auth/verify-email", "auth/verify-email.php", "auth-verify-email");
Router::addRoute("GET", "/auth/verify-email/complete", "auth/verify-email-complete.php", "auth-verify-email-complete");
Router::addRoute("GET", "/auth/password-recovery/request", "auth/recovery-request.php", "auth-recovery-request");
Router::addRoute("POST", "/auth/password-recovery/request", "auth/recovery-request-action.php", "auth-recovery-request-action");
Router::addRoute("GET", "/auth/password-recovery/request/complete", "auth/recovery-request-complete.php", "auth-recovery-request-complete");
Router::addRoute("GET", "/auth/password-recovery/reset", "/auth/recovery-reset.php", "auth-recovery-reset");
Router::addRoute("POST", "/auth/password-recovery/reset", "/auth/recovery-reset-action.php", "auth-recovery-reset-action");
Router::addRoute("GET", "/auth/password-recovery/reset/complete", "/auth/recovery-reset-complete.php", "auth-recovery-reset-complete");
Router::addRoute("GET", "/auth/logout", "auth/logout.php", "auth-logout");
