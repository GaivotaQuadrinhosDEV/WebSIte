<?php
require_once "../class/config.php";
require_once "../class/quadrinho.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $editquadrinho = new Quadrinho();
    $editquadrinho->withMySQL($mysql);
    $editquadrinho->editar($_POST['id'],$_POST['titulo'], $_POST['descricao'], $_POST['imagem'], $_POST['dataL'], $_POST['link'], $_POST['preco'], $_POST['tamanho'], $_POST['paginas'], $_POST['tipo_papel'], $_POST['digital'], $_POST['quantidade'], $_POST['para_maiores'],$_POST['vendidas']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
