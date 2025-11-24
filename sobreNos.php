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
    <title>Sobre Nós - Koala WebStudio</title>
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
                <img src="img/admin.png" alt="admin-logo" style="width: 40px; height: auto;"
                    onclick="location.href='admin.php'">
            <?php } ?>
            <img src="img/user (2).png" alt="" style="width:40px; height:40px; margin-right: 10px; cursor:pointer;"
                onclick="location.href='./usuario/editar.php'">
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
    </div>

    <div class="main-content sobre-content">
        <div class="sobre-titulo">
            <h2 class="sobre-heading">Sobre Nós</h2>
            <p class="sobre-desc">
                Cada projeto é desenvolvido com atenção aos detalhes, design estratégico e tecnologia de ponta.<br>
                Confira alguns dos trabalhos que já ajudaram marcas a se destacar no ambiente digital:
            </p>
        </div>
        <div class="sobre-main-row">
            <div class="sobre-img-box" style="border-image: var(--rosa_roxo) 1;">
                <img class="sobre-img" src="img/sobre.png" alt="Web Design Development" />
            </div>
            <div class="sobre-direita">
                <h3 class="sobre-quem-heading">Quem Somos?</h3>
                <div class="sobre-quem-desc">
                    Na Koala WebStudio, acreditamos que a presença digital deve ser simples, bonita e eficiente.
                    Assim como o koala, que transmite tranquilidade e confiança, buscamos criar experiências digitais
                    que tragam conforto e resultados para nossos clientes.
                </div>
                <div class="sobre-divider"></div>
            </div>
        </div>
        <div class="valores-row">
            <div class="valores-col">
                <h3 class="valores-heading">Nossos Valores:</h3>
                <ul class="valores-list">
                    <li>Criatividade e inovação em cada projeto</li>
                    <li>Clareza e proximidade na comunicação com nossos clientes</li>
                    <li>Responsabilidade e compromisso com prazos e resultados</li>
                    <li>Soluções digitais que unem estética e funcionalidade</li>
                </ul>
            </div>
            <div class="sobre-estatisticas-row">
                <div class="estatistica">
                    <div class="estatistica-num">+ 1000</div>
                    <div class="estatistica-titulo">Sites criados</div>
                </div>
                <div class="estatistica">
                    <div class="estatistica-num">+ 20</div>
                    <div class="estatistica-titulo">Anos no mercado</div>
                </div>
                <div class="estatistica">
                    <div class="estatistica-num">45</div>
                    <div class="estatistica-titulo">Prêmios ganhos</div>
                </div>
                <div class="estatistica">
                    <div class="estatistica-num">+ 30</div>
                    <div class="estatistica-titulo">Colaboradores</div>
                </div>
            </div>
        </div>
        <div class="botao-contato">
            <button class="entrar"><a href="#">Entre em Contato</a></button>
        </div>
        <div class="contato-row">
            <div class="contato-mail">E-mail: koala.web@gmail.com</div>
            <div class="contato-numero">Número: +55 41 99209-6868</div>
        </div>
    </div>
</body>

</html>