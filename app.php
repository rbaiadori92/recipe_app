<?php

$con = mysqli_connect ('127.0.0.1', 'root', '', 'recipe_app_dump');

if ($con) {
    echo "Conexão com a base de dados concluída!\n";
} else {
    echo "Erro na conexão com a base de dados\n";
    exit(); 
}

function voltarMenu() {
    $input = "";
    echo "Selecione 0 para voltar ao menu: ";
    while ($input != "0") {
        $input = readline("");
    }
}

function exibirMenu() {
    echo "\n1 -- Criar Receita\n";
    echo "2 -- Listar Receitas\n";
    echo "3 -- Editar Receita\n";
    echo "4 -- Apagar Receita\n";
    echo "5 -- Criar Categoria\n";
    echo "6 -- Listar Categorias\n";
    echo "7 -- Associar Receita a Categoria\n";
    echo "8 -- Desassociar Receita da Categoria\n";
    echo "9 -- Consultar Receita por Categoria\n";
    echo "10 - Adicionar Ingrediente\n";
    echo "11 - Listar Ingredientes\n";
    echo "12 - Associar Ingrediente à Receita\n";
    echo "13 - Atualizar Ingrediente\n";
    echo "14 - Remover Ingrediente\n";
    echo "15 - Mostrar Detalhes da Receita\n";
    echo "16 - Pesquisar Receita por Ingrediente\n";
    echo "17 - Pesquisar Receita por Parte do Título\n";
    echo "0 -- Sair do programa\n";
}

do {
    exibirMenu();
    $opcao = readline("Escolha uma opção: ");

    switch ($opcao) {
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
        case 10:
            adicionarIngrediente($con);
            break;
        case 11:
            listarIngredientes($con);
            break;
        case 12:
            associarIngrediente($con);
            break;
        case 13:
            atualizarIngrediente($con);
            break;
        case 14:
            removerIngrediente($con);
            break;
        case 15:
            mostrarDetalhesReceita($con);
            break;
        case 16:
            pesquisarReceitasPorIngrediente($con);
            break;
        case 17:
            pesquisarReceitasPorParteTitulo($con);
            break;
        case 0:
            echo "Adeus!\n";
            break;
        default:
            echo "Opção inválida, tente novamente.\n";
            break;
    }
} while ($opcao != 0);


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
function listarReceitasSimples($con) {
    $sql = "SELECT id, nome_receita FROM receita";
    $resultado = mysqli_query($con, $sql);
    
    echo "\n=== Receitas ===\n";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome_receita'] . "\n";
    }
}
function listarCategoriasSimples($con) {
    $sql = "SELECT ID, nome FROM categoria";
    $resultado = mysqli_query($con, $sql);
    
    echo "\n=== Categorias ===\n";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "ID: " . $row['ID'] . " | Nome: " . $row['nome'] . "\n";
    }
}
function listarIngredientesSimples($con) {
    $sql = "SELECT id, Ingredientes FROM ingrediente";
    $resultado = mysqli_query($con, $sql);
    
    echo "\n=== Ingredientes ===\n";
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "ID: " . $row['id'] . " | Nome: " . $row['Ingredientes'] . "\n";
    }
}
function listarReceitas($con) {
    $sql = "SELECT id, nome_receita, tempo_preparo, doses, modo_preparo FROM receita";
    $verificacao = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($verificacao)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome_receita'] . " | Tempo: " . $row['tempo_preparo'] . " min | Doses: " . $row['doses'] . " | Modo Preparo: " . $row['modo_preparo'] . "\n\n";
    }
    voltarMenu();
}

function editarReceita($con) {
    listarReceitas($con);
    $id = readline("ID da receita a atualizar: ");

    $sql = "SELECT * FROM receita WHERE ID = $id";
    $verificacao = mysqli_query($con, $sql);

    if (mysqli_num_rows($verificacao) == 0) {
        echo "Receita não encontrada.\n";
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
    listarReceitasSimples($con);
    $id = readline("ID da receita a apagar: ");

    $sql = "SELECT id FROM receita WHERE ID = $id";
    $verificacao = mysqli_query($con, $sql);

    if (mysqli_num_rows($verificacao) == 0) {
        echo "Receita não encontrada.\n";
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
    $sql = "INSERT INTO categoria (nome) VALUES ('$nome')"; 

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

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome'] . "\n";
    }
    voltarMenu();
}

function associarReceitaCategoria($con) {
    listarReceitasSimples($con);
    $id_receita = readline("ID da receita a associar: ");
    listarCategoriasSimples($con);
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
    listarReceitasSimples($con);
    $id_receita = readline("ID da receita: ");
    listarCategoriasSimples($con);
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
    listarCategoriasSimples($con);
    $id_categoria = readline("ID da categoria para listar receitas: ");

    $sql = "
        SELECT r.id, r.nome_receita, r.tempo_preparo, r.doses, r.modo_preparo
        FROM receita r
        INNER JOIN receita_categoria rc ON r.id = rc.id_receita
        WHERE rc.id_categoria = $id_categoria
    ";

    $resultado = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['nome_receita'] . " | Tempo: " . $row['tempo_preparo'] . " min | Doses: " . $row['doses'] . " | Modo Preparo: " . $row['modo_preparo'] . "\n\n";
    }
    voltarMenu();
}
function adicionarIngrediente($con) {
    $nome_ingrediente = readline("Nome do ingrediente: ");

    $sql = "INSERT INTO ingrediente (Ingredientes) VALUES ('$nome_ingrediente')";
    
    if (mysqli_query($con, $sql)) {
        echo "Ingrediente adicionado com sucesso!\n";
    } else {
        echo "Erro ao adicionar ingrediente: " . mysqli_error($con) . "\n";
    }
    voltarMenu();
}
function listarIngredientes($con) {
    $sql = "SELECT id, Ingredientes FROM ingrediente";
    $resultado = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($resultado)) {
        echo "id: " . $row['id'] . " | Nome: " . $row['Ingredientes'] . "\n";
    }
    voltarMenu();
}
function associarIngrediente($con) {
    listarReceitasSimples($con);
    $id_receita = readline("ID da receita: ");

    $sql = "SELECT id FROM receita WHERE id = $id_receita";
    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0) {
        echo "Receita não encontrada.\n";
    }

    listarIngredientesSimples($con);
    $id_ingrediente = readline("ID do ingrediente: ");

    $sql = "SELECT id FROM ingrediente WHERE id = $id_ingrediente";
    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0) {
        echo "Ingrediente não encontrado.\n";
    }

    $sql = "INSERT INTO receita_ingrediente (id_receita, id_ingrediente) VALUES ($id_receita, $id_ingrediente)";
    if (mysqli_query($con, $sql)) {
        echo "Ingrediente associado à receita com sucesso!\n";
    } else {
        echo "Erro ao associar ingrediente: " . mysqli_error($con) . "\n";
    }
    voltarMenu();
}
function atualizarIngrediente($con) {
    listarIngredientesSimples($con);
    $id = readline("ID do ingrediente a atualizar: ");

    $sql = "SELECT * FROM ingrediente WHERE id = $id";
    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0) {
        echo "Ingrediente não encontrado.\n";
    }

    $novo_nome = readline("Novo nome do ingrediente: ");
    $sql = "UPDATE ingrediente SET Ingredientes = '$novo_nome' WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        echo "Ingrediente atualizado com sucesso!\n";
    } else {
        echo "Erro ao atualizar ingrediente: " . mysqli_error($con) . "\n";
    }
    voltarMenu();
}
function removerIngrediente($con) {
    listarIngredientesSimples($con);
    $id = readline("ID do ingrediente a remover: ");

    $sql = "SELECT * FROM ingrediente WHERE id = $id";
    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0) {
        echo "Ingrediente não encontrado.\n";
    }

    $sql = "DELETE FROM receita_ingrediente WHERE id_ingrediente = $id";
    if (!mysqli_query($con, $sql)) {
        echo "Erro ao remover associação com receitas: " . mysqli_error($con) . "\n";
    }

    $sql = "DELETE FROM ingrediente WHERE id = $id";
    if (mysqli_query($con, $sql)) {
        echo "Ingrediente removido com sucesso!\n";
    } else {
        echo "Erro ao remover ingrediente: " . mysqli_error($con) . "\n";
    }
    voltarMenu();
}
function mostrarDetalhesReceita($con) {
    listarReceitasSimples($con);
    $id_receita = readline("Digite o ID da receita: ");

    $sql = "SELECT * FROM receita WHERE id = $id_receita";
    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) == 0) {
        echo "Receita não encontrada.\n";
    }

    $receita = mysqli_fetch_assoc($resultado);
    echo "\n--- Informações da Receita ---\n";
    echo "Nome: " . $receita['nome_receita'] . "\n";
    echo "Tempo de preparo: " . $receita['tempo_preparo'] . " minutos\n";
    echo "Doses: " . $receita['doses'] . "\n";
    echo "Modo de preparo:\n" . $receita['modo_preparo'] . "\n";

    $sql = "
        SELECT c.nome 
        FROM categoria c
        INNER JOIN receita_categoria rc ON c.id = rc.id_categoria
        WHERE rc.id_receita = $id_receita
    ";
    $categorias = mysqli_query($con, $sql);

    if (mysqli_num_rows($categorias) > 0) {
        while ($cat = mysqli_fetch_assoc($categorias)) {
            echo "- " . $cat['nome'] . "\n";
        }
    } else {
        echo "Nenhuma categoria associada.\n";
    }

    echo "\n--- Ingredientes ---\n";
    $sql = "
        SELECT i.ingredientes 
        FROM ingrediente i
        INNER JOIN receita_ingrediente ri ON i.id = ri.id_ingrediente
        WHERE ri.id_receita = $id_receita
    ";
    $ingredientes = mysqli_query($con, $sql);

    if (mysqli_num_rows($ingredientes) > 0) {
        while ($ing = mysqli_fetch_assoc($ingredientes)) {
            echo "- " . $ing['ingredientes'] . "\n";
        }
    } else {
        echo "Nenhum ingrediente associado.\n";
    }
    voltarMenu();
}

function pesquisarReceitasPorIngrediente($con) {
    $palavra = readline("Digite o nome do ingrediente: ");

    $sql = "
        SELECT DISTINCT r.id, r.nome_receita
        FROM receita r
        INNER JOIN receita_ingrediente ri ON r.id = ri.id_receita
        INNER JOIN ingrediente i ON i.id = ri.id_ingrediente
        WHERE i.ingredientes LIKE '%$palavra%'
    ";

    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo "\nReceitas que usam '$palavra':\n";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "- ID: " . $row['id'] . " | Nome: " . $row['nome_receita'] . "\n";
        }
    } else {
        echo "Nenhuma receita encontrada com o ingrediente '$palavra'.\n";
    }
    voltarMenu();
}
function pesquisarReceitasPorParteTitulo($con) {
    $palavra = readline("Digite parte do nome da receita: ");

    $sql = "
        SELECT id, nome_receita
        FROM receita
        WHERE nome_receita LIKE '%$palavra%'
    ";

    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo "\nReceitas encontradas:\n";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "- ID: " . $row['id'] . " | Nome: " . $row['nome_receita'] . "\n";
        }
    } else {
        echo "Nenhuma receita encontrada com '$palavra' no título.\n";
    }
    voltarMenu();
}