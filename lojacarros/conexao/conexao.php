<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco_de_dados = "stockcar";

$conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);

if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

return $conexao;
$conexao->close();
?>