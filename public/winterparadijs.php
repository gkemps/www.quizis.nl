<?php
include "connect.php";

if (empty($_POST['name'])) {
    header('Location: http://www.quizis.nl/er-ging-iets-mis.html');
    die("post error");
}

$teamname = $conn->real_escape_string($_POST['name']);
$teamcaptain = $conn->real_escape_string($_POST['captain']);
$email = $conn->real_escape_string($_POST['email']);
$quizId = $conn->real_escape_string($_POST['quizId']);

$sql = "INSERT INTO quiz_Team (name, captain, email, quiz_quiz_id)
VALUES ('{$teamname}', '{$teamcaptain}', '{$email}', $quizId)";

$message = implode($_POST, ";");

$headers = 'From: server@sjenkie.nl' . "\r\n" .
    'Reply-To: server@sjenkie.nl' . "\r\n" .
    'Return-Path: server@sjenkie.nl' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail("info@quizis.nl", "Meedoen", $message, $headers, "-f server@sjenkie.nl");

if (!$conn->query($sql)) {
    $message = sprintf("Errormessage: %s\n(%s)\n(%s)\n", $conn->error, implode(";", $_REQUEST), $sql);
    mail('info@quizis.nl', "oeps bij meedoen quiz!", $message, $headers, "-f server@sjenkie.nl");
    die("Oeps, er ging iets fout ({$conn->error}). Probeer het later nog een keer.");
}
$conn->close();

header('Location: http://www.quizis.nl/bedankt_winterparadijs.php?team=x&captain=y');
