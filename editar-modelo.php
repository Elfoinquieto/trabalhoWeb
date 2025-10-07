<?php 
session_start();
require_once __DIR__ . "/src/conexao-bd.php";
require_once __DIR__ . "/src/Repositorio/ModeloRepositorio.php";
require_once __DIR__ . "/src/Modelo/Modelo.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';

// Verifica se o ID foi enviado
$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: admin-modelos.php");
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Modelo</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login-style.css">
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
</head>
<body>
    <main>
        <section class="nav-bar"></section>

        <section class="form-section">
            <div class="form-container">
                <?php if($erro === 'campos'): ?>
                    <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php endif; ?>

                <h1>Editar Modelo</h1>
                <h2>Atualize as informações abaixo</h2>

                <form action="alterarModelo.php" method="POST" class="form">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($modelo->getId()) ?>">

                    <label class="titulo-topico" for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($modelo->getNome()) ?>">

                    <label class="titulo-topico" for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($modelo->getDescricao()) ?>">

                    <label class="titulo-topico" for="pacote">Pacote</label>
                    <input type="text" id="pacote" name="pacote" value="<?= htmlspecialchars($modelo->getPacote()) ?>">

                    <label class="titulo-topico" for="caminho_imagem">Caminho da Imagem</label>
                    <input type="text" id="caminho_imagem" name="caminho_imagem" value="<?= htmlspecialchars($modelo->getCaminhoImagem()) ?>">

                    <button type="submit" value="atualizar">Atualizar</button>
                </form>
            </div>
            <div class="form-img">
                <img src="img/logo.jpeg" alt="" class = "logo">
            </div>
        </section>
    </main>

    <script>
    window.addEventListener('DOMContentLoaded', function() {
        var msg = document.querySelector('.mensagem-erro');
        if (msg) {
            setTimeout(function() {
                msg.classList.add('oculto');
            }, 5000);
        }
    });
    </script>
</body>
</html>
