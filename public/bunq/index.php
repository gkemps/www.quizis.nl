<?php
include "../connect.php";
require '../../vendor/autoload.php';
require '../../secrets.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger instance
$log = new Logger('www.quizis.nl');
$log->pushHandler(new StreamHandler('logs/app.log', Logger::DEBUG));

$log->info("bunq webhook called: " . json_encode($_POST));