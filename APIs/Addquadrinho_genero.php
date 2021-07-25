<?php

require_once "../class/config.php";
require_once "../class/quadrinhos_generos.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $genero = new QuadrinhosGenero();
    $genero->withMySQL($mysql);
    $genero->adicionar($_POST['id_quadrinho'],$_POST['id_genero']);

    header('Location: ../adminGeneros.php');
    die();
}

?>