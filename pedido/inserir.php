<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Pedido.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

//Dados vindos do formulário
$email = trim($_POST['email'] ?? '');
$nome_completo = trim($_POST['nome_completo'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha = $_POST['senha'] ?? '';

$repo = new PedidoRepositorio($pdo);

$repo->salvar(new Pedido(0, $email, $senha, $nome_completo, $telefone));

fazer inserir depois(apenas para o usuario) copiando o inserir do modelo

header('Location: ../login.php');


?>