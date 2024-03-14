<?php
session_start();

include './conexao/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comprar'])) {
    $idUsuario = $_POST['idUsuario'];
    $idCarro = $_POST['idCarro'];
    $formaPagamento = $_POST['formaPagamento'];

    $sqlInserirCompra = "INSERT INTO compras (idCliente, idCarro, formaPagamento) VALUES ('$idUsuario', '$idCarro', '$formaPagamento')";
    if ($conexao->query($sqlInserirCompra) === TRUE) {
        echo "<script>alert('Compra realizada com sucesso');</script>";
        echo "<script>window.location.href = 'minhascompras.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao realizar a compra');</script>";
        echo "<script>window.location.href = 'minhascompras.php';</script>";
        exit();
    }
}
?>