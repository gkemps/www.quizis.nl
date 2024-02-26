<?php
    include "../connect.php";

    $teamCode = "";
    if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
        $path = explode("/", $_SERVER['REQUEST_URI']);
        if (count($path) > 2) {
            $teamCode = $path[count($path) - 1];
        }
    } 
    
    if(empty($teamCode)) {
        die("geen team gevonden");
    }

    // select team
    $sql = "SELECT * FROM quiz_Team WHERE teamId = '{$teamCode}'";

    if (!$result = $conn->query($sql)) {
        die("Error: " . $conn->error . " (Query: $sql)");
    }
    
    if ($result->num_rows > 0) {
        $team = $result->fetch_assoc();
    } else {
        die("Geen team gevonden");
    }

    // select quiz
    $sql = "SELECT * FROM quiz_Quiz WHERE id = {$team['quiz_quiz_id']}";

    if (!$result = $conn->query($sql)) {
        die("Error: " . $conn->error . " (Query: $sql)");
    }
    
    if ($result->num_rows > 0) {
        $quiz = $result->fetch_assoc();
    } else {
        die("Geen team gevonden");
    }

    // select location
    $sql = "SELECT * FROM quiz_Location WHERE id = {$quiz['quiz_Location_id']}";

    if (!$result = $conn->query($sql)) {
        die("Error: " . $conn->error . " (Query: $sql)");
    }

    if ($result->num_rows > 0) {
        $location = $result->fetch_assoc();
    } else {
        die("Geen locatie gevonden");
    }

    $paid = !empty($team['paid']) && $team['paid'] == 2;
    $payPerTeam = !empty($quiz['pricePerTeam']);
    $payPerPerson = !empty($quiz['pricePerPerson']);
    $maxTeamSize = !empty($quiz['maxTeamSize']) ? $quiz['maxTeamSize'] : 5;
    $prepay = !empty($quiz['prepay']);
    $amount = $payPerTeam ? $quiz['pricePerTeam'] : ($payPerPerson ? $quiz['pricePerPerson'] * $maxTeamSize : 0);
    $quizCode = !empty($quiz['code']) ? $quiz['code'] : "Q".$quiz['id'];    
    $not_free = $payPerTeam || $payPerPerson;

    //date formatter
    $date = new DateTime($quiz['date']);
    $formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
    $formatter->setPattern('EEEE d LLLL HH:mm');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pubquiz met je vrienden, collega's of familie. Quiz op maat in Oirschot, Tilburg, Eindhoven en omstreken. Quiz op maat. In de kroeg of bij je thuis. Bedrijfuitje en personeelsfeesten. ">
    <meta name="author" content="Geert Kemps, kemzy@gewis.nl">
    <title>Pubquiz met je vrienden, collega's of familie. Quiz op maat in Oirschot, Tilburg, Eindhoven en omstreken. </title>
    <!-- core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.transitions.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body id="home" class="homepage">

    <header id="header">
        <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html"><img src="../images/custom/logo_quizis.png" alt="quizis" height="60"></a>
                </div>
            </div>
        </nav>
    </header>

    <section id="contact">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 text-center">
                    <div class="media service-box">
                        <i class="fa fa-5x fa-hand-peace-o" style="color: #c95b1f"></i>
                    </div>
                </div>

                <div class="col-sm-12 text-center">
                    <h2>Bedankt voor jullie inschrijving!</h2>
                    <?php if ($not_free): ?>
                        <br />
                        <div class="display-4" style="background-color:#F8DDCF;padding:20px">
                            <?php if($paid) { ?>
                                Jullie hebben al betaald, dus dat is alvast geregeld!
                            <?php } else if($prepay && $payPerTeam) { ?>
                                We ontvangen de teambijdrage van &euro;<?php echo $amount; ?> graag 
                                <a href="https://www.bunq.me/quiz/<?php echo $amount; ?>/<?php echo urlencode($quizCode."-".$team['name']."-#".$team['id']); ?>/ideal" target="_blank">via deze link</a>. 
                                <br /><br />
                                Daarna ontvang je een bevestiging en is jullie inschrijving defintief.
                            <?php } else if($prepay && $payPerPerson) { ?>
                                We ontvangen de bijdrage van <?php echo $quiz['pricePerPerson']; ?> euro pp graag via onderstaande opties:
                                <br />
                                <?php for ($i = $maxTeamSize; $i > 2; $i--) { ?>
                                    <a href="https://www.bunq.me/quiz/<?php echo $i * $quiz['pricePerPerson']; ?>/<?php echo urlencode($quizCode."-".$team['name']."-#".$team['id']); ?>/ideal" target="_blank">Wij spelen graag mee met <?php echo $i; ?> personen</a><br />    
                                <?php } ?>
                                <br />
                                Daarna ontvang je een bevestiging en is jullie inschrijving defintief.
                            <?php } else if($payPerTeam) { ?>
                                We ontvangen de teambijdrage van &euro;<?php echo $amount; ?> graag 
                                <a href="https://www.bunq.me/quiz/<?php echo $amount; ?>/<?php echo urlencode($quizCode."-".$team['name']."-#".$team['id']); ?>/ideal" target="_blank">via deze link</a>. 
                                <br /><br />
                                <i>Later betalen (zie link in mail) of op de avond zelf mag ook.</i>
                            <?php } else if($payPerPerson) { ?>
                                We ontvangen de bijdrage van <?php echo $quiz['pricePerPerson']; ?> euro pp graag via onderstaande opties:
                                <br />
                                <?php for ($i = $maxTeamSize; $i > 2; $i--) { ?>
                                    <a href="https://www.bunq.me/quiz/<?php echo $i * $quiz['pricePerPerson']; ?>/<?php echo urlencode($quizCode."-".$team['name']."-#".$team['id']); ?>/ideal" target="_blank">Wij spelen graag mee met <?php echo $i; ?> personen</a><br />    
                                <?php } ?>
                                <br />
                                <i>Weet je nog niet met hoeveel je bent? Gebruik dan de link in je mail om later te betalen.<br />Betalen op de avond zelf kan ook.</i>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                    <br />
                    <div class="display-4">
                        <strong>Graag tot <?php echo $formatter->format($date)." uur"; ?> @ <?php echo $location['name']; ?>!</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/mousescroll.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-73901233-1', 'auto');
        ga('send', 'pageview');

    </script>
</body>
</html>
