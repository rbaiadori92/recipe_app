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
    echo "Criar Categoria -> 5\n";
    echo "Listar Categorias -> 6\n";
    echo "Associar Receita a Categoria -> 7\n";
    echo "Desassociar Receita da Categoria -> 8\n";
    echo "Consultar Receita por Categoria -> 9\n";
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
        case 5:
            criarCategoria($con);
            break;
        case 6:
            listarCategorias($con);
            break;
        case 7:
            associarReceitaCategoria($con);
            break;
        case 8:
            desassociarReceitaCategoria($con);
            break;
        case 9:
            consultarReceitasPorCategoria($con);
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
function criarCategoria($con) {
    $nome = readline("Nome da categoria: ");
    $sql = "INSERT INTO categoria (nome_categoria) VALUES ('$nome')";

    if (mysqli_query($con, $sql)) {
        echo "Categoria criada com sucesso!\n";
    } else {
        echo "Erro ao criar categoria: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

function listarCategorias($con) {
    $sql = "SELECT id, nome FROM categoria";
    $resultado = mysqli_query($con, $sql);

    //echo "\n=== Categorias ===\n";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome'] . "\n";
    }

    voltarMenu();
}

function associarReceitaCategoria($con) {
    listarReceitas($con);
    $id_receita = readline("ID da receita a associar: ");
    listarCategorias($con);
    $id_categoria = readline("ID da categoria: ");

    $sql = "INSERT INTO receita_categoria (id_receita, id_categoria) VALUES ($id_receita, $id_categoria)";
    if (mysqli_query($con, $sql)) {
        echo "Receita associada à categoria com sucesso!\n";
    } else {
        echo "Erro ao associar à categoria: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

function desassociarReceitaCategoria($con) {
    $id_receita = readline("ID da receita: ");
    $id_categoria = readline("ID da categoria a desassociar: ");

    $sql = "DELETE FROM receita_categoria WHERE id_receita = $id_receita AND id_categoria = $id_categoria";
    if (mysqli_query($con, $sql)) {
        echo "Associação removida com sucesso!\n";
    } else {
        echo "Erro ao remover associação: " . mysqli_error($con) . "\n";
    }

    voltarMenu();
}

function consultarReceitasPorCategoria($con) {
    listarCategorias($con);
    $id_categoria = readline("ID da categoria para listar receitas: ");

    $sql = "
        SELECT r.id, r.nome_receita, r.tempo_preparo, r.doses, r.modo_preparo
        FROM receita r
        INNER JOIN receita_categoria rc ON r.id = rc.id_receita
        WHERE rc.id_categoria = $id_categoria
    ";

    $resultado = mysqli_query($con, $sql);

    //echo "\n=== Receitas da Categoria ===\n";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome_receita'] . " | Tempo: " . $row['tempo_preparo'] . " min | Doses: " . $row['doses'] . " | Modo Preparo: " . $row['modo_preparo'] . "\n\n";
    }

    voltarMenu();
}

//mysqli_close($con);
//echo "Conexão com a base de dados encerrada.\n";