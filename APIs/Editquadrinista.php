<?php
require_once "../class/config.php";
require_once "../class/quadrinista.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $editquadrinista = new Quadrinista();
    $editquadrinista->withMySQL($mysql);
    $editquadrinista->editar($_POST['id'],$_POST['idartistico'],$_POST['nome'],$_POST['descricao'],$_POST['loja'],$_POST['foto'],$_POST['facebook'],$_POST['instagram'],$_POST['twitter'],$_POST['behance'],$_POST['visitantes'],$_POST['localA'],$_POST['dataL']);

    header('Location: ../adminQuadrinistas.php');
    die();
}
