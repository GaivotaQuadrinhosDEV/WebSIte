<?php
require_once "../class/config.php";
require_once "../class/genero.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $editgenero = new Genero();
    $editgenero->withMySQL($mysql);
    $editgenero->editar($_POST['id'],$_POST['nome']);
    sleep (1);
    header('Location: ../adminGeneros.php');
    die();
}
