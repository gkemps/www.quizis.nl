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
                <div class="col-sm-12">
                    <h2>Voucher verzilveren</h2>
                    <p><i>Een quizis.nl voucher bemachtigd en je wil deze graag verzilveren? Vul het formulier
                            in en we nemen dan zo snel mogelijk contact met je op!<br />
                            Lees hieronder ook even de voorwaarden die aan de voucher verbonden zijn.</i>
                    </p>
                </div>

                <div class="col-sm-6">
                    <div class="media service-box">
                        <div class="pull-left">
                            <i class="fa fa-euro"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Voucher twv €150 euro!</h4>
                            <p>gelijk aan ons <a href="/#pricing">Quiz Master Turbo</a> pakket</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">±1.5 uur met maximaal 50 personen</h4>
                            <p>In overleg uitbreiding uiteraard mogelijk</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Check tijdig onze beschikbaarheid</h4>
                            <p>afhankelijk van beschikbaarheid quiz masters.<br />(maand december onder voorbehoud)</p>
                        </div>
                    </div>

                </div>

                <div class="col-sm-6">
                    <div class="contact-form" style="background: #fbe6da">
                        <h3>Verzilveren!</h3>
                        <form id="main-contact-form-2" name="contact-form" method="post" action="/voucher/voucher.php">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Je naam" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Je email adres"
                                    required>
                                <input class="ohnohoning" autocomplete="off" type="text" name="revcode"
                                    placeholder="Your name here">
                            </div>
                            <div class="form-group">
                                <input type="text" name="vourcher_place" class="form-control"
                                    placeholder="Waar heb je deze voucher bemachtigd?" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="quiz_time" class="form-control"
                                    placeholder="Wanneer vind de quiz idealiter plaats?" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="quiz_place" class="form-control"
                                    placeholder="Is er al een locatie voor de quiz?" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="quiz_persons" class="form-control"
                                    placeholder="Hoeveel personen doen er naar verwachting mee?" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-submit"
                                style="background-color: #c95b1f; border-color: #c95b1f">Versturen</button>
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

    <!-- disable submit button after submit -->
    <script>
        document.getElementById('main-contact-form-2').addEventListener('submit', function () {
            document.getElementById('btn-submit').disabled = true;
        });
    </script>
</body>

</html>