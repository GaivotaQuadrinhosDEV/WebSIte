<?php
require_once "../class/config.php";
require_once "../class/pedido.php";
require_once "../class/cliente.php";
require_once "../class/quadrinho.php";
require_once "../class/pedido_item.php";
require_once "../contactform/email.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        AtualizarPedido($_POST['id'], $_POST['status'], $_POST['forma_pagamento'], $mysql);

        $fallback = 'index.php';

        $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

        header("location: {$anterior}");
        die();
    }
}

function AtualizarPedido($id_pedido, $status, $forma_pagamento, $mysql): void
{

    $status = $status + 1;

    $attpedido = new Pedido($mysql);
    $attpedido->atualizarStatus($status, $id_pedido, $_SESSION['usuario'], $forma_pagamento);
    $pedido = $attpedido->encontrarPorId($id_pedido);

    $pedido_items = array();
    for ($i = 0; $i < count($pedido); $i++) {

        $obj_pedido_item = new PedidoItem($mysql);
        $pedido_items =  $obj_pedido_item->encontrarPorPedido($pedido['id']);
        if (count($pedido_items) > 1) {
            $strQuery = '';
            $first = true;
            foreach ($pedido_items as $pedido_item) {
                if ($first == true) {
                    $strQuery = "{$pedido_item['id_produto']}";
                    $first = false;
                } else {
                    $strQuery .= ", {$pedido_item['id_produto']}";
                }
            }
        } else {
            $strQuery = "{$pedido_items[0]['id_produto']}";
        }

        if ($strQuery != '') {
            $obj_quadrinho = new Quadrinho($mysql);
            $listaQuadrinhos =  $obj_quadrinho->encontrarPorIds($strQuery);
            foreach ($listaQuadrinhos as $quadrinho) {
                for ($j = 0; $j < count($pedido_items); $j++) {

                    if ($quadrinho['id'] == $pedido_items[$j]['id_produto']) {
                        $pedido_items[$j]['item'] = $quadrinho;
                    }
                }
            }
        }
        $pedido['itens'] = $pedido_items;
        $pedido_items = null;
    }

    $obj_cliente = new User($mysql);
    $cliente = $obj_cliente->encontrarPorId($_POST['id_cliente']);

    //Enviar email 
    switch ($status) {
        case 1:
            $mensagem = "Pedido: " . $pedido['id'] . "\n";

            foreach ($pedido['itens'] as $item) {
                $mensagem .= "Item: " . $item['item']['titulo'] . " - x" . $item['quantidade'] . "\n";
            }

            $assunto = "Pedido " . $pedido['id'] . " | Pedido feito por " . $pedido['nome'];
            sendEmail("contato@gaivotaquadrinhos.com", $cliente['email'], $cliente['nome'], $status, $mensagem, $assunto);
            break;
        case 2:
            //Email para Gaivota Quadrinhos
            $mensagem = "Pedido: " . $pedido['id'] . "\n"
                . "Forma de pagamneto: " . $pedido['forma_pagamento'] . "\n"
                . "Endereço: " . $pedido['endereco'] . "\n";

            foreach ($pedido['itens'] as $item) {
                $mensagem .= "Item: " . $item['item']['titulo'] . " - x" . $item['quantidade'] . "\n";
            }

            $assunto = "Pedido " . $pedido['id'] . " | Pagamento Efetuado por " . $cliente['nome'];
            sendEmail("contato@gaivotaquadrinhos.com", "contato@gaivotaquadrinhos.com", $cliente['nome'], $status, $mensagem, $assunto);
            sendEmail($cliente['email'], "contato@gaivotaquadrinhos.com", $cliente['nome'], $status, $mensagem, $assunto);

            break;
    }
}
