<?php
session_start();
$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';
$modeloSelecionado = htmlspecialchars($_GET['modelo_nome'] ?? '');

if (!$usuarioLogado) {
    header('Location: ../login.php');
    exit;
}

require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";


$modeloRepositorio = new ModeloRepositorio($pdo);
$modelos = $modeloRepositorio->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação de pedido</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login-style.css">
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
</head>

<body>
    <main>
        <section class="nav-bar"></section>

        <section class="form-section">
            <div class="form-container">
                <h1>Criação de pedido</h1>
                <h2>Faça o pedido de um website aqui!</h2>

                <div class="erro">
                    <?php if ($erro === 'campos'): ?>
                        <p class="mensagem-erro">Preencha todos os campos.</p>
                    <?php elseif ($erro === 'existente'): ?>
                        <p class="mensagem-erro">Já existe um modelo com esse nome.</p>
                    <?php endif; ?>
                </div>

                <form action="inserir.php" method="POST" class="form">

                    <input type="hidden" value="<?php echo htmlspecialchars($usuarioLogado); ?>" name="email">

                    <label class="titulo-topico" for="nome">Nome do site</label>
                    <input type="text" id="nome" name="nome">

                    <label class="titulo-topico" for="modelo">Modelo</label>
                    <select name="modelo" id="modelo">
                        <?php foreach ($modelos as $modelo):
                            $isSelected = ($modelo->getNome() === $modeloSelecionado) ? 'selected' : '';
                            ?>
                            <option value="<?php echo htmlspecialchars($modelo->getNome()); ?>" <?php echo $isSelected; ?>>
                                <?php echo htmlspecialchars($modelo->getNome()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label class="titulo-topico" for="pacote">Pacote</label>
                    <select name="pacote" id="pacote">
                        <option value="Start">Start</option>
                        <option value="Pro">Pro</option>
                        <option value="Premium">Premium</option>
                    </select>

                    <label class="titulo-topico" for="descricao">Descrição do site</label>
                    <input type="text" id="descricao" name="descricao">

                    <button type="submit" value="cadastrar">Realizar Pedido</button>
                </form>
            </div>

            <div class="form-img">
                <img src="../img/logo.jpeg" alt="Logo" class="logo">
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