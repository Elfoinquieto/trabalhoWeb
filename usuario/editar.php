<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';
if (!$usuarioLogado) {
    header('Location: ../login.php');
    exit;
}
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$usuarioRepositorio = new UsuarioRepositorio($pdo);
$usuario = $usuarioRepositorio->buscarPorEmail($usuarioLogado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/admin-style.css">
    <link rel="stylesheet" href="../css/info.css">




    <title>Editar Perfil</title>
</head>

<body>
    <main>
        <section class="container">
            <h3 class="titulo2">Seu Perfil</h3>
        </section>
        <div class="container-mensagem">
            <?php if ($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha todos os campos.</p>
            <?php endif; ?>
            <?php if (isset($_GET['sucesso'])): ?>
                <p class="mensagem-sucesso">Perfil atualizado com sucesso</p>
            <?php endif; ?>
        </div>
        <form action="atualizar.php" method="POST" class="form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario->getId()) ?>">

            <label class="label-form" for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="input-form" style="background-color: var(--verde_escuro);"
                value="<?= htmlspecialchars($usuario->getNomeCompleto()) ?>">

            <label class="label-form" for="descricao">Email</label>
            <input type="text" id="email" name="email" class="input-form" style="background-color: #318684ff;"
                value="<?= htmlspecialchars($usuario->getEmail()) ?>">

            <label class="label-form" for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" class="input-form"
                style="background-color: var(--verde_claro);" value="<?= htmlspecialchars($usuario->getTelefone()) ?>">
            <button type="submit" value="atualizar">Atualizar</button>
        </form>
        <section class="tabela" style="display: flex; flex-direction: column; align-items: center;">
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
        window.addEventListener('DOMContentLoaded', function () {
            var msg = document.querySelector('.mensagem-sucesso');
            if (msg) {
                setTimeout(function () {
                    msg.classList.add('oculto');
                }, 5000);
            }
        });
    </script>

</body>

</html>