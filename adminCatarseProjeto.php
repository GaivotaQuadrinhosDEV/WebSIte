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
if (isset($_SESSION['no_upload']) && $_SESSION['no_upload'] != "") {
    echo ($_SESSION['no_upload']);
    $_SESSION['no_upload'] = "";
}



require_once "class/config.php";
require_once "class/catarse_projeto.php";
require_once "class/quadrinista.php";

$obj_catarse_projeto = new CatarseProjeto();
$obj_catarse_projeto->withMySQL($mysql);
$projetos = $obj_catarse_projeto->exibirTodos();

$obj_quadrinista = new Quadrinista();
$obj_quadrinista->withMySQL($mysql);
$quadrinistas  =  $obj_quadrinista->exibirTodos();

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

            <div class="col">
                <h2>Projetos do Catarse cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#Addcatarseprojeto">
                    <b> Novo Projeto do Catarse</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">ID QUADRINISTA</th>
                            <th scope="col">LINK</th>
                            <th scope="col">TERMINO</th>
                            <th scope="col">IMAGEM</th>
                            <th scope="col">ATIVO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($projetos); $i++) {  ?>
                            <tr>
                                <th scope="row"><?= $projetos[$i]->id ?></th>
                                <td><?=$projetos[$i]->titulo ?></td>
                                <td><?=$projetos[$i]->id_quadrinista ?></td>
                                <td><?=$projetos[$i]->link ?></td>
                                <td><?php echo date("d/m/Y", strtotime($projetos[$i]->termino)) ?></td>
                                <td><img style="width:50px" src="<?=$projetos[$i]->imagem ?>" loading="lazy" ></td>
                                <td><?=$projetos[$i]->ativo ?></td>

                                <td>
                                    <form action="APIs/Delcatarse_projeto.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?=$projetos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
          var modal = $('#editcatarseprojeto')
          modal.find('.modal-title').text('ID ' + <?=$projetos[$i]->id ?>)
		  modal.find('#recipient-titulo').val('<?=$projetos[$i]->titulo ?>')
		  modal.find('#recipient-id_quadrinista').val('<?=$projetos[$i]->id_quadrinista ?>')
		  modal.find('#recipient-link').val('<?=$projetos[$i]->link ?>')
		  modal.find('#recipient-termino').val('<?=$projetos[$i]->termino ?>')
		  modal.find('#recipient-imagem').val('<?=$projetos[$i]->imagem ?>')
		  modal.find('#recipient-ativo').val('<?=$projetos[$i]->ativo ?>')
		  
                        })()" data-target="#editcatarseprojeto" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </main>

    <!-- Modal ADD-->
    <div class="modal modal-full fade" id="Addcatarseprojeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Projeto do Catarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addcatarseprojeto.php" method="post" role="form"  enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">

                                    <select class="form-select btn btn-secondary" name="id_quadrinista" id="id_quadrinista" aria-label="Escolha um Quadrinista">
                                        <option selected>Escolha um Quadrinista</option>
                                        <?php foreach ($quadrinistas as $quadrinista) { ?>
                                            <option value="<?= $quadrinista->id ?>"><?= $quadrinista->nome ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="link" id="link" placeholder="Link do projeto" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="termino" id="termino" placeholder="Data de termino" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                              
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="ativo" id="ativo" placeholder="Ativo" />
                                <div class="validation"></div>
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
    <!-- Modal Edit -->

    <div class="modal fade" id="editcatarseprojeto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edite um Projeto do Catarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editcatarse_projeto.php" method="post" role="form" >
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                <label class="control-label">Id do quadrinista:</label>

                                    <select class="form-select btn btn-secondary" name="id_quadrinista" id="id_quadrinista" aria-label="Escolha um Quadrinista">
                                        <option selected>Escolha um Quadrinista</option>
                                        <?php foreach ($quadrinistas as $quadrinista) { ?>
                                            <option value="<?= $quadrinista->id ?>"><?= $quadrinista->nome ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-lg-12">
                                    <label class="control-label">Titulo:</label>

                                    <input type="text" class="form-control" name="titulo" id="recipient-titulo" placeholder="Titulo" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Link:</label>

                                <input type="text" class="form-control" name="link" id="recipient-link" placeholder="Link do projeto" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Data de termino:</label>

                                <input type="text" class="form-control" name="termino" id="recipient-termino" placeholder="Data de termino" />
                                <div class="validation"></div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label">Imagem:</label>

                                    <input type="text" class="form-control" name="imagem" id="recipient-imagem" placeholder="Imagem">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Ativo:</label>

                                <input type="text" class="form-control" name="ativo" id="recipient-ativo" placeholder="Ativo" />
                                <div class="validation"></div>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->



</body>

</html>