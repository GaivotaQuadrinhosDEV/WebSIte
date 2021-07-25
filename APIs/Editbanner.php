<?php
require_once "../class/config.php";
require_once "../class/banner.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banner = new Banner();
    $banner->withMySQL($mysql);
    $banner->editar($_POST['id'],$_POST['imagem'], $_POST['id_quadrinho'], $_POST['link'], $_POST['ativo']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
