<?php
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');

$repo = new ModeloRepositorio($pdo);

if ($repo->buscarPorNome($nome)) {
    header('Location: cadastrar.php?erro=existente');
    exit;
}

$uploadsDir = __DIR__ . '/../img-modelo/';

if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}
$nomeImagem = null;

if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

    $tmpPath = $_FILES['imagem']['tmp_name'];


    $imgInfo = @getimagesize($tmpPath);
    if ($imgInfo !== false) {

        $mime = $imgInfo['mime'];
        $ext = '';

        switch ($mime) {
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

        $filename = uniqid('img_', true) . $ext;
        $destination = $uploadsDir . $filename;

        // Move a imagem para a pasta final
        if (move_uploaded_file($tmpPath, $destination)) {
            $nomeImagem = $filename;
        }
    }
}



if ($nome === '' || $descricao === '' || $nomeImagem == null) {
    header('Location: cadastrar.php?erro=campos');
    exit;
}

$repo->salvar(new Modelo(
    0,
    $nome,
    $descricao,
    $nomeImagem
));

header('Location: listar.php');
exit;
?>