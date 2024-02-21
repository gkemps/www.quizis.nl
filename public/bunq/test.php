<?php
include "../../vendor/autoload.php";

use bunq\Context\ApiContext;
use bunq\Context\BunqContext;
use bunq\Util\BunqEnumApiEnvironmentType;

$environmentType = BunqEnumApiEnvironmentType::PRODUCTION(); // Can also be BunqEnumApiEnvironmentType::PRODUCTION();
$apiKey = ''; // Replace with your API key
$deviceDescription = 'pipple_laptop'; // Replace with your device description
$permittedIps = []; // List the real expected IPs of this device or leave empty to use the current IP

$apiContext = ApiContext::create(
    $environmentType,
    $apiKey,
    $deviceDescription,
    $permittedIps
);

BunqContext::loadApiContext($apiContext);

$fileName = './bunq.conf'; // Replace with your own secure location to store the API context details
$apiContext->save($fileName);