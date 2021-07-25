<?php
require_once "class/config.php";
require_once "class/quadrinista.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['carrinho'])) {

  if (isset($_GET['remover']) && count($_SESSION['carrinho']) > 0) {

    $idProduto = (int) $_GET['remover'];
    if ($_SESSION['carrinho'][$idProduto]['quantidade'] > 1) {
      $_SESSION['carrinho'][$idProduto]['quantidade']--;
    } else {
      unset($_SESSION['carrinho'][$idProduto]);
    }
  }

  $quadrinistas = [];
  $queryquadrinistas = [];
  foreach ($_SESSION['carrinho'] as $key => $value) {
    $queryquadrinistas[$value['quadrinistas']] = $value['quadrinistas'];
  }


  //Buscar os quadrinistas
  $strQuery = '';
  $first = true;
  foreach ($queryquadrinistas as $q) {
    if ($first == true) {
      $strQuery = "{$q}";
      $first = false;
    } else {
      $strQuery .= ", {$q}";
    }
  }
  if ($strQuery != '') {
    $obj_quadrinista = new Quadrinista($mysql);
    $listaquadrinitas =  $obj_quadrinista->encontrarPorIds($strQuery);

    foreach ($listaquadrinitas as $uniquadrinista) {
      $quadrinistas[$uniquadrinista['id']] = $uniquadrinista;
    }
    foreach ($_SESSION['carrinho'] as $key => $value) {
      $quadrinistas[$value['quadrinistas']]['quadrinhos'][$value['id']] = array('id' => $value['id'], 'nome' => $value['nome'], 'imagem' => $value['imagem'], 'preco' => $value['preco'], 'quantidade' => $value['quantidade']);
    }
  }
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
    <section id="services" class="section-bg">

      <div class="container" style="padding-top: 75px;">

        <div class="row">
          <h1 style="font-weight: 800; display:inline-block">Seus quadrinhos</h1>

          <?php if (isset($_SESSION['carrinho'])) {
            $j = 0; ?>
            <div>
              <form action="APIs/Addpedido.php" method="post" role="form">
                <?php if(isset($_SESSION['id_usuario'])){ ?>
                <input type="hidden" name="id_cliente" value="<?= $_SESSION['id_usuario'] ?>">
                <?php } ?>
                <input type="hidden" name="endereco" value="Patricia Maria dos Santos 125 Pró-Morar - Votorantim - SP">
                <input type="hidden" name="status" value="1">
                <input type="hidden" name="forma_pagamento" value="">
                <input type="hidden" name="codigo_rastreio" value="">
                <button type="submit" class="finalizarBtn">Finalizar pedido</button>
              </form>
            </div>
        </div>
      </div>
      <?php foreach ($quadrinistas as $quadrinista) { ?>

        <div class="container-fluid faixa-color" id="faixa-color"></div>
        <div class="container">
          <div class="row">

            <div class="col-2">
              <a href="quadrinista.php?id=<?= $quadrinista['id'] ?>">
                <img class="catalogo-imgS " src="<?= $quadrinista['foto'] ?>" alt="" loading="lazy" >
                <h4 class="catalogo-textS"><?= $quadrinista['nome'] ?></h4>
              </a>
            </div>
            <div class="col-10">
              <div class="row">
                <?php
                $j++;
                foreach ($quadrinista['quadrinhos'] as $quadrinhos) {
                ?>

                  <div class="comicH">
                    <img class="img-comicH " src="<?= $quadrinhos['imagem'] ?>" loading="lazy" >
                    <h6 class="titleS"><?= $quadrinhos['nome'] ?></h6>
                    <p class="precoS">R$ <?= $quadrinhos['preco'] * $quadrinhos['quantidade'] ?></p>
                    <div align="center">
                      <p class="qtd">Quantidade: <?= $quadrinhos['quantidade'] ?></p>
                      <a style="" href="?remover=<?= $quadrinhos['id'] ?>">
                        <p class="removerBtn">Remover</p>
                      </a>
                    </div>
                  </div>

                <?php  } ?>
              </div>

            </div>
          </div>
        </div>
    <?php  }
          } ?>

    </section>

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
    var triggerTabList = [].slice.call(document.querySelectorAll('#Artist a'))
    triggerTabList.forEach(function(triggerEl) {
      var tabTrigger = new bootstrap.Tab(triggerEl)

      triggerEl.addEventListener('click', function(event) {
        event.preventDefault()
        tabTrigger.show()
      })
    })


    $('#hqs-tab').click(function() {
      $('#artes-tab').removeClass();
      $('#hqs-tab').removeClass();
      $('#hqs-tab').addClass('btn-nav-active');
      $('#artes-tab').addClass('btn-nav');

    });

    $('#artes-tab').click(function() {
      $('#artes-tab').removeClass();
      $('#hqs-tab').removeClass();

      $('#artes-tab').addClass('btn-nav-active');
      $('#hqs-tab').addClass('btn-nav');
    });
  </script>
</body>

</html>