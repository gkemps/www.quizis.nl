<?php
include "../connect.php";

// select quiz
$quizcode = "";
if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
    $path = explode("/", $_SERVER['REQUEST_URI']);
    if (count($path) > 2) {
        $quizcode = $path[count($path) - 1];
    }
}

$sql = "SELECT * FROM quiz_Quiz WHERE quiz_Location_id = 1 AND private = 0 AND date > NOW() ORDER BY date ASC LIMIT 1";
if ($quizcode != "") {
    $sql = "SELECT * FROM quiz_Quiz WHERE code = '{$quizcode}' AND date > NOW() ORDER BY date ASC LIMIT 1";
}

if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

if ($result->num_rows > 0) {
    $quiz = $result->fetch_assoc();
} else {
    die("Geen quiz gevonden");
}

// select location
$sql = "SELECT * FROM quiz_Location WHERE id = {$quiz['quiz_Location_id']}";

if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}
$location = $result->fetch_assoc();

$date = new DateTime($quiz['date']);
// format
$formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
$formatter->setPattern('EE d LLL HH:mm');

$when = ucfirst($formatter->format($date) . " uur");

$payPerTeam = !empty($quiz['pricePerTeam']);
$payPerPerson = !empty($quiz['pricePerPerson']);
$maxTeamSize = !empty($quiz['maxTeamSize']) ? $quiz['maxTeamSize'] : 5;
$prepay = !empty($quiz['prepay']);
$amount = $payPerTeam ? $quiz['pricePerTeam'] : ($payPerPerson ? $quiz['pricePerPerson'] * $maxTeamSize : 0);

if ($prepay && $payPerTeam) {
    $payment = "{$amount} euro per team, betalen via iDeal";
} else if ($prepay && $payPerPerson) {
    $payment = "max {$amount} euro per team ({$quiz['pricePerPerson']} euro pp), betalen via iDeal";
} else if ($payPerTeam) {
    $payment = "{$amount} euro per team, online via iDeal of op de avond zelf";
} else if ($payPerPerson) {
    $payment = "max {$amount} euro per team ({$quiz['pricePerPerson']} euro pp), online via iDeal of op de avond zelf";
} else {
    $payment = "gratis!";
}

// fturue quiz dates at this location
$sql = sprintf("SELECT * FROM quiz_Quiz WHERE quiz_Location_id = {$quiz['quiz_Location_id']} AND private = 0 AND  date > '%s' ORDER BY date ASC", $quiz['date']);
if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

$futureQuizDates = [];
while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['date']);
    // format
    $formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
    $formatter->setPattern('d MMMM');

    $futureQuizDates[] = $formatter->format($date);
}

$conn->close();

// check if we have a referer in $_GET or in the $_SERSER global
$referer = "";
if (isset($_GET['referer'])) {
    $referer = $_GET['referer'];
} else if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Pubquiz met je vrienden, collega's of familie. Quiz op maat in Oirschot, Tilburg, Eindhoven en omstreken. Quiz op maat. In de kroeg of bij je thuis. Bedrijfuitje en personeelsfeesten. ">
    <meta name="author" content="Geert Kemps, kemzy@gewis.nl">
    <title>Pubquiz met je vrienden, collega's of familie. Quiz op maat in Oirschot, Tilburg, Eindhoven en omstreken.
    </title>
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
    <script src="../js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="../images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body id="home" class="homepage">

    <header id="header">
        <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../index.html"><img src="../images/custom/logo_quizis.png"
                            alt="quizis" height="60"></a>
                </div>
            </div>
        </nav>
    </header>

    <section id="contact">
        <div class="container">
            <div class="row">

                <div class="col-sm-6">
                    <div class="media service-box">
                        <div class="pull-left">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $quiz['name']; ?></h4>
                            <p><?php echo $when . " @ " . $location['name']; ?></p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-exclamation"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $quiz['maxTeamMembers']; ?> personen per team</h4>
                            <p>Maximaal <?php echo $quiz['maxTeamMembers']; ?>(!) personen per team</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-euro"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Bijdrage</h4>
                            <p><?php echo $payment; ?></p>
                        </div>
                    </div>

                    <?php if (!empty($futureQuizDates)) { ?>
                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Zet in je agenda</h4>
                                <p><?php echo implode(", ", $futureQuizDates); ?></p>
                            </div>
                        </div>
                    <?php } ?>

                </div>

                <div class="col-sm-6">
                    <div class="contact-form" style="background: #fbe6da">
                        <h3>Meedoen!</h3>

                        <form id="main-contact-form-2" name="contact-form" method="post" action="../meedoen.php">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Teamnaam" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="captain" class="form-control" placeholder="Team captain"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email adres"
                                    required>
                            </div>
                            <input type="hidden" name="quizId" value="<?php echo $quiz['id']; ?>" />
                            <input type="hidden" name="referer" value="<?php echo $referer; ?>" />
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #c95b1f; border-color: #c95b1f">Bevestigen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/mousescroll.js"></script>
    <script src="../js/smoothscroll.js"></script>
    <script src="../js/jquery.prettyPhoto.js"></script>
    <script src="../js/jquery.isotope.min.js"></script>
    <script src="../js/jquery.inview.min.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),
                m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-73901233-1', 'auto');
        ga('send', 'pageview');

    </script>
</body>

</html>