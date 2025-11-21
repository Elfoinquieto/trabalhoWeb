<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">


    <title>Admin</title>
</head>

<body>
    <main>
        <div class="topo-direita">
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
        <section class="container">
            <h3>Painel Administrativo</h3>
            <img src="img/logo.jpeg" alt="">
            <h3>Seja muito bem vindo <strong><?php echo htmlspecialchars($usuarioLogado); ?></strong></h3>
            <div>
                <button class="entrar"> <a href="usuario/listar.php">Gerenciar Usuarios</a></button>
                <button class="entrar"> <a href="modelo/listar.php">Gerenciar Modelos</a></button>
                <button class="entrar"> <a href="pedido/listar.php">Gerenciar Pedidos</a></button>
            </div>
        </section>
    </main>

</body>

</html>