<?php

require_once "../class/config.php";
require_once "../class/quadrinista.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload = upload();

    if ($upload != "") {
        $quadrinista = new Quadrinista();
        $quadrinista->withMySQL($mysql);
        $quadrinista->adicionar($_POST['idartistico'], $_POST['nome'], $_POST['descricao'], $_POST['loja'], "uploads/" . $upload, $_POST['facebook'], $_POST['instagram'], $_POST['twitter'], $_POST['behance'], $_POST['visitantes'], $_POST['localA']);
    }
    $fallback = 'index.php';

    $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;

    header("location: {$anterior}");
    die();
}
