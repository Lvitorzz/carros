<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockCar</title>
    <link rel="stylesheet" href="css/padrao.css">
    <link rel="stylesheet" href="css/lojacarro.css">
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
        <h1>Conheça nossos carros</h1>
        <section class="cards-mais-comprados">

            <?php
            include './carros.php';
            include './conexao/conexao.php';

            function listarCarros()
            {
                global $conexao;
                $sql = "SELECT * FROM carros";
                $resultado = $conexao->query($sql);
                $carros = array();

                if ($resultado->num_rows > 0) {
                    while ($carro = $resultado->fetch_assoc()) {
                        $carros[] = $carro;
                    }
                }

                return $carros;
            }
            $carros = listarCarros();

            foreach ($carros as $carro) {
            ?>
                <div class="card">
                    <img src="carros/<?php echo $carro['linkImagem']; ?>" alt="Imagem do carro">
                    <div class="card-info">
                        <h2><?php echo $carro['marca']; ?> - <?php echo $carro['modelo']; ?></h2>
                        <p>Ano: <?php echo $carro['ano']; ?></p>
                        <p>Valor: R$ <?php echo number_format($carro['valor'], 2, ',', '.'); ?></p>
                        <div class="card-comprar">
                           <a href="./detalhescarro.php?id=<?php echo $carro['id']; ?>">Comprar este carro</a> 
                        </div>
                        
                    </div>
                </div>
            <?php } ?>
        </section>
        <div>
            <a href="./lojacarro.php"><button>Ver todos os modelos</button></a>
        </div>

        <section class="sobre-a-empresa">
            <div class="sobre-a-empresa-card">
                <div>
                    <h2 class="sobre-a-empresa-titulo">Sobre a Empresa</h2>
                    <p class="sobre-a-empresa-paragrafo"></p>
                </div>
                <img class="sobre-a-empresa-img" src="" alt="">
            </div>
        </section>



    </main>
    <footer>
        <div class="footer">
            Todos os direitos reservados
        </div>

    </footer>

    <script src="js/carrocel.js"></script>
</body>

</html>