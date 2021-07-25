<?php
require_once "../class/config.php";
require_once "../class/pedido.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $pedido = new Pedido();
    $pedido->withMySQL($mysql);
    $pedido->editar($_POST['id'],$_POST['id_cliente'],$_POST['endereco'],$_POST['status'],$_POST['forma_pagamento'],$_POST['codigo_rastreio'],$_SESSION['usuario']);
    sleep (1);
    header('Location: ../adminPedidos.php');
    die();
}
