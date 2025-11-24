<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

$repo = new ModeloRepositorio($pdo);

// Captura dados do formulário
$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$imagemExistente = $_POST['imagem_existente'] ?? null;

// Validação básica
if (!$id || $nome === '' || $descricao === '') {
    header("Location: editar.php?id={$id}&erro=campos");
    exit;
}

$sql = "SELECT * FROM modelos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$modeloAtual = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$modeloAtual) {
    echo "Modelo não encontrado!";
    exit;
}


$uploadsDir = __DIR__ . '/../img-modelo/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$nomeImagem = $imagemExistente;


if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

    $tmpPath = $_FILES['imagem']['tmp_name'];
    $imgInfo = @getimagesize($tmpPath);

    if ($imgInfo !== false) {
        // Determina extensão correta
        switch ($imgInfo['mime']) {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            default:
                $ext = image_type_to_extension($imgInfo[2]) ?: '';
        }

        $novoNome = uniqid('img_', true) . $ext;
        $destino = $uploadsDir . $novoNome;

        if (move_uploaded_file($tmpPath, $destino)) {

            if ($imagemExistente && file_exists($uploadsDir . $imagemExistente)) {
                unlink($uploadsDir . $imagemExistente);
            }

            $nomeImagem = $novoNome;
        }
    }
}

$modelo = new Modelo(
    (int) $id,
    $nome,
    $descricao,
    $nomeImagem
);

$repo->alterar($modelo);

header("Location: listar.php");
exit;
?>