<?php
require_once "../class/config.php";
require_once "../class/pedido.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delpedido = new Pedido();
    $delpedido->withMySQL($mysql);
    $delpedido->excluir($_POST['id']);

   
    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}

?>