<?php
declare(strict_types=1);

use Slim\App;
use Yuyui\Interlopertracker\Controllers\ServerInfoController;

return function(App $app){
    $app->post("/server_info", ServerInfoController::class . ":getServerInfo");
};