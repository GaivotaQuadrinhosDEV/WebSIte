<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "class/config.php";
require_once "class/quadrinho.php";
require_once "class/genero.php";
require_once "class/quadrinhos_generos.php";
require_once "class/quadrinistas_quadrinho.php";
require_once "class/pedido.php";

$filtro = "";
$obj_quadrinho = new Quadrinho();
$obj_quadrinho->withMySQL($mysql);
$quadrinhos  =  $obj_quadrinho->exibirTodosQuadrinhos();

$obj_genero = new Genero();
$obj_genero->withMySQL($mysql);
$generos  =  $obj_genero->exibirTodos();

$obj_quadrinhos_genero = new QuadrinhosGenero();
$obj_quadrinhos_genero->withMySQL($mysql);
$quadrinhos_generos  =  $obj_quadrinhos_genero->exibirTodos();

$obj_pedido = new Pedido();
if(isset($_GET['adicionar'])){
    $quadrinhos = $obj_pedido->AddProduto($_GET['adicionar'], $quadrinhos);
}

if (isset($_GET['categoria'])) {
    setCategoria($_GET['categoria']);
} else {
    $quadrinhosFiltros  =  $obj_quadrinho->exibirTodosQuadrinhos();
}

function setCategoria($id)
{
    $GLOBALS["quadrinhosFiltro"] = [];
    for ($i = 0; $i < count($GLOBALS["quadrinhos_generos"]); $i++) {
        if ($id == $GLOBALS["quadrinhos_generos"][$i]['id_genero']) {
            for ($j = 0; $j < count($GLOBALS["quadrinhos"]); $j++) {
                if ($GLOBALS["quadrinhos"][$j]['id'] == $GLOBALS["quadrinhos_generos"][$i]['id_quadrinho']) {
                    array_push($GLOBALS["quadrinhosFiltro"], $GLOBALS["quadrinhos"][$j]);
                }
            }
        }
    }
}

if (isset($_GET['search'])) {
    $quadrinhosFiltros = $obj_quadrinho->encontrarPorTitulo($_GET['search']);
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


    <div style="padding-top: 60px;">
    </div>
    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section id="services" class="section-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="float-left">
                            <h1 style="font-size: 30px;"><b>Quadrinhos<b></h1>
                        </div>
                    </div>
                    <div class="col">
                        <div class="float-right">
                            <form action="quadrinhos.php" name="form" method="get" role="form">
                                <div class="input-group mb-3 ">
                                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                                                                                echo $_GET['search'];
                                                                            } ?>" class="form-control" placeholder="Pesquisar quadrinho" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2"><button type="submit" style="border:0px"><i class="fa fa-search"></i></button></span>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3" id="categorias">
                        <div class="card" style="padding:20px">
                            <nav class="nav flex-column">
                                <h5>Categorias</h5>
                                <a href="quadrinhos.php" type="button" style="text-align: left;" class="btn btn-light">Todos</a>

                                <?php foreach ($generos as $genero) { ?>
                                    <a href="quadrinhos.php?categoria=<?= $genero->id ?>" type="button" style="text-align: left;" class="btn btn-light"><?= $genero->nome ?></a>
                                <?php } ?>
                            </nav>
                        </div>
                    </div>
                  
                    <div class="col-md-9">
                        <div class="row">

                            <?php foreach ($quadrinhosFiltros as $quadrinhosFiltro) {  ?>

                                <div>
                                    <div class="comicH">
                                        <a href="<?= $quadrinhosFiltro->link ?>" target="_blank">

                                            <img class="img-comicH " src="<?= $quadrinhosFiltro->imagem ?>" loading="lazy" >
                                            <h6 class="titleS"><?= $quadrinhosFiltro->titulo ?></h6>
                                            <p class="precoS"><?php if ($quadrinhosFiltro->preco != 0) {
                                                                    echo "R$  ";
                                                                    echo $quadrinhosFiltro->preco;
                                                                } else {
                                                                    echo 'GRATÍS';
                                                                } ?></p>

                                        </a>

                                        <a href="<?= $quadrinhosFiltro->link ?>" target="_blank">
                                            <h4 class="comprarBtn"> <?php if ($quadrinhosFiltro->digital == 0) {
                                                                        echo 'COMPRAR';
                                                                    } else {
                                                                        echo 'LER';
                                                                    }
                                                                    ?> </h4>
                                        </a>
                                    </div>



                                </div>

                            <?php } ?>



                        </div>
                    </div>
                    <div id="categoriasSmall">
                        <h5>Categorias</h5>

                        <a href="quadrinhos.php" type="button" class="btn btn-outline-dark">Todos</a>

                        <?php foreach ($generos as $genero) { ?>
                            <a href="quadrinhos.php?categoria=<?= $genero->id ?>" type="button" class="btn btn-outline-dark"><?= $genero->nome ?></a>
                        <?php } ?>
                    </div>

                </div>



            </div>

        </section>
        <!-- #services -->
    </main>

    <!--==========================
    Footer
  ============================-->
    <?php include "includes/footer.html" ?>

    <!-- #footer -->

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
        $(document).ready(function() {
            if ($(window).width() < 1024) {
                $('#categorias').html("<div></div>");
            } else {
                $('#categoriasSmall').html("<div></div>");
            }
        });
    </script>
</body>

</html>