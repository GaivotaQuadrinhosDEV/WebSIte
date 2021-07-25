<?php
session_start();
include("../class/config.php");

if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    header('Location: ../login.php');
    exit();
}

$usuario = mysqli_real_escape_string($mysql, $_POST['usuario']);
$senha = mysqli_real_escape_string($mysql, $_POST['senha']);

$query = "select id, email, senha, nivel,id_quadrinista from users where email = '{$usuario}'";

$result = mysqli_query($mysql, $query);
$row = mysqli_num_rows($result);

$user = mysqli_fetch_assoc($result);


if ($row == 1) {

    if (crypt($senha,'rl')  == $user["senha"]) {

        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nivel'] = $user["nivel"];

        if (isset($_SESSION['anterior'])) {
            header("location: ../" + $_SESSION['anterior']);
            $_SESSION['anterior'] = null;
        } else {
            if ($user["nivel"] == 1) {
                header('location: ../index.php');
            }
            if ($user["nivel"] == 2) {
                $_SESSION['quadrinista'] = $user['id_quadrinista'];
                header('location: ../perfilQuadrinista.php');
            }
            if ($user["nivel"] == 3) {
                header('location: ../admin.php');
            }
        }
    }else {
        $_SESSION['nao_autenticado'] = true;
        header('location: ../login.php');
        exit();
    }
    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    header('location: ../login.php');
    exit();
}
