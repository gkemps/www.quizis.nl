<?php
if (empty($_POST['teamname']) || empty($_POST['teamsize'])) {
    header("location: https://www.quizis.nl/er-ging-iets-mis.html");
}

$amount = 3 * (int) $_POST['teamsize'];
$desc = rawurlencode($_POST['teamname']);

header("location: ".sprintf("https://bunq.me/quiz/%d/%s", $amount, $desc));