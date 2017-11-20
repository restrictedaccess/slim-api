<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 8:28 PM
 */

namespace RemoteStaff\Workers;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

abstract class AbstractWorker {

    /**
     * @var string
     */
    private $loggerFileName = "";

    /**
     * @var Monolog\Logger
     */
    private $logger;

    public function __construct(){
        // create a log channel
        $this->init();
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('/home/remotestaff/'.$this->loggerFileName.".log", Logger::WARNING));
        $this->logger = $log;

    }
    abstract public function sync($data);

    public  function init(){

    }

    /**
     * @return Monolog\Logger
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return string
     */
    protected function getLoggerFileName()
    {
        return $this->loggerFileName;
    }

    /**
     * @param string $loggerFileName
     */
    protected function setLoggerFileName($loggerFileName)
    {
        $this->loggerFileName = $loggerFileName;
    }

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