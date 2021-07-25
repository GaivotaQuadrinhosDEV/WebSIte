<?php
require_once "../class/config.php";
require_once "../class/gaivotacast.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delgaivotacast = new GaivotaCast();
    $delgaivotacast->withMySQL($mysql);
    $delgaivotacast->excluir($_POST['id']);

    header('Location: ../adminGaivotaCasts.php');
    die();
}

?>