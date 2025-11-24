<?php
session_start();
if (!isset($_SESSION['ocultos'])) {
    $_SESSION['ocultos'] = [];
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
$usuarioLogado = $_SESSION['usuario'] ?? null;
if (!$usuarioLogado) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Pedido.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

$usuarioLogado = $_SESSION['usuario'];
$repo = new UsuarioRepositorio($pdo);
$usuario = $repo->buscarPorEmail($usuarioLogado);
$pedidoRepositorio = new PedidoRepositorio($pdo);
$pedidos = $pedidoRepositorio->listarPorEmail($usuarioLogado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/admin-style.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/info.css">


    <title>Meus Pedidos</title>
</head>

<body>
    <main>
        <div class="navbar-info">
            <img src="../img/logo.jpeg" alt="Koala WebStudio" />
            <div class="links">
                <a href="../index.php">Home</a>
                <a href="../nossosTrabalhos.php">Nossos Trabalhos</a>
                <a href="../pacotes.php">Pacotes</a>
                <a href="#">Modelos</a>
                <a href="../sobreNos.php">Sobre Nós</a>
                <a href="../pedido-usuario/listar.php">Meus Pedidos</a>
            </div>
            <div class="topo-direita">
                <?php if ($usuario !== null && $usuario->getPermissao() === 'admin') {
                    ?>
                    <img src="../img/admin.png" alt="admin-logo" style="width: 40px; height: auto;"
                        onclick="location.href='../admin.php'">
                <?php } ?>
                <img src="../img/user (2).png" alt=""
                    style="width:40px; height:40px; margin-right: 10px; cursor:pointer;"
                    onclick="location.href='../usuario/editar.php'">
                <form action="../logout.php" method="post" style="display:inline;">
                    <button type="submit" class="botao-sair">Sair</button>
                </form>
            </div>
        </div>
        <?php if ($usuario !== null && $usuario->getPermissao() != 'admin'): ?>
            <section class="container">
                <h3 class="titulo2">Meus Pedidos</h3>
            </section>
            <?php if (empty($pedidos)): ?>
                <div class="container">
                    <p class="mensagem-pedido">Você não possui pedidos.</p>
                    <form action="cadastrar.php" method="POST">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($usuarioLogado); ?>">
                        <button class="entrar" type="submit">
                            ✚ Criar Pedido
                        </button>
                    </form>
                </div>

            <?php else: ?>
                <section class="tabela">
                    <button class="entrar">
                        <a href="cadastrar.php">✚ Criar Pedido</a>
                    </button>
                    <br>
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pedido->getNome()) ?></td>
                                    <td><?= htmlspecialchars($pedido->getStatos()) ?></td>
                                    <td>
                                        <?php if ($pedido->getStatos() === 'entregue'): ?>
                                            <button class="editar">Upload</button>
                                            <form action="deletar.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
                                                <button class="excluir">Deletar Pedido</button>
                                            </form>
                                        <?php else: ?>
                                            <form action="deletar.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
                                                <button class="excluir">Cancelar Pedido</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            <?php endif; ?>
        <?php else: ?>
            <div class="container">
                <p class="mensagem-pedido">Admins não podem realizar pedidos</p>
                <form action="../logout.php" method="post" style="display:inline;">
                    <button type="submit" class="editar">Refazer Login</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>