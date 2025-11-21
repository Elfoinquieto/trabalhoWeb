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

require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Pedido.php";
require_once __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";


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
    <link rel="stylesheet" href="../css/info.css">


    <title>Meus Pedidos</title>
</head>

<body>
    <main>
        <div class="topo-direita">
            <form action="../logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
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
                            <?php if (!in_array($pedido->getId(), $_SESSION['ocultos'])): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pedido->getNome()) ?></td>
                                    <td><?= htmlspecialchars($pedido->getStatos()) ?></td>
                                    <td>
                                        <?php if ($pedido->getStatos() === 'entregue'): ?>
                                            <button class="editar">Upload</button>
                                        <?php else: ?>
                                            <button class="excluir">Cancelar Pedido</button>
                                        <?php endif; ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    </main>

</body>

</html>