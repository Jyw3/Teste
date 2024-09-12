<?php 

include("conexao.php");

$id = $_GET["id"];
$tabela = $_GET["tabela"];
$sql = " DELETE FROM " . $tabela
        . " WHERE id=". $id;

if(!($conexao->query($sql) === TRUE )) {
    $conexao -> close();
    die("Erro ao Atualizar: ". $conexao->error);
}

$conexao->close();

header("Location: index.php?table=" . $tabela);


?>