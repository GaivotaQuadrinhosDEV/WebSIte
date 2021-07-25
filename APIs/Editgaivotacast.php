<?php
require_once "../class/config.php";
require_once "../class/gaivotacast.php";
require_once "../functions/upload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $editgaivotacast = new GaivotaCast();
    $editgaivotacast->withMySQL($mysql);
    if (isset($_POST['imagem'])) {
        $editgaivotacast->editar($_POST['id'], $_POST['titulo'], $_POST['episodio'], $_POST['descricao'], $_POST['imagem'], $_POST['link'], $_POST['dataL'], $_POST['redes'], $_POST['duracao'], $_POST['embled'], $_POST['ativo']);
    } else {
        $upload = upload();

        if ($upload != "") {
            $editgaivotacast->editar($_POST['id'], $_POST['titulo'], $_POST['episodio'], $_POST['descricao'], "uploads/" . $upload, $_POST['link'], $_POST['dataL'], $_POST['redes'], $_POST['duracao'], $_POST['embled'], $_POST['ativo']);
        }
    }
    header('Location: ../adminGaivotaCasts.php');
    die();
}
