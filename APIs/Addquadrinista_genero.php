<?php

require_once "../class/config.php";
require_once "../class/quadrinistas_generos.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $genero = new QuadrinistasGenero();
    $genero->withMySQL($mysql);
    $genero->adicionar($_POST['id_quadrinista'],$_POST['id_genero']);

    header('Location: ../adminGeneros.php');
    die();
}

?>