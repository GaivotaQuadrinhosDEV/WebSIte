<?php
require_once "../class/config.php";
require_once "../class/cliente.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $delcliente = new User();
    $delcliente->withMySQL($mysql);
    $delcliente->excluir($_POST['id']);

    header('Location: ../admin.php');
    die();
}

?>