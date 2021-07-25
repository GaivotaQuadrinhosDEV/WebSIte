<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "class/config.php";
require_once "class/gaivotacast.php";
require_once "class/quadrinho.php";
require_once "class/quadrinista.php";
require_once "class/quadrinistas_quadrinho.php";
require_once "class/banner.php";
require_once "class/pedido.php";

$gaivotacasts = new GaivotaCast();
$gaivotacasts->withMySQL($mysql);
$gaivotacasts = $gaivotacasts->exibirTodosAtivos();

$quadrinistas = new Quadrinista();
$quadrinistas->withMySQL($mysql);
$quadrinistas  =  $quadrinistas->exibirTodos();

$banners = new Banner($mysql);
$banners->withMySQL($mysql);
$banners  =  $banners->exibirTodosAtivos();


$obj_pedido = new Pedido();
if (isset($_GET['adicionar'])) {
    $obj_pedido->AddProduto($_GET['adicionar'], $quadrinhos);
}




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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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

    <section id="intro-banner" class="clearfix">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php for ($i = 0; $i < count($banners); $i++) {  ?>

                    <div class="carousel-item <?php if ($i == 0) echo "active" ?>">
                        <?php if ($banners[$i]->id_quadrinho == 0) { ?>
                            <a href="<?= $banners[$i]->link ?>">
                            <?php } else { ?>
                                <a href="<?= $banners[$i]->id_quadrinho ?>">
                                <?php } ?>
                                <img class="d-block w-100 " src="<?= $banners[$i]->imagem ?>" alt="" loading="lazy">
                                </a>
                    </div>

                <?php } ?>
            </div>
            <a style="margin-left: -50px;" class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a style="margin-right: -50px;" class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </section>


    <!-- #intro -->

    <main id="main">
        <!-- #about -->
        <!--==========================
Apoio Section
============================-->

        <section id="apoia" class="section-bg">
            <div class="container-fluid">

                <header class="section-header">
                    <h3>Apoie o </h3>
                    <h1>Gaivota Quadrinhos</h1>
                    <p>O melhor do quadrinho nacional à um click de você. conheça, apoie e ganhe brindes exclusivos do seu quadrinista favorito.</p>

                </header>

                <div class="row justify-content-center">

                    <a href="apoia.php" class="btn-apoia scrollto">APOIAR!</a>

                </div>

            </div>
        </section>

        <!--==========================
About Us Section
============================-->
        <section id="about">
            <div class="container">

                <header class="section-header">
                    <h3>GaivotaCast<img width="75px" height="auto" src="img/icones/icon1.png" loading="lazy"></h3>
                    <p>Um Podcast sobre tudo que há no mundo dos quadrinhos nacionais e independentes</p>
                </header>

                <div class="row about-container">

                    <?php for ($i = 0; $i < 3; $i++) { ?>
                        <div class="col-lg-12 content order-lg-1 order-2" style="padding-bottom: 10px;">
                            <div class="icon-box wow ">
                                <a href="gaivotacast.php?id=<?= $gaivotacasts[$i]->id ?>">
                                    <div class="icon">

                                        <img class="imgsize lazy" src="<?= $gaivotacasts[$i]->imagem ?>" loading="lazy">
                                    </div>
                                    <h4 class="title">
                                        <?= $gaivotacasts[$i]->titulo ?>
                                    </h4>
                                    <p class="descriptionS" style="color:#000"><?= $gaivotacasts[$i]->descricao ?></p>

                                    <i class="fa fa-play-circle" style="font-size:40px; float: left; color:#2559a8"></i>

                                    <p class="date" style="color:#000"><?php echo date("d/m/Y", strtotime($gaivotacasts[$i]->dataL));  ?></p>
                                </a>

                            </div>
                        </div>
                    <?php } ?>

                    <br />
                </div>
                <button type="button" id="maisG" class="btn btn-outline-primary mais">Mais...</button>

        </section>
        <!--==========================
Catalogo Section
============================-->
        <section id="catalogo">
            <header class="section-header">
                <h3>Quadrinistas<img style="padding-bottom: 10px;" width="75px" height="auto" src="img/icones/icon3.png" loading="lazy"></h3>
                <p>Esses são nossos quadrinistas parceiros que fizeram participações em nossos GaivotaCasts</p>

            </header>
            <div class="MultiCarousel" data-items="1,2,3,5" data-slide="1" id="MultiCarousel" data-interval="1000">

                <div class="MultiCarousel-inner">

                    <?php if ($quadrinistas != null) {
                        for ($i = 0; $i < 9; $i++) {  ?>
                            <div class="item">
                                <div class="pad15" style="padding: 50px;">
                                    <a href="quadrinista.php?id=<?= $quadrinistas[$i]->id  ?>">
                                        <img id="gradient">
                                        <img class="catalogo-img lazy" src="<?= $quadrinistas[$i]->foto ?>" loading="lazy" alt="">
                                        <h4 class="catalogo-text"><?= $quadrinistas[$i]->nome ?></h4>
                                    </a>
                                </div>
                            </div>

                    <?php }
                    } ?>

                </div>
                <button class="btn btn-primary leftLst">

                    <i class="fa fa-chevron-left"></i></button>
                <button class="btn btn-primary rightLst"><i class="fa fa-chevron-right"></i></button>
            </div>

            <br />
            <br />
            <button type="button" id="maisC" class="btn btn-outline-primary mais">Mais...</button>


        </section>
        <!-- #Catalogo -->



    </main>

    <!--==========================
    Footer
  ============================-->
    <?php include "includes/footer.html" ?>
    <!-- footer -->

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
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Template Main Javascript File -->
    <script src="js/main.js"></script>

    <script>
        $("#maisG").click(function() {
            window.location.href = 'gaivotacasts.php';
        });
        $("#maisQ").click(function() {
            window.location.href = 'quadrinhos.php';
        });
        $("#maisC").click(function() {
            window.location.href = 'quadrinistas.php';
        });

        $(document).ready(function() {
            var itemsMainDiv = ('.MultiCarousel');
            var itemsDiv = ('.MultiCarousel-inner');
            var itemWidth = "";

            $('.leftLst, .rightLst').click(function() {
                var condition = $(this).hasClass("leftLst");
                if (condition)
                    click(0, this);
                else
                    click(1, this)
            });

            ResCarouselSize();




            $(window).resize(function() {
                ResCarouselSize();
            });

            //this function define the size of the items
            function ResCarouselSize() {
                var incno = 0;
                var dataItems = ("data-items");
                var itemClass = ('.item');
                var id = 0;
                var btnParentSb = '';
                var itemsSplit = '';
                var sampwidth = $(itemsMainDiv).width();
                var bodyWidth = $('body').width();
                $(itemsDiv).each(function() {
                    id = id + 1;
                    var itemNumbers = $(this).find(itemClass).length;
                    btnParentSb = $(this).parent().attr(dataItems);
                    itemsSplit = btnParentSb.split(',');
                    $(this).parent().attr("id", "MultiCarousel" + id);


                    if (bodyWidth >= 1200) {
                        incno = itemsSplit[3];
                        itemWidth = sampwidth / incno;
                    } else if (bodyWidth >= 992) {
                        incno = itemsSplit[2];
                        itemWidth = sampwidth / incno;
                    } else if (bodyWidth >= 768) {
                        incno = itemsSplit[1];
                        itemWidth = sampwidth / incno;
                    } else {
                        incno = itemsSplit[0];
                        itemWidth = sampwidth / incno;
                    }
                    $(this).css({
                        'transform': 'translateX(0px)',
                        'width': itemWidth * itemNumbers
                    });
                    $(this).find(itemClass).each(function() {
                        $(this).outerWidth(itemWidth);
                    });

                    $(".leftLst").addClass("over");
                    $(".rightLst").removeClass("over");

                });
            }


            //this function used to move the items
            function ResCarousel(e, el, s) {
                var leftBtn = ('.leftLst');
                var rightBtn = ('.rightLst');
                var translateXval = '';
                var divStyle = $(el + ' ' + itemsDiv).css('transform');
                var values = divStyle.match(/-?[\d\.]+/g);
                var xds = Math.abs(values[4]);
                if (e == 0) {
                    translateXval = parseInt(xds) - parseInt(itemWidth * s);
                    $(el + ' ' + rightBtn).removeClass("over");

                    if (translateXval <= itemWidth / 2) {
                        translateXval = 0;
                        $(el + ' ' + leftBtn).addClass("over");
                    }
                } else if (e == 1) {
                    var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
                    translateXval = parseInt(xds) + parseInt(itemWidth * s);
                    $(el + ' ' + leftBtn).removeClass("over");

                    if (translateXval >= itemsCondition - itemWidth / 2) {
                        translateXval = itemsCondition;
                        $(el + ' ' + rightBtn).addClass("over");
                    }
                }
                $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
            }

            //It is used to get some elements from btn
            function click(ell, ee) {
                var Parent = "#" + $(ee).parent().attr("id");
                var slide = $(Parent).attr("data-slide");
                ResCarousel(ell, Parent, slide);
            }

        });
    </script>
</body>

</html>