<?php
include "connect.php";
require '../vendor/autoload.php';
require '../secrets.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger instance
$log = new Logger('www.quizis.nl');
$log->pushHandler(new StreamHandler('../logs/app.log', Logger::DEBUG));

if (empty($_POST['name'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/er-ging-iets-mis.html";
    $log->error("post error");
    header('Location: ' . $url);
    die("post error");
}

$teamname = $conn->real_escape_string($_POST['name']);
$teamcaptain = $conn->real_escape_string($_POST['captain']);
$email = $conn->real_escape_string($_POST['email']);
$quizId = $conn->real_escape_string($_POST['quizId']);
$guid = uniqid();
$referer = $conn->real_escape_string($_POST['referer']);
$teamMembers = isset($_POST['teamMembers']) ? intval($_POST['teamMembers']) : "NULL";

//save subscription
$sql = "INSERT INTO quiz_Team (name, captain, email, quiz_quiz_id, referer, teamId, teamMembers, dateCreated)
VALUES ('{$teamname}', '{$teamcaptain}', '{$email}', $quizId, '{$referer}', '{$guid}', {$teamMembers}, NOW())";

if (!$conn->query($sql)) {
    $log->error("Error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

// fetch id
$sql = "SELECT LAST_INSERT_ID() AS id";
$result = $conn->query($sql);
if (!$result) {
    $log->error("Error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

// fetch subscription
$sql = "SELECT * FROM quiz_Team WHERE id = {$result->fetch_assoc()['id']}";
$result = $conn->query($sql);
if (!$result) {
    $log->error("Error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}
$subscription = $result->fetch_assoc();

// fetch quiz
$sql = "SELECT * FROM quiz_Quiz WHERE id = {$quizId}";
$result = $conn->query($sql);
if (!$result) {
    $log->error("Error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}
$quiz = $result->fetch_assoc();

// fetch location
$sql = "SELECT * FROM quiz_Location WHERE id = {$quiz['quiz_Location_id']}";
$result = $conn->query($sql);
if (!$result) {
    $log->error("Error: " . $sql . "<br>" . $conn->error);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}
$location = $result->fetch_assoc();

// quiz specifications
$payPerTeam = !empty($quiz['pricePerTeam']);
$payPerPerson = !empty($quiz['pricePerPerson']);
$maxTeamMembers = !empty($quiz['maxTeamMembers']) ? $quiz['maxTeamMembers'] : 5;
$prepay = !empty($quiz['prepay']);
$amount = $payPerTeam ? $quiz['pricePerTeam'] : ($payPerPerson ? $quiz['pricePerPerson'] * $maxTeamMembers : 0);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/team/{$subscription['teamId']}";

//payment text
$paymentText = "Deelname is gratis!";
if ($prepay) {
    if ($payPerTeam) {
        $paymentText = "Deelname is {$amount} euro per team en mocht je dat nog niet hebben voldaan, 
        dan mag dat via <a href=\"{$url}\">deze link</a>. Je ontvangt een definitieve bevestiging zodra 
        je betaling is ontvangen";
    } else if ($payPerPerson) {
        $paymentText = "Deelname is {$amount} euro per team ({$quiz['pricePerPerson']} euro pp) en mocht 
        je dat nog niet hebben voldaan, dan mag dat via <a href=\"{$url}\">deze link</a>. Je ontvangt een 
        definitieve bevestiging zodra je betaling is ontvangen";
    }
} else {
    if ($payPerTeam) {
        $paymentText = "Deelname is {$amount} euro per team en mocht je dat nog niet hebben voldaan, 
        dan mag dat via <a href=\"{$url}\">deze link</a>. Betalen op de avond zelf mag ook, maar vooraf 
        betalen wordt gewaardeerd.";
    } else if ($payPerPerson) {
        $paymentText = "Deelname is {$amount} euro per team ({$quiz['pricePerPerson']} euro pp) en mocht 
        je dat nog niet hebben voldaan, dan mag dat via <a href=\"{$url}\">deze link</a>. Betalen op de avond
        zelf mag ook, maar vooraf betalen wordt gewaardeerd.";
    }
}

// date formating
$date = new DateTime($quiz['date']);
$formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
$formatter->setPattern('EEEE d LLLL HH:mm');

//send mail
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'pixel.mxrouting.net';
$mail->SMTPAuth = true;
$mail->Username = 'no-reply@quizis.nl';
$mail->Password = SMTP_PASSWORD;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
$mail->Subject = 'Inschrijving Pubquiz: ' . $quiz['name'];
try {
    $mail->setFrom('no-reply@quizis.nl', 'Quizis');
    $mail->addReplyTo('info@quizis.nl', 'Quizis');
} catch (Exception $e) {
    $log->error("Erro setting php mailer addresses: " . $e->getMessage());
    die('error setting phpmailer addresses: ' . $e->getMessage());
}
$mail->addBcc("inschrijven@quizis.nl");
$message = file_get_contents("templates/confirmation.html");
$message = str_replace("*|QUIZ|*", $quiz['name'], $message);
$message = str_replace("*|WHEN|*", $formatter->format($date) . " uur @ " . $location['name'], $message);
$message = str_replace("*|PAYMENTTEXT|*", $paymentText, $message);
$message = str_replace("*|TEAMNAME|*", $subscription['name'], $message);
$message = str_replace("*|TEAMCAPTAIN|*", $subscription['captain'], $message);
$message = str_replace("*|MAXTEAMMEMBERS|*", $maxTeamMembers, $message);

try {
    $mail->clearAddresses();
    $mail->addAddress($subscription['email']);
    $mail->Body = $message;
    $mail->AltBody = sprintf(
        "Bedankt voor jullie inschrijving als team %s voor %s op %s. Check of jullie betaling al in goede orde is ontvangen via deze link: {$url}",
        $subscription['name'],
        $quiz['name'],
        $formatter->format($date) . " uur"
    );

    $mailResult = $mail->send();
    if ($mailResult) {
        $sqlUpdate = "UPDATE quiz_Team SET paid = 0 where id = " . $subscription['id'];
        $updateResult = $conn->query($sqlUpdate);
    }
} catch (Exception $e) {
    $log->error("Error sending mail: " . $e->getMessage());
}

$conn->close();

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/team/{$subscription['teamId']}";

header("Location: $url");
