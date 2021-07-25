<?php

require_once "class/config.php";
require_once "class/gaivotacast.php";
require_once "class/quadrinista.php";
require_once "class/participantes_gaivotacast.php";

$obj_gaivotacast = new GaivotaCast();
$obj_gaivotacast->withMySQL($mysql);
$gaivotacast = $obj_gaivotacast->encontrarPorId($_GET["id"]);
$participantes = $obj_gaivotacast->listParticipantesGaivotaCast($_GET["id"]);
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

    <main id="main">

        <!--==========================
      About Us Section
    ============================-->
        <section id="about" style="margin-top:100px">
            <div class="container">
                <div class="row about-container">
                    <div id="<?= $gaivotacast->id ?>" class="col-lg-12 order-lg-1 order-2" style="padding-bottom: 10px;margin-bottom:10px">

                        <div class="icon-box wow ">

                            <h1 class="titleB" style="color:#000"><?= $gaivotacast->titulo ?></h1>


                            <div>

                                <iframe id="gaivotacast" class="cardSize" src="<?= $gaivotacast->embled ?>" width="100%" frameborder="0" scrolling="no"></iframe>
                            </div>


                            <b style="font-size:20px;padding:5px 0 0 10px">
                                <?= $gaivotacast->duracao;  ?>
                            </b>
                            <div style="float:right"> <a href="<?= $gaivotacast->link ?>" target="_blank">
                                    <img src="img/spotfy.png" style="height: 40px;padding:5px 0 0 10px" loading="lazy">
                                </a>
                            </div>


                            <hr />
                            <h5 class="description">Descrição</h5>
                            <p class="descriptionB"><?= $gaivotacast->descricao ?></p>
                            <p class="descriptionB"> <strong> <?= $gaivotacast->redes ?></strong></p>
                            <hr />
                            <h5 class="description">Participantes</h5>

                            <div class="container-fluid">
                                <div class="row">
                                    <?php if ($participantes != null) {
                                        foreach ($participantes as $quadrinista) { ?>

                                            <div class="col-lg-2 col-md-2 col-sm-4  contentS ">

                                                <a href="quadrinista.php?id=<?= $quadrinista->id ?>">
                                                    <img class="catalogo-imgS " src="<?= $quadrinista->foto ?>" alt="" loading="lazy">
                                                    <h4 class="catalogo-textS"><?= $quadrinista->nome ?></h4>
                                                </a>
                                            </div>
                                    <?php }
                                    } ?>

                                </div>
                            </div>
                            <p class="dateB"><?php echo date("d/m/Y", strtotime($gaivotacast->dataL));  ?></p>
                        </div>


                    </div>
                  
                </div>

              
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
    <script>
        $('#gaivotacast').load(function() {
            $('#loading').hide();
        });
    </script>
</body>

</html>