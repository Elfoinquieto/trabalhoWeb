<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

$id = $_POST['id'] ?? null;
$statos = $_POST['statos'] ?? null;
$saite = $_POST['saite'] ?? '';

if (!$id || !$statos) {
    header("Location: listar.php");
    exit;
}

$pedidoRepositorio = new PedidoRepositorio($pdo);
$pedidoRepositorio->atualizarStatos((int) $id, $statos);
$pedidoRepositorio->atualizarSaite((int) $id, $saite);

header("Location: listar.php");
exit;