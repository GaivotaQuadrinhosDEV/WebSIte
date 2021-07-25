<?php
require_once "../class/config.php";
require_once "../class/gaivotacast.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload = upload();

    if ($upload != "") {
    $inseregaivotacast = new GaivotaCast();
    $inseregaivotacast->withMySQL($mysql);
    $inseregaivotacast->adicionar(
        $_POST['titulo'],$_POST['episodio'],$_POST['descricao'],"uploads/".$upload,
        $_POST['link'],$_POST['dataL'],$_POST['redes'],$_POST['duracao'],$_POST['embled'],$_POST['ativo']);
    }
    header('Location: ../adminGaivotaCasts.php');
    die();
}

?>