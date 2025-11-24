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
    <title>Nossos Pacotes - Koala WebStudio</title>
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

    <div class="main-content pacotes-content">
        <div class="main-left pacotes-titulo">
            <h2 class="pacotes-heading">Nossos Pacotes</h2>
            <p class="pacotes-desc">
                Escolha o plano ideal para o seu projeto.<br>
                Oferecemos soluções flexíveis para atender diferentes necessidades — desde quem está começando até
                empresas que buscam performance máxima no digital.
            </p>
        </div>
        <div class="pacotes-grid">
            <div class="pacote-item pacote-start">
                <h3 class="pacote-nome">Pacote Start</h3>
                <p class="pacote-texto">Ideal para quem precisa de uma presença digital rápida e funcional.</p>
                <ul class="pacote-lista">
                    <li>Site responsivo de até 3 páginas</li>
                    <li>Layout moderno e profissional</li>
                    <li>Integração básica com redes sociais</li>
                    <li>Suporte inicial</li>
                </ul>
                <div class="pacote-preco preco-start">R$ 399,99</div>
            </div>
            <div class="pacote-item pacote-pro">
                <h3 class="pacote-nome">Pacote Pro</h3>
                <p class="pacote-texto">Perfeito para negócios que querem se destacar e atrair mais clientes.</p>
                <ul class="pacote-lista">
                    <li>Site completo de até 6 páginas</li>
                    <li>Design personalizado</li>
                    <li>Blog integrado + formulário de contato</li>
                    <li>Otimização para SEO básico</li>
                    <li>Suporte estendido</li>
                </ul>
                <div class="pacote-preco preco-pro">R$ 599,99</div>
            </div>
            <div class="pacote-item pacote-premium">
                <h3 class="pacote-nome">Pacote Premium</h3>
                <p class="pacote-texto">Solução completa para marcas que querem crescer com força no digital.</p>
                <ul class="pacote-lista">
                    <li>Site avançado, páginas ilimitadas</li>
                    <li>Design exclusivo e estratégico</li>
                    <li>Integrações personalizadas (CRM, e-commerce etc.)</li>
                    <li>SEO avançado + performance otimizada</li>
                    <li>Suporte prioritário e acompanhamento contínuo</li>
                </ul>
                <div class="pacote-preco preco-premium">R$ 999,99</div>
            </div>
        </div>
        <div class="botao-modelos">
            <button class="entrar"><a href="nossosModelos.php">Ver Modelos</a></button>
        </div>
    </div>
</body>

</html>