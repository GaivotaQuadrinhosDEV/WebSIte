<?php
require_once "../class/config.php";
require_once "../class/cliente.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $user = new User();
    $user->withMySQL($mysql);
    $user->editar($_POST['id'],$_POST['nome'],$_POST['email'],$_POST['telefone'],$_POST['nivel'],$_POST['id_quadrinista']);
    sleep (1);
    header('Location: ../admin.php');
    die();
}
