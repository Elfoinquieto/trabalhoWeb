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
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/reset.css">
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
                <?php if($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php elseif($erro === 'existente'): ?>
                <p class="mensagem-erro">Já existe um modelo com esse nome.</p>
                <?php endif; ?>

                <h1>Bem Vindo!</h1>
                <h2>Insira seus dados para o cadastro</h2>
                <form action="inserirUsuario.php" method="POST" class="form">
                    
                    <label class="titulo-topico" for="email">E-mail</label>
                    <input type="email" id="e-mail" name="email" >

                    <label class="titulo-topico" for="nome_completo">Nome Completo: </label>
                    <input type="text" id="nome_completo" name="nome_completo" >
                    
                    <label class="titulo-topico" for="password">Senha</label>
                    <input type="password" id="password" name="senha" >
                    

                    <label class="titulo-topico" for="telefone">Telefone: </label>
                    <input type="text" id="telefone" name="telefone" >
                    

                    <button type="submit" value="cadastrar">Sign-up</button>
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