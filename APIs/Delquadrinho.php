<?php
require_once "../class/config.php";
require_once "../class/quadrinho.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delquadrinho = new Quadrinho();
    $delquadrinho->withMySQL($mysql);
    $delquadrinho->excluir($_POST['id']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}

?>