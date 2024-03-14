<?php
session_start();

include './conexao/conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.html");
    exit();
}

$idUsuario = $_SESSION['id'];

$sql = "SELECT * FROM usuarios WHERE id='$idUsuario'";
$resultado = $conexao->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    $nomeUsuario = $usuario['nome'];
    $emailUsuario = $usuario['email'];
} else {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];

    $sqlEditar = "UPDATE usuarios SET nome='$novoNome', email='$novoEmail' WHERE id='$idUsuario'";
    if ($conexao->query($sqlEditar) === TRUE) {
        $_SESSION['nome'] = $novoNome;
        $_SESSION['email'] = $novoEmail;

        echo "<script>alert('Usuario editado com sucesso');</script>";
        echo "<script>window.location.href = 'informacoes.php';</script>";
    } else {
        echo "<script>alert('Erro ao editar usuarios');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir'])) {
    $sqlExcluir = "DELETE FROM usuarios WHERE id='$idUsuario'";
    if ($conexao->query($sqlExcluir) === TRUE) {
        session_unset();
        session_destroy();
        header("Location: login.html");
        exit();
    } else {
        echo "<script>alert('Erro ao excluir usuário');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Usuário</title>
    <link rel="stylesheet" href="css/padrao.css">
    <link rel="stylesheet" href="css/informacoes.css">
</head>

<body>
<header>
        <section class="cabecalho">
            <div class="marca">
                <H1 class="marca-titulo">
                    StockCar
                </H1>
            </div>
            <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) : ?>
                <nav class="navegacao">
                    <a class="navegacao-compras" href="minhascompras.php">MINHAS COMPRAS</a>
                    <a class="navegacao-informacoes" href="index.php">PAGINA INICIAL</a>
                    <?php if ($_SESSION['administrador'] == 1) : ?>
                        <a class="navegacao-administracao" href="paineladministracao.php">ACESSAR O PAINEL DE ADMINISTRAÇÃO</a>
                    <?php endif; ?>
                    <a class="navegacao-sair" href="logout.php">SAIR</a>
                </nav>
                <p>Usuário: <?php echo $_SESSION['nome']; ?> </p>
            <?php else : ?>
                <nav class="navegacao">
                    <a class="navegacao-cadastro" href="cadastro.html">CADASTRO</a>
                    <a class="navegacao-login" href="login.html">LOGIN</a>
                </nav>
            <?php endif; ?>
        </section>

    </header>

    <main>
        <section class="container">
            <h2>Editar Informações de usuario</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="campo-formulario">
                    <label for="nome">Alterar nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $nomeUsuario; ?>">
                </div>
                <div class="campo-formulario">
                    <label for="email">Alterar email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $emailUsuario; ?>">
                </div>
                <div class="campo-formulario">
                    <button type="submit" name="editar">Editar</button>
                    <button class="excluir" type="submit" name="excluir" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir Conta</button>
                </div>

            </form>
        </section>
    </main>

    <footer>
    </footer>
</body>

</html>