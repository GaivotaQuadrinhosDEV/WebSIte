<?php


class Quadrinho
{
    public int $id;
    public string $titulo;
    public string $descricao;
    public string $imagem;
    public string $dataL;
    public string $link;
    public float $preco;
    public string $tamanho;
    public int $paginas;
    public string $tipo_papel;
    public int $digital;
    public int $quantidade;
    public int $para_maiores;
    public int $vendidas;

    private $mysql;

    public function withMySQL(mysqli $mysql)
    {
        $this->mysql =  $mysql;
    }

    public function adicionar(string $titulo, string $descricao, string $imagem, string $dataL, string $link, string $preco, string $tamanho, string $paginas, string $tipo_papel, string $digital, string $quantidade, string $para_maiores, string $is_quadrinho, string $vendidas): void
    {
        $insereQuadrinho = $this->mysql->prepare('INSERT INTO quadrinhos (titulo, descricao, imagem, dataL, link,preco,tamanho,paginas,tipo_papel,digital,quantidade,para_maiores,is_quadrinho,vendidas) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $insereQuadrinho->bind_param('ssssssssssssss', $titulo,  $descricao,  $imagem, $dataL, $link,  $preco,  $tamanho,  $paginas,  $tipo_papel,  $digital,  $quantidade,  $para_maiores, $is_quadrinho, $vendidas);
        $insereQuadrinho->execute();
    }

    public function editar(string $id, string $titulo, string $descricao, string $imagem, string $dataL, string $link, string $preco, string $tamanho, string $paginas, string $tipo_papel, string $digital, string $quantidade, string $para_maiores, string $vendidas): void
    {
        $editaQuadrinho = $this->mysql->prepare('UPDATE quadrinhos SET titulo = ? , descricao = ? , imagem = ?,  dataL = ?,  link = ?, preco = ?, tamanho = ? , paginas = ?, tipo_papel = ?, digital = ?, quantidade = ?, para_maiores = ?, vendidas = ? WHERE id = ?');
        $editaQuadrinho->bind_param('ssssssssssssss', $titulo, $descricao, $imagem, $dataL, $link, $preco, $tamanho, $paginas, $tipo_papel, $digital, $quantidade, $para_maiores, $vendidas, $id);
        $editaQuadrinho->execute();
    }


    public function excluir(string $id): void
    {
        $excluirQuadrinho = $this->mysql->prepare('DELETE FROM quadrinhos WHERE quadrinhos.id = ?');
        $excluirQuadrinho->bind_param('s', $id);
        $excluirQuadrinho->execute();
    }

    public function exibirTodosQuadrinhos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM quadrinhos WHERE is_quadrinho = 1 ORDER BY quadrinhos.id DESC');

        $quadrinhos=[]; 
        while ($entry = $resultado->fetch_object()) {
            $quadrinhos[] = $entry;
        }
        return $quadrinhos;
    }

    public function exibirTodosBrindes(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM quadrinhos WHERE is_quadrinho = 0 ORDER BY quadrinhos.id DESC');

        $quadrinhos=[]; 
        while ($entry = $resultado->fetch_object()) {
            $quadrinhos[] = $entry;
        }
        return $quadrinhos;
    }

    public function encontrarPorTitulo(string $titulo): array
    {
        $selecionaQuadrinho = $this->mysql->query("SELECT * FROM quadrinhos WHERE titulo LIKE '%$titulo%'");
        $quadrinhos=[]; 
        while ($entry = $selecionaQuadrinho->fetch_object()) {
            $quadrinhos[] = $entry;
        }
        return $quadrinhos;
    }

    public function encontrarPorIds(string $id): array
    {
        $selecionaQuadrinho = $this->mysql->query("SELECT * FROM quadrinhos WHERE id IN ({$id})");
        $quadrinhos=[]; 
        while ($entry = $selecionaQuadrinho->fetch_object()) {
            $quadrinhos[] = $entry;
        }
        return $quadrinhos;
    }
}
