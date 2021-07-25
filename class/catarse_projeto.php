<?php


class CatarseProjeto
{
    public int $id;
    public string $titulo;
    public int $id_quadrinista;
    public string $link;
    public string $termino;
    public string $imagem;
    public int $ativo;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }
  
    public function adicionar(string $titulo, string $id_quadrinista,string $link, string $termino,string $imagem,string $ativo) : void
    {
        $editaCatarse = $this->mysql->prepare('INSERT INTO catarse_projeto (titulo,id_quadrinista,link,termino,imagem,ativo) VALUES(?,?,?,?,?,?)');
        $editaCatarse->bind_param('ssssss',$titulo,$id_quadrinista,$link,$termino,$imagem,$ativo);
        $editaCatarse->execute();
    }


    public function editar(string $id, string $titulo, string $id_quadrinista,string $link,string $termino,string $imagem, string $ativo): void
    {
        $editaCatarse = $this->mysql->prepare('UPDATE catarse_projeto SET titulo = ?,id_quadrinista = ?, link = ?, termino = ?, imagem = ?, ativo = ? WHERE id = ?');
        $editaCatarse->bind_param('sssssss',$titulo,$id_quadrinista,$link,$termino,$imagem,$ativo ,$id);
        $editaCatarse->execute();
    }


    public function excluir(string $id): void
    {
        $excluirCatarse = $this->mysql->prepare('DELETE FROM catarse_projeto WHERE catarse_projeto.id = ?');
        $excluirCatarse->bind_param('s', $id);
        $excluirCatarse->execute();
    }

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM catarse_projeto ORDER BY catarse_projeto.id DESC');
        $catarses = [];
        while ($entry = $resultado->fetch_object()) {
            $catarses[] = $entry;
        }
        return $catarses;
    }

    public function exibirTodosAtivos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM catarse_projeto WHERE ativo = 1 ORDER BY catarse_projeto.id DESC');
        $catarses = [];
        while ($entry = $resultado->fetch_object()) {
            $catarses[] = $entry;
        }
        return $catarses;
    }

    public function encontrarPorQuadrinista(string $id_quadrinista)
    {
        $selecionaCatarse = $this->mysql->query("SELECT * FROM catarse_projeto WHERE ativo = 1 AND id_quadrinista = $id_quadrinista");

        $catarses = new CatarseProjeto();
        $catarses =  $selecionaCatarse->fetch_object();
        
        return $catarses;
    }

    

    
}
