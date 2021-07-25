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
require_once "class/pedido.php";

$obj_pedido = new Pedido();
$obj_pedido->withMySQL($mysql);
$pedidos = $obj_pedido->exibirTodos();
$pedidosAtivos = array();
$pedidosNAtivos = array();

for ($i = 0; $i < count($pedidos); $i++) {
    if ($pedidos[$i]['status'] == 4) {
        array_push($pedidosNAtivos, $pedidos[$i]);
    } else {
        array_push($pedidosAtivos, $pedidos[$i]);
    }
}


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
            <a class="btn btn-info" style="margin: 10px;" href="#quadrinhos">Pedidos Ativos</a>

            <a class="btn btn-info" style="margin: 10px;" href="#quadrinistas_quadrinho">Pedidos Não Ativos</a>

        </div>
        <div class="row" id="Ativos">

            <div class="col">
                <h2>Pedidos Ativos cadastrados</h2>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID CLIENTE</th>
                            <th scope="col">ENDEREÇO</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">DATA</th>
                            <th scope="col">FORMA DE PAGAMENTO</th>
                            <th scope="col">CODIGO DE RASTREIO</th>
                            <th scope="col">ATUALIZADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($pedidos); $i++) {  ?>
                            <tr>
                                <th scope="row"><?= $pedidos[$i]->id ?></th>
                                <td><?= $pedidos[$i]->id_cliente ?></td>
                                <td><?= $pedidos[$i]->endereco ?></td>
                                <td><?= $pedidos[$i]->status ?></td>
                                <td><?= $pedidos[$i]->dataL ?></td>
                                <td><?= $pedidos[$i]->forma_pagamento ?></td>
                                <td><?= $pedidos[$i]->codigo_rastreio ?></td>
                                <td><?= $pedidos[$i]->atualizado ?></td>
                               

                                <td>
                                    <form action="APIs/Delpedido.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $pedidos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
          var modal = $('#editpedido')
          modal.find('.modal-title').text('ID ' + <?= $pedidos[$i]->id ?>)
		  modal.find('#recipient-id').val('<?= $pedidos[$i]->id ?>')
		  modal.find('#recipient-id_cliente').val('<?= $pedidos[$i]->id_cliente ?>')
		  modal.find('#recipient-endereco').val('<?= $pedidos[$i]->endereco ?>')
		  modal.find('#recipient-status').val('<?= $pedidos[$i]->status ?>')
		  modal.find('#recipient-dataL').val('<?= $pedidos[$i]->dataL ?>')
          modal.find('#recipient-forma_pagamento').val('<?= $pedidos[$i]->forma_pagamento ?>')
          modal.find('#recipient-codigo_rastreio').val('<?= $pedidos[$i]->codigo_rastreio ?>')
		
		  
                        })()" data-target="#editpedido" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>
                                   
                                   <?php if($pedido["status"] == 1) {?>
                                        <button type="button" data-target="#pagamentopedido" onclick="(function(){
          var modal = $('#pagamentopedido')
          modal.find('.modal-title').text('ID ' + <?= $pedidos[$i]->id ?>)
		  modal.find('#recipient-id').val('<?= $pedidos[$i]->id ?>')
		  modal.find('#recipient-id_cliente').val('<?= $pedidos[$i]->id_cliente ?>')
		  modal.find('#recipient-status').val('<?= $pedidos[$i]->status ?>')
		
		  
                        })()"data-toggle="modal" style="margin-top: 10px;"  class="btn btn-success">Atualizar Status</button>
                                        <!-- <form style="display: inline;" action="APIs/Attpedido.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $pedidos[$i]->id ?>">
                                        <input type="hidden" id="status" name="status" value="<?= $pedidos[$i]->status ?>">.
                                        <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $pedidos[$i]->id_cliente ?>">
                                        <button type="submit" class="btn btn-success">Atualizar Status</button>
                                    </form> -->
                                        <?php } ?>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row" id="Nativos">

            <div class="col">
                <h2>Pedidos Não Ativos cadastrados</h2>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID CLIENTE</th>
                            <th scope="col">ENDEREÇO</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">DATA</th>
                            <th scope="col">FORMA DE PAGAMENTO</th>
                            <th scope="col">CODIGO DE RASTREIO</th>
                            <th scope="col">ATUALIZADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidosNAtivos as $pedido) { ?>
                            <tr>
                                <th scope="row"><?= $pedidos[$i]->id ?></th>
                                <td><?= $pedidos[$i]->id_cliente ?></td>
                                <td><?= $pedidos[$i]->endereco ?></td>
                                <td><?= $pedidos[$i]->status ?></td>
                                <td><?= $pedidos[$i]->dataL ?></td>
                                <td><?= $pedidos[$i]->forma_pagamento ?></td>
                                <td><?= $pedidos[$i]->codigo_rastreio ?></td>
                                <td><?= $pedidos[$i]->atualizado ?></td>
                                <td>
                                    <form action="APIs/Delpedido.php" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $pedidos[$i]->id ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                    <button type="button" onclick="(function(){
var modal = $('#editcliente')
modal.find('.modal-title').text('ID ' + <?= $pedidos[$i]->id ?>)
modal.find('#recipient-id').val('<?= $pedidos[$i]->id ?>')
modal.find('#recipient-id_cliente').val('<?= $pedidos[$i]->id_cliente ?>')
modal.find('#recipient-endereco').val('<?= $pedidos[$i]->endereco ?>')
modal.find('#recipient-status').val('<?= $pedidos[$i]->status ?>')
modal.find('#recipient-dataL').val('<?= $pedidos[$i]->dataL ?>')
modal.find('#recipient-forma_pagamento').val('<?= $pedidos[$i]->forma_pagamento ?>')
modal.find('#recipient-codigo_rastreio').val('<?= $pedidos[$i]->codigo_rastreio ?>')

            })()" data-target="#editpedido" data-toggle="modal" style="margin-top: 10px;" class="btn btn-warning">Editar</button>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>



    </main>


    <!-- Modal Edit -->

    <div class="modal fade" id="editpedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Altere um Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/Editpedido.php" method="post" role="form" >
                            <div class="form-row">
                                <div class="form-group col-lg-12">

                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label">ID Cliente:</label>

                                    <input type="text" class="form-control" name="id_cliente" id="recipient-id_cliente" placeholder="Id Cliente" data-rule="email" data-msg="Email invalido">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label">Endereço:</label>

                                    <input type="text" class="form-control" name="endereco" id="recipient-endereco" placeholder="Endereço">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-lg-12">
                                    <label class="control-label">Status:</label>

                                    <input class="form-control" name="status" id="recipient-status" placeholder="Status"/>
               
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Data:</label>

                                <input type="text" class="form-control" name="data" id="recipient-dataL" placeholder="Data" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Forma de Pagamento:</label>

                                <input type="text" class="form-control" name="forma_pagamento" id="recipient-forma_pagamento" placeholder="Forma de Pagamento" />
    
                            </div>
                            <div class="form-group">
                                <label class="control-label">Codigo de Rastreio:</label>

                                <input type="text" class="form-control" name="codigo_rastreio" id="recipient-codigo_rastreio" placeholder="Codigo de Rastreio" />
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

    <!-- Modal Pagamento -->

    <div class="modal fade" id="pagamentopedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecione a froma do Pagamento do Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form">

                        <form action="APIs/attpedido.php" method="post" role="form" >
        
                                    <input type="hidden" class="form-control" name="id" id="recipient-id" placeholder="ID">
                              
                                    <input type="hidden" class="form-control" name="id_cliente" id="recipient-id_cliente" placeholder="Id Cliente" >
                            
                                    <input type="hidden"  type="email" class="form-control" name="status" id="recipient-status" placeholder="Status" />
                            
                            <div class="form-group">
                                <label class="control-label">Forma de Pagamento:</label>
                                <select class="form-select btn btn-secondary" name="forma_pagamento" id="recipient-forma_pagamento" aria-label="Escolha uma Forma de Pagamento">
                                        <option selected>Escolha uma Forma de Pagamento</option>
                                            <option value="Picpay">Picpay</option>
                                            <option value="Tranferencia">Transferência Bancaria</option>
                                            <option value="Pix">Pix</option>
                                    </select>
                                    <img src="img/ppay.png" style="width: 40px;">
                                    <img src="img/nubank.png" style="width: 40px;">
                                    <img src="img/pix.png" style="width: 40px;">
                               
                            </div>

                            <div class="text-center"><button type="submit" class="btn btn-primary" title="Send Message">Atualizar</button></div>
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