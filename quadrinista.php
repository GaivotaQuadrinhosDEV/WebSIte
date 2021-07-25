<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require_once "class/config.php";
require_once "class/quadrinista.php";
require_once "class/participantes_gaivotacast.php";
require_once "class/quadrinistas_quadrinho.php";
require_once "class/catarse_projeto.php";

if (!isset($_GET['id'])) {
  header('Location: quadrinistas.php');
}

$quadrinista_obj = new Quadrinista();
$quadrinista_obj->withMySQL($mysql);
$quadrinista = $quadrinista_obj->encontrarPorId($_GET['id']);
$quadrinista_obj->addVisitante($quadrinista->id, $quadrinista->visitantes + 1);

$catarse_projeto = new CatarseProjeto();
$catarse_projeto->withMySQL($mysql);
$catarse_projeto = $catarse_projeto->encontrarPorQuadrinista($quadrinista->id);

$obj_quadrinistas_quadrinho = new QuadrinistasQuadrinho();
$obj_quadrinistas_quadrinho->withMySQL($mysql);
$quadrinhos = $obj_quadrinistas_quadrinho->exibirQuadrinhosPorQuadrinista($_GET['id']);

$brindes = $obj_quadrinistas_quadrinho->exibirBrindesPorQuadrinista($_GET['id']);

$obj_participantes_gaivotacast = new ParticipantesGaivotacast();
$obj_participantes_gaivotacast->withMySQL($mysql);
$gaivotacasts = $obj_participantes_gaivotacast->exibirPorQuadrinista($_GET['id']);

if (isset($_GET['adicionar'])) {

  $idProduto = (int) $_GET['adicionar'];

  for ($i = 0; $i < count($quadrinhos); $i++) {
    if ($quadrinhos[$i]['id'] == $idProduto) {

      if (isset($_SESSION['carrinho'][$idProduto])) {
        $_SESSION['carrinho'][$idProduto]['quantidade']++;
      } else {
        $_SESSION['carrinho'][$idProduto] = array('id' => $idProduto, 'nome' => $quadrinhos[$i]['titulo'], 'imagem' => $quadrinhos[$i]['imagem'], 'preco' => $quadrinhos[$i]['preco'], 'quantidade' => 1, 'quadrinistas' => $quadrinistas_quadrinho[0]['id_quadrinista']);
      }
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


    <!--==========================
      Catalogo Section
    ============================-->
    <section id="catalogo">
      <div class="bg-artist"></div>

      <div class="container" style="transform: translateY(-150px);">
        <div class="row">
          <div class="col-12">
            <div class="circular-portrait mx-auto d-block">
              <img src="<?= $quadrinista->foto ?>" loading="lazy">
            </div>
            <h1 class="titulo"><?= $quadrinista->nome ?></h1>
          </div>
        </div>
        <div class="row" style="padding-top: 30px;">

          <div class="col-md-8 col-sm-12">
            <h3 style="font-weight: bold;">Sobre mim</h3>
            <p><?= $quadrinista->descricao ?></p>
          </div>
          <div class="col-md-4 col-sm-12 text-center">
            <?php if($quadrinista->loja != null) { ?>
            <a href="<?= $quadrinista->loja ?>" target="_blank">
              <h4 class="lojinha"><i class="fa fa-shopping-bag" style="font-size:18px"></i> Visitar Site </h4>
            </a>
            <?php }?>
            <?php if ($quadrinista->facebook != null) { ?>
              <a href="<?= $quadrinista->facebook ?>" target="_blank">
                <h4 class="redes"><i class="fa fa-facebook-square" style="font-size:18px"></i> Facebook </h4>
              </a>
            <?php } ?>

            <?php if ($quadrinista->instagram != null) { ?>
              <a href="<?= $quadrinista->instagram ?>" target="_blank">
                <h4 class="redes"><i class="fa fa-instagram" style="font-size:18px"></i> Instagram </h4>
              </a>
            <?php } ?>

            <?php if ($quadrinista->twitter != null) { ?>
              <a href="<?= $quadrinista->twitter ?>" target="_blank">
                <h4 class="redes"><i class="fa fa-twitter-square" style="font-size:18px"></i> Twitter </h4>
              </a>
            <?php } ?>

            <?php if ($quadrinista->behance != null) { ?>
              <a href="<?= $quadrinista->behance ?>" target="_blank">
                <h4 class="redes"><i class="fa fa-behance" style="font-size:18px"></i> Behance </h4>
              </a>
            <?php } ?>

          </div>
        </div>
        <div class="row" style="padding-top: 30px;">
          <div class="col-12 ">
            <ul class="nav nav-pills" id="Artist" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="btn-nav-active" id="hqs-tab" data-bs-toggle="tab" href="#hqs" role="tab" aria-controls="hqs" aria-selected="true">Quadrinhos</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="btn-nav" id="brindes-tab" data-bs-toggle="tab" href="#brindes" role="tab" aria-controls="brindes" aria-selected="false">Brindes</a>
              </li>

            </ul>

            <div class="tab-content" id="ArtistContent">
              <!-- Quadrinhos -->
              <div class="tab-pane fade show active" id="hqs" role="tabpanel" aria-labelledby="hqs-tab">
                <section id="services" class="section-bg" style="border: 2px solid #2559a8;  background: #fff">
                  <?php if ($quadrinhos != null) { ?>
                    <div class="row" style="padding-left: 5%;">
                      <?php foreach ($quadrinhos as $quadrinho) {  ?>

                        <div>
                          <div class="comicH">
                            <a href="<?= $quadrinho->link ?>" target="_blank">

                              <img class="img-comicH " src="<?= $quadrinho->imagem ?>" loading="lazy">
                              <h6 class="titleS"><?= $quadrinho->titulo ?></h6>
                              <p class="precoS"><?php if ($quadrinho->preco != 0) {
                                                  echo "R$  ". number_format($quadrinho->preco, 2,',');
                                                } else {
                                                  echo 'GRATÍS';
                                                } ?></p>
                            </a>
                            <div style="text-align: center;">
                              <a href="<?= $quadrinho->link ?>" target="_blank">

                                <h4 class="comprarBtn"> <?php if ($quadrinho->digital == 0) {
                                                          echo 'COMPRAR';
                                                        } else {
                                                          echo 'LER';
                                                        }
                                                        ?> </h4>
                              </a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </section>
              </div>

              <!-- brindes -->
              <div class="tab-pane fade" id="brindes" role="tabpanel" aria-labelledby="brindes-tab">
                <section id="services" class="section-bg" style="border: 2px solid #2559a8;  background: #fff">
                  <?php if ($quadrinhos != null) { ?>
                    <div class="row" style="padding-left: 5%;">
                      <?php foreach ($brindes as $brinde) {  ?>

                        <div>
                          <div class="comicH">
                            <a href="<?= $brinde->link ?>" target="_blank">

                              <img class="img-comicH " src="<?= $brinde->imagem ?>" loading="lazy">
                              <h6 class="titleS"><?= $brinde->titulo ?></h6>
                              <p class="precoS"><?= "R$ ".number_format($brinde->preco,2,','); ?></p>
                            </a>
                            <div style="text-align: center;">
                              <a href="<?= $brinde->link ?>" target="_blank">
                                <h4 class="comprarBtn"> <?= 'COMPRAR' ?> </h4>
                              </a>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </section>
              </div>
            </div>
          </div>
        </div>

        <!-- catarse -->
        <?php if ($catarse_projeto != null) { ?>
          <section id="catarse">
            <h3 style="font-weight: bold;">Projeto no Catarse <img style="height: 50px; margin-top:-15px; margin-left:-10px" src="img/icones/catarse.png" loading="lazy"></h3>

            <a href="<?= $catarse_projeto->link ?>" target="_blank">
              <div class="catarse-content">
                <div class="row">
                  <img src="<?= $catarse_projeto->imagem ?>" loading="lazy">
                  <h1><?= $catarse_projeto->titulo ?></h1>
                  <span>
                    Termino: <p><?= date("d/m/Y", strtotime($catarse_projeto->termino)) ?></p>
                  </span>
                </div>
              </div>
            </a>
          </section>
        <?php } ?>
        <!-- gaivota cast -->

        <?php if ($gaivotacasts != null) { ?>
          <section id="about">
            <h3 style="font-weight: bold;">GaivotaCasts Participados</h3>
            <div class="row about-container" style="padding-top: 25px;">
              <?php foreach ($gaivotacasts as $gaivotacast) { ?>
                <div class="col-lg-5 col-md-5 col-sm-3 contentSmall" style="padding-bottom: 10px;">

                  <div class="icon-box wow">
                    <a href="gaivotacast.php?id=<?= $gaivotacast->id ?>">

                      <div class="icon">

                        <img class="imgsize lazy" src="<?= $gaivotacast->imagem ?>" loading="lazy">
                      </div>

                      <h4 class="title">
                        <?= $gaivotacast->titulo ?> <i class="fa fa-play-circle" style="font-size:20px"></i>
                      </h4>
                    </a>
                    <p class="descriptionS"><?= $gaivotacast->descricao ?></p>
                    <p class="date"><?php echo date("d/m/Y", strtotime($gaivotacast->dataL));  ?></p>

                  </div>
                </div>
              <?php } ?>


            </div>
          </section>
        <?php } ?>




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
      $('#hqs-tab').addClass('btn-nav-active');
      $('#brindes-tab').addClass('btn-nav');

    });

    $('#brindes-tab').click(function() {
      $('#brindes-tab').removeClass();
      $('#hqs-tab').removeClass();

      $('#brindes-tab').addClass('btn-nav-active');
      $('#hqs-tab').addClass('btn-nav');
    });
  </script>
</body>

</html>