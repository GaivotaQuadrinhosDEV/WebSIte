<?php
require_once "../class/config.php";
require_once "../class/quadrinistas_generos.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delgenero = new QuadrinistasGenero();
    $delgenero->withMySQL($mysql);
    $delgenero->excluir($_POST['id']);

    header('Location: ../adminGeneros.php');
    die();
}

?>