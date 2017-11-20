<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 5:47 PM
 */

namespace RemoteStaff;


abstract class AbstractSolrResource {
    /**
     * Get the solr config
     * @param $core The name of core
     * @return array
     */
    protected function getSolrConfig($core){
        $settings = require dirname(__FILE__)."/../settings.php";
        return [
            "endpoint" => [
                "api_server" => [
                    "core" => $core,
                    "port" => $settings["settings"]["solr"]["port"],
                    "host" => $settings["settings"]["solr"]["host"]
                ]
            ]
        ];
    }
} 