<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: listar.php");
    exit;
}

$repo = new ModeloRepositorio($pdo);
$repo->deletar($id);

header("Location: listar.php");
exit;
?>