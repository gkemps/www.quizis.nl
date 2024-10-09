<?php
require '../../vendor/autoload.php';
require '../../secrets.php';
require '../connect.php';

if (empty($_GET['teamId'])) {
    die("Geen teamId opgegeven");
}

if (empty($_GET['amount'])) {
    die("Geen bedrag opgegeven");
}

// team data ophalen
$teamId = $conn->real_escape_string($_GET['teamId']);
$sql = "SELECT * FROM quiz_Team WHERE teamId = '{$teamId}'";
if (!$result = $conn->query($sql)) {
    die("Team niet gevonden");
}

if ($result->num_rows > 0) {
    $team = $result->fetch_assoc();
} else {
    die("Geen team gevonden");
}

// quiz data ophalen
$sql = "SELECT * FROM quiz_Quiz WHERE id = {$team['quiz_quiz_id']}";
if (!$result = $conn->query($sql)) {
    die("Quiz niet gevonden");
}

if ($result->num_rows > 0) {
    $quiz = $result->fetch_assoc();
} else {
    die("Geen quiz gevonden");
}

$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey(MOLLIE_API_KEY);

$description = "{$quiz['name']} - {$team['name']} #{$team['id']}";

// convert amount to valid currency format with 2 decimals
$amount = number_format($_GET['amount'], 2, '.', '');

$paymentLink = $mollie->paymentLinks->create([
    "description" => $description,
    "amount" => [
        "currency" => "EUR",
        "value" => $amount,
    ],
    "redirectUrl" => "https://quizis.nl/bedankt/{$team['teamId']}",
    "webhookUrl" => "https://quizis.nl/betaald/{$team['teamId']}",
    "expiresAt" => date('Y-m-d\TH:i:s\Z', strtotime('+10 minutes')),
]);

$url = $paymentLink->getCheckoutUrl();

header("Location: $url");