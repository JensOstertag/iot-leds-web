<?php

Router::addRoute("GET", "/", "index.php", "index");
Router::addRoute("GET|POST", "/404", "404.php", "404");
Router::addRoute("GET|POST", "/400", "400.php", "400");
Router::addRoute("GET|POST", "/libraries", "libraries.php", "libraries");

Router::addRoute("POST", "/translations-api", "translations/api.php", "translations-api");

Router::addRoute("GET", "/dashboard", "dashboard.php", "dashboard");

// Account settings
Router::addRoute("GET", "/account-settings", "account-settings/account-settings.php", "account-settings");
Router::addRoute("GET", "/account-settings/change-password", "account-settings/change-password.php", "account-settings-change-password");
Router::addRoute("POST", "/account-settings/change-password", "account-settings/change-password-action.php", "account-settings-change-password-action");
Router::addRoute("GET", "/account-settings/api-key", "account-settings/personal-api-key.php", "account-settings-api-key");

// Animations
Router::addRoute("GET", "/animations", "animations/overview.php", "animation-overview");
Router::addRoute("POST", "/animations/table", "animations/overview-table.php", "animation-overview-table");
Router::addRoute("GET", "/animations/edit", "animations/edit.php", "animation-create");
Router::addRoute("GET", "/animations/edit/{i:animation}", "animations/edit.php", "animation-edit");
Router::addRoute("POST", "/animations/save", "animations/save.php", "animation-save");
Router::addRoute("GET", "/animations/delete/{i:animation}", "animations/delete.php", "animation-delete");

// Devices
Router::addRoute("GET", "/devices", "devices/overview.php", "device-overview");
Router::addRoute("POST", "/devices/table", "devices/overview-table.php", "device-overview-table");
Router::addRoute("GET", "/devices/edit", "devices/edit.php", "device-create");
Router::addRoute("GET", "/devices/edit/{i:device}", "devices/edit.php", "device-edit");
Router::addRoute("POST", "/devices/save", "devices/save.php", "device-save");
Router::addRoute("GET", "/devices/delete/{i:device}", "devices/delete.php", "device-delete");

// Control panel
Router::addRoute("GET", "/controls", "controls/overview.php", "control-overview");
Router::addRoute("POST", "/controls/table", "controls/overview-table.php", "control-overview-table");
Router::addRoute("GET", "/controls/edit/{i:device}", "controls/edit.php", "control-edit");
Router::addRoute("POST", "/controls/save", "controls/save.php", "control-save");

// User management
Router::addRoute("GET", "/users", "users/overview.php", "user-overview");
Router::addRoute("POST", "/users/table", "users/overview-table.php", "user-overview-table");
Router::addRoute("GET", "/users/edit", "users/edit.php", "user-create");
Router::addRoute("GET", "/users/edit/{i:user}", "users/edit.php", "user-edit");
Router::addRoute("POST", "/users/save", "users/save.php", "user-save");
Router::addRoute("GET", "/users/delete/{i:user}", "users/delete.php", "user-delete");

// System settings
Router::addRoute("GET", "/system-settings", "system-settings/system-settings.php", "system-settings");
Router::addRoute("POST", "/system-settings/save", "system-settings/system-settings-save.php", "system-settings-save");

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

// API
Router::addRoute("POST", "/api/get-device-animation", "api/get-device-animation.php", "api-get-device-animation");
// TODO: API endpoint to get all animations for a user
// TODO: API endpoints to add, edit and delete animations
// TODO: API endpoint to set the current animation and power state of a device
