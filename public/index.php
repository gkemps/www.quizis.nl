<?php
// fetch future quiz dates
include "connect.php";

$sql = "SELECT * FROM quiz_Quiz WHERE quiz_Location_id = 1 AND private = 0 AND date > NOW() ORDER BY date ASC";
if (!$result = $conn->query($sql)) {
    die("Error: " . $conn->error . " (Query: $sql)");
}

$quiz_dates = [];
while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['date']);
    // format
    $formatter = new \IntlDateFormatter('nl_NL', \IntlDateFormatter::SHORT, \IntlDateFormatter::SHORT);
    $formatter->setPattern('d MMMM');

    $quiz_dates[] = $formatter->format($date);
}

$conn->close();

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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.transitions.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Navigatie</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="images/custom/logo_quizis.png" alt="logo"
                            height="60"></a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="scroll active"><a href="#home">Home</a></li>
                        <li class="scroll"><a href="#features">Mogelijkheden</a></li>
                        <li class="scroll"><a href="#services">Hoe werkt het?</a></li>
                        <!--<li class="scroll"><a href="#portfolio">Agenda</a></li>-->
                        <li class="scroll"><a href="#pricing">Prijzen</a></li>
                        <!--<li class="scroll"><a href="#blog">Inschrijven</a></li>-->
                        <li class="scroll"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

    <section id="main-slider">
        <div class="owl-carousel">
            <div class="item" style="background-image: url(images/slider/gezellige_pubquiz_oirsprong.png);">
                <div class="slider-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6" style="width: 100%; text-align: right">
                                <div class="carousel-content">
                                    <?php if (count($quiz_dates) > 0) { ?>
                                        <h2>
                                            <?php
                                            print implode("<br />", $quiz_dates);
                                            ?>
                                            <br />
                                            <br />
                                            <span
                                                style="background-color: #f8f0d3; border-radius: 25px; border: 5px solid #c95a1f; padding: 10px"><a
                                                    href="/meedoen">Inschrijven!</a></span>
                                        </h2>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item" style="background-image: url(images/slider/slider-winterparadijs-2024.jpg);">
                <div class="slider-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h2>
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <span
                                            style="background-color: #f8f0d3; border-radius: 25px; border: 5px solid #c95a1f; padding: 10px"><a
                                                href="/winterparadijs">Inschrijven!</a></span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.owl-carousel-->
    </section><!--/#main-slider-->

    <section id="cta" class="wow fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <h2>Omdat er altijd reden voor een Quiz is</h2>
                    <p>Een pubquiz in je favoriete kroeg. Je collega's verslaan op het personeelsfeest. Of je familie
                        uitdagen op dat weekendje weg. Quizis verzorgt leuke, uitdagende quizzen met vragen in allerlei
                        vormen en maten komende uit verschillende categorieën. We denken graag met je mee om jouw eigen
                        PubQuiz tot een succes te maken. Vraag je offerte bij ons aan, of kijk wanneer het weer Quizis.
                    </p>
                </div>
                <div class="col-sm-3 text-right">
                    <a class="btn btn-primary btn-lg" href="#features">Meer weten</a>
                </div>
            </div>
        </div>
    </section><!--/#cta-->

    <section id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Quiz Mogelijkheden</h2>
                <p class="text-center wow fadeInDown">Quiszis verzorgt wekelijks/maandelijkse quizzen in cafés, maar
                    heeft ook ervaring met het organiseren van een geslaagde quiz op een personeelsfeest, familieweekend
                    of verenigingsuitje. Wij denken graag met je mee en komen samen met jou tot een voorstel op maat.
                    Alles is mogelijk.</p>
            </div>
            <div class="row">
                <div class="col-sm-6 wow fadeInLeft">
                    <img class="img-responsive" src="images/custom/logo_quizis_large.png" alt="">
                </div>
                <div class="col-sm-6">
                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-comment-o"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Pubquiz</h4>
                            <p>Een wekelijkse of maandelijkse quiz in je favoriete kroeg.</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-magic"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Quiz op maat</h4>
                            <p>Quiz volledig op maat. Vragen uit je eigen regio, sport, sector of cultuur.</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-futbol-o"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Thema quiz</h4>
                            <p>Quiz in een thema naar keuze. Geheel over sport, film of toch het afgelopen jaar.</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-industry"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Personeelsfeest</h4>
                            <p>Daag je collega's uit die het altijd beter weten tijdens je bedrijfsuitje.</p>
                        </div>
                    </div>

                    <div class="media service-box wow fadeInRight">
                        <div class="pull-left">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Familie weekend</h4>
                            <p>Versla die ene irritante oom en laat zien dat jij de slimste bent van de familie.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--<section id="cta2">-->
    <!--<div class="container">-->
    <!--<div class="text-center">-->
    <!--<h2 class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms"><span>MULTI</span> IS A CREATIVE HTML TEMPLATE</h2>-->
    <!--<p class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">Mauris pretium auctor quam. Vestibulum et nunc id nisi fringilla <br />iaculis. Mauris pretium auctor quam.</p>-->
    <!--<p class="wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms"><a class="btn btn-primary btn-lg" href="#">Free Download</a></p>-->
    <!--<img class="img-responsive wow fadeIn" src="images/cta2/cta2-img.png" alt="" data-wow-duration="300ms" data-wow-delay="300ms">-->
    <!--</div>-->
    <!--</div>-->
    <!--</section>-->

    <section id="work-process">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">QUIZIS: Compleet verzorgde avond</h2>
                <p class="text-center wow fadeInDown">wij staan garant voor</p>
            </div>

            <div class="row text-center">
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="0ms">
                        <div class="icon-circle">
                            <span>1</span>
                            <i class="fa fa-question fa-2x"></i>
                        </div>
                        <h3>UITDAGING</h3>
                    </div>
                </div>
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="100ms">
                        <div class="icon-circle">
                            <span>2</span>
                            <i class="fa fa-smile-o fa-2x"></i>
                        </div>
                        <h3>PLEZIER</h3>
                    </div>
                </div>
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="200ms">
                        <div class="icon-circle">
                            <span>3</span>
                            <i class="fa fa-heart fa-2x"></i>
                        </div>
                        <h3>GEZELLIGHEID</h3>
                    </div>
                </div>
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="300ms">
                        <div class="icon-circle">
                            <span>4</span>
                            <i class="fa fa-plus fa-2x"></i>
                        </div>
                        <h3>DIVERSITEIT</h3>
                    </div>
                </div>
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="400ms">
                        <div class="icon-circle">
                            <span>5</span>
                            <i class="fa fa-beer fa-2x"></i>
                        </div>
                        <h3>HILARITEIT</h3>
                    </div>
                </div>
                <div class="col-md-2 col-md-4 col-xs-6">
                    <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="500ms">
                        <div class="icon-circle">
                            <span>6</span>
                            <i class="fa fa-check fa-2x"></i>
                        </div>
                        <h3>KWALITEIT</h3>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#work-process-->

    <section id="services">
        <div class="container">

            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Wat is een PubQuiz?</h2>
                <p class="text-center wow fadeInDown"></p>
            </div>

            <div class="row">
                <div class="features">
                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-repeat"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Acht rondes, incl. foto & muziek</h4>
                                <p>Een PubQuiz bestaat uit 8 rondes van 10 vragen. Er is 1 fotoronde, 1 muziekronde en
                                    diverse audiofragmenten.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Teams</h4>
                                <p>Een PubQuiz team bestaat uit 2 tot 5 personen. Ieder team aan een eigen tafel.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="300ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-hourglass"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Avond vullend</h4>
                                <p>De duur van de quiz is ongeveer 2,5 uur. Dat is inclusief 2 pauzes en de
                                    prijsuitreiking.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="400ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Locatie</h4>
                                <p>In de regio Oirschot (Eindhoven, Tilburg, Den Bosch) of daarbuiten. In je favoriete
                                    kroeg, de voetbal kantine, op kantoor of op iedere locatie naar keuze.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="500ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-ban"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Hulplijnen</h4>
                                <p>Quizis verzorgt kennis quizzen, dus doen we deze uit het blote hoofd. Mobiele
                                    telefoons en andere hulplijnen zijn niet toegestaan.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-microphone"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Quiz Master</h4>
                                <p>
                                    De Quizis Quiz Master leest de vragen voor en controleert de antwoorden. Zelf
                                    presenteren mag uiteraard ook.
                                </p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                </div>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#services-->

    <!--<section id="portfolio">-->
    <!--<div class="container">-->
    <!--<div class="section-header">-->
    <!--<h2 class="section-title text-center wow fadeInDown">Our Works</h2>-->
    <!--<p class="text-center wow fadeInDown">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->

    <!--<div class="text-center">-->
    <!--<ul class="portfolio-filter">-->
    <!--<li><a class="active" href="#" data-filter="*">All Works</a></li>-->
    <!--<li><a href="#" data-filter=".creative">Creative</a></li>-->
    <!--<li><a href="#" data-filter=".corporate">Corporate</a></li>-->
    <!--<li><a href="#" data-filter=".portfolio">Portfolio</a></li>-->
    <!--</ul>&lt;!&ndash;/#portfolio-filter&ndash;&gt;-->
    <!--</div>-->

    <!--<div class="portfolio-items">-->
    <!--<div class="portfolio-item creative">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/01.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 1</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item corporate portfolio">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/02.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 2</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item creative">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/03.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 3</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item corporate">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/04.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 4</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item creative portfolio">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/05.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 5</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item corporate">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/06.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 5</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item creative portfolio">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/07.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 7</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->

    <!--<div class="portfolio-item corporate">-->
    <!--<div class="portfolio-item-inner">-->
    <!--<img class="img-responsive" src="images/portfolio/08.jpg" alt="">-->
    <!--<div class="portfolio-info">-->
    <!--<h3>Portfolio Item 8</h3>-->
    <!--Lorem Ipsum Dolor Sit-->
    <!--<a class="preview" href="images/portfolio/full.jpg" rel="prettyPhoto"><i class="fa fa-eye"></i></a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.portfolio-item&ndash;&gt;-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.container&ndash;&gt;-->
    <!--</section>&lt;!&ndash;/#portfolio&ndash;&gt;-->

    <!--<section id="about">-->
    <!--<div class="container">-->

    <!--<div class="section-header">-->
    <!--<h2 class="section-title text-center wow fadeInDown">About Us</h2>-->
    <!--<p class="text-center wow fadeInDown">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->

    <!--<div class="row">-->
    <!--<div class="col-sm-6 wow fadeInLeft">-->
    <!--<h3 class="column-title">Video Intro</h3>-->
    <!--&lt;!&ndash; 16:9 aspect ratio &ndash;&gt;-->
    <!--<div class="embed-responsive embed-responsive-16by9">-->
    <!--<iframe src="//player.vimeo.com/video/58093852?title=0&amp;byline=0&amp;portrait=0&amp;color=e79b39" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>-->
    <!--</div>-->
    <!--</div>-->

    <!--<div class="col-sm-6 wow fadeInRight">-->
    <!--<h3 class="column-title">Multi Capability</h3>-->
    <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->

    <!--<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>-->

    <!--<div class="row">-->
    <!--<div class="col-sm-6">-->
    <!--<ul class="nostyle">-->
    <!--<li><i class="fa fa-check-square"></i> Ipsum is simply dummy</li>-->
    <!--<li><i class="fa fa-check-square"></i> When an unknown</li>-->
    <!--</ul>-->
    <!--</div>-->

    <!--<div class="col-sm-6">-->
    <!--<ul class="nostyle">-->
    <!--<li><i class="fa fa-check-square"></i> The printing and typesetting</li>-->
    <!--<li><i class="fa fa-check-square"></i> Lorem Ipsum has been</li>-->
    <!--</ul>-->
    <!--</div>-->
    <!--</div>-->

    <!--<a class="btn btn-primary" href="#">Learn More</a>-->

    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</section>&lt;!&ndash;/#about&ndash;&gt;-->

    <!--<section id="meet-team">-->
    <!--<div class="container">-->
    <!--<div class="section-header">-->
    <!--<h2 class="section-title text-center wow fadeInDown">Meet The Team</h2>-->
    <!--<p class="text-center wow fadeInDown">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->

    <!--<div class="row">-->
    <!--<div class="col-sm-6 col-md-3">-->
    <!--<div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="0ms">-->
    <!--<div class="team-img">-->
    <!--<img class="img-responsive" src="images/team/01.jpg" alt="">-->
    <!--</div>-->
    <!--<div class="team-info">-->
    <!--<h3>Bin Burhan</h3>-->
    <!--<span>Co-Founder</span>-->
    <!--</div>-->
    <!--<p>Backed by some of the biggest names in the industry, Firefox OS is an open platform that fosters greater</p>-->
    <!--<ul class="social-icons">-->
    <!--<li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
    <!--</ul>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="col-sm-6 col-md-3">-->
    <!--<div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="100ms">-->
    <!--<div class="team-img">-->
    <!--<img class="img-responsive" src="images/team/02.jpg" alt="">-->
    <!--</div>-->
    <!--<div class="team-info">-->
    <!--<h3>Jane Man</h3>-->
    <!--<span>Project Manager</span>-->
    <!--</div>-->
    <!--<p>Backed by some of the biggest names in the industry, Firefox OS is an open platform that fosters greater</p>-->
    <!--<ul class="social-icons">-->
    <!--<li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
    <!--</ul>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="col-sm-6 col-md-3">-->
    <!--<div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="200ms">-->
    <!--<div class="team-img">-->
    <!--<img class="img-responsive" src="images/team/03.jpg" alt="">-->
    <!--</div>-->
    <!--<div class="team-info">-->
    <!--<h3>Pahlwan</h3>-->
    <!--<span>Designer</span>-->
    <!--</div>-->
    <!--<p>Backed by some of the biggest names in the industry, Firefox OS is an open platform that fosters greater</p>-->
    <!--<ul class="social-icons">-->
    <!--<li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
    <!--</ul>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="col-sm-6 col-md-3">-->
    <!--<div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="300ms">-->
    <!--<div class="team-img">-->
    <!--<img class="img-responsive" src="images/team/04.jpg" alt="">-->
    <!--</div>-->
    <!--<div class="team-info">-->
    <!--<h3>Nasir uddin</h3>-->
    <!--<span>UI/UX</span>-->
    <!--</div>-->
    <!--<p>Backed by some of the biggest names in the industry, Firefox OS is an open platform that fosters greater</p>-->
    <!--<ul class="social-icons">-->
    <!--<li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
    <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
    <!--</ul>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->

    <!--<div class="divider"></div>-->

    <!--<div class="row">-->
    <!--<div class="col-sm-4">-->
    <!--<h3 class="column-title">Our Skills</h3>-->
    <!--<strong>GRAPHIC DESIGN</strong>-->
    <!--<div class="progress">-->
    <!--<div class="progress-bar progress-bar-primary" role="progressbar" data-width="85">85%</div>-->
    <!--</div>-->
    <!--<strong>WEB DESIGN</strong>-->
    <!--<div class="progress">-->
    <!--<div class="progress-bar progress-bar-primary" role="progressbar" data-width="70">70%</div>-->
    <!--</div>-->
    <!--<strong>WORDPRESS DEVELOPMENT</strong>-->
    <!--<div class="progress">-->
    <!--<div class="progress-bar progress-bar-primary" role="progressbar" data-width="90">90%</div>-->
    <!--</div>-->
    <!--<strong>JOOMLA DEVELOPMENT</strong>-->
    <!--<div class="progress">-->
    <!--<div class="progress-bar progress-bar-primary" role="progressbar" data-width="65">65%</div>-->
    <!--</div>-->
    <!--</div>-->

    <!--<div class="col-sm-4">-->
    <!--<h3 class="column-title">Our History</h3>-->
    <!--<div role="tabpanel">-->
    <!--<ul class="nav main-tab nav-justified" role="tablist">-->
    <!--<li role="presentation" class="active">-->
    <!--<a href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-expanded="true">2010</a>-->
    <!--</li>-->
    <!--<li role="presentation">-->
    <!--<a href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-expanded="false">2011</a>-->
    <!--</li>-->
    <!--<li role="presentation">-->
    <!--<a href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-expanded="false">2013</a>-->
    <!--</li>-->
    <!--<li role="presentation">-->
    <!--<a href="#tab4" role="tab" data-toggle="tab" aria-controls="tab4" aria-expanded="false">2014</a>-->
    <!--</li>-->
    <!--</ul>-->
    <!--<div id="tab-content" class="tab-content">-->
    <!--<div role="tabpanel" class="tab-pane fade active in" id="tab1" aria-labelledby="tab1">-->
    <!--<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>-->
    <!--<p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters readable English.</p>-->
    <!--</div>-->
    <!--<div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="tab2">-->
    <!--<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>-->
    <!--<p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters readable English.</p>-->
    <!--</div>-->
    <!--<div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="tab3">-->
    <!--<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>-->
    <!--<p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters readable English.</p>-->
    <!--</div>-->
    <!--<div role="tabpanel" class="tab-pane fade" id="tab4" aria-labelledby="tab3">-->
    <!--<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>-->
    <!--<p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters readable English.</p>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->

    <!--<div class="col-sm-4">-->
    <!--<h3 class="column-title">Faqs</h3>-->
    <!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">-->
    <!--<div class="panel panel-default">-->
    <!--<div class="panel-heading" role="tab" id="headingOne">-->
    <!--<h4 class="panel-title">-->
    <!--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
    <!--Enim eiusmod high life accusamus-->
    <!--</a>-->
    <!--</h4>-->
    <!--</div>-->
    <!--<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
    <!--<div class="panel-body">-->
    <!--Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum.-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="panel panel-default">-->
    <!--<div class="panel-heading" role="tab" id="headingTwo">-->
    <!--<h4 class="panel-title">-->
    <!--<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">-->
    <!--Nihil anim keffiyeh helvetica-->
    <!--</a>-->
    <!--</h4>-->
    <!--</div>-->
    <!--<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">-->
    <!--<div class="panel-body">-->
    <!--Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum.-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="panel panel-default">-->
    <!--<div class="panel-heading" role="tab" id="headingThree">-->
    <!--<h4 class="panel-title">-->
    <!--<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">-->
    <!--Vegan excepteur butcher vice lomo-->
    <!--</a>-->
    <!--</h4>-->
    <!--</div>-->
    <!--<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">-->
    <!--<div class="panel-body">-->
    <!--Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum.-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->

    <!--</div>-->
    <!--</div>-->
    <!--</section>&lt;!&ndash;/#meet-team&ndash;&gt;-->

    <section id="animated-number">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Voorbeeld vragen</h2>
                <br />
                <h4 class="text-center wow fadeInDown"> - Welke 4 EU landen hebben maar 1 aangrenzend buurland? - </h4>
                <br />
                <h4 class="text-center wow fadeInDown"> - Wat zijn Maki, Nigiri, Oshi en Inari? - </h4>
                <br />
                <h4 class="text-center wow fadeInDown"> - Welke voetbalclub speelt zijn wedstrijden op Selhurst Park? -
                </h4>
            </div>

            <!--<div class="row text-center">-->
            <!--<div class="col-sm-3 col-xs-6">-->
            <!--<div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="0ms">-->
            <!--<div class="animated-number" data-digit="2305" data-duration="1000"></div>-->
            <!--<strong>CUPS OF COFFEE CONSUMED</strong>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="col-sm-3 col-xs-6">-->
            <!--<div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="100ms">-->
            <!--<div class="animated-number" data-digit="1231" data-duration="1000"></div>-->
            <!--<strong>CLIENT WORKED WITH</strong>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="col-sm-3 col-xs-6">-->
            <!--<div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="200ms">-->
            <!--<div class="animated-number" data-digit="3025" data-duration="1000"></div>-->
            <!--<strong>PROJECT COMPLETED</strong>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="col-sm-3 col-xs-6">-->
            <!--<div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="300ms">-->
            <!--<div class="animated-number" data-digit="1199" data-duration="1000"></div>-->
            <!--<strong>QUESTIONS ANSWERED</strong>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
        </div>
    </section><!--/#animated-number-->

    <section id="pricing">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Prijzen</h2>
                <p class="text-center wow fadeInDown">Onderstaande prijzen zijn een indicatie en excl BTW. Neem <a
                        href="mailto:info@quizis.nl">contact</a> met ons op voor meer informatie of een offerte op maat.
                </p>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="wow zoomIn" data-wow-duration="400ms" data-wow-delay="0ms">
                        <ul class="pricing">
                            <li class="plan-header">
                                <div class="price-duration">
                                    <span class="price">
                                        <small>va</small> €80
                                    </span>
                                    <span class="duration">
                                        &nbsp;
                                    </span>
                                </div>

                                <div class="plan-name">
                                    Doe het <br />zelf
                                </div>
                            </li>
                            <li><strong>8</strong> RONDES</li>
                            <li><strong>80</strong> VRAGEN</li>
                            <li><strong>INC</strong> FOTO & MUZIEK RONDE</li>
                            <li><strong>&plusmn;2.5</strong> UUR QUIZ PLEZIER</li>
                            <li>ZELF PRESENTEREN</li>
                            <li>ZELF NAKIJKEN</li>
                            <li class="plan-purchase"><a class="btn btn-primary"
                                    href="mailto:info@quizis.nl?subject=Offerte Doe Het Zelf">BESTEL
                                    NU</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="wow zoomIn" data-wow-duration="400ms" data-wow-delay="400ms">
                        <ul class="pricing">
                            <li class="plan-header">
                                <div class="price-duration">
                                    <span class="price">
                                        €3 pp
                                    </span>
                                    <span class="duration">
                                        min. €150
                                    </span>
                                </div>

                                <div class="plan-name">
                                    Quiz Master <br />Turbo
                                </div>
                            </li>
                            <li><strong>6</strong> RONDES</li>
                            <li><strong>60</strong> VRAGEN</li>
                            <li><strong>INC</strong> FOTO & MUZIEK RONDE</li>
                            <li><strong>&plusmn;1.5</strong> UUR QUIZ PLEZIER</li>
                            <li>PROFESSIONELE QUIZ MASTER</li>
                            <li>SNELLER KLAAR</li>
                            <li class="plan-purchase"><a class="btn btn-primary"
                                    href="mailto:info@quizis.nl?subject=Offerte Quiz Master Turbo">BESTEL
                                    NU</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="wow zoomIn" data-wow-duration="400ms" data-wow-delay="200ms">
                        <ul class="pricing featured">
                            <li class="plan-header">
                                <div class="price-duration">
                                    <span class="price">
                                        €4 pp
                                    </span>
                                    <span class="duration">
                                        min. €200
                                    </span>
                                </div>

                                <div class="plan-name">
                                    Quiz Master <br />XXL
                                </div>
                            </li>
                            <li><strong>8</strong> RONDES</li>
                            <li><strong>80</strong> VRAGEN</li>
                            <li><strong>INC</strong> FOTO & MUZIEK RONDE</li>
                            <li><strong>&plusmn;2.5</strong> UUR QUIZ PLEZIER</li>
                            <li>PROFESSIONELE QUIZ MASTER</li>
                            <li>AVOND VULLEND</li>
                            <li class="plan-purchase"><a class="btn btn-default"
                                    href="mailto:info@quizis.nl?subject=Offerte Quiz Master XXL">BESTEL
                                    NU</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="wow zoomIn" data-wow-duration="400ms" data-wow-delay="600ms">
                        <ul class="pricing">
                            <li class="plan-header">
                                <div class="price-duration">
                                    <span class="price">
                                        €??
                                    </span>
                                    <span class="duration">
                                        &nbsp;
                                    </span>
                                </div>

                                <div class="plan-name">
                                    OP MAAT <br />
                                    XXL
                                </div>
                            </li>
                            <li>GEHEEL OP MAAT</li>
                            <li>ALLES IN OVERLEG</li>
                            <li>DIV THEMA'S MOGELIJK</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li class="plan-purchase"><a class="btn btn-primary"
                                    href="mailto:info@quizis.nl?subject=Offerte Op Maat XXL">BESTEL
                                    NU</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#pricing-->

    <!--<section id="testimonial">-->
    <!--<div class="container">-->
    <!--<div class="row">-->
    <!--<div class="col-sm-8 col-sm-offset-2">-->

    <!--<div id="carousel-testimonial" class="carousel slide text-center" data-ride="carousel">-->
    <!--&lt;!&ndash; Wrapper for slides &ndash;&gt;-->
    <!--<div class="carousel-inner" role="listbox">-->
    <!--<div class="item active">-->
    <!--<p><img class="img-circle img-thumbnail" src="images/testimonial/01.jpg" alt=""></p>-->
    <!--<h4>Louise S. Morgan</h4>-->
    <!--<small>Treatment, storage, and disposal (TSD) worker</small>-->
    <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->
    <!--<div class="item">-->
    <!--<p><img class="img-circle img-thumbnail" src="images/testimonial/01.jpg" alt=""></p>-->
    <!--<h4>Louise S. Morgan</h4>-->
    <!--<small>Treatment, storage, and disposal (TSD) worker</small>-->
    <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->
    <!--</div>-->

    <!--&lt;!&ndash; Controls &ndash;&gt;-->
    <!--<div class="btns">-->
    <!--<a class="btn btn-primary btn-sm" href="#carousel-testimonial" role="button" data-slide="prev">-->
    <!--<span class="fa fa-angle-left" aria-hidden="true"></span>-->
    <!--<span class="sr-only">Previous</span>-->
    <!--</a>-->
    <!--<a class="btn btn-primary btn-sm" href="#carousel-testimonial" role="button" data-slide="next">-->
    <!--<span class="fa fa-angle-right" aria-hidden="true"></span>-->
    <!--<span class="sr-only">Next</span>-->
    <!--</a>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->
    <!--</section>&lt;!&ndash;/#testimonial&ndash;&gt;-->

    <!--<section id="blog">-->
    <!--<div class="container">-->
    <!--<div class="section-header">-->
    <!--<h2 class="section-title text-center wow fadeInDown">Latest Blogs</h2>-->
    <!--<p class="text-center wow fadeInDown">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->

    <!--<div class="row">-->
    <!--<div class="col-sm-6">-->
    <!--<div class="blog-post blog-large wow fadeInLeft" data-wow-duration="300ms" data-wow-delay="0ms">-->
    <!--<article>-->
    <!--<header class="entry-header">-->
    <!--<div class="entry-thumbnail">-->
    <!--<img class="img-responsive" src="images/blog/01.jpg" alt="">-->
    <!--<span class="post-format post-format-video"><i class="fa fa-film"></i></span>-->
    <!--</div>-->
    <!--<div class="entry-date">25 November 2014</div>-->
    <!--<h2 class="entry-title"><a href="#">While now the fated Pequod had been so long afloat this</a></h2>-->
    <!--</header>-->

    <!--<div class="entry-content">-->
    <!--<P>With a blow from the top-maul Ahab knocked off the steel head of the lance, and then handing to the mate the long iron rod remaining, bade him hold it upright, without its touching off the steel head of the lance, and then handing to the mate the long iron rod remaining. without its touching off the steel without its touching off the steel</P>-->
    <!--<a class="btn btn-primary" href="#">Read More</a>-->
    <!--</div>-->

    <!--<footer class="entry-meta">-->
    <!--<span class="entry-author"><i class="fa fa-pencil"></i> <a href="#">Victor</a></span>-->
    <!--<span class="entry-category"><i class="fa fa-folder-o"></i> <a href="#">Tutorial</a></span>-->
    <!--<span class="entry-comments"><i class="fa fa-comments-o"></i> <a href="#">15</a></span>-->
    <!--</footer>-->
    <!--</article>-->
    <!--</div>-->
    <!--</div>&lt;!&ndash;/.col-sm-6&ndash;&gt;-->
    <!--<div class="col-sm-6">-->
    <!--<div class="blog-post blog-media wow fadeInRight" data-wow-duration="300ms" data-wow-delay="100ms">-->
    <!--<article class="media clearfix">-->
    <!--<div class="entry-thumbnail pull-left">-->
    <!--<img class="img-responsive" src="images/blog/02.jpg" alt="">-->
    <!--<span class="post-format post-format-gallery"><i class="fa fa-image"></i></span>-->
    <!--</div>-->
    <!--<div class="media-body">-->
    <!--<header class="entry-header">-->
    <!--<div class="entry-date">01 December 2014</div>-->
    <!--<h2 class="entry-title"><a href="#">BeReviews was a awesome envent in dhaka</a></h2>-->
    <!--</header>-->

    <!--<div class="entry-content">-->
    <!--<P>With a blow from the top-maul Ahab knocked off the steel head of the lance, and then handing to the steel</P>-->
    <!--<a class="btn btn-primary" href="#">Read More</a>-->
    <!--</div>-->

    <!--<footer class="entry-meta">-->
    <!--<span class="entry-author"><i class="fa fa-pencil"></i> <a href="#">Campbell</a></span>-->
    <!--<span class="entry-category"><i class="fa fa-folder-o"></i> <a href="#">Tutorial</a></span>-->
    <!--<span class="entry-comments"><i class="fa fa-comments-o"></i> <a href="#">15</a></span>-->
    <!--</footer>-->
    <!--</div>-->
    <!--</article>-->
    <!--</div>-->
    <!--<div class="blog-post blog-media wow fadeInRight" data-wow-duration="300ms" data-wow-delay="200ms">-->
    <!--<article class="media clearfix">-->
    <!--<div class="entry-thumbnail pull-left">-->
    <!--<img class="img-responsive" src="images/blog/03.jpg" alt="">-->
    <!--<span class="post-format post-format-audio"><i class="fa fa-music"></i></span>-->
    <!--</div>-->
    <!--<div class="media-body">-->
    <!--<header class="entry-header">-->
    <!--<div class="entry-date">03 November 2014</div>-->
    <!--<h2 class="entry-title"><a href="#">Play list of old bangle  music and gajal</a></h2>-->
    <!--</header>-->

    <!--<div class="entry-content">-->
    <!--<P>With a blow from the top-maul Ahab knocked off the steel head of the lance, and then handing to the steel</P>-->
    <!--<a class="btn btn-primary" href="#">Read More</a>-->
    <!--</div>-->

    <!--<footer class="entry-meta">-->
    <!--<span class="entry-author"><i class="fa fa-pencil"></i> <a href="#">Ruth</a></span>-->
    <!--<span class="entry-category"><i class="fa fa-folder-o"></i> <a href="#">Tutorial</a></span>-->
    <!--<span class="entry-comments"><i class="fa fa-comments-o"></i> <a href="#">15</a></span>-->
    <!--</footer>-->
    <!--</div>-->
    <!--</article>-->
    <!--</div>-->
    <!--</div>-->
    <!--</div>-->

    <!--</div>-->
    <!--</section>-->

    <!--<section id="get-in-touch">-->
    <!--<div class="container">-->
    <!--<div class="section-header">-->
    <!--<h2 class="section-title text-center wow fadeInDown">Get in Touch</h2>-->
    <!--<p class="text-center wow fadeInDown">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> et dolore magna aliqua. Ut enim ad minim veniam</p>-->
    <!--</div>-->
    <!--</div>-->
    <!--</section>&lt;!&ndash;/#get-in-touch&ndash;&gt;-->

    <section id="contact">
        <div style="height:250px"></div>
        <div class="container-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div>
                            <h3>Contact & Offerte</h3>
                            <address>
                                <strong>Quizis.nl</strong><br>
                                Meester Bakxstraat 17<br>
                                5688SZ Oirschot<br>
                                info@quizis.nl<br />
                                KvK: 68841396
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2024 Quizis.nl
                </div>
                <div class="col-sm-6">
                    <ul class="social-icons">
                        <li><a href="https://www.facebook.com/WanneerHetQuizis/"><i class="fa fa-facebook"></i></a></li>
                        <!--<li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-pinterest"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-dribbble"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-behance"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-flickr"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-youtube"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
                        <!--<li><a href="#"><i class="fa fa-github"></i></a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

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