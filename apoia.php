<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "class/config.php";
require_once "class/quadrinista.php";

$obj_quadrinista = new Quadrinista();
$obj_quadrinista->withMySQL($mysql);
$quadrinistas = $obj_quadrinista->exibirTodos();
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

    <?php include "includes/headerApoia.php" ?>
    <!-- #header -->



    <main id="main">
        <!--==========================
      O que é Section
    ============================-->

        <section id="introApoia" class="section-bg">
            <div class="container-fluid">

                <header class="section-header">
                    <h3>O que é o </h3>
                    <h1> <img src="img/apoia/logoApoia.png" style="width:300px" class="img-fluid" loading="lazy" >
                    </h1>
                    <p style="font-size: 18px;">O melhor do quadrinho nacional à um click de você. conheça, apoie e ganhe brindes exclusivos do seu quadrinista favorito.</p>
                    <center>
                        <a href="#services" class="btn-get-planos scrollto">Ver Planos!</a>
                        <a href="https://app.picpay.com/user/GaivotaQuadrinhos" target="_blank" class="btn-action scrollto">APOIAR no
                            <img style="width:100px; margin-top:-5px" src="img/apoia/picpay.png"></a>
                    </center>
                </header>

            </div>
        </section>
        <!--==========================
      Porque Section
    ============================-->

        <section id="apoia" class="section-bg">
            <div class="container-fluid">

                <header class="section-header">
                    <h3>Porque</h3>
                    <h1> APOIAR?</h1>
                    <p>O seu é apoio é importante para a gaivota quadrinhos continuar trazendo o entretenimento,
                        divulgação e informação sobre o quadrinho nacional. Com a sua ajuda, você poderá além de manter
                        nosso programa, ganhar brindes, conteúdo exclusivo e apoiar o quadrinista independente através
                        da rede de suporte ao quadrinista.</p>

                </header>

                <div class="row">
                </div>

            </div>
        </section>
        <!--==========================
      Fruto Section
    ============================-->
        <section id="about" class="section-bg">
            <div class="container">

                <header class="section-header">
                    <h3>O fruto do seu</h3>
                    <h1> APOIO!</h1>
                    <p>Com seu apoio poderemos manter e melhorar o gaivotacast, nosso podcast de quadrinhos nacionais, assim como trazer projetos novos para a cena brasileira de quadrinhos independentes.</p>

                </header>

                <div class="row justify-content-center">
                    <div class="col-md-6">

                        <div class="contentFruto" style="padding-bottom: 10px;">

                            <div class="icon-box wow" style="color: #000">

                                <img class="imgFruto " src="img/apoia/Entrevistas.png" loading="lazy">

                                <h4 class="title" style="font-weight: bold; text-align: center;">Entrevistas</h4>

                                <p>Chamamos quadrinistas de todos os cantos do Brasil para
                                    falar de sua vida e quadrinhos produzidos.
                                    Aqui você poderá ter um deslumbre de cada quadrinista e até se inspirar para
                                    ler suas obras.
                                </p>

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">


                        <div class="contentFruto" style="padding-bottom: 10px;">

                            <div class="icon-box wow" style="color: #000">

                                <img class="imgFruto " src="img/apoia/Históriasquadrinisticas.png" loading="lazy" >

                                <h4 class="title" style="font-weight: bold; text-align: center;">Histórias Quadrinísticas</h4>

                                <p class="descriptionS">Juntamos um grupo de quadrinistas para falar de um tema especifico,
                                    criando um programa mais divertido, interessante, descontraido e com muito mais participantes especialistas no assunto.</p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </div>
        </section>
        <!--==========================
      Planos Section
    ============================-->
        <section id="services" class="section-bg">
            <div class="container-fluid">

                <header class="section-header">
                    <h3>Quais os</h3>
                    <h1> PLANOS?</h1>
                    <p>Veja os planos que você pode apoiar, cada um com uma recompensa especial.</p>

                </header>

                <div class="row justify-content-center">


                    <div class="planoBorder">
                        <div class="card card-flip h-100 ">
                            <div class="card-front ">
                                <div class="card-body">

                                    <h6 class="card-title">Ovo de Gaivota</h6>
                                    <img class="img-icon " src="img/apoia/ovoGaivota.png" loading="lazy">
                                    <br>
                                    <h5 class="card-title">R$ 1,00</h5>
                                </div>
                            </div>
                            <div class="card-back bg-white">
                                <div class="card-body">
                                    <h6 class="card-title">Ovo de Gaivota</h6>
                                    <p class="card-text">Nosso muito obrigado e agradecimento no final dos episódios.</p>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="planoBorder">
                        <div class="card card-flip h-100">
                            <div class="card-front">
                                <div class="card-body">

                                    <h6 class="card-title">Filhote de Gaivota</h6>
                                    <img class="img-icon " src="img/apoia/filhoteGaivota.png" loading="lazy">
                                    <br>
                                    <h5 class="card-title">R$ 5,00</h5>
                                </div>
                            </div>
                            <div class="card-back bg-white">
                                <div class="card-body">
                                    <h6 class="card-title">Filhote de Gaivota</h6>
                                    <p class="card-text">
                                        • Recompensa anterior <br>
                                        • Participe do nosso grupo do telegram onde discutimos sobre quadrinhos, sugerimos pautas e convidados do podcast.</p>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="planoBorder">
                        <div class="card card-flip h-100">
                            <div class="card-front">
                                <div class="card-body">

                                    <h6 class="card-title">Gaivota Adulta</h6>
                                    <img class="img-icon " src="img/apoia/gaivotaAdulta.png" loading="lazy" >
                                    <br>
                                    <h5 class="card-title">R$ 15,00</h5>
                                </div>
                            </div>
                            <div class="card-back bg-white">
                                <div class="card-body">
                                    <h6 class="card-title">Gaivota Adulta</h6>
                                    <p class="card-text">
                                        • Recompensas anteriores <br>
                                        • A partir do segundo mês, participe de sorteio de quadrinhos, pins, prints e outros itens do mundo quadrinístico. O sorteio só vale para participantes que apoiam por mais de 2 meses.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="planoBorder">
                        <div class="card card-flip h-100">
                            <div class="card-front">
                                <div class="card-body">

                                    <h6 class="card-title">Gaivota de Ouro</h6>
                                    <img class="img-icon " src="img/apoia/gaivotaOuro.png" loading="lazy" >
                                    <br>
                                    <h5 class="card-title">R$ 25,00</h5>
                                </div>
                            </div>
                            <div class="card-back bg-white">
                                <div class="card-body">
                                    <h6 class="card-title">Gaivota de Ouro</h6>
                                    <p class="card-text">
                                        • Recompensas anteriores<br>
                                        • Parte do dinheiro será destinado para um de nossos artistas parceiros. </p>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="planoBorder">
                        <div class="card card-flip h-100">
                            <div class="card-front">
                                <div class="card-body">

                                    <h6 class="card-title">Gaivota de Diamante</h6>
                                    <img class="img-icon " src="img/apoia/gaivotaDiamante.png" loading="lazy" >
                                    <br>
                                    <h5 class="card-title">R$ 40,00</h5>
                                </div>
                            </div>
                            <div class="card-back bg-white">
                                <div class="card-body">
                                    <h6 class="card-title">Gaivota de Diamante</h6>
                                    <p class="card-text">
                                        • Recompensas anteriores<br>
                                        • Parte do dinheiro será destinado para um de nossos artistas parceiros. e ainda garante o brinde sem precisar participar do sorteio.</p>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </section>
        <!-- #services -->

        <!--==========================
      Metas Section
    ============================-->

        <section id="apoiaA" class="section-bg">
            <div class="container">

                <header class="section-header">
                    <h3>Quais as nossas</h3>
                    <h1>METAS?</h1>
                    <p>Veja nossas metas de apoios para melhorar o GaivotaCast e outros futuros programas que queremos fazer</p>

                </header>

                <div class="row">

                    <div class="col-5 meta" style=" transform: translateX(10%);" >
                        <div style="text-align: right;">
                            <h4><b>COLOQUE A GAIVOTA PARA VOAR</b></h4>
                            <p>Nós ajude a pagar os servidores e conseguirmos melhorar nossa estrutura (microfones, etc).</p>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="divider"></div>
                    </div>
                    <div class="col-5 meta" style=" transform: translateX(-10%);" >
                        <div style="text-align: left;">
                            <h4><b>A PLENO VAPOR</b></h4>
                            <p>O GaivotaCast será semanal e poderemos estruturar sorteios maiores.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <section id="about" class="section-bg">
            <div class="container-fluid" style="padding-bottom: 100px;">
                <header class="section-header">
                    <h3>Veja todos os quadrinistas</h3>
                    <h1> PARCEIROS!</h1>

                </header>
                <div class="row" style="padding-TOP: 50px;">
                    <?php foreach ($quadrinistas as $quadrinista) { ?>

                        <div class="col-lg-2 col-md-2 col-sm-4  contentSapoia ">

                            <a href="quadrinista.php?id=<?= $quadrinista->id ?>">
                                <img class="catalogo-imgS-apoia " src="<?= $quadrinista->foto ?>" alt="" loading="lazy">
                                <h4 class="catalogo-textS-apoia"><?= $quadrinista->nome ?></h4>
                            </a>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <!-- <div class="container">
                <center>
                    <a href="quadrinistas.php" class="btn-get-quadrinistas scrollto">Ver todos os quadrinistas parceiros!</a>
                </center>
            </div> -->
        </section>
    </main>


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

</body>

</html>