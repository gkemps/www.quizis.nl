<?php
header('Content-Type: application/json');

// Database connection details
$servername = "www.quizis.nl";
$username = "bonanza";
$password = "Bouwvak2024Bon@naza!";
$dbname = "misc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the action
$action = $_GET['action'];

if ($action == 'check') {
    // Check the prize status of all squares
    $sql = "SELECT * FROM bonanza_squares";
    $result = $conn->query($sql);
    $squares = array();
    while ($row = $result->fetch_assoc()) {
        $squares[$row['id']] = $row['status'];
    }
    echo json_encode($squares);
} elseif ($action == 'open') {
    // Open a specific square
    $id = intval($_GET['id']);
    // Check if the square has already been opened
    $sql = "SELECT status, prize, opened FROM bonanza_squares WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] != 'closed') {
            $sql = "SELECT name FROM bonanza_prces where id = " . $row['prize'];
            $result = $conn->query($sql);
            $prize = $result->fetch_assoc();
            echo json_encode(array('status' => 'already_opened', 'result' => $row['status'], 'prize' => $prize['name'], 'opened' => $row['opened']));
            $conn->close();
            exit();
        }
    }
    // Determine the chance of winning by the ratio of closed squares and available prizes
    $sql = "SELECT COUNT(*) AS total FROM bonanza_squares WHERE status = 'closed'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $closed_squares = $row['total'];

    $sql = "SELECT COUNT(*) AS total FROM bonanza_prizes WHERE (validFrom IS NULL OR validFrom < NOW()) AND id NOT IN (SELECT prize FROM bonanza_squares WHERE status = 'win')";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $available_prizes = $row['total'];

    $chance = $available_prizes / $closed_squares;
    $randomValue = rand(0, 100) / 100;
    $win = $chance > $randomValue ? 'win' : 'lose';

    // log win ratio and stats
    $draw = sprintf("available_prizes: %d, closed_squares: %d, chance: %f, randomValue: %f, win: %s\n", $available_prizes, $closed_squares, $chance, $randomValue, $win);

    if ($win == 'lose') {
        echo json_encode(array('status' => 'opened', 'result' => $win, 'draw' => $draw));
        $sql = "UPDATE bonanza_squares SET status = '$win', opened = NOW() WHERE id = $id";
        $conn->query($sql);
        $conn->close();
        exit();
    }

    $sql = "SELECT id, prize, description FROM bonanza_prizes WHERE (validFrom IS NULL OR validFrom > NOW()) AND id NOT IN (SELECT prize FROM bonanza_squares WHERE status = 'win') ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);
    $prizes = array();
    while ($row = $result->fetch_assoc()) {
        $prizes[] = ['id' => $row['id'], 'name' => $row['prize'], 'desc' => $row['description']];
    }
    $prize = $prizes[0];
    $prizeId = $prize['id'];

    // Update the square's status in the database
    $sql = "UPDATE bonanza_squares SET status = '$win', prize = $prizeId, opened = NOW() WHERE id = $id";
    $conn->query($sql);
    echo json_encode(array('status' => 'opened', 'result' => $win, 'prize' => $prize['name'], 'desc' => $prize['desc'], 'draw' => $draw));
}

$conn->close();