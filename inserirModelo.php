<?php
    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/ModeloRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Modelo.php';

     //Dados vindos do formulário
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $caminho_imagem = trim($_POST['caminho_imagem'] ?? '');
    $pacote = $_POST['pacote'] ?? '';

    $repo = new ModeloRepositorio($pdo);

    if($repo->buscarPornome($nome)){
        echo "Nome já existe! {$nome}\n";
        exit; 
    }

    //Validar campos obrigatórios
   if($nome === '' || $pacote === '' || $descricao === '' || $caminho_imagem === ''){
        header('Location: cadastrar-modelo.php?erro=campos');
        exit;
   }

    $repo->salvar(new Modelo(0, $nome, $pacote, $descricao, $caminho_imagem)); 

    echo "Modelo inserido: {$nome}\n";

    header('Location: admin-modelos.php');

?>
