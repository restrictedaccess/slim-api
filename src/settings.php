<?php
return [
    'settings' => [
        "env" => "dev",
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        //Database Settings
        'mysql' => [
            'driver' => 'pdo_mysql',
            'user' => 'remotestaff',
            'password' => 'i0MpD3k6yqTz',
            'dbname' => 'remotestaff',
            "host"=>"iweb11"
        ],

        //Beanstalkd Config
        'beanstalkd' => [
            "host" => "127.0.0.1",
            "port" => "11300"
        ],

        "mailconfig" => [
            "host" => "smtp.mailgun.org",
            "username" => "postmaster@mail.realestate.ph",
            "password" => "0ada814091b78f722e0aa9571ebdc63f",
            "port" => 465,
            "ssl" => "tls"

        ],
        "mailgun" => [
            "api_key"=>"key-8055d61602a4f4a21201f59fe789ad9e",
             "domain"=>"mg.remotestaff.com.au"
        ],
        "uploads_dir" => "/srv/api/uploads/uploads",
        "files_dir" => "/srv/api/uploads/applicants_files",
        "solr" => [
            "host"=>"iweb_solr",
            "port"=> 8983
        ],

        "couchdb" => [
            "host" => "http://replication:r2d2rep@iweb10:5984"
        ],
        "njs_url" => "http://test.njs.remotestaff.com.au",
        "valid_domains" => [
            "http://devs.remotestaff.com.au/",
            "http://staging.remotestaff.com.au/",
            "http://remotestaff.com.au/",
            "http://www.remotestaff.com.au/"
        ]

    ],
];
