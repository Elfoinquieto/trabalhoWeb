<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

// Captura dos dados do formulário
$id = $_POST['id'] ?? '';
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');

$repo = new UsuarioRepositorio($pdo);

// Verificação de campos obrigatórios
if ($nome === '' || $email === '' || $telefone === '') {
    header('Location: editar.php?erro=campos');
    exit;
}


// Buscar o modelo existente
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {
    echo "Modelo não encontrado!";
    exit;
}

// Cria o objeto atualizado
$usuario = new Usuario(
    (int) $id,
    $email,
    $dados['senha'],
    $nome,
    $telefone,
    $dados['permissao']

);

// Atualiza no banco
$repo->alterar($usuario);

// Redireciona de volta para a lista
header('Location: editar.php?sucesso=1');
exit;
?>