<?php
require_once "../class/config.php";
require_once "../class/banner.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload = upload();

    if ($upload != "") {
        $inserebanner = new Banner();
        $inserebanner->withMySQL($mysql);
        $inserebanner->adicionar("uploads/".$upload,$_POST['id_quadrinho'],$_POST['link'],$_POST['ativo']);
    }
    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    
    die();
}
