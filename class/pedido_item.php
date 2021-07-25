<?php


class PedidoItem
{

    public string $id;
    public string $id_pedido;
    public string $quantidade;
    public string $id_produto;
    public string $id_quadrinista;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $id_pedido,string $quantidade, string $id_produto, string $id_quadrinista) : void
    {
        $inserepedido_items = $this->mysql->prepare('INSERT INTO pedido_item (id_pedido,quantidade,id_produto,id_quadrinista) VALUES(?,?,?,?)');
        $inserepedido_items->bind_param('ssss',$id_pedido,$quantidade,$id_produto,$id_quadrinista);
        $inserepedido_items->execute();
        
    }

    public function editar(string $id ,string $id_pedido,string $quantidade, string $id_produto, string $id_quadrinista) : void
    {
        $editapedido_item = $this->mysql->prepare('UPDATE pedido_item SET id_pedido = ?, quantidade = ?, id_produto = ?, id_quadrinista = ? WHERE id = ?');
        $editapedido_item->bind_param('sssss',$id_pedido,$quantidade,$id_produto,$id_quadrinista,$id);
        $editapedido_item->execute();
    }

    public function excluir(string $id) : void
    {
        $excluipedido_item = $this->mysql->prepare('DELETE FROM pedido_item WHERE pedido_item.id = ?');
        $excluipedido_item->bind_param('s',$id);
        $excluipedido_item->execute();

    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM pedido_item ');

          $users=[]; 
        while ($entry = $resultado->fetch_object()) {
            $users[] = $entry;
        }
        return $users;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionapedido_item = $this->mysql->prepare("SELECT * FROM pedido_item WHERE id = ?");
        $selecionapedido_item->bind_param('s', $id);
        $selecionapedido_item->execute();
        $u = new User();
        $u =  $selecionapedido_item->get_result()->fetch_object();
        return $u;
    }
    

    public function encontrarPorPedido(string $id_pedido): array
    {
        $selecionapedido_item = $this->mysql->query("SELECT * FROM pedido_item WHERE id_pedido = $id_pedido ");

        $users=[]; 
        while ($entry = $selecionapedido_item->fetch_object()) {
            $users[] = $entry;
        }
        return $users;
    }


   
}