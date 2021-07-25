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

    require_once "class/quadrinista.php";


    $obj_quadrinista = new Quadrinista();
    $obj_quadrinista->withMySQL($mysql);
    $quadrinistas = $obj_quadrinista->exibirTodos();

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
                    <h2>Quadrinistas cadastrados</h2>
                    <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#AddQuadrinista">
                        <b> Novo Quadrinista</b> <i class="fa fa-plus-circle"></i></a>
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">IDARTISTICO</th>
                                <th scope="col">NOME</th>
                                <th scope="col">DESCRICAO</th>
                                <th scope="col">SITE</th>
                                <th scope="col">FOTO</th>
                                <th scope="col">FACEBOOK</th>
                                <th scope="col">INSTAGRAM</th>
                                <th scope="col">TWITTER</th>
                                <th scope="col">BEHANCE</th>
                                <th scope="col">VISITANTES</th>
                                <th scope="col">LOCAL</th>
                                <th scope="col">DATA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($quadrinistas != null) {
                                for ($i = 0; $i < count($quadrinistas); $i++) {  ?>
                                    <tr>
                                        <th scope="row"><?= $quadrinistas[$i]->id ?></th>
                                        <td><?= $quadrinistas[$i]->idartistico ?></td>
                                        <td><img style="width:50px" src=<?= $quadrinistas[$i]->foto ?> loading="lazy"></td>
                                        <td><?= $quadrinistas[$i]->nome ?></td>
                                        <td class="max-lines"><?= $quadrinistas[$i]->descricao ?></td>
                                        <td><?= $quadrinistas[$i]->loja ?></td>
                                        <td><?= $quadrinistas[$i]->facebook ?></td>
                                        <td><?= $quadrinistas[$i]->instagram ?></td>
                                        <td><?= $quadrinistas[$i]->twitter ?></td>
                                        <td><?= $quadrinistas[$i]->behance ?></td>

                                        <td><?= $quadrinistas[$i]->visitantes ?></td>
                                        <td><?= $quadrinistas[$i]->localA ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($quadrinistas[$i]->dataL))  ?></td>

                                        <td>
                                            <form action="APIs/DelQuadrinista.php" method="POST">
                                                <input type="hidden" id="id" name="id" value="<?= $quadrinistas[$i]->id ?>">
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                            <button type="button" onclick="(function(){
                                    
            var modal = $('#EditQuadrinista')
            modal.find('.modal-title').text('ID Quadrinista' + <?= $quadrinistas[$i]->id ?>)
            modal.find('#recipient-id').val('<?= $quadrinistas[$i]->id ?>')
            modal.find('#recipient-idartistico').val('<?= $quadrinistas[$i]->idartistico ?>')
            modal.find('#recipient-nome').val('<?= $quadrinistas[$i]->nome ?>')
            modal.find('#recipient-descricao').val(' <?= $quadrinistas[$i]->descricao ?>')
            modal.find('#recipient-loja').val('<?= $quadrinistas[$i]->loja ?>')
            modal.find('#recipient-foto').val('<?= $quadrinistas[$i]->foto ?>')      
            modal.find('#recipient-facebook').val('<?= $quadrinistas[$i]->facebook ?>')      
            modal.find('#recipient-instagram').val('<?= $quadrinistas[$i]->instagram ?>')      
            modal.find('#recipient-twitter').val('<?= $quadrinistas[$i]->twitter ?>')      
            modal.find('#recipient-behance').val('<?= $quadrinistas[$i]->behance ?>')          
            modal.find('#recipient-visitantes').val('<?= $quadrinistas[$i]->visitantes ?>')      
            modal.find('#recipient-localA').val('<?= $quadrinistas[$i]->localA ?>')      
            modal.find('#recipient-dataL').val('<?= $quadrinistas[$i]->dataL ?>')      
                
                            })()" data-target="#EditQuadrinista" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>

                                        </td>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>

        </main>

        <!-- Modal -->
        <div class="modal fade" id="AddQuadrinista" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastre um Quadrinista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form">

                            <form action="APIs/Addquadrinista.php" method="post" role="form" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-lg-9">
                                        <input type="text" name="nome" class="form-control" id="name" placeholder="Nome" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                        <div class="validation"></div>
                                    </div>
                                </div>
                                <input class="form-control" name="idartistico" id="idartistico" placeholder="ID Artisticos"></input>
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="loja" id="loja" placeholder="Link da Loja" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Link da facebook" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Link da instagram" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Link da twitter" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="behance" id="behance" placeholder="Link da behance" />
                                    <div class="validation"></div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="localA" id="localA" placeholder="Cidade e Estado" />
                                    <div class="validation"></div>
                                </div>

                                <input type="hidden" class="form-control" name="visitantes" id="visitantes" placeholder="Visitantes" value="0">




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


        <div class="modal fade" id="EditQuadrinista" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Altere um quadrinista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form">

                            <form action="APIs/Editquadrinista.php" method="post" role="form">
                                <div class="form-row">
                                    <div class="form-group col-lg-12">

                                        <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label class="control-label">Nome Artistico:</label>
                                        <input type="text" name="idartistico" class="form-control" id="recipient-idartistico" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                        <div class="validation"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label class="control-label">Nome:</label>
                                        <input type="text" name="nome" class="form-control" id="recipient-nome" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                        <div class="validation"></div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label">Descrição:</label>
                                    <textarea type="text" class="form-control" name="descricao" id="recipient-descricao" placeholder="Descrição" rows="20" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres"></textarea>
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Site:</label>
                                    <input class="form-control" name="loja" id="recipient-loja" placeholder="Loja"></input>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Foto:</label>
                                    <input type="text" class="form-control" name="foto" id="recipient-foto" placeholder="Foto" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Facebook:</label>
                                    <input type="text" class="form-control" name="facebook" id="recipient-facebook" placeholder="Facebook" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Instagram:</label>
                                    <input type="text" class="form-control" name="instagram" id="recipient-instagram" placeholder="Instagram" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Twitter:</label>
                                    <input type="text" class="form-control" name="twitter" id="recipient-twitter" placeholder="Twitter" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Behance:</label>
                                    <input type="text" class="form-control" name="behance" id="recipient-behance" placeholder="Behance" />
                                    <div class="validation"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Cidade - Estado:</label>
                                    <input type="text" class="form-control" name="localA" id="recipient-localA" placeholder="Cidade e Estado" />
                                    <div class="validation"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Data:</label>

                                    <input type="text" class="form-control" name="dataL" id="recipient-dataL" placeholder="Data" />
                                    <div class="validation"></div>
                                </div>
                                <input type="hidden" class="form-control" name="visitantes" id="recipient-visitantes" placeholder="Visitantes">



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