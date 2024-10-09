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

$paymentId = $conn->real_escape_string($_POST['id']);

// fetch payment at Mollie
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey(MOLLIE_API_KEY);

try {
    $payment = $mollie->payments->get($paymentId);
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    // return 422 bad request
    http_response_code(422);
    $log->error("Mollie API error: " . $e->getMessage());
    die("Mollie API error: " . $e->getMessage());
}

if ($payment->status !== "paid") {
    // return 422 bad request
    $log->error("webhook trigger for unpaid payment: {$paymentId}");
    die("post error: payment not paid");
}

// update team subscription in database
$sql = "UPDATE quiz_Team SET paid = 1, datePaid = NOW(), amount = amount + {$payment->amount->value} WHERE teamId = '{$teamId}'";

if (!$conn->query($sql)) {
    // return 422 bad request
    http_response_code(500);
    $log->error("error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

// return 200 OK
http_response_code(200);
echo "OK";