<?php

require_once "quadrinistas_quadrinho.php";
class Pedido
{
    public string $id;
    public string $id_cliente;
    public string $endereco;
    public string $status;
    public string $forma_pagamento;
    public string $codigo_rastreio;
    public string $atualizado;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function AddProduto($idQuadrinho, $quadrinhos): void
    {

        $idProduto = (int) $idQuadrinho;

        $obj_quadrinista_quadrinho = new QuadrinistasQuadrinho();
        $obj_quadrinista_quadrinho->withMySQL($this->mysql);
        $quadrinistas_quadrinho  =  $obj_quadrinista_quadrinho->exibirPorQuadrinhos($idProduto);

        for ($i = 0; $i < count($quadrinhos); $i++) {
            if ($quadrinhos[$i]['id'] == $idProduto) {

                if (isset($_SESSION['carrinho'][$idProduto])) {
                    $_SESSION['carrinho'][$idProduto]['quantidade']++;
                } else {
                    $_SESSION['carrinho'][$idProduto] = array('id' => $idProduto, 'nome' => $quadrinhos[$i]->titulo, 'imagem' => $quadrinhos[$i]->imagem, 'preco' => $quadrinhos[$i]->preco, 'quantidade' => 1, 'quadrinistas' => $quadrinistas_quadrinho[0]->id_quadrinista);
                }
            }
        }
    }

    public function adicionar(string $id_cliente, string $endereco, string $status, string $forma_pagamento, string $codigo_rastreio, string $atualizado): int
    {
        $inserepedidos = $this->mysql->prepare('INSERT INTO pedido (id_cliente,endereco,status,dataL,forma_pagamento,codigo_rastreio,atualizado) VALUES(?,?,?,NOW(),?,?,?)');
        $inserepedidos->bind_param('ssssss', $id_cliente, $endereco, $status, $forma_pagamento, $codigo_rastreio, $atualizado);
        $inserepedidos->execute();

        return mysqli_insert_id($this->mysql);
    }

    public function editar(string $id, string $id_cliente, string $endereco, string $status, string $forma_pagamento, string $codigo_rastreio, string $atualizado): void
    {
        $editapedido = $this->mysql->prepare('UPDATE pedido SET id_cliente = ?, endereco = ?, status = ?, forma_pagamento = ?, codigo_rastreio = ?, atualizado = ?  WHERE id = ?');
        $editapedido->bind_param('sssssss', $id_cliente, $endereco, $status, $forma_pagamento, $codigo_rastreio, $atualizado, $id);
        $editapedido->execute();
    }

    public function excluir(string $id): void
    {
        $excluipedido = $this->mysql->prepare('DELETE FROM pedido WHERE pedido.id = ?');
        $excluipedido->bind_param('s', $id);
        $excluipedido->execute();
    }

    public function atualizarStatus(int $status, string $id, string $atualizado, string $forma_pagamento): void
    {

        $editapedido = $this->mysql->prepare("UPDATE pedido SET status = ?, forma_pagamento = ?, atualizado = ? WHERE id = ?");
        $editapedido->bind_param('ssss', $status, $forma_pagamento, $atualizado, $id);
        $editapedido->execute();
    }
    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM pedido ORDER BY pedido.dataL DESC');

        $pedidos = [];
        while ($entry = $resultado->fetch_object()) {
            $pedidos[] = $entry;
        }
        return $pedidos;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionapedido = $this->mysql->prepare("SELECT * FROM pedido WHERE id = ?");

        $selecionapedido->bind_param('s', $id);
        $selecionapedido->execute();
        $p = new Pedido();
        $p =  $selecionapedido->get_result()->fetch_object();
        return $p;
    }


    public function encontrarPorIdsStatus(string $id, string $status): array
    {
        $selecionapedido = $this->mysql->query("SELECT * FROM pedido WHERE id IN ({$id}) and status = $status");

        $pedidos = [];
        while ($entry = $selecionapedido->fetch_object()) {
            $pedidos[] = $entry;
        }
        return $pedidos;
    }

    public function encontrarPorCliente(string $id, string $status): array
    {
        $selecionapedido = $this->mysql->prepare("SELECT * FROM pedido WHERE id_cliente = $id and status = $status");

        $pedidos = [];
        while ($entry = $selecionapedido->fetch_object()) {
            $pedidos[] = $entry;
        }
        return $pedidos;
    }
}
