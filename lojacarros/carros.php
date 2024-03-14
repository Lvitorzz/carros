<?php
include './conexao/conexao.php';
global $conexao;
$conexao = $conexao;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $valor = $_POST['valor'];
    $linkImagem = $_POST['linkImagem'];

    $sql = "INSERT INTO carros (marca, modelo, ano, valor, linkImagem) VALUES ('$marca', '$modelo', $ano, $valor, '$linkImagem')";
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Carro cadastrado com sucesso');</script>";
        echo "<script>window.location.href = 'paineladministracao.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar carro: . $conexao->error .');</script>";
    }
}
?>
