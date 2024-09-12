<?php
include("conexao.php");

// Obtendo os valores enviados via POST
$nome = $_POST["nome"];
$tabela = $_POST["tabela"];

// Verifica se o nome não está vazio
if (empty($nome)) {
    die("Erro: O campo nome não pode estar vazio.");
}

// Escapando o nome da tabela para evitar SQL Injection
$nome = mysqli_real_escape_string($conexao, $nome);

// Montando o SQL para criar a tabela. Não é possível usar prepared statements para CREATE TABLE
$sql = "CREATE TABLE IF NOT EXISTS `$nome` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    status VARCHAR(2)
)";

// Executando a query e verificando se houve sucesso
if (!$conexao->query($sql)) {
    $conexao->close();
    die("Erro ao criar a tabela: " . $conexao->error);
}

// Fechando a conexão
$conexao->close();

// Redirecionando para a página principal ou para a lista criada
header("Location: index.php?table=" . urlencode($tabela));
exit;
?>
