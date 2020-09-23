<?php
include '../connect.php';

$sql = "SELECT name, captain FROM quiz_Team ORDER BY name ASC";

$result = $conn->query($sql);

$teams = [];
while($row = mysqli_fetch_assoc($result)){
    $teams[] = $row['name']." (".$row['captain'].")";
}