<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


// curl
$container['curl'] = function ($c) {
    $env = $c->get('settings')['env'];
    $curl = new RemoteStaff\Components\Curl();
    $ch = $curl->curl;
    //curl_setopt( $ch, CURLOPT_URL, $url );

    curl_setopt( $ch, CURLOPT_HEADER, false );

    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );

    curl_setopt( $ch, CURLOPT_VERBOSE, true );

    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );

    curl_setopt( $ch, CURLOPT_FAILONERROR, false );

    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );

    if (in_array($env, ["dev", "staging"])){
        curl_setopt($ch, CURLOPT_CAINFO, "/home/remotestaff/rs.crt");
    }

    return $curl;
};
