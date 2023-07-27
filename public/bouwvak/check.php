<?php
include "../connect.php";
$dbname = "misc";

// Connect to the database
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Function to update the row in the 'users' table
function updateUser($connection, $id) {
  $id = mysqli_real_escape_string($connection, $id);

  // Check if the row with the given ID exists in the table
  $query = "SELECT * FROM bouwvak_bonanza WHERE id = '$id'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    // Row exists, update the data
    $updateQuery = "UPDATE bouwvak_bonanza SET entered = NOW() WHERE id = '$id'";
    if (mysqli_query($connection, $updateQuery)) {
        $row = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        return $row['prize'];
    } else {
      die(mysqli_error($connection));
    }
  } else {
    return "";
  }
}

if (isset($_POST['number'])) {
  $id = $_POST['number'];

  $prize = updateUser($connection, $id);

  header("location: http://www.quizis.nl/bouwvak?number={$_POST['number']}&prize=$prize");
}

// Close the database connection
mysqli_close($connection);
?>