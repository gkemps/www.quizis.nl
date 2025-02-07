<?php
include "../connect.php";

$teamCode = "";
if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
    $path = explode("/", $_SERVER['REQUEST_URI']);
    if (count($path) > 2) {
        $teamCode = $path[count($path) - 1];
    }
}

if (empty($teamCode)) {
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
                    <a class="navbar-brand" href="index.html"><img src="../images/custom/logo_quizis.png" alt="quizis"
                            height="60"></a>
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
                    <h2>Bedankt voor jullie betaling!</h2>
                    <div class="display-4" style="background-color:#DFF0D8;padding:20px">
                        Bedankt voor jullie betaling. Jullie zijn nu officieel
                        ingeschreven!
                        <br /><br />
                        Klik <a href="/team/<?php echo $team['teamId']; ?>">hier</a> voor je teamoverzicht.
                    </div>
                    <br />
                    <div class="display-4">
                        <strong>Graag tot <?php echo $formatter->format($date) . " uur"; ?> @
                            <?php echo $location['name']; ?>!</strong>
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