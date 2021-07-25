<?php
require_once "../class/config.php";
require_once "../class/catarse_projeto.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catarseprojeto = new CatarseProjeto();
    $catarseprojeto->withMySQL($mysql);
    $catarseprojeto->editar($_POST['id'],$_POST['titulo'],$_POST['id_quadrinista'], $_POST['link'], $_POST['termino'],$_POST['imagem'],$_POST['ativo']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
