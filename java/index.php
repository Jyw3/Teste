<?php
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles1.css">
    <link rel="stylesheet" href="styles2.css">
    <title>Listas</title>
</head>
<body>

<div class="central">
<h1><?php echo htmlspecialchars($_GET['table']); ?></h1>

<?php
if (isset($_GET['table'])) {
    $tabela = mysqli_real_escape_string($conexao, $_GET['table']);

    // Verifica se a tabela existe
    $verifica_tabela = $conexao->query("SHOW TABLES LIKE '$tabela'");
    if ($verifica_tabela->num_rows == 1) {
        // A tabela existe, faz a consulta nela
        $sql = "SELECT id, nome FROM " . $tabela . " WHERE status = 'a' ";
        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {
            echo "<table>"; // Abrindo a tabela antes de iterar os resultados

            while ($registro = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($registro["nome"]) . "</td>";
                echo "<td>
                        <a href='excluir.php?id=" . urlencode($registro["id"]) . "&tabela=" . urlencode($tabela) . "'>
                            <img src='/faculdade/java/lixo.png' alt='Excluir' style='width: 40px; height: 40px;'>
                        </a>
                      </td><br>";
                echo "</tr>";
            }

            echo "</table>"; // Fecha a tabela
        } else {
            echo "<p>Nenhuma tarefa encontrada na lista atual " . htmlspecialchars($tabela) . ".</p>";
        }

        ?>
        <form action="inserttarefa.php" method="post">
            <p>
                <input type="text" id="tarefa" name="tarefa" required>
                <!-- Passando o nome da tabela corretamente -->
                <input type="hidden" name="tabela" value="<?php echo htmlspecialchars($tabela); ?>">
                <button type="submit">Criar</button>
            </p>
        </form>
        <?php

    } else {
        echo "<p>Lista inválida ou não encontrada.</p>";
    }
} else {
    echo "<p>Nenhuma lista selecionada.</p>";
}

// Fecha a conexão
$conexao->close();
?>

</div>

<div class="barra">
    <h1>Listas</h1>

    <?php
    include("conexao.php");
    $sql = "SHOW TABLES";
    $resultado = $conexao->query($sql);

    if ($resultado) {
        echo "<ul>";

        // Itera sobre o resultado e exibe os nomes das tabelas como links
        while ($row = $resultado->fetch_assoc()) {
            $tabela = array_values($row)[0]; // Pega o nome da tabela
            $nome_tabela_encoded = urlencode($tabela); // Codifica o nome da tabela para a URL
            echo "<li><a href='index.php?table=" . htmlspecialchars($nome_tabela_encoded) . "'>" . htmlspecialchars($tabela) . "</a></li>";
        }

        echo "</ul>";
        ?>
        <form action="criartabela.php" method="post">
            <p>
                <input type="text" id="nome" name="nome" required>
                <button type="submit">Criar</button>
            </p>
        </form>
        <?php

    } else {
        echo "Erro ao listar as tabelas: " . $conexao->error;
    }

    // Fecha a conexão
    $conexao->close();
    ?>
</div>

</body>
</html>
