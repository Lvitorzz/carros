<?php
include './conexao/conexao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if ($conexao->query($sql) === TRUE) {
        echo "<script>alert('Usuário cadastrado com sucesso');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuario: . $conexao->error .');</script>";
    }
}

?>
