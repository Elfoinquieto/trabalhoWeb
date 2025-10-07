<?php 
    session_start();

    require_once __DIR__ . '/src/conexao-bd.php';
    require_once __DIR__ . '/src/Repositorio/UsuarioRepositorio.php';
    require_once __DIR__ . '/src/Modelo/Usuario.php';

    //Permite somente POST
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header('Location: login.php');
        exit;
    }

    //Dados vindos do formulário
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

   //Validar campos obrigatórios
   if($email === '' || $senha === ''){
        header('Location: login.php?erro=campos');
        exit;
   }


   $repo = new UsuarioRepositorio($pdo);

   //Validar credenciais
   if($repo->autenticar($email, $senha)){
        session_regenerate_id(true);
        $_SESSION['usuario'] = $email;
        // echo '<pre>';
        // var_dump($_SESSION);
        // echo '</pre>';
        header('Location: admin.php');
        exit;
   }

//Erro de credenciais
   header('Location: login.php?erro=credenciais');
   exit;

?>