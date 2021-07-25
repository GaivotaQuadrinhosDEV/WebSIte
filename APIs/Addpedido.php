<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../class/config.php";
require_once "../class/pedido.php";
require_once "../class/pedido_item.php";
require_once "../class/pedido_quadrinista.php";
require_once "../class/quadrinistas_quadrinho.php";
require_once "../APIs/Attpedido.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    if (isset($_SESSION['usuario'])) {

        $pedido = new Pedido($mysql);
        $id_pedido = $pedido->adicionar($_POST['id_cliente'], $_POST['endereco'], $_POST['status'], $_POST['forma_pagamento'], $_POST['codigo_rastreio'], $_SESSION['usuario']);

        
        foreach ($_SESSION['carrinho'] as $key => $value) {
            $quadrinista_quadrinho_obj = new QuadrinistasQuadrinho();
            $quadrinista_quadrinho_obj->withMySQL($mysql);
            $quadrinista_quadrinho = $quadrinista_quadrinho_obj->exibirPorQuadrinhos($value['id']);

            $pedido_item = new PedidoItem();
            $pedido_item->withMySQL($mysql);
            $pedido_item->adicionar(strval($id_pedido), $value['quantidade'], $value['id'],$quadrinista_quadrinho[0]->id_quadrinista);
        
            $pedido_quadrinista_obj = new PedidoQuadrinista();
            $pedido_quadrinista_obj->withMySQL($mysql);
            $pedido_quadrinista_obj->adicionar(strval($id_pedido),$quadrinista_quadrinho[0]->id_quadrinista);
        }

        AtualizarPedido($id_pedido, 0,  $_POST['forma_pagamento'],$mysql);

        $_SESSION['carrinho'] = null;

        header("location: {$anterior}");
    }else{
        $_SESSION['anterior'] = $anterior;
        header("location: login.php");
    }
    exit;
}
