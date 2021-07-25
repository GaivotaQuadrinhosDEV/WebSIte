<?php

require_once "../class/config.php";
require_once "../class/quadrinho.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload = upload();

    if ($upload != "") {
    $quadrinho = new Quadrinho();
    $quadrinho->withMySQL($mysql);
    $quadrinho->adicionar($_POST['titulo'], $_POST['descricao'], "uploads/".$upload, $_POST['dataL'], $_POST['link'], $_POST['preco'], $_POST['tamanho'], $_POST['paginas'], $_POST['tipo_papel'], $_POST['digital'], $_POST['quantidade'], $_POST['para_maiores'],$_POST['is_quadrinho'],$_POST['vendidas']);
    }
    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
