<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login-usuario/login.php");
    exit;
}
require __DIR__ . "/../src/conexao-bd.php";
require_once __DIR__ . "/../src/Modelo/Modelo.php";
require_once __DIR__ . "/../src/Repositorio/ModeloRepositorio.php";

$modeloRepositorio = new ModeloRepositorio($pdo);
$modelos = $modeloRepositorio->listar();
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
        <section class="navbar"></section>
        <section class="container">
            <h3>Administração - Koala WebStudio</h3>
            <button class="entrar"><a href="../admin.php">Gerenciar Geral</a></button>
            <h3 class="titulo">Gerenciamento de Modelos</h3>
        </section>
        <section class="tabela">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Pacote</th>
                        <th>Descrição</th>
                        <th>Imagem</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <button class="criar"><a href="cadastrar.php">Novo Modelo</a></button>
                    <?php foreach ($modelos as $modelo): ?>
                        <tr>
                            <td><?= htmlspecialchars($modelo->getId()) ?></td>
                            <td><?= htmlspecialchars($modelo->getNome()) ?></td>
                            <td><?= htmlspecialchars($modelo->getPacote()) ?></td>
                            <td><?= htmlspecialchars($modelo->getDescricao()) ?></td>
                            <td><img src="<?= htmlspecialchars($modelo->getCaminhoImagem()) ?>" alt=""></td>
                            <td>
                                <div class="form-action">
                                    <form action="editar.php" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($modelo->getId()) ?>">
                                        <button class="editar" type="submit">Editar</button>
                                    </form>
                                    <form action="deletar.php" method="POST">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($modelo->getId()) ?>">
                                        <button class="excluir" type="submit">Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    </main>

</body>

</html>