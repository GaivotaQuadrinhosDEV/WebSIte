<?php
session_start();

require_once "../class/config.php";
require_once "../class/cliente.php";

$obj_clientes = new User();
$obj_clientes->withMySQL($mysql);
$clientes = $obj_clientes->exibirTodos();

$fallback = 'index.php';

$anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

foreach ($clientes as $cliente) {
    if ($cliente->email == $_POST['email']) {
        $_SESSION['ja_cadastrado'] = true;

        header("location: {$anterior}");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $user->withMySQL($mysql);
    $user->adicionar($_POST['nome'], $_POST['email'], $_POST['telefone'], 
    crypt($_POST['senha'],'rl'), $_POST['nivel'], $_POST['id_quadrinista']);

    $_SESSION['cadastrado'] = true;

    header("location: {$anterior}");
    exit;
}
