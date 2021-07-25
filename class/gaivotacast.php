<?php

require_once "participantes_gaivotacast.php";
require_once "quadrinista.php";

class GaivotaCast
{

    public int $id;
    public string $titulo;
    public int $episodio;
    public string $descricao;
    public string $imagem;
    public string $link;
    public string $dataL;
    public string $redes;
    public string $duracao;
    public string $embled;
    public int $ativo;
    public $paticipantes;

    private $mysql;

    public function withMySQL($mysql)
    {
        $this->mysql = $mysql;
    }

    public function listParticipantesGaivotaCast(string $id)
    {
        $obj_participantes_gaivotacast = new ParticipantesGaivotacast();
        $obj_participantes_gaivotacast->withMySQL($this->mysql);
        $participantes_gaivotacast = $obj_participantes_gaivotacast->exibirPorGaivotacast($id);
        if ($participantes_gaivotacast != null) {

            $strQuery = '';
            $first = true;
            foreach ($participantes_gaivotacast as $pg) {
                if ($first == true) {
                    $strQuery = "{$pg->id_quadrinista}";
                    $first = false;
                } else {
                    $strQuery .= ", {$pg->id_quadrinista}";
                }
            }
            $obj_quadrinista = new Quadrinista();
            $obj_quadrinista->withMySQL($this->mysql);
            return $obj_quadrinista->encontrarPorIds($strQuery);
        }else{
            return null;
        }
    }


    public function adicionar(string $titulo, string $episodio, string $descricao, string $imagem, string $link, string $dataL, string $redes, string $duracao, string $embled, string $ativo): void
    {
        $insereGaivotaCast = $this->mysql->prepare('INSERT INTO gaivotacast (titulo, episodio, descricao, imagem, link, dataL, redes, duracao,embled,ativo) VALUES(?,?,?,?,?,?,?,?,?,?)');
        $insereGaivotaCast->bind_param('ssssssssss',  $titulo, $episodio,  $descricao,  $imagem,  $link, $dataL, $redes, $duracao, $embled, $ativo);
        $insereGaivotaCast->execute();
    }

    public function editar(string $id, string $titulo, string $episodio, string $descricao, string $imagem, string $link, string $dataL, string $redes, string $duracao, string $embled,  string $ativo): void
    {
        $editaGaivotaCast = $this->mysql->prepare('UPDATE gaivotacast SET titulo = ? , episodio = ? , descricao = ?,  imagem = ?,  link = ?,dataL = ?, redes = ?,duracao = ?, embled = ?, ativo = ?  WHERE id = ?');
        $editaGaivotaCast->bind_param('sssssssssss', $titulo, $episodio, $descricao, $imagem, $link, $dataL, $redes, $duracao, $embled, $ativo, $id);
        $editaGaivotaCast->execute();
    }
    public function excluir(string $id): void
    {
        $excluiGaivotacast = $this->mysql->prepare('DELETE FROM gaivotacast WHERE gaivotacast.id = ?');
        $excluiGaivotacast->bind_param('s', $id);
        $excluiGaivotacast->execute();
    }

    //----------------------------------------------------

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM gaivotacast ORDER BY gaivotacast.id DESC');
        $gaivotacasts=[]; 
        while ($entry = $resultado->fetch_object()) {
            $gaivotacasts[] = $entry;
        }
        return $gaivotacasts;
    }

    public function exibirTodosAtivos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM gaivotacast WHERE gaivotacast.ativo = 1 ORDER BY gaivotacast.id DESC');
        $gaivotacasts=[]; 
        while ($entry = $resultado->fetch_object()) {
            $gaivotacasts[] = $entry;
        }
        return $gaivotacasts;
    }

    public function encontrarPorId(string $id)
    {
        $selecionaCast = $this->mysql->prepare("SELECT * FROM gaivotacast WHERE id = ?");

        $selecionaCast->bind_param('s', $id);
        $selecionaCast->execute();
        $gc = new GaivotaCast();
        $gc =  $selecionaCast->get_result()->fetch_object();
        return $gc;
    }

    public function encontrarPorIds(string $id): array
    {
        $selecionaCast = $this->mysql->query("SELECT * FROM gaivotacast WHERE id IN ({$id})");
        $gaivotacasts=[]; 
        while ($entry = $selecionaCast->fetch_object()) {
            $gaivotacasts[] = $entry;
        }
        return $gaivotacasts;
    }
}
