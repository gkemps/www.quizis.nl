<?php
include '../connect.php';

ob_start();

$sql = "SELECT * FROM quizis.quiz_Quiz where date > '" . date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s") . "' AND date <= '2025-" . date("m") . "-" . date("d") . " 23:59:59' AND private = 0 and presentation = 1  order by date ASC limit 1";
$result = $conn->query($sql);
$quiz = mysqli_fetch_assoc($result);
if (empty($quiz)) {
    die("uitgeschakeld");
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Navigatie</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.html"><img src="../images/custom/logo_quizis.png"
                            alt="quizis" height="60"></a>
                </div>
            </div>
        </nav>
    </header>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="contact-form" style="background: #fbe6da">
                        <?php if (isset($_POST['teamcode'])): ?>
                            <?php
                            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
                            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . "/team/" . $_POST['teamcode'];
                            header("Location: $url");
                            ?>
                        <?php elseif (isset($_POST['registered'])): ?>
                            <?php
                            $sql = "SELECT teamId, name, captain FROM quiz_Team WHERE quiz_quiz_id = " . $quiz['id'] . " ORDER BY name ASC";

                            $result = $conn->query($sql);

                            $teams = [];
                            while ($row = mysqli_fetch_assoc($result)) {
                                $teams[$row['teamId']] = $row['name'] . " (" . $row['captain'] . ")";
                            }
                            ?>

                            <form id="team-selection" name="team-selection" method="post" action="/aanmelden/index.php">
                                <div class="form-group">
                                    <label for="teamname-selector">Team naam</label>
                                    <select id="teamname-selector" name="teamcode" class="form-control" required>
                                        <option value="">--- kies team</option>
                                        <?php
                                        foreach ($teams as $id => $team):
                                            ?>
                                            <option value="<?php echo $id; ?>"><?php echo $team; ?></option>
                                            <?php
                                        endforeach
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="team_selected" class="btn btn-primary"
                                    style="background-color: #c95b1f; border-color: #c95b1f">Dit is mijn team!</button>
                            </form>
                        <?php else: ?>
                            <h3>Is je team ingeschreven voor <?php echo $quiz['name'] ?>?</h3>

                            <form id="signup-form" name="contact-form" method="post" action="/aanmelden/index.php">
                                <button type="submit" name="registered" class="btn btn-primary"
                                    style="background-color: #c95b1f; border-color: #c95b1f; width:100px;">Ja!</button>

                                <br /><br />
                                Nee, nog niet? <a href="/meedoen/<?php echo $quiz['code']; ?>">Klik dan snel hier</a>!
                            </form>
                        <?php endif ?>
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