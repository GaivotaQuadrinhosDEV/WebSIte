<?php

class Quadrinista
{
    public int $id;
    public string $idartistico;
    public string $nome;
    public string $descricao;
    public string $loja;
    public string $foto;
    public string $facebook;
    public string $instagram;
    public string $twitter;
    public string $behance;
    public int $visitantes;
    public string $localA;

    private $mysql;

    public function withMySQL($mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $idartistico, string $nome, string $descricao, string $loja, string $foto, string $facebook, string $instagram, string $twitter, string $behance, string $visitantes, string $localA): void
    {
        $insereQuadrinista = $this->mysql->prepare('INSERT INTO quadrinista (idartistico,nome, descricao, loja,foto,facebook,instagram,twitter,behance,visitantes,localA,dataL) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())');
        $insereQuadrinista->bind_param('sssssssssss', $idartistico, $nome, $descricao, $loja, $foto, $facebook, $instagram, $twitter, $behance, $visitantes, $localA);
        $insereQuadrinista->execute();
    }

    public function editar(string $id, string $idartistico, string $nome, string $descricao, string $loja, string $foto, string $facebook, string $instagram, string $twitter, string $behance, string $visitantes, string $localA, string $dataL): void
    {
        $editaQuadrinista = $this->mysql->prepare('UPDATE quadrinista SET idartistico = ?,nome = ?, descricao = ?, loja = ?,foto = ?,facebook = ?,instagram = ?,twitter = ?,behance = ? ,visitantes = ?,localA = ?,dataL = ? WHERE id = ?');
        $editaQuadrinista->bind_param('sssssssssssss', $idartistico, $nome, $descricao, $loja, $foto, $facebook, $instagram, $twitter, $behance, $visitantes, $localA, $dataL, $id);
        $editaQuadrinista->execute();
    }

    public function excluir(string $id): void
    {
        $excluirquadrinista = $this->mysql->prepare('DELETE FROM quadrinista WHERE quadrinista.id = ?');
        $excluirquadrinista->bind_param('s', $id);
        $excluirquadrinista->execute();
    }

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM quadrinista');
        $quadrinistas = [];
        while ($entry = $resultado->fetch_object()) {
            $quadrinistas[] = $entry;
        }
        return $quadrinistas;
    }

    public function encontrarPorId(string $id)
    {
        $selecionaquadrinista = $this->mysql->prepare("SELECT * FROM quadrinista WHERE id IN (?)");
        $selecionaquadrinista->bind_param('s', $id);
        $selecionaquadrinista->execute();
        $q = new Quadrinista();
        $q =  $selecionaquadrinista->get_result()->fetch_object();
        return $q;
    }

    public function encontrarPorIds(string $id): array
    {
        $selecionaquadrinista = $this->mysql->query("SELECT * FROM quadrinista WHERE id IN ({$id})");
        $quadrinistas = [];
        while ($entry = $selecionaquadrinista->fetch_object()) {
            $quadrinistas[] = $entry;
        }
        return $quadrinistas;
    }

    public function encontrarPorNome(string $nome): array
    {

        $selecionaquadrinista = $this->mysql->query("SELECT * FROM quadrinista WHERE nome LIKE '%$nome%'");
        $quadrinistas = [];
        while ($entry = $selecionaquadrinista->fetch_object()) {
            $quadrinistas[] = $entry;
        }
        return $quadrinistas;
    }

    public function addVisitante(string $id, int $visitantes)
    {
        $editaQuadrinista = $this->mysql->prepare('UPDATE quadrinista SET visitantes = ? WHERE id = ?');
        $editaQuadrinista->bind_param('is', $visitantes, $id);
        $editaQuadrinista->execute();
    }
}
