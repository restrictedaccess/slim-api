<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}
date_default_timezone_set("Asia/Manila");

if (function_exists('mb_internal_encoding') && ((int) ini_get('mbstring.func_overload')) & 2)
{
    $mbEncoding = mb_internal_encoding();
    mb_internal_encoding('ASCII');
}

// Create your message and send it with Swift Mailer

if (isset($mbEncoding))
{
    mb_internal_encoding($mbEncoding);
}

require __DIR__ . '/../vendor/autoload.php';
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$cacheDir = dirname(__FILE__).'/cache';
if (!is_dir($cacheDir)) {
    mkdir($cacheDir);
}

session_start();
$paths = [__DIR__.'/../src/classes'];
$isDevMode = false;
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$dbParams = $settings["settings"]["mysql"];
define("BASE_DIR", __DIR__);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
