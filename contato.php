<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "class/config.php";
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

   
    <main id="main">

        <!--==========================
      Contact Section
    ============================-->
        <section id="contact" style="margin-top: 60px;">
            <div class="container">

                <div class="section-header">
                    <h3>Entre em contato</h3>
                </div>

                <div class="row wow fadeInUp">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-5 info">
                                <i class="ion-ios-location-outline"></i>
                                <p> Av. Itavuvu, 11777, Jardim Santa Cecilia, Sorocaba, SP, 18078-005 </p>
                            </div>
                            <div class="col-md-4 info">
                                <i class="ion-ios-email-outline"></i>
                                <p>contato@gaivotaquadrinhos.com</p>
                            </div>
                            <div class="col-md-3 info">
                                <i class="ion-ios-telephone-outline"></i>
                                <p>+55 (15) 99645-7359</p>
                            </div>
                        </div>

                        <div class="form">
                            <div id="sendmessage">Sua mensagem foi enviada. Obrigado!</div>
                            <div id="errormessage"></div>
                            <form action="contactform/contactform.php" name="form" method="post" role="form" class="contactForm">
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Nome" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                        <div class="validation"></div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Email invalido" />
                                        <div class="validation"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Assunto" data-rule="minlen:4" data-msg="O assunto deve ter pelo menos 8 caracteres" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Escreva o que você gostaria mandar " placeholder="Mensagem"></textarea>
                                    <div class="validation"></div>
                                </div>
                                <div class="text-center"><button type="submit" name="submit" value="submit" title="Send Message">Enviar Mensagem</button></div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- #contact -->

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
    </script>
</body>

</html>