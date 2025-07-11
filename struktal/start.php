<?php

// Autoload Composer libraries
require_once(__APP_DIR__ . "/vendor/autoload.php");

// ClassLoader
require_once(__APP_DIR__ . "/struktal/src/ClassLoader.class.php");
$classLoader = ClassLoader::getInstance();

// Load Logger
$classLoader->loadClass(__APP_DIR__ . "/struktal/src/Logger.class.php");

// Load Comm
$classLoader->loadClass(__APP_DIR__ . "/struktal/src/Comm.class.php");

// Configuration files
require_once(__APP_DIR__ . "/struktal/config/Config.class.php");
Config::init();
require_once(__APP_DIR__ . "/src/config/app-config.php");

// Load enums
$classLoader->loadEnums(__APP_DIR__ . "/struktal/src/enum/");

// Load libraries
$classLoader->loadClasses(__APP_DIR__ . "/struktal/src/lib/");

// Load extra enums and classes
foreach(Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"] as $path) {
    $classLoader->loadEnums($path);
    $classLoader->loadClasses($path);
}

unset($classLoader);

// Setup Composer libraries
use eftec\bladeone\BladeOne;
const Blade = new BladeOne(__APP_DIR__ . "/src/templates", __APP_DIR__ . "/template-cache", BladeOne::MODE_DEBUG);

use struktal\Router\Router;
const Router = new Router();
Router->setPagesDirectory(__APP_DIR__ . "/src/pages/");
Router->setAppUrl(Config::$APP_SETTINGS["APP_URL"]);
Router->setAppBaseUri(Config::$ROUTER_SETTINGS["ROUTER_BASE_URI"]);
Router->setStaticDirectoryUri("static/");

use struktal\ORM\Database\Database;
if(Config::$DB_SETTINGS["DB_USE"]) {
    Database::connect(
        Config::$DB_SETTINGS["DB_HOST"],
        Config::$DB_SETTINGS["DB_NAME"],
        Config::$DB_SETTINGS["DB_USER"],
        Config::$DB_SETTINGS["DB_PASS"]
    );
}

use struktal\Auth\Auth;
const Auth = new Auth();
Auth->setUserObjectName(User::class);

// Override BladeOne's include directive to use components with isolated variables
Blade->directive("include", function($expression) {
    $code = Blade->phpTag . " Blade->startComponent($expression); ?>";
    $code .= Blade->phpTag . ' echo Blade->renderComponent(); ?>';
    return $code;
});

// Setup logger
$sendEmailHandler = function(string $message) {
    if(empty(Config::$LOG_SETTINGS["LOG_ERROR_REPORT"])) {
        return;
    }

    $mail = new Mail();
    $mail->setSubject("[" . Config::$APP_SETTINGS["APP_NAME"] . "] Error report")
        ->setTextBody($message);
    foreach(Config::$LOG_SETTINGS["LOG_ERROR_REPORT"] as $recipient) {
        $mail->addRecipient($recipient);
    }
    $mail->send();
};
Logger::addCustomLogHandler(Logger::$LOG_ERROR, $sendEmailHandler);
Logger::addCustomLogHandler(Logger::$LOG_FATAL, $sendEmailHandler);
unset($sendEmailHandler);

// Initialize routes
require_once(__APP_DIR__ . "/src/config/app-routes.php");

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $message = "Error " . $errno . ": ";
    $message .= "\"" . $errstr . "\"";
    $message .= " in " . $errfile . " on line " . $errline;
    try {
        Logger::getLogger("PHP")->error($message);
    } catch(Error|Exception $e) {
        // If the logger fails, log to the default PHP error log
        error_log($message);
    }

    if(Config::$APP_SETTINGS["PRODUCTION"]) {
        // Redirect to error page in production
        Router->redirect(Router->generate("500"));
    } else {
        // Show stack trace screen in development
        echo Blade->run("components.layout.deverror", [
            "exceptionName" => "Error " . $errno,
            "exceptionMessage" => $errstr,
            "trace" => [
                [
                    "file" => $errfile,
                    "line" => $errline
                ]
            ]
        ]);
    }
});

set_exception_handler(function($exception) {
    $message = "Uncaught " . get_class($exception) . ": ";
    $message .= "\"" . $exception->getMessage() . "\"";
    $message .= " in " . $exception->getFile() . " on line " . $exception->getLine();
    $message .= PHP_EOL . $exception->getTraceAsString();

    try {
        Logger::getLogger("PHP")->fatal($message);
    } catch(Error|Exception $e) {
        error_log($message);
    }

    if(Config::$APP_SETTINGS["PRODUCTION"]) {
        // Redirect to error page in production
        Router->redirect(Router->generate("500"));
    } else {
        // Show stack trace screen in development
        $trace = $exception->getTrace();
        echo Blade->run("components.layout.deverror", [
            "exceptionName" => get_class($exception),
            "exceptionMessage" => $exception->getMessage(),
            "trace" => [
                [
                    "file" => $exception->getFile(),
                    "line" => $exception->getLine()
                ],
                ...$trace
            ]
        ]);
    }
});

// Setup timezone
date_default_timezone_set("UTC");
