<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 2:40 PM
 */

namespace RemoteStaff;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/**
 * Class AbstractMongoResource
 *
 * Creates a MongoResource
 *
 * @package RemoteStaff
 *
 *
 */
abstract class AbstractMongoResource {

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    private $documentManager;


    /**
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDocumentManager(){
        if ($this->documentManager===null){
            $this->documentManager = $this->createDocumentManager();
        }
        return $this->documentManager;

    }

    /**
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public function createDocumentManager(){
        AnnotationDriver::registerAnnotationClasses();

        $config = new Configuration();
        $config->setProxyDir('/srv/api/tmp/proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir('/srv/api/tmp/hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setMetadataDriverImpl(AnnotationDriver::create('/srv/api/src/documents'));
        $config->setRetryConnect(PHP_INT_MAX);


        return DocumentManager::create(new Connection("iweb10", [
            "timeout" => 300000,
            "socketTimeoutMS" => 30000
        ]), $config);
    }

} 