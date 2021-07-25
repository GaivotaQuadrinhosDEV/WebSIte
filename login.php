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
   
            <div class="col-12">
                <div class="center">
                    <img class="img-login" src="img/loginTop.png">
            
                    <form action="APIs/login.php" name="form" method="post" role="form">
                        <?php if (isset($_SESSION['nao_autenticado'])) { ?>
                            <p class="btn btn-outline-danger disabled" style="width: 100%;">Email ou senha invalidos</p>
                        <?php
                        }
                        unset($_SESSION['nao_autenticado']);
                        ?>
                        
                        <div class="form-group">
                            <label style="font-family:'JackArmstrong'; font-size:18px" for="exampleInputEmail1">Email</label>
                            <input name="usuario" name="text" placeholder="Seu email" autofocus="" type="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label style="font-family:'JackArmstrong'; font-size:18px" for="exampleInputPassword1">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Sua senha">
                        </div>
                        <center>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                        <a href="cadastrar.php" class="btn btn-info" style="background-color: #2559a8">Cadastrar</a>
                        <a href="index.php" style="display:block; float:right; padding:10px" class="form-check-label" for="exampleCheck1">Voltar ao inicio</a>

                        </center>
                    </form>
                    
                </div>
         
            </div>
        </div>
    </div>


</body>

</html>