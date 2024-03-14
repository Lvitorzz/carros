<?php
include './conexao/conexao.php';
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo "<script>alert('Você precisa estar logado para comprar um carro!'); window.location.href = 'login.html';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $idCarro = $_GET['id'];

    $sql = "SELECT * FROM carros WHERE id = $idCarro";
    $resultado = $conexao->query($sql);

    if ($resultado->num_rows > 0) {
        $carro = $resultado->fetch_assoc();
    } else {
        echo "Carro não encontrado!";
        exit();
    }
} else {
    echo "ID do carro não fornecido!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Carro</title>
    <link rel="stylesheet" href="css/padrao.css">
    <link rel="stylesheet" href="css/detalhescarro.css">
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
    <h1>Detalhes do Carro</h1>

    <div class="card">
        <img src="carros/<?php echo $carro['linkImagem']; ?>" alt="Imagem do carro">
        <div class="card-info">
            <h2><?php echo $carro['marca']; ?> - <?php echo $carro['modelo']; ?></h2>
            <p>Ano: <?php echo $carro['ano']; ?></p>
            <p>Valor: R$ <?php echo number_format($carro['valor'], 2, ',', '.'); ?></p>
            <form action="cadastrarcompra.php" method="post">
                <input type="hidden" name="idCarro" value="<?php echo $carro['id']; ?>">
                <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['id']; ?>">
                <label for="formaPagamento">Selecione a forma de pagamento:</label>
                <select name="formaPagamento" id="formaPagamento">
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Pix">Pix</option>
                    <option value="Boleto Bancário">Boleto Bancário</option>
                </select>
                <button type="submit" name="comprar">Comprar</button>
            </form>
        </div>
    </div>
</body>

</html>
