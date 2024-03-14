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
    <link rel="stylesheet" href="css/styles.css">
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
                    <a class="navegacao-informacoes" href="informacoes.php">MINHAS INFORMAÇÕES</a>
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

        <section class="destaque">
            <div class="destaque-card">
                <div class="destaque-card-textos">
                    <h2 class="destaque-card-titulo"> O Carro perfeito para você</h2>
                    <p class="destaque-card-paragrafo">O Carro perfeito para você
                        Essa empresa é muito bem-sucedida. Oferece serviços mais robusto</p>
                </div>
                <div class="destaque-card-imgs">
                    <img class="destaque-card-img1" src="img/car/car1.jpg" alt="">
                </div>
            </div>

        </section>
        <div class="mais-carros">
            <h1>Conheça nossos carros</h1>
            <div class="botao">
                <a href="./lojacarro.php"><button>Ver todos os modelos</button></a>
            </div>       
        </div>
        
        
        <section class="cards-mais-comprados">
            
            <?php
            include './carros.php';
            include './conexao/conexao.php';

            function listarCarros()
            {
                global $conexao;
                $sql = "SELECT * FROM carros LIMIT 3";
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
                    </div>
                </div>
            <?php } ?>
        </section>   
   </main>
    <section class="sobre-a-empresa">
            <div class="sobre-a-empresa-card">
                <div>
                    <h2 class="sobre-a-empresa-titulo">Sobre a Empresa</h2>
                    <p class="sobre-a-empresa-paragrafo">Na Stock Car, nosso foco está em oferecer uma experiência excepcional de vendas de carros importados. Utilizamos tecnologias avançadas e catálogos interativos para apresentar de forma detalhada e envolvente os melhores veículos importados do mercado. Nosso compromisso com a qualidade, precisão e a conexão entre os sonhos dos clientes e a realidade dos carros disponíveis nos permite facilitar e aprimorar a jornada de compra, garantindo que cada cliente encontre o carro ideal para suas necessidades e desejos.</p>
                </div>
                <img class="sobre-a-empresa-img" src="" alt="">
            </div>
        </section>
    <footer>
        <div class="footer">
            Todos os direitos reservados
        </div>

    </footer>

    <script src="js/carrocel.js"></script>
</body>

</html>