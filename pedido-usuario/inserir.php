<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Pedido.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

//Dados vindos do formulário
$email = trim($_POST['email'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$pacote = trim($_POST['pacote'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$saite = trim($_POST['saite'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$statos = 'pendente';

if (empty($email) || empty($nome) || empty($pacote) || empty($descricao) || empty($modelo)) {
    header('Location: cadastrar.php?erro=campos');
    exit;
}

$repo = new PedidoRepositorio($pdo);

$repo->salvar(new Pedido(0, $nome, $pacote, $descricao, $saite, $modelo, $statos, $email));

header('Location: listar.php');


?>