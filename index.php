<?php
session_start();
require __DIR__ . "/src/conexao-bd.php";
require_once __DIR__ . "/src/Modelo/Usuario.php";
require_once __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";

$usuarioLogado = $_SESSION['usuario'];
$repo = new UsuarioRepositorio($pdo);

$usuario = $repo->buscarPorEmail($usuarioLogado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koala WebStudio</title>
    <link rel="stylesheet" href="css/informativas.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/info.css">
</head>

<body>
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
            <?php if ($usuario->getPermissao() === 'admin') {
                ?>
                <a href="admin.php" class="botao-admin">Admin</a>
            <?php } ?>
            <img src="img/user (2).png" alt="" style="width:40px; height:40px; margin-right: 10px; cursor:pointer;"
                onclick="location.href='./usuario/editar.php'">
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="main-left">
            <p class="koala">Koala WebStudio</p>
            <h2>Criamos </h2>
            <h2 class="mark">Web Sites</h2>
            <h2>Criativos e Funcionais</h2>
            <div class="divider"></div>
            <p>
                Desenvolvemos soluções digitais sob medida para conectar sua marca ao mundo, com sites modernos,
                rápidos
                e prontos para gerar resultados.
            </p>
            <div class="features-row">
                <div class="feature">
                    <h4>Inovação</h4>
                    <p>Sites modernos, responsivos e otimizados para velocidade e usabilidade. Sua presença digital
                        sempre atualizada com as melhores práticas do mercado.</p>
                </div>
                <div class="feature">
                    <h4>Solução</h4>
                    <p>Cada projeto é único: desenvolvemos serviços web personalizados que se adaptam às
                        necessidades do
                        seu negócio e ao perfil do seu público.</p>
                </div>
                <div class="feature">
                    <h4>Confiança</h4>
                    <p>Acompanhamos você em todas as etapas, oferecendo suporte dedicado e transparência total para
                        que
                        seu projeto cresça com segurança.</p>
                </div>
            </div>
            <div class="buttons-row">
                <button class="entrar"> <a href="#">Pacotes</a></button>
                <button class="entrar"> <a href="#">Nossos Trabalhos</a></button>
                <button class="entrar"> <a href="#">Sobre Nós</a></button>
            </div>
        </div>
        <div class="main-right">
            <img src="img/imagemHome.png" alt="Ilustração Web Dev" />
        </div>
    </div>
</body>

</html>