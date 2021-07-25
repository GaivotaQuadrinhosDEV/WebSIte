<?php

class ParticipantesGaivotacast
{
    public int $id;
    public int $idQuadrinista;
    public int $idGaivotacast;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $idQuadrinista, string $idGaivotacast): void
    {
        $insereparticipantes_gaivotacast = $this->mysql->prepare('INSERT INTO participantes_gaivotacast (id_quadrinista,id_gaivotacast) VALUES(?,?)');
        $insereparticipantes_gaivotacast->bind_param('ss',  $idQuadrinista, $idGaivotacast);
        $insereparticipantes_gaivotacast->execute();
    }

    public function editar(string $id, string $idQuadrinista, string $idGaivotacast): void
    {
        $editaparticipantes_gaivotacast = $this->mysql->prepare('UPDATE participantes_gaivotacast SET id_quadrinista = ? , id_gaivotacast = ?  WHERE id = ?');
        $editaparticipantes_gaivotacast->bind_param('sss', $idQuadrinista, $idGaivotacast, $id);
        $editaparticipantes_gaivotacast->execute();
    }
    public function excluir(string $id): void
    {
        $excluiparticipantes_gaivotacast = $this->mysql->prepare('DELETE FROM participantes_gaivotacast WHERE participantes_gaivotacast.id = ?');
        $excluiparticipantes_gaivotacast->bind_param('s', $id);
        $excluiparticipantes_gaivotacast->execute();
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM participantes_gaivotacast ORDER BY participantes_gaivotacast.id DESC');
        while ($entry = $resultado->fetch_object()) {
            $participantes[] = $entry;
        }
        return $participantes;
    }

    public function exibirPorGaivotacast(string $idGaivotacast): array
    {
        $resultado = $this->mysql->query("SELECT * FROM participantes_gaivotacast WHERE id_gaivotacast = {$idGaivotacast}");
        $participantes = [];
        while ($entry = $resultado->fetch_object()) {
            $participantes[] = $entry;
        }
        return $participantes;
    }

    public function exibirPorQuadrinista(string $idQuadrinista): array
    {
        $resultado = $this->mysql->query("SELECT * FROM participantes_gaivotacast WHERE id_quadrinista = {$idQuadrinista}");
        $participantes = [];
        while ($entry = $resultado->fetch_object()) {
            $participantes[] = $entry;
        }

        if (count($participantes) > 0) {

            $strQuery = '';
            $first = true;
            foreach ($participantes as $pg) {
                if ($first == true) {
                    $strQuery = "{$pg->id_gaivotacast}";
                    $first = false;
                } else {
                    $strQuery .= ", {$pg->id_gaivotacast}";
                }
            }

            $obj_gaivotacast = new GaivotaCast($this->mysql);
            $obj_gaivotacast->withMySQL($this->mysql);
            return $obj_gaivotacast->encontrarPorIds($strQuery);
        } else {
            return [];
        }
    }
}
