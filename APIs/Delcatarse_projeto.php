<?php
require_once "../class/config.php";
require_once "../class/catarse_projeto.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delcatarseprojeto = new CatarseProjeto();
    $delcatarseprojeto->withMySQL($mysql);
    $delcatarseprojeto->excluir($_POST['id']);

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
    
    header("location: {$anterior}");
    die();
}

?>