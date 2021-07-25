<?php
require_once "../class/config.php";
require_once "../class/quadrinistas_quadrinho.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delquadrinistas_quadrinho = new QuadrinistasQuadrinho();
    $delquadrinistas_quadrinho->withMySQL($mysql);
    $delquadrinistas_quadrinho->excluir($_POST['id']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}

?>