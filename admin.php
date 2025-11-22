<?php
session_start();
require_once __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";
require_once __DIR__ . "/src/Modelo/Usuario.php";
require __DIR__ . "/src/conexao-bd.php";

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioLogado = $_SESSION['usuario'];
$repo = new UsuarioRepositorio($pdo);
$usuario = $repo->buscarPorEmail($usuarioLogado);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/info.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/admin-style.css">



    <title>Admin</title>
</head>

<body>
    <main>
        <div class="navbar-info">
            <img src="img/logo.jpeg" alt="Koala WebStudio" />
            <div class="links">
                <a href="index.php">Home</a>
                <a href="nossosTrabalhos.php">Nosso Trabalho</a>
                <a href="">Pacotes</a>
                <a href="">Modelos</a>
                <a href="">Sobre Nós</a>
            </div>
            <div class="topo-direita">
                <?php if ($usuario !== null && $usuario->getPermissao() === 'admin') {
                    ?>
                    <a href="admin.php" class="botao-admin">Admin</a>
                <?php } ?>
                <img src="img/user (2).png" alt="" style="width:40px; height:40px; margin-right: 10px; cursor:pointer;"
                    onclick="location.href='./usuario/editar.php'">
                <form action="logout.php" method="post" style="display:inline;">
                    <?php if ($usuarioLogado): ?>
                        <button type="submit" class="botao-sair">Sair</button>
                    <?php else: ?>
                        <button type="submit" class="editar">Entrar</button>
                    <?php endif ?>
                </form>
            </div>
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