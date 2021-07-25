<?php

require_once "../class/config.php";
require_once "../class/quadrinistas_quadrinho.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $qq = new QuadrinistasQuadrinho();
    $qq->withMySQL($mysql);
    $qq->adicionar($_POST['id_quadrinista'],$_POST['id_quadrinho']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}

?>