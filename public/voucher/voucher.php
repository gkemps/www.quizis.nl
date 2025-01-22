<?php
include "../connect.php";
require '../../vendor/autoload.php';
require '../../secrets.php';

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

// reverse captcha
if (!empty($_POST['revcode'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/er-ging-iets-mis.html";
    $log->error("reverse captcha error: " . print_r($_POST, true));
    header('Location: ' . $url);
    die("post error");
}

$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$vourcher_place = $conn->real_escape_string($_POST['vourcher_place']);
$quiz_time = $conn->real_escape_string($_POST['quiz_time']);
$quiz_place = $conn->real_escape_string($_POST['quiz_place']);
$quiz_persons = $conn->real_escape_string($_POST['quiz_persons']);

// mail to admin
$mail = new PHPMailer(true);
try {
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
    $mail->Subject = 'Nieuwe voucher aanvraag';
    $mail->Body = "<p>Er is een nieuwe voucher aanvraag gedaan:</p>
    <p>Naam: {$name}</p>
    <p>Email: {$email}</p>
    <p>Waar bemachtigd: {$vourcher_place}</p>
    <p>Quiz tijd: {$quiz_time}</p>
    <p>Quiz plaats: {$quiz_place}</p>
    <p>Quiz personen: {$quiz_persons}</p>";

    $mail->addAddress('voucher@quizis.nl');
    try {
        $mail->setFrom('no-reply@quizis.nl', 'Quizis');
        $mail->addReplyTo('info@quizis.nl', 'Quizis');
    } catch (Exception $e) {
        $log->error("Erro setting php mailer addresses: " . $e->getMessage());
        die('error setting phpmailer addresses: ' . $e->getMessage());
    }

    $mail->send();
} catch (Exception $e) {
    $log->error("Mailer Error: " . $mail->ErrorInfo);
    die("Oeps, er ging iets fout. Probeer het later nog een keer.");
}

$conn->close();

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/bedankt.html";

header("Location: $url");