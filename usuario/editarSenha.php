<?php
session_start();
$usuarioLogado = $_SESSION['usuario'] ?? null;
$erro = $_GET['erro'] ?? '';
$senhaCorreta = $_SESSION['senhaCorreta'] ?? false;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login-style.css">
    <link rel="stylesheet" href="../css/admin-style.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
</head>

<body>
    <main>
        <section class="nav-bar">
        </section>
        <section class="form-section">
            <div class="form-container">
                <h1>Mudar senha</h1>
                <h2>Digite sua senha</h2>
                <div class="erro">
                    <?php if ($erro === 'credenciais'): ?>
                        <p class="mensagem-erro">Senha incorreta tente novamente</p>
                    <?php elseif ($erro === 'campos'): ?>
                        <p class="mensagem-erro">Preencha senha.</p>
                    <?php endif; ?>
                </div>
                <?php ?>
                <?php if (!$senhaCorreta): ?>
                    <form action="autenticarSenha.php" method="POST" class="form">
                        <label for="password">Senha</label>
                        <input type="password" name="senhaAtual" required>
                        <button type="submit" value="Mudar senha">Verificar Senha</button>
                    </form>
                <?php endif; ?>
                <?php if ($senhaCorreta): ?>
                    <form action="atualizarSenha.php" method="POST" class="form">
                        <p class="mensagem-sucesso">Senha correta, digite a nova senha</p>
                        <label for="senhaNova">Senha Nova</label>
                        <input type="password" name="senhaNova" required>
                        <button type="submit">Mudar Senha</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="form-img">
                <img src="img/logo.jpeg" alt="" class="logo">
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