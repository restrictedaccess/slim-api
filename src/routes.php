<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
header('Cache-control: no-cache="set-cookie"');
// Routes
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});



require __DIR__ . '/../src/routes/test.php';
require __DIR__."/../src/routes/candidates.php";
require __DIR__."/../src/routes/callnotes.php";
require __DIR__."/../src/routes/evalnotes.php";
require __DIR__."/../src/routes/query.php";
require __DIR__."/../src/routes/prescreened.php";
require __DIR__."/../src/routes/instantemail.php";
require __DIR__."/../src/routes/inactive.php";
//require __DIR__."/../src/routes/jobtitle.php";
require __DIR__."/../src/routes/availability.php";
require __DIR__."/../src/routes/categorized.php";


require __DIR__."/../src/routes/skill.php";

require __DIR__."/../src/routes/filterQuery.php";
require __DIR__."/../src/routes/fileUpload.php";
require __DIR__."/../src/routes/education.php";
require __DIR__."/../src/routes/employmenthistory.php";
require __DIR__."/../src/routes/resume.php";
require __DIR__."/../src/routes/testtaken.php";
require __DIR__."/../src/routes/language.php";
require __DIR__."/../src/routes/login.php";
require __DIR__."/../src/routes/seo_category.php";
require __DIR__."/../src/routes/change_request.php";
require __DIR__."/../src/routes/seo_site_map.php";
require __DIR__."/../src/routes/cta_tracker.php";
require __DIR__."/../src/routes/invoice.php";
