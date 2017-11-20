<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 12:23 PM
 */
require __DIR__ . '/vendor/autoload.php';
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$cacheDir = BASE_DIR.'/cache';
if (!is_dir($cacheDir)) {
    mkdir($cacheDir);
}

$paths = [__DIR__.'/src/entities'];
$isDevMode = false;
// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$dbParams = $settings["settings"]["mysql"];
define("BASE_DIR", __DIR__);
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $cacheDir);
$entityManager = EntityManager::create($dbParams, $config);
// replace with mechanism to retrieve EntityManager in your app

return ConsoleRunner::createHelperSet($entityManager);
