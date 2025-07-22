<?php

// CRUD = Create Read Update Delete

// Criar uma conexão à base de dados
$con = mysqli_connect('127.0.0.1', 'root', '', 'recipe_app_dump');

// Verificar se a conexão foi concluída
if ($con) {
    echo "Conexão com a base de dados concluída!\n";
} else {
    echo "Erro na conexão com a base de dados\n";
    exit(); // Encerra o script se não houver conexão
}

$fim = true;

mysqli_close($con);
echo "Conexão com a base de dados encerrada.\n";



