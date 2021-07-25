<?php
require_once "class/config.php";
require_once "class/gaivotacast.php";

$obj_gaivotacast = new GaivotaCast();
$obj_gaivotacast->withMySQL($mysql);
$gaivotacasts = $obj_gaivotacast->exibirTodosAtivos();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Gaivota Quadrinhos</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!--==========================
  Header
  ============================-->
    <?php include "includes/header.php" ?>
    <!-- #header -->

    <!--==========================
    Intro Section
  ============================-->


    <!-- #intro -->
    <section id="intro" class="clearfix">
        <div class="container-fluid">

            <div class="intro-info">
                <img src="img/logoCast.png" width="40%">
                        </div>
        </div>
    </section>
    <main id="main">
        <!--==========================
      About Us Section
    ============================-->
        <section id="about">
            <div class="container">
                <div class="row about-container" style="transform: translateY(-200px);">
                    <?php foreach ($gaivotacasts as $gaivotacast) { ?>
                        <div class="col-lg-12 content order-lg-1 order-2" style="padding-bottom: 10px;">
                            <div class="icon-box wow ">
                                <a href="gaivotacast.php?id=<?= $gaivotacast->id ?>">
                                    <div class="icon">
                                        <img class="imgsize lazy" src="<?= $gaivotacast->imagem ?>" loading="lazy">
                                    </div>
                                    <h4 class="title">
                                        <?= $gaivotacast->titulo ?>
                                    </h4>
                                    <p class="descriptionS" style="color:#000"><?= $gaivotacast->descricao ?></p>

                                    <i class="fa fa-play-circle" style="font-size:40px; float: left; color:#2559a8"></i>

                                    <p class="date" style="color:#000"><?php echo date("d/m/Y", strtotime($gaivotacast->dataL));  ?></p>
                                </a>

                            </div>
                        </div>
                    <?php } ?>

                </div>
                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
        <!-- #about -->

    </main>

    <!--==========================
    Footer
  ============================-->
    <?php include "includes/footer.html" ?>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/mobile-nav/mobile-nav.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js"></script>


</body>

</html>