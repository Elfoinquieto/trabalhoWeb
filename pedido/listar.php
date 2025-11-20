<?php
session_start();
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
$pedidos = $pedidoRepositorio->listar();

//Itens por página da url
$itens_por_pagina = filter_input(INPUT_GET, 'itens_por_pagina', FILTER_VALIDATE_INT) ?: 5;

//Página atual da url -> valor padrão 1
$pagina_atual = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;

//Cálculo do offset(Quantos registros pular)
$offset = ($pagina_atual - 1) * $itens_por_pagina;

//Cálculo do total de usuários
$total_pedidos = $pedidoRepositorio->contarTotal();

//Cálculo do total de páginas
$total_paginas = ceil($total_pedidos / $itens_por_pagina);

//Parâmetros de ordenação
$ordem = filter_input(INPUT_GET, 'ordem') ?: null;
$direcao = filter_input(INPUT_GET, 'direcao') ?: 'ASC';

// Busca produtos com ordenação
$pedidos = $pedidoRepositorio->buscarPaginado($itens_por_pagina, $offset, $ordem, $direcao);

// Função para gerar URLs de ordenação
function gerarUrlOrdenacao($campo, $paginaAtual, $ordemAtual, $direcaoAtual, $itensPorPagina)
{
    $novaDirecao = ($ordemAtual === $campo && $direcaoAtual === 'ASC') ? 'DESC' : 'ASC';
    return "?pagina={$paginaAtual}&ordem={$campo}&direcao={$novaDirecao}&itens_por_pagina={$itensPorPagina}";
}
// Mostrar ícone de ordenação
function mostrarIconeOrdenacao($campo, $ordemAtual, $direcaoAtual)
{
    if ($ordemAtual === $campo) {
        return $direcaoAtual === 'ASC' ? '↑' : '↓';
    }
    return '';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/admin-style.css">


    <title>Admin</title>
</head>

<body>
    <main>
        <div class="topo-direita">
            <form action="../logout.php" method="post" style="display:inline;">
                <button type="submit" class="botao-sair">Sair</button>
            </form>
        </div>
        <section class="navbar">
            <a href="../admin.php">Painel</a>
            <a href="../usuario/listar.php">Usuarios</a>
            <a href="../modelo/listar.php">Modelos</a>
        </section>
        <section class="container">
            <h3 class="titulo">Gerenciamento de Usuários</h3>
        </section>

        <form class="form-paginacao" method="GET" action="">
            <label for="itens_por_pagina">Itens por página:</label>
            <select name="itens_por_pagina" id="itens_por_pagina" onchange="this.form.submit()">
                <option value="5" <?= $itens_por_pagina == 5 ? 'selected' : '' ?>>5</option>
                <option value="10" <?= $itens_por_pagina == 10 ? 'selected' : '' ?>>10</option>
                <option value="20" <?= $itens_por_pagina == 20 ? 'selected' : '' ?>>20</option>
            </select>
            <input type="hidden" name="ordem" value="<?= htmlspecialchars($ordem) ?>">
            <input type="hidden" name="direcao" value="<?= htmlspecialchars($direcao) ?>">
        </form>

        <section class="tabela" style="display: flex; flex-direction: column; align-items: center;">
            <table>
                <thead>
                    <tr>
                        <th><a href="<?= gerarUrlOrdenacao('nome', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>"
                                style="color: inherit; text-decoration: none;">Nome
                                <?= mostrarIconeOrdenacao('nome', $ordem, $direcao) ?></a></th>
                        <th><a href="<?= gerarUrlOrdenacao('pacote', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>"
                                style="color: inherit; text-decoration: none;">Pacote
                                <?= mostrarIconeOrdenacao('pacote', $ordem, $direcao) ?></a></th>
                        <th>Descrição</th>
                        <th>Site</th>
                        <th>Modelo</th>
                        <th>Status</th>
                        <th colspan="2">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido->getNome()) ?></td>
                            <td><?= htmlspecialchars($pedido->getPacote()) ?></td>
                            <td><?= htmlspecialchars($pedido->getDescricao()) ?></td>
                            <td>
                                <?= htmlspecialchars($pedido->getSaite()) ?>
                                <?php if ($pedido->getSaite() == ''): ?>
                                    <input id="saite" name="saite" type="file" webkitdirectory multiple>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($pedido->getModelo()) ?></td>
                            <td>
                                <form action="mudarStatos.php" method="POST"
                                    style="display: flex; align-items: center; justify-content: space-around;">
                                    <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
                                    <select name="statos" class="select-permissao">
                                        <option value="pendente" <?= $pedido->getStatos() === 'pendente' ? 'selected' : '' ?>>Pendente
                                        </option>
                                        <option value="entregue" <?= $pedido->getStatos() === 'entregue' ? 'selected' : '' ?>>
                                            Entregue</option>
                                    </select>
                                </form>

                            </td>
                            <td>
                                <form action="mudarStatos.php" method="POST">
                                    <button type="submit" class="editar">Enviar Mudanças</button>
                                </form>
                                <br/>
                                <form action="negar.php" method="post">
                                    <input type="hidden" name="id" value="<?= $pedido->getId() ?>">
                                    <input type="submit" class="excluir" value="Negar Pedido">
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</body>

</html>