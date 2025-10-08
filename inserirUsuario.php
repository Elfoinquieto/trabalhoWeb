<?php
    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Usuario.php';

     //Dados vindos do formulário
    $email = trim($_POST['email'] ?? '');
    $nome_completo = trim($_POST['nome_completo'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $repo = new UsuarioRepositorio($pdo);

    if($repo->buscarPorEmail($email)){
        header('Location: cadastrar.php?erro=existente');
        exit; 
    }

    //Validar campos obrigatórios
   if($email === '' || $senha === '' || $nome_completo === '' || $telefone === ''){
        header('Location: cadastrar.php?erro=campos');
        exit;
   }

    $repo->salvar(new Usuario(0, $email, $senha, $nome_completo, $telefone)); 


    header('Location: login.php');
    

?>