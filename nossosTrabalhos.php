<?php
session_start();
require __DIR__ . "/src/conexao-bd.php";
require_once __DIR__ . "/src/Modelo/Usuario.php";
require_once __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";

$usuarioLogado = $_SESSION['usuario'] ?? null;
$repo = new UsuarioRepositorio($pdo);

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
            <a href="#">Modelos</a>
            <a href="#">Sobre Nós</a>
        </div>
        <div class="topo-direita">
            <?php if ($usuario !== null && $usuario->getPermissao() === 'admin') {
                ?>
                <a href="admin.php" class="botao-admin">Admin</a>
            <?php } ?>
            <img src="img/user (2).png" alt="" style="width:40px; height:40px; margin-right: 10px; cursor:pointer;" onclick="location.href='./usuario/editar.php'">
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </div>

    <div class="main-content trabalhos-content">
        <div class="main-left trabalhos-titulo">
            <h2 class="trabalhos-heading">Nossos Trabalhos</h2>
            <p class="trabalhos-desc">
                Cada projeto é desenvolvido com atenção aos detalhes, design estratégico e tecnologia de ponta. Confira alguns dos trabalhos que já ajudaram marcas a se destacar no ambiente digital:
            </p>
        </div>
        <div class="portfolio-grid">
            <div class="portfolio-item">
                <div class="img-box border-rosa">
                    <img src="img/flashco.png" alt="Flash.co" class="portfolio-img">
                </div>
                <div class="portfolio-nome nome-flash">Flash.co</div>
            </div>
            <div class="portfolio-item">
                <div class="img-box border-roxo">
                    <img src="img/mercurius.png" alt="Mercurius" class="portfolio-img">
                </div>
                <div class="portfolio-nome nome-mercurius">Mercurius.</div>
            </div>
            <div class="portfolio-item">
                <div class="img-box border-verde">
                    <img src="img/brainstack.png" alt="BrainStack" class="portfolio-img">
                </div>
                <div class="portfolio-nome nome-brain">BrainStack</div>
            </div>
            <div class="portfolio-item">
                <div class="img-box border-roxo">
                    <img src="img/foodhue.png" alt="FoodHue" class="portfolio-img">
                </div>
                <div class="portfolio-nome nome-food">FoodHue</div>
            </div>
        </div>
    </div>
</body>
</html>
