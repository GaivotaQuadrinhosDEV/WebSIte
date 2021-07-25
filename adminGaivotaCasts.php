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

require_once "class/gaivotacast.php";


$obj_gaivotacast = new GaivotaCast();
$obj_gaivotacast->withMySQL($mysql);
$gaivotacasts =  $obj_gaivotacast->exibirTodos();

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
                <h2>GaivotaCasts cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#AddGaivotaCast">
                    <b> Novo GaivotaCast</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">EPISODIO</th>
                            <th scope="col">DESCRICAO</th>
                            <th scope="col">IMAGEM</th>
                            <th scope="col">LINK</th>
                            <th scope="col">DATA</th>
                            <th scope="col">REDES</th>
                            <th scope="col">DURACAO</th>
                            <th scope="col">EMBLED</th>
                            <th scope="col">ATIVO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($gaivotacasts); $i++) {  ?>
                            <tr>
                                <th scope="row"><?= $gaivotacasts[$i]->id ?></th>
                                <td><?= $gaivotacasts[$i]->titulo ?></td>
                                <td><?= $gaivotacasts[$i]->episodio ?></td>
                                <td class="max-lines"><?= $gaivotacasts[$i]->descricao ?></td>
                                <td><img style="width:50px" src=<?= $gaivotacasts[$i]->imagem ?> loading="lazy"></td>
                                <td><?= $gaivotacasts[$i]->link ?></td>
                                <td><?php echo date("d/m/Y", strtotime($gaivotacasts[$i]->dataL)) ?></td>
                                <td class="max-lines"><?= $gaivotacasts[$i]->redes ?></td>
                                <td><?= $gaivotacasts[$i]->duracao ?></td>
                                <td><?= $gaivotacasts[$i]->embled ?></td>
                                <td><?= $gaivotacasts[$i]->ativo ?></td>

                                <td>
                                    <form action="APIs/Delgaivotacast.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $gaivotacasts[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
          var modal = $('#editgaivotacast')
          modal.find('.modal-title').text('ID ' + <?= $gaivotacasts[$i]->id ?>)
		  modal.find('#recipient-titulo').val('<?= $gaivotacasts[$i]->titulo ?>')
		  modal.find('#recipient-episodio').val('<?= $gaivotacasts[$i]->episodio ?>')
		  modal.find('#recipient-descricao').val('<?= $gaivotacasts[$i]->descricao ?>')
		  modal.find('#recipient-imagem').val('<?= $gaivotacasts[$i]->imagem ?>')
		  modal.find('#recipient-link').val('<?= $gaivotacasts[$i]->link ?>')
		  modal.find('#recipient-dataL').val('<?= $gaivotacasts[$i]->dataL ?>')
		  modal.find('#recipient-redes').val(`<?= $gaivotacasts[$i]->redes ?>`)
		  modal.find('#recipient-duracao').val('<?= $gaivotacasts[$i]->duracao ?>')
		  modal.find('#recipient-embled').val('<?= $gaivotacasts[$i]->embled ?>')
		  modal.find('#recipient-ativo').val('<?= $gaivotacasts[$i]->ativo ?>')
		  
                        })()" data-target="#editgaivotacast" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Modal -->
    <div class="modal fade" id="AddGaivotaCast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um GaivotaCast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addgaivotacast.php" method="post" role="form" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <input type="text" name="titulo" class="form-control" id="name" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>

                                <div class="form-group col-lg-3">
                                    <input type="number" class="form-control" name="episodio" id="episodio" placeholder="Episodio" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="20"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="file" name="fileToUpload" id="fileToUpload">

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="link" id="link" placeholder="Link" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="dataL" id="dataL" placeholder="Data ano-mês-dia" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="redes" id="redes" placeholder="Redes" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="duracao" id="duracao" placeholder="Duração 00:00:00" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="embled" id="embled" placeholder="Link Embled" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="ativo" id="ativo" placeholder="Ativo" />
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

    <div class="modal fade" id="editgaivotacast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edite um GaivotaCast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editgaivotacast.php" method="post" role="form" enctype="multipart/form-data">
                        <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <label class="control-label">Titulo:</label>
                                    <input type="text" class="form-control" name="titulo" id="recipient-titulo" placeholder="Titulo" />
                                </div>
                                <div class="form-group col-lg-3">
                                    <label class="control-label">Episodio:</label>

                                    <input type="number" class="form-control" name="episodio" id="recipient-episodio" placeholder="Episódio" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descrição:</label>
                                <input type="text" class="form-control" name="descricao" id="recipient-descricao" placeholder="Descrição" />
                            </div>
                            <div class="form-group">
                            <label class="control-label">Imagem:</label>
                            <input  class="form-control" name="imagem" id="recipient-imagem" placeholder="Imagem">

                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </div>
                            <div class="form-group">
                            <label class="control-label">Lisk:</label>
                                <input type="text" class="form-control" name="link" id="recipient-link" placeholder="Link" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                            </div>
                            <div class="form-group">
                            <label class="control-label">Data de lançamento:</label>
                                <input type="text" class="form-control" name="dataL" id="recipient-dataL" placeholder="Data ano-mês-dia" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                            </div>
                            <div class="form-group">
                            <label class="control-label">Redes:</label>
                                <textarea class="form-control" name="redes" id="recipient-redes" placeholder="Redes" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                            <label class="control-label">Duração:</label>
                                <input type="text" class="form-control" name="duracao" id="recipient-duracao" placeholder="Duração 00:00:00" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />       
                            </div>
                            <div class="form-group">
                            <label class="control-label">Embled:</label>
                                <input type="text" class="form-control" name="embled" id="recipient-embled" placeholder="Link Embled" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                            </div>
                            <div class="form-group">
                            <label class="control-label">Ativo:</label>
                                <input type="text" class="form-control" name="ativo" id="recipient-ativo" placeholder="Ativo" />
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