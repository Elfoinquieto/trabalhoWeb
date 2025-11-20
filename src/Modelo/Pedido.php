<?php
    class Pedido
    {
        private int $id;
        private string $nome;
        private string $pacote;
        private string $descricao;
        private string $saite;
        private string $modelo;
        private string$statos;

        //Método construtor
        public function __construct(int $id, string $nome, string $pacote, string $descricao, string $saite, string $modelo, string $statos){
            $this->id = $id;
            $this->descricao = $descricao;
            $this->saite = $saite;
            $this->nome = $nome;
            $this->pacote = $pacote;
            $this->modelo = $modelo;
            $this->statos = $statos;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getDescricao(): string
        {
            return $this->descricao;
        }

        public function getSaite(): string
        {
            return $this->saite;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getPacote(): string
        {
            return $this->pacote;
        }

        public function getModelo(): string
        {
            return $this->modelo;
        }

        public function getStatos(): string
        {
            return $this->statos;
        }
    }

?>