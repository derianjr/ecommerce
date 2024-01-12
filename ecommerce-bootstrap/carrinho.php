<?php
include 'config.php';
session_start();
$id_usuario = $_SESSION['email'];

if (!isset($id_usuario)) {
    header('Location: login.php');
}

// PUXANDO DO BANCO DE DADOS AS INFORMAÇÕES E MOSTRANDO NA TELA

if (isset($_POST['add_carrinho'])) {
    $nome_produto = mysqli_real_escape_string($conn, $_POST['nome_produto']);
    $preco_produto = mysqli_real_escape_string($conn, $_POST['preco_produto']);
    $imagem_produto = mysqli_real_escape_string($conn, $_POST['imagem_produto']);
    $quantidade_produto = mysqli_real_escape_string($conn, $_POST['quantidade_produto']);

    $select_carrinho = mysqli_query($conn, "SELECT * FROM carrinho WHERE nome = '$nome_produto' AND id_cliente = '$id_usuario'");

    if (mysqli_num_rows($select_carrinho) > 0) {
        $mensagem[] = 'Produto já foi adicionado !';
    } else {
        mysqli_query($conn, "INSERT INTO carrinho(id_cliente,  nome, preco, imagem, quantidade) VALUES('$id_usuario','$nome_produto',
        '$preco_produto','$imagem_produto','$quantidade_produto')");
        $mensagem[] = 'Produto inserido no carrinho !';
    }
}
// PARTE DE ADICIONAR NO CARRINHO

if (isset($_POST['atualiza_carrinho'])) {
    $atualiza_quantidade = $_POST['quantidade_carrinho'];
    $atualiza_id = $_POST['atualiza_id'];
    mysqli_query($conn, "UPDATE `carrinho` SET quantidade = '$atualiza_quantidade' WHERE id = '$atualiza_id'");
}

// PARTE DE REMOVER DO CARRINHO

if (isset($_GET['deleteitem'])) {
    $remove_id = $_GET['carrinho_id'];
    mysqli_query($conn, "DELETE FROM `carrinho`  WHERE id = '$remove_id'");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TecBrain</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="carrinho.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-danger px-4 px-lg-5"></nav>

<section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center"><strong>Carrinho de Compras</strong></h3>
                    <table id="shoppingCart" class="table table-condensed table-responsive">
                        <thead>
                            <tr>
                                <th style="width:60%">Produto</th>
                                <th style="width:12%">Preço</th>
                                <th style="width:10%">Quantidade</th>
                                <th style="width:10%">Preço Total</th>
                                <th style="width:16%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $valor_total = 0;
                            $consulta_carrinho = mysqli_query($conn, "SELECT * FROM carrinho WHERE id_cliente = '$id_usuario'") or die('A consulta falhou');
                            if (mysqli_num_rows($consulta_carrinho) > 0) {
                                while ($fetch_carrinho = mysqli_fetch_assoc($consulta_carrinho)) {
                            ?>
                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-md-3 text-left">
                                                    <img src="<?php echo $fetch_carrinho['imagem']; ?>" alt="" class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                </div>
                                                <div class="col-md-9 text-left mt-sm-2">
                                                    <h4><?php echo $fetch_carrinho['nome']; ?></h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">R$ <?php echo $fetch_carrinho['preco']; ?></td>
                                        <td data-th="Quantity">

                                            <form action="" method="POST">
                                                <input type="hidden" name="atualiza_id" class="form-control form-control-lg text-center" value="<?php echo $fetch_carrinho['id']; ?>">
                                                <input type="number" name="quantidade_carrinho" class="form-control form-control-lg text-center" min="1" value="<?php echo $fetch_carrinho['quantidade']; ?>">
                                                <input type="submit" name="atualiza_carrinho" class="btn btn-danger btn-outline-dark text-white mt-auto mb-2" value="Atualiza">
                                            </form>
                                        </td>
                                        <td>R$ <?php echo $valor_item = (intval($fetch_carrinho['preco']) * $fetch_carrinho['quantidade']); ?></td>
                                        <td><a href="index.php?deleteitem=1&carrinho_id=<?php echo $fetch_carrinho['id']; ?>" class="btn btn-danger btn-outline-dark text-white mt-auto mb-2" onclick="return confirm('Deseja deletar item?');">x
                                        <td>
                                    </tr>

                            <?php
                                    $valor_total += $valor_item;
                                };
                            } else {
                                echo '<tr><td>Nenhum item adicioando</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="float-right text-right">
                        <h4>Total:</h4>
                        <h1>R$<?php echo $valor_total; ?></h1>
                    </div>
                </div>
            </div>
            <div class="row mt-4 d-flex align-items-center">
                <div class="col-sm-6 order-md-2 text-right">
                    <a href="index.php" class="btn btn-danger btn-outline-dark text-white mt-auto mb-4 btn-lg pl-5 pr-5">Continuar Comprando</a>
                </div>

            </div>
        </div>
    </section>
        <!-- Footer-->
        <footer class="py-5 bg-danger">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
</body>
</html>