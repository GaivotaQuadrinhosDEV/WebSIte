<?php


class QuadrinhosGenero
{
    public string $id;
    public string $idQuadrinho;
    public string $idGenero;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $idQuadrinho,string $idGenero ): void
    {
        $insereQuadrinhos_generos = $this->mysql->prepare('INSERT INTO quadrinhos_generos (id_quadrinho,id_genero) VALUES(?,?)');
        $insereQuadrinhos_generos->bind_param('ss',  $idQuadrinho,$idGenero);
        $insereQuadrinhos_generos->execute();
    }

    public function editar(string $id ,string $idQuadrinho,string $idGenero ) : void
    {
        $editaQuadrinhos_generos = $this->mysql->prepare('UPDATE quadrinhos_generos SET id_quadrinho = ? , id_genero = ?  WHERE id = ?');
        $editaQuadrinhos_generos->bind_param('sss',$idQuadrinho,$idGenero,$id);
        $editaQuadrinhos_generos->execute();
    }
    public function excluir(string $id) : void
    {
        $excluiQuadrinhos_generos = $this->mysql->prepare('DELETE FROM quadrinhos_generos WHERE quadrinhos_generos.id = ?');
        $excluiQuadrinhos_generos->bind_param('s',$id);
        $excluiQuadrinhos_generos->execute();

    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT * FROM quadrinhos_generos ORDER BY quadrinhos_generos.id DESC');
        $quadrinhos_generos=[]; 
        while ($entry = $resultado->fetch_object()) {
            $quadrinhos_generos[] = $entry;
        }
        return $quadrinhos_generos;
    }

    public function exibirPorgeneros(string $idGenero): array
    {
        $resultado = $this->mysql->query("SELECT * FROM quadrinhos_generos WHERE id_genero = $idGenero");
        $quadrinhos_generos=[]; 
        while ($entry = $resultado->fetch_object()) {
            $quadrinhos_generos[] = $entry;
        }
        return $quadrinhos_generos;
    }

    public function exibirPorQuadrinho(string $idQuadrinho): array
    {
        $resultado = $this->mysql->query("SELECT * FROM quadrinhos_generos WHERE id_quadrinho = $idQuadrinho");
        $quadrinhos_generos=[]; 
        while ($entry = $resultado->fetch_object()) {
            $quadrinhos_generos[] = $entry;
        }
        return $quadrinhos_generos;
    }

   
}
