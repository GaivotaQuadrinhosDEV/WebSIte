<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (session_status() == PHP_SESSION_ACTIVE) {
    if (isset($_SESSION['nivel'])) {
        $nivel = $_SESSION['nivel'];
    }
}
$boxQtd = 0;
if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $key => $value) {
        $boxQtd += $value['quantidade'];
    }
}
?>

<header id="header" class="fixed-top">
    <div class="container-fluid">

        <div class="logo float-left">

            <a class="scrollto" style="padding-left:50px" href="index.php#intro" ><img src="img/logo.png" class="img-fluid " loading="lazy" ></a>
        </div>

        <nav class="main-nav float-right d-none d-lg-block">
            <ul>
                <li class="active"><a href="index.php#intro">Inicio</a></li>
                <li><a href="gaivotacasts.php">GaivotaCasts</a></li>
                <li><a href="quadrinhos.php">Quadrinhos</a></li>
                <li><a href="quadrinistas.php">Quadrinistas</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li style="padding-right:100px"><a href="apoia.php">Apoia</a></li>

                <?php if (isset($_SESSION['nivel'])) {
                    if ($nivel == 2) { ?>
                        <li><a href="perfilQuadrinista.php"><i class="fa fa-user" style="transform: translateX(-5px);"></i> Perfil</a></li>
                    <?php } ?>
                    <?php if ($nivel == 3) { ?>
                        <li><a href="admin.php"><i class="fa fa-user" style="transform: translateX(-5px);"></i>Admin</a></li>
                    <?php } ?>
                    <?php if ($nivel == 1) { ?>
                        <!-- <li><a href="perfilCliente.php"><i class="fa fa-user" style="transform: translateX(-5px);"></i>Perfil</a></li> -->
                    <?php } ?>

                <?php } else { ?>
                    <!-- <li><a href="perfilQuadrinista.php"><i class="fa fa-sign-in" style="transform: translateX(-5px);"></i>Login</a></li>-->
                <?php } ?> 
                <?php if (isset($_SESSION['carrinho'])) { ?>
                    <li><a href="carrinho.php" style="color: #f1a308;"><i class="fa fa-archive" style="font-size: 30px;transform: translateX(-5px);"></i>
                            <h7><?= $boxQtd ?></h7>
                        </a></li>
                <?php } ?>
                <li style="padding-left:100px"></li>
            </ul>
        </nav>

        <!-- .main-nav -->

    </div>
</header>