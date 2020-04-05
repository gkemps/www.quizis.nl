<?php
  if (!isset($_REQUEST['path'])) {
      header("Location: https://www.quizis.nl");
      die();
  }

  $path = $_REQUEST['path'];
  list($nr, $teams) = explode("-", $path);

  $cost = 15 * $nr;
  header("Location: https://www.bunq.me/quiz/".$cost);
  die($nr); 
?>
