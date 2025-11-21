<?php
session_start();

require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: editarSenha.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'] ?? null;
$senhaAtual = $_POST['senhaAtual'] ?? '';
if (!$usuarioLogado) {
    header('Location: ../login.php');
    exit;
}

//Validar campos obrigatórios
if ($senhaAtual === '') {
    header('Location: editarSenha.php?erro=campos');
    exit;
}

$repo = new UsuarioRepositorio($pdo);

if ($repo->autenticar($usuarioLogado, $senhaAtual)) {
    $_SESSION['senhaCorreta'] = true;
    header('Location: editarSenha.php');
    exit;
} else {
    $_SESSION['senhaCorreta'] = false;
    header('Location: editarSenha.php?erro=credenciais');
    exit;
}

?>