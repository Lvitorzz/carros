<?php
session_start();

include './conexao/conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.html");
    exit();
}

$idUsuario = $_SESSION['id'];

$sqlCompras = "SELECT carros.marca, carros.modelo, carros.ano, carros.valor, carros.linkImagem, compras.formaPagamento
                FROM compras
                INNER JOIN carros ON compras.idCarro = carros.id
                WHERE compras.idCliente = '$idUsuario'";
$resultado = $conexao->query($sqlCompras);

$compras = array();

if ($resultado->num_rows > 0) {
    while ($compra = $resultado->fetch_assoc()) {
        $compras[] = $compra;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras</title>
    <link rel="stylesheet" href="css/padrao.css">
    <link rel="stylesheet" href="css/minhascompras.css">
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
                    <a class="navegacao-compras" href="informacoes.php">MINHAS INFORMAÇÕES</a>
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
    <h1 class="txt">Minhas Compras</h1>

    <div class="cards-container">
        <?php foreach ($compras as $compra) : ?>
            <div class="card">
                <img src="carros/<?php echo $compra['linkImagem']; ?>" alt="Imagem do carro">
                <div class="card-info">
                    <h2><?php echo $compra['marca']; ?> - <?php echo $compra['modelo']; ?></h2>
                    <p>Ano: <?php echo $compra['ano']; ?></p>
                    <p>Valor: R$ <?php echo number_format($compra['valor'], 2, ',', '.'); ?></p>
                    <p>Forma de Pagamento: <?php echo $compra['formaPagamento']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>