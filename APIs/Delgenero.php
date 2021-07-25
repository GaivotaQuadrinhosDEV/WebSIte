<?php
require_once "../class/config.php";
require_once "../class/genero.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delgenero = new Genero();
    $delgenero->withMySQL($mysql);
    $delgenero->excluir($_POST['id']);

    header('Location: ../adminGeneros.php');
    die();
}

?>