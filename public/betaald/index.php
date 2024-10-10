<?php

include "../connect.php";
require '../../vendor/autoload.php';
require '../../secrets.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger instance
$log = new Logger('www.quizis.nl');
$log->pushHandler(new StreamHandler('../../logs/app.log', Logger::DEBUG));

if (empty($_POST['id'])) {
    // return 422 bad request
    http_response_code(422);
    $log->error("post error: no id provided by webhook: " . json_encode($_POST));
    die("post error: no id provided by webhook");
}

// fetch teamId from url: /betaald/{teamId}
$teamId = explode("/", $_SERVER['REQUEST_URI'])[2];
if (empty($teamId)) {
    // return 422 bad request
    http_response_code(422);
    $log->error("post error: no teamId provided by webhook: " . $_SERVER['REQUEST_URI']);
    die("request error: no teamId provided by webhook");
}

$paymentLinkId = $conn->real_escape_string($_POST['id']);

// fetch payment at Mollie
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey(MOLLIE_API_KEY);

try {
    $log->info("fetching payment Link : {$paymentLinkId}");
    $paymentLink = $mollie->paymentLinks->get($paymentLinkId);
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    // return 422 bad request
    http_response_code(422);
    $log->error("Mollie API error: " . $e->getMessage());
    die("Mollie API error x: " . $e->getMessage());
}

$payments = $paymentLink->payments();
$payment = null;
foreach ($payments as $p) {
    if ($p->status === "paid") {
        $payment = $p;
        break;
    }
}

if ($payment === null) {
    // return 422 bad request
    http_response_code(422);
    $log->error("error: no paid payment found in payment link: " . json_encode($paymentLink));
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

// update team subscription in database
$sql = "UPDATE quiz_Team SET paid = 1, datePaid = NOW(), amount = COALESCE(amount, 0) + {$payment->amount->value} WHERE teamId = '{$teamId}'";

if (!$conn->query($sql)) {
    // return 422 bad request
    http_response_code(500);
    $log->error("error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

// return 200 OK
http_response_code(200);
echo "OK";