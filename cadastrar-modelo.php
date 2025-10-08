

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
        <section class="nav-bar">

        </section>
        <section class="form-section">
            <div class="form-container">
                <?php if($erro === 'campos'): ?>
                <p class="mensagem-erro">Preencha todos os campos.</p>
                <?php elseif($erro === 'existente'): ?>
                <p class="mensagem-erro">Já existe um modelo com esse nome.</p>
                <?php endif; ?>

                <h1>Ola Novamente!</h1>
                <h2>Insira os dados do modelo para o cadastro</h2>
                <form action="inserirModelo.php" method="POST" class="form">
                    
                    <label class="titulo-topico" for="nome">Nome</label>
                    <input type="nome" id="nome" name="nome" >

                    <label class="titulo-topico" for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao" >
                    
                    <label class="titulo-topico" for="pacote">Pacote</label>
                    <input type="text" id="pacote" name="pacote" >
                    

                    <label class="titulo-topico" for="caminho_imagem">Caminho da Imagem</label>
                    <input type="text" id="caminho_imagem" name="caminho_imagem" >
                    

                    <button type="submit" value="cadastrar">Cadastrar</button>
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