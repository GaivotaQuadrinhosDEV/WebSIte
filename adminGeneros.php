<?php
session_start();
if (!$_SESSION['usuario']) {
    header("location: login.php");
    exit();
}
if ($_SESSION['nivel'] != 3) {
    header("location: login.php");
    exit();
}
require_once "class/config.php";

require_once "class/genero.php";
require_once "class/quadrinistas_generos.php";
require_once "class/quadrinhos_generos.php";
require_once "class/quadrinista.php";

require_once "class/quadrinho.php";

$obj_genero = new Genero();
$obj_genero->withMySQL($mysql);
$generos  =  $obj_genero->exibirTodos();

$obj_quadrinistas_genero = new QuadrinistasGenero();
$obj_quadrinistas_genero->withMySQL($mysql);
$quadrinistas_generos  =  $obj_quadrinistas_genero->exibirTodos();

$obj_quadrinhos_genero = new QuadrinhosGenero();
$obj_quadrinhos_genero->withMySQL($mysql);
$quadrinhos_generos  =  $obj_quadrinhos_genero->exibirTodos();

$obj_quadrinista = new Quadrinista();
$obj_quadrinista->withMySQL($mysql);
$quadrinistas  =  $obj_quadrinista->exibirTodos();

$obj_quadrinho = new Quadrinho();
$obj_quadrinho->withMySQL($mysql);
$quadrinhos  =  $obj_quadrinho->exibirTodosQuadrinhos();
?>

<!doctype html>
<html lang="en">


<head>
    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Administrador</title>
</head>

<body>
    <?php include "includes/headeradmin.html" ?>

    <main role="main" class="container-fluid">
        <div class="row">
            <a class="btn btn-info" style="margin: 10px;" href="#generos">Gêneros</a>

            <a class="btn btn-info" style="margin: 10px;" href="#genero_quadrinistas">Gêneros de Quadrinistas</a>

            <a class="btn btn-info" style="margin: 10px;" href="#genero_quadrinhos">Gêneros de Quadrinhos</a>

        </div>

        <div class="row" id="genero">
            <div class="col">
                <h2>Gêneros cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#Addgenero">
                    <b> Novo Gênero</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($generos); $i++) {  ?>
                            <tr>

                                <th scope="row"><?= $generos[$i]->id ?></th>
                                <td><?= $generos[$i]->nome ?></td>

                                <td>
                                    <form action="APIs/Delgenero.php" method="POST" style="display: inline-block;">
                                        <input type="hidden" id="id" name="id" value="<?= $generos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" style="display: inline-block;" onclick="(function(){
                                   
          var modal = $('#editgenero')
          modal.find('.modal-title').text('ID Genero ' + <?= $generos[$i]->id ?>)
		  modal.find('#recipient-id').val('<?= $generos[$i]->id ?>')
		  modal.find('#recipient-nome').val('<?= $generos[$i]->nome ?>')   
		 

                        })()" data-target="#editgenero" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>

                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" id="genero_quadrinistas">
            <div class="col">
                <h2>Gêneros de Quadrinistas cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#Addquadrinistagenero">
                    <b> Novo Gênero Quadrinista</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">

                    <thead>
                        <tr>

                            <th scope="col">ID</th>
                            <th scope="col">ID QUADRINISTA</th>
                            <th scope="col">ID GÊNERO</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($quadrinistas_generos); $i++) {  ?>
                            <tr>

                                <th scope="row"><?= $quadrinistas_generos[$i]->id ?></th>
                                <td><?= $quadrinistas_generos[$i]->id_quadrinista ?></td>
                                <td><?= $quadrinistas_generos[$i]->id_genero ?></td>

                                <td>
                                    <form action="APIs/Delquadrinista_genero.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $quadrinistas_generos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>

                                </td>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" id="genero_quadrinhos">
            <div class="col">
                <h2>Gêneros de Quadrinhos cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#Addquadrinhogenero">
                    <b> Novo Gênero Quadrinho</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID QUADRINHO</th>
                            <th scope="col">ID GÊNERO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($quadrinhos_generos); $i++) {  ?>
                            <tr>

                                <th scope="row"><?= $quadrinhos_generos[$i]->id ?></th>
                                <td><?= $quadrinhos_generos[$i]->id_quadrinho ?></td>
                                <td><?= $quadrinhos_generos[$i]->id_genero ?></td>

                                <td>
                                    <form action="APIs/Delquadrinho_genero.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $quadrinhos_generos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>

                                </td>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>


    <!-- Modal Genero -->
    <div class="modal fade" id="Addgenero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um gênero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addgenero.php" method="post" role="form">
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>



                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Cadastrar</button></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Quadrinista-->
    <div class="modal fade" id="Addquadrinistagenero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Genero de um Quadrinista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form">

                        <form action="APIs/Addquadrinista_genero.php" method="post" role="form">


                            <div class="form-row">
                                <div class="form-group col-lg-9">

                                    <select class="form-select btn btn-secondary" name="id_quadrinista" id="id_quadrinista" aria-label="Escolha um Quadrinista">
                                        <option selected>Escolha um Quadrinista</option>
                                        <?php if ($quadrinistas != null) {
                                            for ($i = 0; $i < count($quadrinistas); $i++) { ?>
                                                <option value="<?= $quadrinistas[$i]->id ?>"><?= $quadrinistas[$i]->nome ?></option>
                                        <?php }
                                        } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">

                                    <select class="form-select btn btn-secondary" name="id_genero" id="id_genero" aria-label="Escolha um Gênero">
                                        <option selected>Escolha um Gênero</option>
                                        <?php for ($i = 0; $i < count($generos); $i++) {   ?>
                                            <option value="<?= $generos[$i]->id ?>"><?= $generos[$i]->nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Cadastrar</button></div>
                        </form>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Quadrinho -->
    <div class="modal fade" id="Addquadrinhogenero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Quadrinho gênero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addquadrinho_genero.php" method="post" role="form">
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <select class="form-select btn btn-secondary" name="id_quadrinho" id="id_quadrinho" aria-label="Escolha um Quadrinho">
                                        <option selected>Escolha um Quadrinho</option>
                                        <?php for ($i = 0; $i < count($quadrinhos); $i++) {  ?>
                                            <option value="<?= $quadrinhos[$i]->id ?>"><?= $quadrinhos[$i]->titulo ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <select class="form-select btn btn-secondary" name="id_genero" id="id_genero" aria-label="Escolha um Gênero">
                                        <option selected>Escolha um Gênero</option>
                                        <?php for ($i = 0; $i < count($generos); $i++) {  ?>
                                            <option value="<?= $generos[$i]->id ?>"><?= $generos[$i]->nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Cadastrar</button></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div class="modal fade" id="editgenero" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Altere um genero</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editgenero.php" method="post" role="form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <label class="control-label">Nome:</label>
                                    <input type="text" name="nome" class="form-control" id="recipient-nome" placeholder="Nome" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Alterar</button></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>