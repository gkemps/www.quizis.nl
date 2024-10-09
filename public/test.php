<?php
require '../vendor/autoload.php';
require '../secrets.php';

$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey(MOLLIE_API_KEY);

$paymentLink = $mollie->paymentLinks->create([
    "description" => "Test betaling via Mollie via quizis.nl",
    "amount" => [
        "currency" => "EUR",
        "value" => "0.40",
    ],
    "redirectUrl" => "https://quizis.nl/bedankt/abc123",
    "webhookUrl" => "https://quizis.nl/betaald",
    "expiresAt" => "2025-09-15T11:00:00+00:00",
]);

$url = $paymentLink->getCheckoutUrl();

// print url in html
echo "<a href='$url'>Betalen via {$url}</a>";