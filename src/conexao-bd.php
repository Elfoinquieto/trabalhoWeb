<?php
    $pdo = new PDO(
        'mysql:host=localhost;dbname=koaladb;charset=utf8mb4','root','gu150883',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

?>