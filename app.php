<?php

$con = mysqli_connect('127.0.0.1', 'root', '', 'recipe_app_dump');

if ($con) {
    echo "Conexão com a base de dados concluída!\n";
} else {
    echo "Erro na conexão com a base de dados\n";
    exit(); 
}

$fim = false;
while (!$fim) {
    echo "\nCriar Receita -> 1\n";
    echo "Listar Receitas -> 2\n";
    echo "Editar Receita -> 3\n";
    echo "Apagar Receita -> 4\n";
    echo "Sair do programa -> 0\n";

    $opcao = readline("Escolha uma opção: ");

    switch ($opcao) {
        case 0:
            echo "Adeus!\n";
            $fim = true;
            break;
        case 1:
            criarReceita($con);
            break;
        case 2:
            listarReceitas($con);
            break;
        case 3:
            editarReceita($con);
            break;
        case 4:
            apagarReceita($con);
            break;
        default:
            echo "Opção inválida!\n";
            break;
    }
}

function voltarMenu() {
    $input = "";
    echo "Selecione 0 para voltar ao menu: ";
    while ($input != "0") {
        $input = readline("");
    }
}

function criarReceita($con) {
    $nome_receita = readline("Nome da receita: ");
    $modo_preparo = readline("Modo de preparo: ");
    $tempo_preparo = readline("Tempo de preparo (minutos): ");
    $doses = readline("Doses: ");

    $sql = "INSERT INTO receita (nome_receita, modo_preparo, tempo_preparo, doses) 
            VALUES ('$nome_receita', '$modo_preparo', $tempo_preparo, $doses)";
    
    if (mysqli_query($con, $sql)) {
        echo "Receita inserida com sucesso!\n";
    } else {
        echo "Erro ao inserir receita: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

function listarReceitas($con) {
    $sql = "SELECT id, nome_receita, tempo_preparo, doses, modo_preparo FROM receita";
    $verificacao = mysqli_query($con, $sql);

    echo "\n=== Lista de Receitas ===\n";
    while ($row = mysqli_fetch_assoc($verificacao)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome_receita'] . " | Tempo: " . $row['tempo_preparo'] . " min | Doses: " . $row['doses'] . " | Modo Preparo: " . $row['modo_preparo'] . "\n\n";
    }
}

function editarReceita($con) {
    listarReceitas($con);
    $id = readline("ID da receita a atualizar: ");

    $sql = "SELECT * FROM receita WHERE ID = $id";
    $verificacao = mysqli_query($con, $sql);

    if (mysqli_num_rows($verificacao) == 0) {
        echo "Receita não encontrada.\n";
        return;
    }

    $nome_receita = readline("Nome da receita: ");
    $modo_preparo = readline("Modo de Preparo: ");
    $tempo_preparo = readline("Tempo de Preparo(minutos): ");
    $doses = readline("Doses: ");

    $sql = "UPDATE receita 
            SET nome_receita = '$nome_receita', modo_preparo = '$modo_preparo', tempo_preparo = $tempo_preparo, doses = $doses 
            WHERE ID = $id";

    if (mysqli_query($con, $sql)) {
        echo "Receita atualizada com sucesso!\n";
    } else {
        echo "Erro ao atualizar receita: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

function apagarReceita($con) {
    listarReceitas($con);
    $id = readline("ID da receita a apagar: ");

    $sql = "SELECT id FROM receita WHERE ID = $id";
    $verificacao = mysqli_query($con, $sql);

    if (mysqli_num_rows($verificacao) == 0) {
        echo "Receita não encontrada.\n";
        return;
    }

    $sql = "DELETE FROM receita WHERE ID = $id";
    if (mysqli_query($con, $sql)) {
        echo "Receita apagada com sucesso!\n";
    } else {
        echo "Erro ao apagar receita: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

//mysqli_close($con);
//echo "Conexão com a base de dados encerrada.\n";
