<?php

require_once "../class/config.php";
require_once "../class/genero.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $genero = new Genero();
    $genero->withMySQL($mysql);
    $genero->adicionar($_POST['nome']);

    header('Location: ../adminGeneros.php');
    die();
}

?>