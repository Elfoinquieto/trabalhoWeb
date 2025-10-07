<?php
require_once __DIR__ . '/src/conexao-bd.php';
require_once __DIR__ . '/src/Repositorio/ModeloRepositorio.php';
require_once __DIR__ . '/src/Modelo/Modelo.php';

// Captura dos dados do formulário
$id = $_POST['id'] ?? '';
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$pacote = trim($_POST['pacote'] ?? '');
$caminho_imagem = trim($_POST['caminho_imagem'] ?? '');

$repo = new ModeloRepositorio($pdo);

// Verificação de campos obrigatórios
if ( $nome === '' || $descricao === '' || $pacote === '' || $caminho_imagem === '') {
    header('Location: editar-modelo.php?erro=campos');
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
    (int)$id,
    $nome,
    $pacote,
    $descricao,
    $caminho_imagem
);

// Atualiza no banco
$repo->alterar($modelo);

// Redireciona de volta para a lista
header('Location: admin-modelos.php');
exit;
?>
