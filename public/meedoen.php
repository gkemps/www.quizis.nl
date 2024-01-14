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
$guid = substr(com_create_guid(), 1, 36);

$sql = "INSERT INTO quiz_Team (name, captain, email, quiz_quiz_id, teamId, dateCreated)
VALUES ('{$teamname}', '{$teamcaptain}', '{$email}', $quizId, '{$guid}', NOW())";

if (!$conn->query($sql)) {
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

$sql = "SELECT LAST_INSERT_ID() AS id";
$result = $conn->query($sql);
if (!$result) {
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

$sql = "SELECT * FROM quiz_Team WHERE id = {$result->fetch_assoc()['id']}";
$subscription = $conn->query($sql);
if (!$result) {
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

$conn->close();

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $protocol.'://'.$_SERVER['HTTP_HOST'] . "/bedankt/{$subscription->fetch_assoc()['teamId']}";

header("Location: $url");
