<?php
session_start();

require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
$senhaNova = trim($_POST['senhaNova'] ?? '');
$repo = new UsuarioRepositorio($pdo);

// Verifica se o usuário está logado
if (!$usuarioLogado) {
    header('Location: ../login.php');
    exit;
}

if (!($_SESSION['senhaCorreta'] ?? false)) {
    header('Location: editarSenha.php?erro=credenciais');
    exit;
}

// Verifica se o campo está preenchido
if ($senhaNova === '') {
    header('Location: editarSenha.php?erro=campos');
    exit;
}

// Busca o usuário pelo email da sessão
$dados = $repo->buscarPorEmail($usuarioLogado);


if (!$dados) {
    echo "Usuário não encontrado!";
    exit;
}

// Cria o objeto atualizado
$usuario = new Usuario(
    (int) $dados->getId(),
    $usuarioLogado,
    $senhaNova,
    $dados->getNomeCompleto(),
    $dados->getTelefone(),
    $dados->getPermissao()
);

// Atualiza no banco
$repo->alterarSenha($usuario);

// Limpa a flag de senha correta
unset($_SESSION['senhaCorreta']);

// Redireciona para confirmar sucesso
header('Location: editar.php?sucesso=1');
exit;
