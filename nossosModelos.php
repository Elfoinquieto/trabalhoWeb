<?php
session_start();
require __DIR__ . "/src/conexao-bd.php";
require_once __DIR__ . "/src/Modelo/Usuario.php";
require_once __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";
require_once __DIR__ . "/src/Repositorio/ModeloRepositorio.php";
require_once __DIR__ . "/src/Modelo/Modelo.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
$repo = new UsuarioRepositorio($pdo);
$modeloRepositorio = new ModeloRepositorio($pdo);
$modelos = $modeloRepositorio->listar();

if ($usuarioLogado) {
    $usuario = $repo->buscarPorEmail($usuarioLogado);
} else {
    $usuario = null;
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossos Trabalhos - Koala WebStudio</title>
    <link rel="stylesheet" href="css/informativas.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/info.css">
</head>

<body>
    <div class="navbar-info">
        <img src="img/logo.jpeg" alt="Koala WebStudio" />
        <div class="links">
            <a href="index.php">Home</a>
            <a href="nossosTrabalhos.php">Nossos Trabalhos</a>
            <a href="pacotes.php">Pacotes</a>
            <a href="nossosModelos.php">Modelos</a>
            <a href="sobreNos.php">Sobre Nós</a>
            <a href="pedido-usuario/listar.php">Meus Pedidos</a>
        </div>
        <div class="topo-direita">
            <?php if ($usuario !== null && $usuario->getPermissao() === 'admin') {
                ?>
                <a href="../admin.php" class="botao-admin">Admin</a>
            <?php } ?>
            <img src="img/user (2).png" alt="" style="width:40px; height:40px; margin-right: 10px; cursor:pointer;"
                onclick="location.href='./usuario/editar.php'">
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </div>

    <div class="main-content trabalhos-content">
        <div class="main-left trabalhos-titulo">
            <h2 class="trabalhos-heading">Nossos Trabalhos</h2>
            <p class="trabalhos-desc">
                Cada projeto é desenvolvido com atenção aos detalhes, design estratégico e tecnologia de ponta. Confira
                alguns dos trabalhos que já ajudaram marcas a se destacar no ambiente digital:
            </p>
        </div>
        <div class="portfolio-grid">
            <?php foreach ($modelos as $modelo): ?>
                <div class="portfolio-item">
                    <div class="img-box>">
                        <img src="<?= $modelo->getImagem() ?>" alt="<?= htmlspecialchars($modelo->getNome()) ?>"
                            class="portfolio-img">
                    </div>
                    <div class="portfolio-nome">
                        <?= htmlspecialchars($modelo->getNome()) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>