<?php
include("conexao.php");

// Obtendo o valor do nome e tabela enviados via POST
$nome = $_POST["tarefa"];
$tabela = $_POST["tabela"];

// Verifica se o nome não está vazio
if (empty($nome)) {
    die("Erro: O campo tarefa não pode estar vazio.");
}

// Verifica se a tabela não está vazia e se a tabela realmente existe
$tabela = mysqli_real_escape_string($conexao, $tabela);
$verifica_tabela = $conexao->query("SHOW TABLES LIKE '$tabela'");

if ($verifica_tabela->num_rows == 1) {
    // Usando prepared statement para evitar SQL Injection
    $sql = $conexao->prepare("INSERT INTO $tabela (nome, status) VALUES (?, 'A')");
    $sql->bind_param("s", $nome);

    // Executando a query e verificando se houve sucesso
    if (!$sql->execute()) {
        $sql->close();
        $conexao->close();
        die("Erro: " . $conexao->error);
    }

    // Fechando a conexão e redirecionando para index.php
    $sql->close();
    $conexao->close();

    header("Location: index.php?table=" . urlencode($tabela));
    exit;
} else {
    die("Erro: Tabela não encontrada.");
}
?>
