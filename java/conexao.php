<?php

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $bancodedados = "listadeabitos";
    
    $conexao = new mysqli($servidor, $usuario, $senha, $bancodedados);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    ?>