<?php
session_start();
if (!$_SESSION['usuario']) {
  header("location: login.php");
  exit();
}
if ($_SESSION['nivel'] != 1) {
  header("location: login.php");
  exit();
}


require_once "class/config.php";
require_once "class/quadrinista.php";
require_once "class/pedido.php";
require_once "class/cliente.php";
require_once "class/genero.php";
require_once "class/pedido_item.php";
require_once "class/quadrinho.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$obj_user = new User($mysql);
$user = $obj_user->encontrarPorId($_SESSION["id_usuario"]);

$obj_pedido = new Pedido($mysql);
$pedidos  =  $obj_pedido->encontrarPorCliente($_SESSION['id_usuario'], 1);

$pedido_items = array();
for ($i = 0; $i < count($pedidos); $i++) {

  $obj_pedido_item = new PedidoItem($mysql);
  $pedido_items =  $obj_pedido_item->encontrarPorPedido($pedidos[$i]['id']);
  if (count($pedido_items) > 1) {
    $strQuery = '';
    $first = true;
    foreach ($pedido_items as $pedido_item) {
      if ($first == true) {
        $strQuery = "{$pedido_item['id_produto']}";
        $first = false;
      } else {
        $strQuery .= ", {$pedido_item['id_produto']}";
      }
    }
  } else {
    $strQuery = "{$pedido_items[0]['id_produto']}";
  }

  if ($strQuery != '') {
    $obj_quadrinho = new Quadrinho($mysql);
    $listaQuadrinhos =  $obj_quadrinho->encontrarPorIds($strQuery);
    foreach ($listaQuadrinhos as $quadrinho) {
      for ($j = 0; $j < count($pedido_items); $j++) {

        if ($quadrinho['id'] == $pedido_items[$j]['id_produto']) {
          $pedido_items[$j]['item'] = $quadrinho;
        }
      }
    }
  }
  $pedidos[$i]['itens'] = $pedido_items;
  $pedido_items = null;
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

  <main id="main">


    <!--==========================
      Catalogo Section
    ============================-->

    <section id="catalogo">
      <img src="img/teto.png" class="bg-artist-perfil"> </img>
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="card" style="transform: translateY(-100px);">
              <a class="btn btn-secondary config"><i class="fa fa-gear"></i></a>      
              <div style="padding: 25px;">
                <b>Nome:</b>
                <h5><?= $user['nome'] ?></h5>
                <b>Email:</b>
                <p> <?= $user['email'] ?></p>
                <b>Telefone:</b>
                <p><?= $user['telefone'] ?></p>
              </div>
        <a class="btn btn-danger logout" href="APIs/logout.php" type="button" class="btn btn-danger">Logout</a>

            </div>

          </div>

        </div>

        <div style="transform: translateY(-80px);">
          <h1 style="font-weight: 800;">Seus Pedidos</h1>

          <?php foreach ($pedidos as $pedido) { ?>
            <div class="row" style="padding-bottom: 15px;">
              <div class="col-12">
                <div class="card cardPedido">
                  <h5 class="card-header">Pedido: <?= $pedido['id'] ?></h5>
                  <div class="card-body">
                
                    <span class="card-text" style="disolay: inline">Endereço: <?= $pedido['endereco'] ?></span>
                      <span class="card-text alert alert-primary" style=" position: absolute; right: 0px;disolay: inline">Status: <?php
                      if($pedido['status'] == 1) echo '<b>Pagamento Pendente</b>';
                      if($pedido['status'] == 2) echo 'Pagamento Feito';
                      if($pedido['status'] == 3) echo 'Quadrinhos Embalados';
                      if($pedido['status'] == 4) echo 'Em Transito';
                      if($pedido['status'] == 5) echo 'Entregue';
                      ?></span>
                  
                    <section id="services" style="padding: 0px;">
                      <div class="row">
                        <?php foreach ($pedido['itens'] as $key => $pedido_item) { ?>
                          <div class="comicHSmall">
                            <img class="img-comicH " src="<?= $pedido_item['item']['imagem'] ?>" loading="lazy" >
                            <h6 class="titleS"><?= $pedido_item['item']['titulo'] ?></h6>
                            <div class="qtdPedido" align="center">Quantidade: <?= $pedido_item['quantidade'] ?></div>
                          </div>
                        <?php } ?>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>


    </section>

    <!-- #Catalogo -->

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

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>

</html>