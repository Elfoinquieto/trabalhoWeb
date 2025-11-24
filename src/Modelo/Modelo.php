<?php
class Modelo
{
    private int $id;
    private string $nome;
    private string $descricao;
    private string $imagem;

    //Método construtor
    public function __construct(int $id, string $nome, string $descricao, string $imagem)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
        $this->nome = $nome;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getImagem(): string
    {
        return $this->imagem;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
}

?>