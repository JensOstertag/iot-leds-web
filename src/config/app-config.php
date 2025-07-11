<?php

// Router settings
Config::$ROUTER_SETTINGS["ROUTER_BASE_URI"] = Config::configSecret()["ROUTER_SETTINGS"]["ROUTER_BASE_URI"] ?? "/";

// Application settings
Config::$APP_SETTINGS["APP_NAME"] = Config::configSecret()["APP_SETTINGS"]["APP_NAME"] ?? "IoT-LEDs";
Config::$APP_SETTINGS["WEBSITE_TITLE"] = Config::configSecret()["APP_SETTINGS"]["WEBSITE_TITLE"] ?? "IoT-LEDs";
Config::$APP_SETTINGS["APP_URL"] = Config::configSecret()["APP_SETTINGS"]["APP_URL"] ?? "http://localhost:3000";
Config::$APP_SETTINGS["APP_FAVICON"] = Config::configSecret()["APP_SETTINGS"]["APP_FAVICON"] ?? "/img/favicon.png";
Config::$APP_SETTINGS["APP_AUTHOR"] = Config::configSecret()["APP_SETTINGS"]["APP_AUTHOR"] ?? "Jens Ostertag";
Config::$APP_SETTINGS["APP_VERSION"] = Config::configSecret()["APP_SETTINGS"]["APP_VERSION"] ?? "1.0.0";
Config::$APP_SETTINGS["PRODUCTION"] = Config::configSecret()["APP_SETTINGS"]["PRODUCTION"] ?? true;

// Log settings
Config::$LOG_SETTINGS["LOG_DIRECTORY"] = Config::configSecret()["LOG_SETTINGS"]["LOG_DIRECTORY"] ?? __APP_DIR__ . "/logs/";
Config::$LOG_SETTINGS["LOG_FILENAME"] = Config::configSecret()["LOG_SETTINGS"]["LOG_FILENAME"] ?? "log-%date%.log";
Config::$LOG_SETTINGS["LOG_LEVEL"] = Config::configSecret()["LOG_SETTINGS"]["LOG_TRACE"] ?? Logger::$LOG_TRACE;
Config::$LOG_SETTINGS["LOG_ERROR_REPORT"] = Config::configSecret()["LOG_SETTINGS"]["LOG_ERROR_REPORT"] ?? [];

// Database settings
Config::$DB_SETTINGS["DB_HOST"] = Config::configSecret()["DATABASE_SETTINGS"]["DB_HOST"] ?? "localhost";
Config::$DB_SETTINGS["DB_USER"] = Config::configSecret()["DATABASE_SETTINGS"]["DB_USER"] ?? "username";
Config::$DB_SETTINGS["DB_PASS"] = Config::configSecret()["DATABASE_SETTINGS"]["DB_PASS"] ?? "password";
Config::$DB_SETTINGS["DB_NAME"] = Config::configSecret()["DATABASE_SETTINGS"]["DB_NAME"] ?? "database";
Config::$DB_SETTINGS["DB_USE"] = Config::configSecret()["DATABASE_SETTINGS"]["DB_USE"] ?? false;

// Mail settings
Config::$MAIL_SETTINGS["MAIL_SMTP_HOST"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_HOST"] ?? "smtp.localhost";
Config::$MAIL_SETTINGS["MAIL_SMTP_PORT"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_PORT"] ?? 25;
Config::$MAIL_SETTINGS["MAIL_SMTP_USER"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_USER"] ?? "username";
Config::$MAIL_SETTINGS["MAIL_SMTP_PASS"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_PASS"] ?? "password";
Config::$MAIL_SETTINGS["MAIL_SMTP_SECURE"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_SECURE"] ?? "tls";
Config::$MAIL_SETTINGS["MAIL_SMTP_AUTH"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_SMTP_AUTH"] ?? true;
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_EMAIL"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_DEFAULT_SENDER_EMAIL"] ?? "mail@iot-leds";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_NAME"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_DEFAULT_SENDER_NAME"] ?? "IoT-LEDs";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_REPLY_TO"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_DEFAULT_REPLY_TO"] ?? "mail@iot-leds";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SUBJECT"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_DEFAULT_SUBJECT"] ?? "IoT-LEDs";
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_REDIRECT_ALL_MAILS"] ?? false;
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS_TO"] = Config::configSecret()["MAIL_SETTINGS"]["MAIL_REDIRECT_ALL_MAILS_TO"] ?? "mail@iot-leds";

// ClassLoader settings
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "Config.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "Logger.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "ClassLoader.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"][] = __APP_DIR__ . "/src/lib/";

// SEO settings
Config::$SEO_SETTINGS["SEO_DEFAULT_DESCRIPTION"] = Config::configSecret()["SEO_SETTINGS"]["SEO_DEFAULT_DESCRIPTION"] ?? "Webinterface to control IoT WS2812B-LEDs";
Config::$SEO_SETTINGS["SEO_KEYWORDS"] = Config::configSecret()["SEO_SETTINGS"]["SEO_KEYWORDS"] ?? [];
Config::$SEO_SETTINGS["SEO_IMAGE_PREVIEW"] = Config::configSecret()["SEO_SETTINGS"]["SEO_IMAGE_PREVIEW"] ?? "img/seo/preview.png";
Config::$SEO_SETTINGS["SEO_OPENGRAPH"] = Config::configSecret()["SEO_SETTINGS"]["SEO_OPENGRAPH"] ?? ["OPENGRAPH_SITE_NAME" => null];
Config::$SEO_SETTINGS["SEO_TWITTER"] = Config::configSecret()["SEO_SETTINGS"]["SEO_TWITTER"] ?? ["TWITTER_SITE" => null, "TWITTER_CREATOR" => null];
Config::$SEO_SETTINGS["SEO_ROBOTS"] = Config::configSecret()["SEO_SETTINGS"]["SEO_ROBOTS"] ?? ["noindex", "nofollow"];
Config::$SEO_SETTINGS["SEO_REVISIT"] = Config::configSecret()["SEO_SETTINGS"]["SEO_REVISIT"] ?? "7 days";
