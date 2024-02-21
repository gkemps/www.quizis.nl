<?php

include "connect.php";

$sql = "SELECT * FROM quiz_Quiz";

$result = $conn->query($sql);

for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    echo $row['name'] . "<br>";
}

die('done!');