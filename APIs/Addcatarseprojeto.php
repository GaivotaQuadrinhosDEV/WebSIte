<?php

require_once "../class/config.php";
require_once "../class/catarse_projeto.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload = upload();

    if ($upload != "") {
    $catarseProjeto = new CatarseProjeto();
    $catarseProjeto->withMySQL($mysql);
    $catarseProjeto->adicionar($_POST['titulo'], $_POST['id_quadrinista'], $_POST['link'],$_POST['termino'],"uploads/".$upload,$_POST['ativo']);
    }
    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
