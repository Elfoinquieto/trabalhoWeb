<?php 
    session_start();
    $usuarioLogado = $_SESSION['usuario'] ?? null;
    $erro = $_GET['erro'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login-style.css">
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
</head>
<body>
    <main>
        <?php 
        if($usuarioLogado): ?>
        <section class="container-topo">
            <div class="topo-direita">
                <p>Você já está logado como <strong><?php echo htmlspecialchars($usuarioLogado)?></strong></p>
                <form action="logout.php" method="post">
                    <button type="submit" class="botao-sair">Sair</button>
                </form>
                
            </div>
            <div class="conteudo">
                <a href="admin.php" class="link-adm">Ir para o painel administrativo</a>
            </div>
        </section>
        <?php else: ?>

        <section class="nav-bar">

        </section>
        <section class="form-section">
            <div class="form-container">
                <?php if($erro === 'credenciais'): ?>
                <p class="mensagem-erro">Usuário e senha incorretos.</p>
                <?php elseif($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha e-mail e senha.</p>
                <?php endif; ?>

                <h1>Olá de novo!</h1>
                <h2>Insira seus dados para o Login</h2>
                <form action="autenticar.php" method="POST" class="form">
                    <label for="email">E-mail</label>
                    <input type="email" id="e-mail" name="email">

                    <label for="password">Senha</label>
                    <input type="password" id="password" name="senha">

                    <a href="">Esqueci a minha senha</a>
                    <h2>Não tem uma conta? <a href="cadastrar.php">Crie uma aqui</a></h2>
                    <button type="submit" value="Entrar">Entrar</button>
                </form>
            </div>
            <div class="form-img">
                <img src="img/logo.jpeg" alt="" class = "logo">
            </div>
        </section>
        <?php endif; ?>
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