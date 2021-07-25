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
require_once "class/quadrinho.php";
require_once "class/quadrinistas_quadrinho.php";
require_once "class/quadrinista.php";

$obj_quadrinho = new Quadrinho();
$obj_quadrinho->withMySQL($mysql);
$quadrinhos  =  $obj_quadrinho->exibirTodosBrindes();

$obj_quadrinistas_quadrinhos = new QuadrinistasQuadrinho();
$obj_quadrinistas_quadrinhos->withMySQL($mysql);
$quadrinistas_quadrinhos  =  $obj_quadrinistas_quadrinhos->exibirTodosBrindes();

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
            <a class="btn btn-info" style="margin: 10px;" href="#brindes">Brindes</a>

            <a class="btn btn-info" style="margin: 10px;" href="#quadrinistas_brindes">Quadrinistas de Brindes</a>

        </div>


        <div class="row" id="brindes">
            <div class="col">
                <h2>Brindes cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#AddBrinde">
                    <b> Novo Brinde</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TITULO</th>
                            <th scope="col">DESCRICAO</th>
                            <th scope="col">CAPA</th>
                            <th scope="col">DATA</th>
                            <th scope="col">LINK</th>
                            <th scope="col">PREÇO</th>
                            <th scope="col">TAMANHO</th>
                            <th scope="col">PAGINAS</th>
                            <th scope="col">TIPO PAPEL</th>
                            <th scope="col">DIGITAL</th>
                            <th scope="col">QUANTIDADE</th>
                            <th scope="col">PARA MAIORES</th>
                            <th scope="col">VENDIDAS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($quadrinhos); $i++) {  ?>
                            <tr>

                                <th scope="row"><?= $quadrinhos[$i]->id ?></th>
                                <td><?= $quadrinhos[$i]->titulo ?></td>
                                <td class="max-lines"><?= $quadrinhos[$i]->descricao ?></td>
                                <td><img style="width:50px" src=<?= $quadrinhos[$i]->imagem ?> loading="lazy"></td>
                                <td><?php echo date("d/m/Y", strtotime($quadrinhos[$i]->dataL)) ?></td>
                                <td><?= $quadrinhos[$i]->link ?></td>
                                <td><?= number_format($quadrinhos[$i]->preco,2,',') ?></td>
                                <td><?= $quadrinhos[$i]->tamanho ?></td>
                                <td><?= $quadrinhos[$i]->paginas ?></td>
                                <td><?= $quadrinhos[$i]->tipo_papel ?></td>
                                <td><?= $quadrinhos[$i]->digital ?></td>
                                <td><?= $quadrinhos[$i]->quantidade ?></td>
                                <td><?= $quadrinhos[$i]->para_maiores ?></td>
                                <td><?= $quadrinhos[$i]->vendidas ?></td>

                                <td>
                                    <form action="APIs/Delquadrinho.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $quadrinhos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
                                   
          var modal = $('#editquadrinho')
          modal.find('.modal-title').text('ID Quadrinho ' + <?= $quadrinhos[$i]->id ?>)
		  modal.find('#recipient-id').val('<?= $quadrinhos[$i]->id ?>')
		  modal.find('#recipient-titulo').val('<?= $quadrinhos[$i]->titulo ?>')
          modal.find('#recipient-descricao').val('<?= $quadrinhos[$i]->descricao ?>')
          modal.find('#recipient-imagem').val(`<?= $quadrinhos[$i]->imagem ?>`)
		  modal.find('#recipient-dataL').val('<?= $quadrinhos[$i]->dataL ?>')
		  modal.find('#recipient-link').val('<?= $quadrinhos[$i]->link ?>')
          modal.find('#recipient-preco').val('<?= number_format($quadrinhos[$i]->preco,2,',') ?>')      
          modal.find('#recipient-tamanho').val('<?= $quadrinhos[$i]->tamanho ?>')      
          modal.find('#recipient-paginas').val('<?= $quadrinhos[$i]->paginas ?>')      
          modal.find('#recipient-tipo_papel').val('<?= $quadrinhos[$i]->tipo_papel ?>')      
          modal.find('#recipient-digital').val('<?= $quadrinhos[$i]->digital ?>')      
          modal.find('#recipient-quantidade').val('<?= $quadrinhos[$i]->quantidade ?>')      
          modal.find('#recipient-para_maiores').val('<?= $quadrinhos[$i]->para_maiores ?>')      
          modal.find('#recipient-vendidas').val('<?= $quadrinhos[$i]->vendidas ?>')      
		 

                        })()" data-target="#editquadrinho" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>

                                </td>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" id="quadrinistas_brindes">
            <div class="col">
                <h2>Autores de Brindes cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#AddAutorBrinde">
                    <b> Novo Autor de Brinde</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID QUADRINISTA</th>
                            <th scope="col">ID BRINDE</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($quadrinistas_quadrinhos); $i++) {  ?>
                            <tr>

                                <th scope="row"><?= $quadrinistas_quadrinhos[$i]->id ?></th>
                                <td><?= $quadrinistas_quadrinhos[$i]->id_quadrinista ?></td>
                                <td><?= $quadrinistas_quadrinhos[$i]->id_quadrinho ?></td>

                                <td>
                                    <form action="APIs/Delquadrinistas_quadrinho.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $quadrinistas_quadrinhos[$i]->id ?>">
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

    <!-- Modal -->
    <div class="modal fade" id="AddBrinde" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Brinde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addquadrinho.php" method="post" role="form"  enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-lg-9">
                                    <input type="text" name="titulo" class="form-control" id="name" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="dataL" id="dataL" placeholder="Data ano-mês-dia" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="link" id="link" placeholder="Link" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="preco" id="preco" placeholder="Preço" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="tamanho" id="tamanho" placeholder="Tamanho cm x cm x cm" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="paginas" id="paginas" placeholder="Quantidade de paginas" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="tipo_papel" id="tipo_papel" placeholder="Tipo do papel" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-row">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="digital" id="digital" placeholder="Digital " />
                                    <div class="validation"></div>
                                </div>

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade no estoque" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-row">

                                <div class="form-group">
                                    <input type="text" class="form-control" name="para_maiores" id="para_maiores" placeholder="Para Maiiores de 18 anos" />
                                    <div class="validation"></div>
                                </div>

                            </div>
                            <input type="hidden" class="form-control" name="is_quadrinho" id="is_quadrinho" value="0">
                            <input type="hidden" class="form-control" name="vendidas" id="vendidas" placeholder="Vendeidas" value="0">


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

    <!-- Modal Autor Brinde-->
    <div class="modal fade" id="AddAutorBrinde" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Autor de Brinde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addquadrinistas_quadrinho.php" method="post" role="form">
                            <div class="form-row">
                                <div class="form-group col-lg-9">

                                    <select class="form-select btn btn-secondary" name="id_quadrinista" id="id_quadrinista" aria-label="Escolha um Quadrinista">
                                        <option selected>Escolha um Quadrinista</option>
                                        <?php for ($i = 0; $i < count($quadrinistas); $i++) {  ?>
                                            <option value="<?= $quadrinistas[$i]->id ?>"><?= $quadrinistas[$i]->nome ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-9">

                                    <select class="form-select btn btn-secondary" name="id_quadrinho" id="id_quadrinho" aria-label="Escolha um Quadrinho">
                                        <option selected>Escolha um Brinde</option>
                                        <?php for ($i = 0; $i < count($quadrinhos); $i++) {  ?>
                                            <option value="<?= $quadrinhos[$i]->id ?>"><?= $quadrinhos[$i]->titulo ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Cadastrar</button></div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div class="modal fade" id="editquadrinho" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Altere um Brinde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editquadrinho.php" method="post" role="form">
                            <div class="form-row">
                                <div class="form-group col-lg-12">

                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label">Titulo:</label>

                                    <input type="text" name="titulo" class="form-control" id="recipient-titulo" placeholder="Titulo" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="control-label">Descrição:</label>

                                <textarea type="text" class="form-control" name="descricao" id="recipient-descricao" placeholder="Descrição" rows="20" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres"></textarea>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">imagem:</label>
                                <input class="form-control" name="imagem" id="recipient-imagem" placeholder="Imagem da capa"></input>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Data de Lançamento:</label>

                                <input type="text" class="form-control" name="dataL" id="recipient-dataL" placeholder="Data ano-mês-dia" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Link:</label>

                                <input type="text" class="form-control" name="link" id="recipient-link" placeholder="Link" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                <div class="validation"></div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Preço:</label>

                                <input type="text" class="form-control" name="preco" id="recipient-preco" placeholder="Preço" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tamanho:</label>

                                <input type="text" class="form-control" name="tamanho" id="recipient-tamanho" placeholder="Tamanho" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Paginas:</label>

                                <input type="text" class="form-control" name="paginas" id="recipient-paginas" placeholder="Quantidade de paginas" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tipo do papel:</label>

                                <input type="text" class="form-control" name="tipo_papel" id="recipient-tipo_papel" placeholder="Tipo do papel" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-row">

                                <div class="form-group">
                                    <label class="control-label">Digital:</label>

                                    <input type="text" class="form-control" name="digital" id="recipient-digital" placeholder="Digital " />
                                    <div class="validation"></div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label">Quantidade:</label>

                                <input type="text" class="form-control" name="quantidade" id="recipient-quantidade" placeholder="Quantidade no estoque" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-row">

                                <div class="form-group">
                                    <label class="control-label">Para Maiores:</label>

                                    <input type="text" class="form-control" name="para_maiores" id="recipient-para_maiores" placeholder="Para Maiiores de 18 anos" />
                                    <div class="validation"></div>
                                </div>

                            </div>

                            <input type="hidden" class="form-control" name="vendidas" id="recipient-vendidas" placeholder="Vendidas">


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