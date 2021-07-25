<?php
session_start();
if (!$_SESSION['usuario']) {
  header("location: login.php");
  exit();
}
if ($_SESSION['nivel'] != 2) {
  header("location: login.php");
  exit();
}


require_once "class/config.php";
require_once "class/quadrinista.php";
require_once "class/quadrinho.php";
require_once "class/gaivotacast.php";
require_once "class/participantes_gaivotacast.php";
require_once "class/quadrinistas_quadrinho.php";
require_once "class/quadrinistas_generos.php";
require_once "class/pedido.php";
require_once "class/genero.php";
require_once "class/pedido_item.php";
require_once "class/pedido_quadrinista.php";

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$obj_quadrinista = new Quadrinista($mysql);
$quadrinistas  =  $obj_quadrinista->encontrarPorId($_SESSION['quadrinista']);

//Quadrinhos do Quadrinista
$obj_quadrinistas_quadrinho = new QuadrinistasQuadrinho($mysql);
$quadrinistas_quadrinho = $obj_quadrinistas_quadrinho->exibirQuadrinhosPorQuadrinista($_SESSION['quadrinista']);

if ($quadrinistas_quadrinho != null) {

  $strQuery = '';
  $first = true;
  foreach ($quadrinistas_quadrinho as $qq) {
    if ($first == true) {
      $strQuery = "{$qq['id_quadrinho']}";
      $first = false;
    } else {
      $strQuery .= ", {$qq['id_quadrinho']}";
    }
  }

  $obj_quadrinho = new Quadrinho($mysql);
  $quadrinhos  =  $obj_quadrinho->encontrarPorIds($strQuery);
} else {
  $quadrinhos = null;
}

//Brindes do Quadrinista
$quadrinistas_brinde = $obj_quadrinistas_quadrinho->exibirBrindesPorQuadrinista($_SESSION['quadrinista']);

if ($quadrinistas_brinde != null) {

  $strQuery = '';
  $first = true;
  foreach ($quadrinistas_brinde as $qb) {
    if ($first == true) {
      $strQuery = "{$qb['id_quadrinho']}";
      $first = false;
    } else {
      $strQuery .= ", {$qb['id_quadrinho']}";
    }
  }

  $obj_brindes = new Quadrinho($mysql);
  $brindes  =  $obj_brindes->encontrarPorIds($strQuery);
} else {
  $brindes = null;
}

//GaivotaCast do Quadrinista
$obj_participantes_gaivotacast = new ParticipantesGaivotacast($mysql);
$participantes_gaivotacast = $obj_participantes_gaivotacast->exibirPorQuadrinista($_SESSION['quadrinista']);

if ($participantes_gaivotacast != null) {

  $strQuery = '';
  $first = true;
  foreach ($participantes_gaivotacast as $pg) {
    if ($first == true) {
      $strQuenry = "{$pg['id_gaivotacast']}";
      $first = false;
    } else {
      $strQuenry .= ", {$pg['id_gaivotacast']}";
    }
  }

  $obj_gaivotacast = new GaivotaCast($mysql);
  $gaivotacasts = $obj_gaivotacast->encontrarPorIds($strQuenry);
} else {
  $gaivotacasts = null;
}

$obj_quadrinista_genero = new QuadrinistasGenero($mysql);
$quadrinista_generos = $obj_quadrinista_genero->exibirPorQuadrinista($_SESSION['quadrinista']);

if ($quadrinista_generos != null) {

  $strQuery = '';
  $first = true;
  foreach ($quadrinista_generos as $qg) {
    if ($first == true) {
      $strQuenry = "{$qg['id_genero']}";
      $first = false;
    } else {
      $strQuenry .= ", {$qg['id_genero']}";
    }
  }

  $obj_generos = new Genero($mysql);
  $generos = $obj_generos->encontrarPorIds($strQuenry);
} else {
  $generos = null;
}
//Pedidos

$obj_pedido_quadrinista = new PedidoQuadrinista($mysql);
$pedidos_quadrinistas = $obj_pedido_quadrinista->exibirPorQuadrinista($_SESSION['quadrinista']);
if (count($pedidos_quadrinistas) > 0) {
  $strQuery = '';
  $first = true;
  foreach ($pedidos_quadrinistas as $pedidos_quadrinista) {
    if ($first == true) {
      $strQuery = "{$pedidos_quadrinista['id_pedido']}";
      $first = false;
    } else {
      $strQuery .= ", {$pedidos_quadrinista['id_pedido']}";
    }
  }

  $obj_pedido = new Pedido($mysql);
  $pedidos  =  $obj_pedido->encontrarPorIdsStatus($strQuery, '2');

  //Pedidos Itens
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
      <img src="img/teto.png" class="bg-artist-perfil " loading="lazy" > 
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">
            <div class="card perfil-square" style="transform: translateY(-150px);">
              <div class="circular-portrait mx-auto d-block" style="transform: translateY(-40px);">
                <img src="<?= $quadrinistas['foto'] ?>">
              </div>
              <h1 class="title-perfil"><?= $quadrinistas['nome'] ?></h1>
              <h6>Quadrinista <?php if ($generos != null) {
                                echo "de ";
                                for ($i = 0; $i < count($generos); $i++) {

                                  if ($i > 0) {
                                    echo "\\";
                                    echo $generos[$i]['nome'];
                                  } else {
                                    echo ($generos[$i]['nome']);
                                  }
                                }
                              } ?></h6>
              <p style="font-size: 12px; font-weight: 500;padding-bottom: 10px;"><i class="fa fa-map-marker" style="font-size:12px"></i> <?= $quadrinistas['localA'] ?></p>
              <div class="row">
                <a href="<?= $quadrinistas['loja'] ?>" target="_blank">
                  <h4 class="lojinha-small"><i class="fa fa-shopping-bag" style="font-size:18px"></i> </h4>
                </a>
                <?php if ($quadrinistas['facebook'] != null) { ?>
                  <a href="">
                    <h4 class="redes-small"><i class="fa fa-facebook-square" style="font-size:18px"></i> </h4>
                  </a>
                <?php } ?>

                <?php if ($quadrinistas['instagram'] != null) { ?>
                  <a href="">
                    <h4 class="redes-small"><i class="fa fa-instagram" style="font-size:18px"></i> </h4>
                  </a>
                <?php } ?>

                <?php if ($quadrinistas['twitter'] != null) { ?>
                  <a href="">
                    <h4 class="redes-small"><i class="fa fa-twitter-square" style="font-size:18px"></i> </h4>
                  </a>
                <?php } ?>

                <?php if ($quadrinistas['behance'] != null) { ?>
                  <a href="">
                    <h4 class="redes-small"><i class="fa fa-behance" style="font-size:18px"></i> </h4>
                  </a>
                <?php } ?>
              </div>
              <div class="row" style="margin-top: 20px ;">
                <div class="col" style="margin-left:-25%; text-align: left;">
                  <p>Visitas</p>
                  <p>Quadrinhos</p>
                  <p>Brindes</p>
                  <p>GaivotaCast</p>
                </div>
                <div class="col" style="margin-right:-50%">
                  <p><?= $quadrinistas['visitantes'] ?></p>
                  <p><?php if (isset($quadrinhos)) {
                        echo (count($quadrinhos));
                      } else {
                        echo (0);
                      } ?></p>
                  <p><?php if (isset($brindes)) {
                        echo (count($brindes));
                      } else {
                        echo (0);
                      } ?></p>
                  <p><?php if (isset($gaivotacasts)) {
                        echo (count($gaivotacasts));
                      } else {
                        echo (0);
                      } ?></p>
                </div>
              </div>

              <div style="margin-top: 20px;">

                <p style="font-size: 10px; font-weight: 800;">MEMBRO DESDE DE <?php echo (strtoupper(strftime('%d de %B de %Y', strtotime($quadrinistas['dataL'])))) ?></p>
              </div>
              <hr style="border: 1px solid #cccccc; width: 75%;">
              <div>
                <h5 style="font-weight: 800;">Sobre</h5>
                <p><?= $quadrinistas['descricao'] ?></p>
              </div>
              <a class="btn btn-danger logout" style="margin: 10px" href="APIs/logout.php" type="button" class="btn btn-danger">Logout</a>

            </div>

          </div>
          <div class="col-md-8">
            <div class="row" style="padding-top: 30px;">
              <div class="col-12">
                <ul class="nav nav-pills" id="Artist" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="btn-nav-active" id="hqs-tab" data-bs-toggle="tab" href="#hqs" role="tab" aria-controls="hqs" aria-selected="true">Quadrinhos</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="btn-nav" id="brindes-tab" data-bs-toggle="tab" href="#brindes" role="tab" aria-controls="brindes" aria-selected="false">Brindes</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="btn-nav" id="gaivotacasts-tab" data-bs-toggle="tab" href="#gaivotacasts" role="tab" aria-controls="gaivotacasts" aria-selected="false">Gaivotacasts</a>
                  </li>

                </ul>

                <div class="tab-content" id="ArtistContent">
                  <!-- Quadrinhos -->
                  <div class="tab-pane fade show active" id="hqs" role="tabpanel" aria-labelledby="hqs-tab">
                    <section id="services" class="section-bg" style="background: #fff">
                      <?php if ($quadrinhos != null) { ?>
                        <div class="row" style="padding-left: 5%;">
                          <?php for ($i = 0; $i < count($quadrinhos); $i++) {  ?>

                            <div class="wow bounceInUp" data-wow-duration="1.4s">
                              <div class="comicH">
                                <a href="<?= $quadrinhos[$i]['link'] ?>" target="_blank">

                                  <img class="img-comicH " src="<?= $quadrinhos[$i]['imagem'] ?>" loading="lazy" >
                                  <h6 class="titleS"><?= $quadrinhos[$i]['titulo'] ?></h6>
                                </a>

                              </div>
                            </div>

                          <?php } ?>
                        </div>

                      <?php } ?>
                    </section>

                  </div>

                  <!-- Brindes -->
                  <div class="tab-pane fade" id="brindes" role="tabpanel" aria-labelledby="brindes-tab">
                    <section id="services" class="section-bg" style=" background: #fff">
                      <?php if ($brindes != null) { ?>
                        <div class="row" style="padding-left: 5%;">
                          <?php for ($i = 0; $i < count($brindes); $i++) {  ?>

                            <div class="wow bounceInUp" data-wow-duration="1.4s">
                              <div class="comicH">
                                <a href="<?= $brindes[$i]['link'] ?>" target="_blank">

                                  <img class="img-comicH " src="<?= $brindes[$i]['imagem'] ?>" loading="lazy" >
                                  <h6 class="titleS"><?= $brindes[$i]['titulo'] ?></h6>
                                </a>

                              </div>
                            </div>

                          <?php } ?>
                        </div>

                      <?php } ?>
                    </section>
                  </div>
                  <!-- GaivotaCasts -->
                  <div class="tab-pane fade" id="gaivotacasts" role="tabpanel" aria-labelledby="gaivotacasts-tab">
                    <?php if ($gaivotacasts != null) { ?>
                      <section id="about" class="section-bg" style=" background: #fff">


                        <div class="row about-container">
                          <?php for ($i = 0; $i < count($gaivotacasts); $i++) { ?>
                            <div class="col-lg-5 col-md-5 col-sm-3 contentSmall" style="padding-bottom: 10px;">

                              <div class="icon-box wow">
                                <a href="gaivotacast.php?id=<?= $gaivotacasts[$i]['id'] ?>">

                                  <div class="icon">

                                    <img class="imgsize lazy" src="<?= $gaivotacasts[$i]['imagem'] ?>" loading="lazy" >
                                  </div>

                                  <h4 class="title">
                                    <?= $gaivotacasts[$i]['titulo'] ?> <i class="fa fa-play-circle" style="font-size:20px"></i>
                                  </h4>
                                </a>
                                <p class="descriptionS"><?= $gaivotacasts[$i]['descricao'] ?></p>
                                <p class="date"><?php echo date("d/m/Y", strtotime($gaivotacasts[$i]['dataL']));  ?></p>

                              </div>
                            </div>

                          <?php } ?>
                        <?php } ?>

                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <!-- Pedidos -->
          <?php if (isset($pedidos)) {  ?>
            <h1 style="font-weight: 800;">Pedidos dos seus quadrinhos</h1>

            <?php foreach ($pedidos as $pedido) { ?>
              <div class="row" style="padding-bottom: 15px;">
                <div class="col-12">
                  <div class="card cardPedido">
                    <h5 class="card-header">Pedido: <?= $pedido['id'] ?></h5>
                    <div class="card-body">

                      <span class="card-text" style="disolay: inline">Endereço: <?= $pedido['endereco'] ?></span>
                      <span class="card-text alert alert-primary" style=" position: absolute; right: 0px;disolay: inline">Status:
                        <?php
                        if ($pedido['status'] == 1) echo '<b>Pagamento Pendente</b>';
                        if ($pedido['status'] == 2) echo 'Pagamento Feito';
                        if ($pedido['status'] == 3) echo 'Quadrinhos Embalados';
                        if ($pedido['status'] == 4) echo 'Em Transito';
                        if ($pedido['status'] == 5) echo 'Entregue';
                        ?></span>

                      <section id="services" style="padding: 0px;">
                        <div class="row">
                          <?php foreach ($pedido['itens'] as $key => $pedido_item) {
                            if ($pedido_item['id_quadrinista'] == $_SESSION['quadrinista']) { ?>
                              <div class="comicHSmall">
                                <img class="img-comicH " src="<?= $pedido_item['item']['imagem'] ?>" loading="lazy" >
                                <h6 class="titleS"><?= $pedido_item['item']['titulo'] ?></h6>
                                <div class="qtdPedido" align="center">Quantidade: <?= $pedido_item['quantidade'] ?></div>
                              </div>
                          <?php }
                          } ?>
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
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
      $('#brindes-tab').removeClass();
      $('#hqs-tab').removeClass();
      $('#gaivotacasts-tab').removeClass();

      $('#hqs-tab').addClass('btn-nav-active');
      $('#brindes-tab').addClass('btn-nav');
      $('#gaivotacasts-tab').addClass('btn-nav');
    });

    $('#brindes-tab').click(function() {
      $('#brindes-tab').removeClass();
      $('#hqs-tab').removeClass();
      $('#gaivotacasts-tab').removeClass();

      $('#brindes-tab').addClass('btn-nav-active');
      $('#hqs-tab').addClass('btn-nav');
      $('#gaivotacasts-tab').addClass('btn-nav');
    });

    $('#gaivotacasts-tab').click(function() {
      $('#brindes-tab').removeClass();
      $('#hqs-tab').removeClass();
      $('#gaivotacasts-tab').removeClass();

      $('#gaivotacasts-tab').addClass('btn-nav-active');
      $('#brindes-tab').addClass('btn-nav');
      $('#hqs-tab').addClass('btn-nav');
    });
  </script>
</body>

</html>