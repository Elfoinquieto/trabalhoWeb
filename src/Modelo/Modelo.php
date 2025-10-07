<?php
    class Modelo
    {
        private int $id;
        private string $nome;
        private string $pacote;
        private string $descricao;
        private string $caminho_imagem;

        //Método construtor
        public function __construct(int $id, string $nome, string $pacote, string $descricao, string $caminho_imagem){
            $this->id = $id;
            $this->descricao = $descricao;
            $this->caminho_imagem = $caminho_imagem;
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

        public function getCaminhoImagem(): string
        {
            return $this->caminho_imagem;
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