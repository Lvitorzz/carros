<?php
session_start();

include './conexao/conexao.php';

function loginUsuario($conexao, $email, $senha)
{
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = loginUsuario($conexao, $email, $senha);
    if ($usuario) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['administrador'] = $usuario['administrador'];
        $_SESSION['logado'] = true;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Email ou senha incorretos');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    }
}
