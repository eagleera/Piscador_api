<?php

$allowedOrigins = array(
'(http(s)://)?(www\.)?api.piscador', // Laravel API Domain
'http://localhost:8080' // VueJS CLient
); 
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != '') {
foreach ($allowedOrigins as $allowedOrigin) {
if (preg_match('#' . $allowedOrigin . '#', $_SERVER['HTTP_ORIGIN'])) {
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS'); 
header('Access-Control-Max-Age: 1000'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); 
break; 
}
}
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application /container and bootstraps the application so it | is ready to receive HTTP / Console requests from the environment .  |  */

$app = require __DIR__ . '/../bootstrap/app.php'; 

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

if (isset($_SERVER['HTTP_ORIGIN'])) {
   // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
   // whitelist of safe domains
   header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
   header('Access - Control - Allow - Credentials:true');
   header('Access - Control - Max - Age:86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

   if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
       header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

   if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
       header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

$app->run();
