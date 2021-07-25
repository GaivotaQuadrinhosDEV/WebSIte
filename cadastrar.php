<?php
session_start();
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

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body style="background-color: #cce5ff;">


    <div class="contatiner">
        <div class="row">

            <div class="col-md-12 col-sm-12">
                <div class="center" style="padding-bottom: 50px;">
                    <img class="img-login" src="img/loginTop.png">
                    <form action="APIs/addcliente.php" name="form" method="post" role="form">
                        <?php if (isset($_SESSION['cadastrado'])) { ?>
                            <p class="btn btn-outline-success disabled" style="width: 100%;">Usuario cadastrado!</p>
                        <?php
                        }
                        unset($_SESSION['cadastrado']);
                        ?>
                        <?php if (isset($_SESSION['ja_cadastrado'])) { ?>
                            <p class="btn btn-outline-danger disabled" style="width: 100%;">Email já cadastrado!</p>
                        <?php
                        }
                        unset($_SESSION['ja_cadastrado']);
                        ?>
                        <div class="form-group">
                            <label style="font-family:'JackArmstrong'; font-size:24px" for="exampleInputEmail1">Nome</label>
                            <input name="nome" name="text" placeholder="Seu nome" autofocus="" type="text" class="form-control">
                        </div>
                        <input type="hidden" id="id_quadrinista" name="id_quadrinista" value="0">
                        <input type="hidden" id="nivel" name="nivel" value="1">
                        <input type="hidden" id="telefone" name="telefone" value="null">
                        <div class="form-group">
                            <label style="font-family:'JackArmstrong'; font-size:24px" for="exampleInputEmail1">Email</label>
                            <input name="email" name="text" placeholder="Seu email" type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label style="font-family:'JackArmstrong'; font-size:24px" for="exampleInputPassword1">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Sua senha">
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="login.php" class="btn btn-info" style="background-color: #2559a8">Login</a>
                        <a href="index.php" style="display:block; float:right; padding:10px" class="form-check-label" for="exampleCheck1">Voltar ao inicio</a>

                        </center>


                    </form>
                 
                </div>

            </div>
        </div>
    </div>


</body>

</html>