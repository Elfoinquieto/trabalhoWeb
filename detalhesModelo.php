<?php
session_start();
require __DIR__ . "/src/conexao-bd.php";
require_once __DIR__ . "/src/Modelo/Usuario.php";
require_once __DIR__ . "/src/Modelo/Modelo.php";
require_once __DIR__ . "/src/Repositorio/UsuarioRepositorio.php";
require_once __DIR__ . "/src/Repositorio/ModeloRepositorio.php";

if (isset($_GET['id'])) {
    $id_limpo = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    if (filter_var($id_limpo, FILTER_VALIDATE_INT) === 0 || filter_var($id_limpo, FILTER_VALIDATE_INT) !== false) {
        $id = (int) $id_limpo;

    } else {
        header("Location: nossosModelos.php");
        exit();
    }

} else {

    header("Location: nossosModelos.php");
    exit();
}

$usuarioLogado = $_SESSION['usuario'] ?? null;
$repo = new UsuarioRepositorio($pdo);
$repoModelo = new ModeloRepositorio($pdo);
$modelo = $repoModelo->buscarPorId($id);

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
    <title> Koala WebStudio</title>
    <link rel="stylesheet" href="css/informativas.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="css/info.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
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
            <?php if ($usuario !== null && $usuario->getPermissao() === 'admin') { ?>
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

    <div class="modelo-destaque-content">
        <div class="modelo-destaque-imgbox">
            <img src="img-modelo/<?= htmlspecialchars($modelo->getImagem()) ?>" class="modelo-img">
        </div>
        <div class="modelo-destaque-info">
            <h2 class="modelo-destaque-titulo"><?= htmlspecialchars($modelo->getNome()) ?> </h2>
            <p class="modelo-destaque-desc">
                <?= htmlspecialchars($modelo->getDescricao()) ?>
            </p>
            <div class="modelo-destaque-sep"></div>

            <div class="modelo-destaque-botao">
                <button class="entrar">
                    <a
                        href="pedido-usuario/cadastrar.php?modelo_nome=<?php echo htmlspecialchars($modelo->getNome()); ?>">
                        Fazer Pedido
                    </a>
                </button>
            </div>
        </div>
    </div>
</body>

</html>