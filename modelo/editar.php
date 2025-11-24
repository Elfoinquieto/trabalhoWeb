<?php
session_start();
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';

// Verifica se o ID foi enviado
$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: listar.php");
    exit;
}

// Cria o repositório e busca o modelo pelo ID
$modeloRepositorio = new ModeloRepositorio($pdo);
$stmt = $pdo->prepare("SELECT * FROM modelos WHERE id = ?");
$stmt->execute([$id]);
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dados) {
    echo "Modelo não encontrado!";
    exit;
}

// Cria o objeto modelo com os dados atuais
$modelo = $modeloRepositorio->formarObjeto($dados);

if (method_exists($modelo, 'getImagem')) {
    $valorImagem = $modelo->getImagem();
} else {
    $valorImagem = '';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Modelo</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login-style.css">
    <link rel="icon" href="../img/logo.jpg" type="image/x-icon">
</head>

<body>
    <main>
        <section class="nav-bar"></section>

        <section class="form-section">
            <div class="form-container">

                <h1>Editar Modelo</h1>
                <h2>Atualize as informações abaixo</h2>

                <?php if ($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif; ?>

                <form action="atualizar.php" method="POST" class="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($modelo->getId()) ?>">

                    <label class="titulo-topico" for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($modelo->getNome()) ?>">

                    <label class="titulo-topico" for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao"
                        value="<?= htmlspecialchars($modelo->getDescricao()) ?>">

                    <label class="titulo-topico" for="imagem">Imagem</label>
                    <input id="imagem" name="imagem" type="file" accept="image/*">
                    <?php if (!empty($valorImagem)): ?>
                        <div class="preview-imagem">
                            <!-- Ajuste o caminho conforme onde você armazena as imagens (ex: ../uploads/) -->
                            <p>Imagem atual: <?= htmlspecialchars($valorImagem) ?></p>
                            <img src="../img-modelo/<?= htmlspecialchars($valorImagem) ?>" alt="Imagem"
                                style="max-width:200px;display:block;margin-top:8px;">
                            <!-- Mantém o nome da imagem atual caso o usuário não envie nova -->
                            <input type="hidden" name="imagem_existente" value="<?= htmlspecialchars($valorImagem) ?>">
                        </div>
                    <?php endif; ?>
                    <button type="submit" value="atualizar">Atualizar</button>
                </form>
            </div>
            <div class="form-img">
                <img src="../img/logo.jpeg" alt="" class="logo">
            </div>
        </section>
    </main>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var msg = document.querySelector('.mensagem-erro');
            if (msg) {
                setTimeout(function () {
                    msg.classList.add('oculto');
                }, 5000);
            }
        });
    </script>
</body>

</html>