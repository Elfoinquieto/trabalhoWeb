<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

// Captura dos dados do formulário
$id = $_POST['id'] ?? '';
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$pacote = trim($_POST['pacote'] ?? '');
$imagem = trim($_POST['imagem'] ?? '');

$repo = new ModeloRepositorio($pdo);

// Verificação de campos obrigatórios
if ($nome === '' || $descricao === '' || $pacote === '' || $imagem === '') {
    header('Location: editar.php?erro=campos');
    exit;
}

// Buscar o modelo existente
$sql = "SELECT * FROM modelos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {
    echo "Modelo não encontrado!";
    exit;
}

// Cria o objeto atualizado
$modelo = new Modelo(
    (int) $id,
    $nome,
    $pacote,
    $descricao,
    $imagem
);

// Atualiza no banco
$repo->alterar($modelo);

// Redireciona de volta para a lista
header('Location: listar.php');
exit;
?>