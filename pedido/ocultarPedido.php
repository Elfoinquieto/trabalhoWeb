<?php
session_start();
$id = $_POST['id'] ?? null;
if ($id && !in_array($id, $_SESSION['ocultos'])) {
    $_SESSION['ocultos'][] = $id;
}
header("Location: listar.php");
exit;
