<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$id = $_POST['id'] ?? null;
$permissao = $_POST['permissao'] ?? null;

if (!$id || !$permissao) {
    header("Location: listar.php");
    exit;
}

$usuarioRepositorio = new UsuarioRepositorio($pdo);
$usuarioRepositorio->atualizarPermissao((int) $id, $permissao);

header("Location: listar.php");
exit;