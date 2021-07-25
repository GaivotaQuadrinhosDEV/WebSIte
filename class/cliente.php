<?php


class User
{
    public int $id;
    public string $nome;
    public string $email;
    public string $telefone;
    public string $senha;
    public int $nivel;
    public int $id_quadrinista;
    
    private $mysql;

    public function __construct()
    {
        
    }
    
    public function withMySQL($mysql)
    {
        $this->mysql = $mysql;
    }

    public function adicionar(string $nome, string $email, string $telefone,string $senha,string $nivel,string $id_quadrinista) : void
    {
        $insereUser = $this->mysql->prepare('INSERT INTO users (nome, email, telefone,senha,nivel,id_quadrinista) VALUES(?,?,?,?,?,?)');
        $insereUser->bind_param('ssssss',$nome,$email,$telefone,$senha,$nivel,$id_quadrinista);
        $insereUser->execute();
    }

    public function editar(string $id ,string $nome, string $email, string $telefone,string $nivel,string $id_quadrinista) : void
    {
        $editaArtigo = $this->mysql->prepare('UPDATE users SET nome = ? , email = ? , telefone = ?, nivel = ?, id_quadrinista = ? WHERE id = ?');
        $editaArtigo->bind_param('ssssss',$nome,$email,$telefone,$nivel,$id_quadrinista,$id);
        $editaArtigo->execute();
    }

    public function excluir(string $id) : void
    {
        $excluiCliente = $this->mysql->prepare('DELETE FROM users WHERE users.id = ?');
        $excluiCliente->bind_param('s',$id);
        $excluiCliente->execute();

    }

    public function exibirTodos(): array
    {
        $resultado = $this->mysql->query('SELECT * FROM users');
        $gaivotacasts=[];
        while ($entry = $resultado->fetch_object()) {
            $gaivotacasts[] = $entry;
        }
        return $gaivotacasts;
    }

    public function encontrarPorNome(string $nome): array
    {
        $selecionaUser = $this->mysql->prepare("SELECT * FROM users WHERE nome = ?");

        $selecionaUser->bind_param('s', $nome);
        $selecionaUser->execute();
        $user = new User();
        $user =  $selecionaUser->get_result()->fetch_object();
        return $user;
    }

    public function encontrarPorId(string $id): array
    {
        $selecionaUser = $this->mysql->prepare("SELECT * FROM users WHERE id = $id");

        $selecionaUser->execute();
        $user = new User();
        $user =  $selecionaUser->get_result()->fetch_object();
        return $user;
    }
}