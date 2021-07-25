<?php

require_once "quadrinho.php";

class QuadrinistasQuadrinho
{
    public string $id;
    public string $idQuadrinista;
    public string $idQuadrinho;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $idQuadrinista, string $idQuadrinho): void
    {
        $inserequadrinistas_quadrinhos = $this->mysql->prepare('INSERT INTO quadrinistas_quadrinho (id_quadrinista,id_quadrinho) VALUES(?,?)');
        $inserequadrinistas_quadrinhos->bind_param('ss',  $idQuadrinista, $idQuadrinho);
        $inserequadrinistas_quadrinhos->execute();
    }

    public function editar(string $id, string $idQuadrinista, string $idQuadrinho): void
    {
        $editaquadrinistas_quadrinhos = $this->mysql->prepare('UPDATE quadrinistas_quadrinho SET id_quadrinista = ? , id_quadrinho = ?  WHERE id = ?');
        $editaquadrinistas_quadrinhos->bind_param('sss', $idQuadrinista, $idQuadrinho, $id);
        $editaquadrinistas_quadrinhos->execute();
    }
    public function excluir(string $id): void
    {
        $excluiquadrinistas_quadrinhos = $this->mysql->prepare('DELETE FROM quadrinistas_quadrinho WHERE quadrinistas_quadrinho.id = ?');
        $excluiquadrinistas_quadrinhos->bind_param('s', $id);
        $excluiquadrinistas_quadrinhos->execute();
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM quadrinistas_quadrinho ORDER BY quadrinistas_quadrinho.id DESC');
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }
        return $quadrinistas_quadrinhos;
    }

    public function exibirTodosQuadrinhos(): array
    {
        $resultado = $this->mysql->query('SELECT QQ.id, QQ.id_quadrinista, QQ.id_quadrinho FROM quadrinistas_quadrinho QQ, quadrinhos Q WHERE Q.is_quadrinho = 1 and Q.id = QQ.id_quadrinho ORDER BY QQ.id DESC');
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }
        return $quadrinistas_quadrinhos;
    }
    public function exibirTodosBrindes(): array
    {
        $resultado = $this->mysql->query('SELECT QQ.id, QQ.id_quadrinista, QQ.id_quadrinho FROM quadrinistas_quadrinho QQ, quadrinhos Q WHERE Q.is_quadrinho = 0 and Q.id = QQ.id_quadrinho ORDER BY QQ.id DESC');
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }
        return $quadrinistas_quadrinhos;
    }

    public function exibirPorQuadrinhos(string $idQuadrinho): array
    {
        $resultado = $this->mysql->query("SELECT * FROM quadrinistas_quadrinho WHERE id_quadrinho = $idQuadrinho");
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }
        return $quadrinistas_quadrinhos;
    }

    public function exibirQuadrinhosPorQuadrinista(string $idQuadrinista): array
    {
        $resultado =  $this->mysql->query("SELECT * FROM quadrinistas_quadrinho QQ INNER JOIN quadrinhos Q
             ON Q.id = QQ.id_quadrinho
             WHERE QQ.id_quadrinista = $idQuadrinista and Q.is_quadrinho = 1");
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }

        if (count($quadrinistas_quadrinhos) > 0) {

            $strQuery = '';
            $first = true;
            foreach ($quadrinistas_quadrinhos as $qq) {
                if ($first == true) {
                    $strQuery = "{$qq->id_quadrinho}";
                    $first = false;
                } else {
                    $strQuery .= ", {$qq->id_quadrinho}";
                }
            }

            $obj_quadrinho = new Quadrinho();
            $obj_quadrinho->withMySQL($this->mysql);
            return $obj_quadrinho->encontrarPorIds($strQuery);
        } else {
            return [];
        }
    }

    public function exibirBrindesPorQuadrinista(string $idQuadrinista): array
    {
        $resultado =  $this->mysql->query("SELECT * FROM quadrinistas_quadrinho QQ INNER JOIN quadrinhos Q
        ON Q.id = QQ.id_quadrinho
        WHERE QQ.id_quadrinista = $idQuadrinista and Q.is_quadrinho = 0");
        $quadrinistas_quadrinhos = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas_quadrinhos[] = $entry;
        }
        
        if (count($quadrinistas_quadrinhos) > 0) {

            $strQuery = '';
            $first = true;
            foreach ($quadrinistas_quadrinhos as $qq) {
                if ($first == true) {
                    $strQuery = "{$qq->id_quadrinho}";
                    $first = false;
                } else {
                    $strQuery .= ", {$qq->id_quadrinho}";
                }
            }

            $obj_quadrinho = new Quadrinho();
            $obj_quadrinho->withMySQL($this->mysql);
            return $obj_quadrinho->encontrarPorIds($strQuery);
        } else {
            return [];
        }
    }
}
