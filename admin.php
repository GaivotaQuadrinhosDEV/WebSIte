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
require_once "class/cliente.php";

$obj_user = new User();
$obj_user->withMySQL($mysql);
$users = $obj_user->exibirTodos();

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
                <h2>Clientes cadastrados</h2>
                <a href="#" id="encomendar" class="NewBtn scrollto" data-toggle="modal" data-target="#AddCliente">
                    <b> Novo Cliente</b> <i class="fa fa-plus-circle"></i></a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">TELEFONE</th>
                            <th scope="col">NIVEL</th>
                            <th scope="col">ID QUADRINISTA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($users); $i++) {  ?>
                            <tr>
                                <th scope="row"><?= $users[$i]->id ?></th>
                                <td><?= $users[$i]->nome ?></td>
                                <td><?= $users[$i]->email ?></td>
                                <td><?= $users[$i]->telefone ?></td>
                                <td><?= $users[$i]->nivel ?></td>
                                <td><?= $users[$i]->id_quadrinista ?></td>

                                <td>
                                    <form action="APIs/Delcliente.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $users[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
          var modal = $('#editcliente')
          modal.find('.modal-title').text('ID ' + <?= $users[$i]->id ?>)
		  modal.find('#recipient-id').val('<?= $users[$i]->id ?>')
		  modal.find('#recipient-name').val('<?= $users[$i]->nome ?>')
		  modal.find('#recipient-email').val('<?= $users[$i]->email ?>')
		  modal.find('#recipient-telefone').val('<?= $users[$i]->telefone ?>')
		  modal.find('#recipient-nivel').val('<?= $users[$i]->nivel ?>')
		  modal.find('#recipient-id_quadrinista').val('<?= $users[$i]->id_quadrinista ?>')
		  
                        })()" data-target="#editcliente" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </main>

    <!-- Modal ADD-->
    <div class="modal modal-full fade" id="AddCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastre um Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Addcliente.php" method="post" role="form" >
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="text" name="nome" class="form-control" id="name" placeholder="Nome" data-rule="minlen:4" data-msg="Esse campo tem que ter pelo menos 4 caracteres" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-12">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Email invalido" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" data-rule="minlen:4" data-msg="Telefone" />
                                <div class="validation"></div>
                            </div>
                          
                            <div class="form-group">
                                <input type="text" class="form-control" name="nivel" id="nivel" placeholder="Nivel" data-rule="minlen:4" data-msg="Nivel" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="id_quadrinista" id="id_quadrinista" placeholder="ID do Quadrinista"/>
                                <div class="validation"></div>
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

    <div class="modal fade" id="editcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edite um Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editcliente.php" method="post" role="form" >
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label">Nome:</label>

                                    <input type="text" class="form-control" name="nome" id="recipient-name" placeholder="Nome" data-rule="email" data-msg="Email invalido">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-lg-12">
                                    <label class="control-label">Email:</label>

                                    <input type="email" class="form-control" name="email" id="recipient-email" placeholder="Email" data-rule="email" data-msg="Email invalido" />
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Telefone:</label>

                                <input type="text" class="form-control" name="telefone" id="recipient-telefone" placeholder="Telefone" data-rule="minlen:4" data-msg="Telefone invalido" />
                                <div class="validation"></div>
                            </div>
                           
                            <div class="form-group">
                                <label class="control-label">Nivel:</label>

                                <input type="text" class="form-control" name="nivel" id="recipient-nivel" placeholder="Nivel" data-rule="minlen:4" data-msg="Nivel invalido" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">ID do Quadrinista:</label>

                                <input type="text" class="form-control" name="id_quadrinista" id="recipient-id_quadrinista" placeholder="ID do Quadrinista" />
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