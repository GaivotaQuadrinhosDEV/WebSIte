<?php


class QuadrinistasGenero
{
    public string $id;
    public string $idQuadrinista;
    public string $idGenero; 

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $idQuadrinista,string $idGenero ): void
    {
        $inserequadrinistas_generos = $this->mysql->prepare('INSERT INTO quadrinistas_generos (id_quadrinista,id_genero) VALUES(?,?)');
        $inserequadrinistas_generos->bind_param('ss',  $idQuadrinista,$idGenero);
        $inserequadrinistas_generos->execute();
    }

    public function editar(string $id ,string $idQuadrinista,string $idGenero ) : void
    {
        $editaquadrinistas_generos = $this->mysql->prepare('UPDATE quadrinistas_generos SET id_quadrinista = ? , id_genero = ?  WHERE id = ?');
        $editaquadrinistas_generos->bind_param('sss',$idQuadrinista,$idGenero,$id);
        $editaquadrinistas_generos->execute();
    }
    public function excluir(string $id) : void
    {
        $excluiquadrinistas_generos = $this->mysql->prepare('DELETE FROM quadrinistas_generos WHERE quadrinistas_generos.id = ?');
        $excluiquadrinistas_generos->bind_param('s',$id);
        $excluiquadrinistas_generos->execute();

    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM quadrinistas_generos ORDER BY quadrinistas_generos.id DESC');
        $quadrinhistas_genero=[];
        while ($entry = $resultado->fetch_object()) {
            $quadrinhistas_genero[] = $entry;
        }
        return $quadrinhistas_genero;
    }

    public function exibirPorgeneros(string $idGenero): array
    {
        $resultado = $this->mysql->prepare('SELECT * FROM quadrinistas_generos WHERE id_genero = ?');
        $resultado->bind_param('s', $idGenero);
        $resultado->execute();
        $quadrinhistas_genero=[];
        while ($entry = $resultado->get_result()->fetch_object()) {
            $quadrinhistas_genero[] = $entry;
        }
        return $quadrinhistas_genero;
    }

    public function exibirPorQuadrinista(string $idQuadrinista): array
    {
        $resultado = $this->mysql->prepare('SELECT * FROM quadrinistas_generos WHERE id_quadrinista = ?');
        $resultado->bind_param('s', $idQuadrinista);
        $resultado->execute();
        $quadrinhistas_genero=[];
        while ($entry = $resultado->get_result()->fetch_object()) {
            $quadrinhistas_genero[] = $entry;
        }
        return $quadrinhistas_genero;
    }

   
}
