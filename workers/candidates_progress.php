<?php
define("BASE_DIR", __DIR__);
require __DIR__ . '/../vendor/autoload.php';
$settings = require __DIR__.'/../src/settings.php';
use \RemoteStaff\Workers\CandidateProgress;
use RemoteStaff\Workers\IndexCandidates;

use Pheanstalk\Pheanstalk;
$config = $settings["settings"];
$queue =  new Pheanstalk($config['beanstalkd']['host'] . ":" . $config['beanstalkd']['port']);

// Set which queues to bind to
$queue->watch("candidates_progress");

// pick a job and process it
while($job = $queue->reserve()) {

    $worker = new IndexCandidates();

    $received = json_decode($job->getData(), true);
    $action   = $received['action'];
    if(isset($received['data'])) {
        $data = $received['data'];
    } else {
        $data = array();
    }

    echo "Received a $action (" . current($data) . ") ...";
    if(method_exists($worker, $action)) {
        $outcome = $worker->$action($data);

        // how did it go?
        if($outcome) {
            echo "done \n";
            $queue->bury($job);
        } else {
            echo "failed \n";
            $queue->bury($job);
        }
    } else {
        echo "action not found\n";
        $queue->bury($job);
    }
    unset($worker);
}

