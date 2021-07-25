<?php


class PedidoQuadrinista
{
    public string $id; 
    public string $idPedido;
    public string $idQuadrinista;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $idPedido,string $idQuadrinista ): void
    {
        $inserepedido_quadrinista = $this->mysql->prepare('INSERT INTO pedido_quadrinista (id_pedido,id_quadrinista) VALUES(?,?)');
        $inserepedido_quadrinista->bind_param('ss',  $idPedido,$idQuadrinista);
        $inserepedido_quadrinista->execute();
    }

    public function editar(string $id ,string $idPedido,string $idQuadrinista ) : void
    {
        $editapedido_quadrinista = $this->mysql->prepare('UPDATE pedido_quadrinista SET id_pedido = ? , id_quadrinista = ?  WHERE id = ?');
        $editapedido_quadrinista->bind_param('sss',$idPedido,$idQuadrinista,$id);
        $editapedido_quadrinista->execute();
    }
    public function excluir(string $id) : void
    {
        $excluipedido_quadrinista = $this->mysql->prepare('DELETE FROM pedido_quadrinista WHERE pedido_quadrinista.id = ?');
        $excluipedido_quadrinista->bind_param('s',$id);
        $excluipedido_quadrinista->execute();

    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM pedido_quadrinista ORDER BY pedido_quadrinista.id DESC');
        $pedido_quadrinistas=[]; 
        while ($entry = $resultado->fetch_object()) {
            $pedido_quadrinistas[] = $entry;
        }
        return $pedido_quadrinistas;
    }

    public function exibirPorQuadrinista(string $id_quadrinista): array
    {

        $resultado = $this->mysql->prepare("SELECT * FROM pedido_quadrinista where id_quadrinista = $id_quadrinista");
        $pedido_quadrinistas=[]; 
        while ($entry = $resultado->fetch_object()) {
            $pedido_quadrinistas[] = $entry;
        }
        return $pedido_quadrinistas;
    }

   
}
