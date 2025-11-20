<?php
    class Modelo
    {
        private int $id;
        private string $nome;
        private string $pacote;
        private string $descricao;
        private string $imagem;

        //Método construtor
        public function __construct(int $id, string $nome, string $pacote, string $descricao, string $imagem){
            $this->id = $id;
            $this->descricao = $descricao;
            $this->imagem = $imagem;
            $this->nome = $nome;
            $this->pacote = $pacote;
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

        public function getPacote(): string
        {
            return $this->pacote;
        }
    }

?>