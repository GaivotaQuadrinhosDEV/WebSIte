<?php
require_once "../class/config.php";
require_once "../class/quadrinista.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delquadrinista = new Quadrinista();
    $delquadrinista->withMySQL($mysql);
    $delquadrinista->excluir($_POST['id']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}

?>