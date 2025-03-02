<?php
require_once __DIR__ . "/bootstrap.php";

use GO\Scheduler;

$scheduler = new Scheduler();

$scheduler->php(__DIR__ . "/src/Jobs/GrabServerInfoJob.php")->at("* * * * * 5");

$scheduler->run();