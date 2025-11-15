<?php
header('Content-Type: application/json');
include "connect.php";

// Check if required parameters are present
if (empty($_POST['quizId']) || empty($_POST['email'])) {
    echo json_encode([
        'valid' => false,
        'message' => 'Ongeldige aanvraag'
    ]);
    exit;
}

$quizId = intval($_POST['quizId']);
$email = trim($_POST['email']);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'valid' => false,
        'message' => 'Ongeldig email adres'
    ]);
    exit;
}

// Fetch quiz with whitelist deadline
$sql = "SELECT id, whitelistDeadline FROM quiz_Quiz WHERE id = {$quizId}";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo json_encode([
        'valid' => false,
        'message' => 'Quiz niet gevonden'
    ]);
    $conn->close();
    exit;
}

$quiz = $result->fetch_assoc();

// Check if whitelist is active
$whitelistActive = false;
if (!empty($quiz['whitelistDeadline'])) {
    $deadline = new DateTime($quiz['whitelistDeadline']);
    $now = new DateTime();
    $whitelistActive = $now < $deadline;
}

// If whitelist is not active, email is valid
if (!$whitelistActive) {
    echo json_encode([
        'valid' => true,
        'message' => ''
    ]);
    $conn->close();
    exit;
}

// Check if email is in whitelist (case-insensitive)
$emailEscaped = $conn->real_escape_string($email);
$sql = "SELECT id FROM quiz_Whitelist_Email 
        WHERE quiz_quiz_id = {$quizId} 
        AND LOWER(email) = LOWER('{$emailEscaped}')
        LIMIT 1";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        'valid' => false,
        'message' => 'Er ging iets mis bij het controleren van het email adres'
    ]);
    $conn->close();
    exit;
}

if ($result->num_rows > 0) {
    // Email is in whitelist
    echo json_encode([
        'valid' => true,
        'message' => ''
    ]);
} else {
    // Email is not in whitelist
    echo json_encode([
        'valid' => false,
        'message' => 'Inschrijving is momenteel alleen mogelijk voor uitgenodigde deelnemers'
    ]);
}

$conn->close();
