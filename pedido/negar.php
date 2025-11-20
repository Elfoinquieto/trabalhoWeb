<?php

require __DIR__ . "/../src/conexao-bd.php";
require __DIR__ . "/../src/Modelo/Pedido.php";
require __DIR__ . "/../src/Repositorio/PedidoRepositorio.php";

$pedidoRepositorio = new PedidoRepositorio($pdo);
$pedidoRepositorio->deletar($_POST['id']);

header("Location: listar.php");