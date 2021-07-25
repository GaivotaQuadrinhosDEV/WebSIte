<?php


class Genero
{
    public string $id ;
    public string $nome;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $nome) : void
    {
        $insereGeneros = $this->mysql->prepare('INSERT INTO generos (nome) VALUES(?)');
        $insereGeneros->bind_param('s',$nome);
        $insereGeneros->execute();
    }

    public function editar(string $id ,string $nome) : void
    {
        $editaGenero = $this->mysql->prepare('UPDATE generos SET nome = ? WHERE id = ?');
        $editaGenero->bind_param('ss',$nome,$id);
        $editaGenero->execute();
    }

    public function excluir(string $id) : void
    {
        $excluiGenero = $this->mysql->prepare('DELETE FROM generos WHERE generos.id = ?');
        $excluiGenero->bind_param('s',$id);
        $excluiGenero->execute();

    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM generos');
        $generos=[];
        while ($entry = $resultado->fetch_object()) {
            $generos[] = $entry;
        }
        return $generos;
    }

    public function encotrarPorNome(string $nome): array
    {
        $selecionaGenero = $this->mysql->prepare("SELECT * FROM generos WHERE nome = ?");

        $selecionaGenero->bind_param('s', $nome);
        $selecionaGenero->execute();
        $g = new Genero();
        $g =  $selecionaGenero->get_result()->fetch_object();
        return $g;
    }

    public function encontrarPorIds(string $id) : array
    {
        $selecionaGenero = $this->mysql->query("SELECT * FROM generos WHERE id IN ({$id})");
        $generos=[];
        while ($entry = $selecionaGenero->fetch_object()) {
            $generos[] = $entry;
        }
        return $generos;
    }
}