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

$sql = "INSERT INTO quiz_Team (name, captain, email, quiz_quiz_id, dateCreated)
VALUES ('{$teamname}', '{$teamcaptain}', '{$email}', $quizId, NOW())";

if (!$conn->query($sql)) {
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}
$conn->close();

header("Location: http://www.quizis.nl/bedankt.php?team={$teamname}&captain={$teamcaptain}");
