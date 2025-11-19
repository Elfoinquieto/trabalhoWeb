<?php
class Usuario
{
    private int $id;
    private string $email;
    private string $senha;
    private string $nome_completo;
    private string $telefone;

    private string $permissao;

    //Método construtor
    public function __construct(int $id, string $email, string $senha, string $nome_completo, string $telefone, string $permissao = 'user')
    {
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
        $this->nome_completo = $nome_completo;
        $this->telefone = $telefone;
        $this->permissao = $permissao;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomeCompleto(): string
    {
        return $this->nome_completo;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }
    public function getPermissao(): string
    {
        return $this->permissao;
    }
}

?>