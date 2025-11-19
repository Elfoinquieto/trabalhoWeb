<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Usuario.php";
require_once __DIR__ . "/../src/Repositorio/UsuarioRepositorio.php";

$usuarioRepositorio = new UsuarioRepositorio($pdo);
$usuarios = $usuarioRepositorio->listar();

//Itens por página da url
$itens_por_pagina = filter_input(INPUT_GET, 'itens_por_pagina', FILTER_VALIDATE_INT) ?: 5;

//Página atual da url -> valor padrão 1
$pagina_atual = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;

//Cálculo do offset(Quantos registros pular)
$offset = ($pagina_atual - 1) * $itens_por_pagina;

//Cálculo do total de usuários
$total_usuarios = $usuarioRepositorio->contarTotal();

//Cálculo do total de páginas
$total_paginas = ceil($total_usuarios / $itens_por_pagina);

//Parâmetros de ordenação
$ordem = filter_input(INPUT_GET, 'ordem') ?: null;
$direcao = filter_input(INPUT_GET, 'direcao') ?: 'ASC';

// Busca produtos com ordenação
$usuarios = $usuarioRepositorio->buscarPaginado($itens_por_pagina, $offset, $ordem, $direcao);

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
        <section class="navbar">
            <a href="../admin.php">Painel</a>
            <a href="../admin.php">Modelos</a>
            <a href="../admin.php">Pedidos</a>
        </section>
        <section class="container">
            <h3>Administração - Koala WebStudio</h3>
            <button class="entrar"><a href="../admin.php">Gerenciar Geral</a></button>
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
                        <th>Nome Completo</th>
                        <th>Telefone</th>
                        <th><a href="<?= gerarUrlOrdenacao('email', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>"
                                style="color: inherit; text-decoration: none;">Email
                                <?= mostrarIconeOrdenacao('email', $ordem, $direcao) ?></a></th>
                        <th><a href="<?= gerarUrlOrdenacao('permissao', $pagina_atual, $ordem, $direcao, $itens_por_pagina) ?>"
                                style="color: inherit; text-decoration: none;">Permissão
                                <?= mostrarIconeOrdenacao('permissao', $ordem, $direcao) ?></a></th>
                        <th>Alterar Permissão</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario->getNomeCompleto()) ?></td>
                            <td><?= htmlspecialchars($usuario->getTelefone()) ?></td>
                            <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                            <td><?= htmlspecialchars($usuario->getPermissao()) ?></td>
                            <td>
                                <form action="mudarPermissao.php" method="POST"
                                    style="display: flex; align-items: center; justify-content: space-around;">
                                    <input type="hidden" name="id" value="<?= $usuario->getId() ?>">
                                    <select name="permissao" class="select-permissao">
                                        <option value="user" <?= $usuario->getPermissao() === 'user' ? 'selected' : '' ?>>User
                                        </option>
                                        <option value="admin" <?= $usuario->getPermissao() === 'admin' ? 'selected' : '' ?>>
                                            Admin</option>
                                    </select>
                                    <button type="submit" class="editar">OK</button>
                                </form>

                            </td>
                            <td>
                                <form action="deletar.php" method="post">
                                    <input type="hidden" name="id" value="<?= $usuario->getId() ?>">
                                    <input type="submit" class="excluir" value="Excluir">
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