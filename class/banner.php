<?php


class Banner
{
    public int $id;
    public string $imagem;
    public int $id_quadrinho;
    public string $link;
    public int $ativo;

    private $mysql;

    public function withMySQL($mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $imagem, string $id_quadrinho, string $link, string $ativo): void
    {
        $insereBanner = $this->mysql->prepare('INSERT INTO banner (imagem ,id_quadrinho, link, ativo) VALUES(?,?,?,?)');
        $insereBanner->bind_param('ssss', $imagem, $id_quadrinho, $link, $ativo);
        $insereBanner->execute();
    }

    public function editar(string $id, string $imagem, string $id_quadrinho, string $link, string $ativo): void
    {
        $editaBanner = $this->mysql->prepare('UPDATE banner SET imagem = ?, id_quadrinho = ?, link = ?, ativo = ? WHERE id = ?');
        $editaBanner->bind_param('sssss', $imagem, $id_quadrinho, $link, $ativo, $id);
        $editaBanner->execute();
    }


    public function excluir(string $id): void
    {
        $excluirBanner = $this->mysql->prepare('DELETE FROM banner WHERE banner.id = ?');
        $excluirBanner->bind_param('s', $id);
        $excluirBanner->execute();
    }

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM banner ORDER BY banner.id DESC');
        $banners= [];
        while ($entry = $resultado->fetch_object()) {
            $banners[] = $entry;
        }
        return $banners;
    }

    public function exibirTodosAtivos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM banner WHERE ativo = 1 ORDER BY banner.id DESC');
        $banners= [];
        while ($entry = $resultado->fetch_object()) {
            $banners[] = $entry;
        }
        return $banners;
    }
}
