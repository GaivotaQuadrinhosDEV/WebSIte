<?php
require_once "../class/config.php";
require_once "../class/banner.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delbanner = new Banner();
    $delbanner->withMySQL($mysql);
    $delbanner->excluir($_POST['id']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
    
    header("location: {$anterior}");
    die();
}

?>