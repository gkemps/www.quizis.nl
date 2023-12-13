<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "public/connect.php";
require 'vendor/autoload.php';
require 'secrets.php';

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
$mail->Subject = 'Pubquiz vanavond';
try {
    $mail->setFrom('no-reply@quizis.nl', 'Quizis');
    $mail->addReplyTo('info@quizis.nl', 'Quizis');
} catch(Exception $e) {
    die('error setting phpmailer addresses: '.$e->getMessage());
}

$sql = "SELECT 
    t.id, t.name, t.captain, t.email, q.name as quiz_name, q.date
FROM
    quizis.quiz_Team AS t
        LEFT JOIN
    quizis.quiz_Quiz AS q ON t.quiz_quiz_id = q.id
    where t.quiz_quiz_id in (155) and paid IS NULL";

$result = $conn->query($sql);

$i = 0;
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $message = file_get_contents("public/templates/email_payment_oirsprong.html");
    $message = str_replace("*|QUIZNAME|*", $row['quiz_name']." (".$row['date'].")", $message);
    $message = str_replace("*|TEAMNAME|*", $row['name'], $message);
    $message = str_replace("*|TEAMCAPTAIN|*", $row['captain'], $message);
    $message = str_replace("*|PAYMENT_CODE|*", urlencode($row['name']."-".$row['captain']), $message);

    try {
        $mail->clearAddresses();
        //$mail->addAddress($row['email']);
        $mail->addAddress('oirschot9@gmail.com');
        $mail->Body = $message;
        $mail->AltBody = sprintf("Bedankt voor jullie inschrijving als team %s voor %s. Maar we missen nog jullie betaling, zouden jullie die zsm kunnen voldoen via %s", $row['name'], $row['quiz_name']." ".$row['date'], "https://www.bunq.me/quiz/20/".urlencode($row['name']."-".$row['captain'])."/ideal");

        $mailResult = $mail->send();
        if ($mailResult) {
            printf("mail sent to %s (%s) for quiz %s \r\n", $row['email'], $row['name'], $row['quiz_name']);
        }
    } catch (Exception $e) {
        printf("**** error while sending mail to %s because of %s \r\n", $row['email'], $e);
    }

    $i++;
    if ($i > 0)
        die('temp exit');
}

$conn->close();