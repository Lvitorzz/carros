<?php
session_start();

include './conexao/conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editarCarro'])) {
    $idCarro = $_POST['idCarro'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $ano = $_POST['ano'];
    $valor = $_POST['valor'];
    $imagem = $_POST['imagem'];

    $sqlEditar = "UPDATE carros SET marca='$marca', modelo='$modelo', ano='$ano', valor='$valor', linkImagem='$imagem' WHERE id='$idCarro'";
    if ($conexao->query($sqlEditar) === TRUE) {
        header("Location: paineladministracao.php");
        echo "<script>alert('Carro editado com sucesso');</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao editar carro');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluirCarro'])) {
    $idCarro = $_POST['idCarro'];
    $sqlExcluir = "DELETE FROM carros WHERE id='$idCarro'";
    if ($conexao->query($sqlExcluir) === TRUE) {
        echo "<script>alert('Carro excluído com sucesso');</script>";
        echo "<script>window.location.href = 'paineladministracao.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao excluir carro');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluirUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    if ($idUsuario != $_SESSION['id']) {
        $sqlExcluir = "DELETE FROM usuarios WHERE id='$idUsuario'";
        if ($conexao->query($sqlExcluir) === TRUE) {
            echo "<script>alert('Usuario excluído com sucesso');</script>";
            echo "<script>window.location.href = 'paineladministracao.php';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao excluir usuario');</script>";
        }
    } else {
        echo "<script>alert('Não foi possivel excluir, você esta logado com este usuario!');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tornarAdministrador'])) {
    $idUsuario = $_POST['idUsuario'];
    $sqlTornarAdmin = "UPDATE usuarios SET administrador = TRUE WHERE id='$idUsuario'";
    if ($conexao->query($sqlTornarAdmin) === TRUE) {
        echo "<script>alert('Usuário agora é administrador');</script>";
        echo "<script>window.location.href = 'paineladministracao.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao tornar usuário administrador');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel administração</title>
    <link rel="stylesheet" href="css/padrao.css">
    <link rel="stylesheet" href="css/painel.css">
</head>

<body>
    <header>
        <section class="cabecalho">
            <div class="marca">
                <H1 class="marca-titulo">
                    StockCar
                </H1>
            </div>
            <nav class="navegacao">
                <a class="navegacao-compras" href="index.php">VOLTAR AO SITE</a>
            </nav>
        </section>
    </header>

    <h1 class="txt-painel">Painel administração StockCar</h1>

    <div id="editarCarroModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Carro</h2>
            <form id="editCarForm" method="post">
                <input type="hidden" name="idCarro" id="carroId">
                <label for="marca">Altera marca:</label>
                <input type="text" id="editarMarcaCarro" name="marca">
                <br>
                <label for="modelo">Alterar modelo:</label>
                <input type="text" id="editarModeloCarro" name="modelo">
                <br>
                <label for="ano">Alterar ano:</label>
                <input type="text" id="editarAnoCarro" name="ano">
                <br>
                <label for="valor">Alterar valor:</label>
                <input type="text" id="editarValorCarro" name="valor">
                <br>
                <label for="valor">Alterar imagem:</label>
                <input type="text" id="editarImagemCarro" name="imagem">
                <br>
                <button type="submit" name="editarCarro">Salvar Alterações</button>
            </form>
        </div>
    </div>
    <div class="tabelas">
        <table>
            <caption>Carros</caption>
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Valor</th>
                    <th>Link da Imagem</th>
                    <th><a href="./cadastroCarro.html"><button>Cadastrar Carros</button></a></th>

                </tr>
            </thead>
            <tbody>
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
                    echo "<tr>";
                    echo "<td>" . $carro['marca'] . "</td>";
                    echo "<td>" . $carro['modelo'] . "</td>";
                    echo "<td>" . $carro['ano'] . "</td>";
                    echo "<td>R$ " . number_format($carro['valor'], 2, ',', '.') . "</td>";
                    echo "<td>" . $carro['linkImagem'] . "</td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='idCarro' value='" . $carro['id'] . "'>
                        </form>
                        <button class='editCarButton' carro-id='" . $carro['id'] . "' carro-marca='" . $carro['marca'] . "' carro-modelo='" . $carro['modelo'] . "' carro-ano='" . $carro['ano'] . "' carro-valor='" . $carro['valor'] . "' carro-imagem='" . $carro['linkImagem'] . "' >Editar</button>
                    </td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='idCarro' value='" . $carro['id'] . "'>
                            <button class='excluir' type='submit' name='excluirCarro'>Excluir</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <table>
            <caption>Clientes</caption>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './carros.php';
                include './conexao/conexao.php';

                function listarUsuarios()
                {
                    global $conexao;
                    $sql = "SELECT * FROM usuarios";
                    $resultado = $conexao->query($sql);
                    $usuarios = array();

                    if ($resultado->num_rows > 0) {
                        while ($usuario = $resultado->fetch_assoc()) {
                            $usuarios[] = $usuario;
                        }
                    }

                    return $usuarios;
                }
                $usuarios = listarUsuarios();

                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . $usuario['nome'] . "</td>";
                    echo "<td>" . $usuario['email'] . "</td>";
                    echo "<td><form method='post'><input type='hidden' name='idUsuario' value='" . $usuario['id'] . "'><button class='excluir'type='submit' name='excluirUsuario'>Excluir</button></form></td>";
                    echo "<td>
                        <form method='post'>
                            <input type='hidden' name='idUsuario' value='" . $usuario['id'] . "'>
                            <button type='submit' name='tornarAdministrador'>Tornar Administrador</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <table>
        <caption>Vendas</caption>
        <thead>
            <tr>
                <th>Carro</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sqlVendas = "SELECT carros.marca, carros.valor, carros.modelo, usuarios.nome AS cliente, compras.formaPagamento
                            FROM compras
                            INNER JOIN carros ON compras.idCarro = carros.id
                            INNER JOIN usuarios ON compras.idCliente = usuarios.id";

            $resultadoVendas = $conexao->query($sqlVendas);

            if ($resultadoVendas->num_rows > 0) {
                while ($venda = $resultadoVendas->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $venda['marca'] . " - " . $venda['modelo'] . "</td>";
                    echo "<td>" . $venda['cliente'] . "</td>";
                    echo "<td>" . $venda['formaPagamento'] . "</td>";
                    echo "<td>R$ " . number_format($venda['valor'], 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nenhuma venda registrada.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>


    <script>
        function openEditModal(id, marca, modelo, ano, valor, imagem) {
            document.getElementById("carroId").value = id;
            document.getElementById("editarMarcaCarro").value = marca;
            document.getElementById("editarModeloCarro").value = modelo;
            document.getElementById("editarAnoCarro").value = ano;
            document.getElementById("editarValorCarro").value = valor;
            document.getElementById("editarImagemCarro").value = imagem;
            document.getElementById("editarCarroModal").style.display = "block";
        }

        document.getElementsByClassName("close")[0].onclick = function() {
            document.getElementById("editarCarroModal").style.display = "none";
        };

        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.editCarButton');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('carro-id');
                    var marca = this.getAttribute('carro-marca');
                    var modelo = this.getAttribute('carro-modelo');
                    var ano = this.getAttribute('carro-ano');
                    var valor = this.getAttribute('carro-valor');
                    var imagem = this.getAttribute('carro-imagem');
                    openEditModal(id, marca, modelo, ano, valor, imagem);
                });
            });
        });
    </script>
</body>

</html>