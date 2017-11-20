<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 26/07/16
 * Time: 11:25 PM
 */
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use RemoteStaff\Resources\LeadResource as Lead_Resource;
use RemoteStaff\Resources\SubcontractorResource;

$subcontractor_resource = new SubcontractorResource();
$job_order_resource = new RemoteStaff\Mongo\Resources\JobOrderResource();
$candidate_resource = new \RemoteStaff\Resources\CandidateResource();
$lead_resource = new Lead_Resource();

$app->get('/test/view/', function (Request $request, Response $response, $args) use ($subcontractor_resource, $job_order_resource, $candidate_resource) {
    //$data = $subcontractor_resource->get(3054);
    //$data = $job_order_resource->getByTrackingCode("20160711313292-ASL");
    print_r($candidate_resource->get(122261)->getProgress());
    echo date("Y-m-d H:i:s");
    echo json_encode([success => true, result => $data]);
});

$app->get("/load/", function(Request $request, Response $response, $args) use ($lead_resource){
    $lead = $lead_resource->get(11);
    echo json_encode([success=>true, result=>$lead]);
});

