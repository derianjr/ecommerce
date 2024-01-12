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
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-danger">
        <div class="text-white">
            <?php
            echo "Seja Bem-Vindo!!   " . $_SESSION['email'];
            ?>
        </div>
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-white" href="#!">TecBrain</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active text-white" aria-current="page" href="login.php">LOGIN</a></li>
                </ul>
                <form class="d-flex">
                    <a href="carrinho.php" class="btn btn-danger btn-outline-dark text-white">Carrinho</a>
                </form>
            </div>
        </div>
    </nav>
    <hr class="mt-1">
    <!-- Header-->
<header class="container">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
            <img src="img/imagem1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
            <img src="img/imagem2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item" data-bs-interval="1000">
            <img src="img/imagem3.jpg class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</header>
    <hr class="mt-3">
    <!-- Section-->
    <main class="d-flex justify-content-center">
        <div class="container d-flex row justify-content-center">
            <hr class="mt-3">
            <?php
            $select_produtos = mysqli_query($conn, "SELECT * FROM produtos");
            if (mysqli_num_rows($select_produtos) > 0) {
                while ($fetch_produtos = mysqli_fetch_assoc($select_produtos)) {
            ?>
                    <div class="col-xl-2 col-lg col-md-4 col-sm-6 d-flex ">
                        <div class="card text-center bg-light ">
                            <img src="<?php echo $fetch_produtos['imagem']; ?>">
                            <div class="card-header">
                                <strong>R$ <?php echo $fetch_produtos['preco']; ?></strong>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $fetch_produtos['nome']; ?></h5>
                                <small>
                                    <p class="card-text">
                                        <?php echo $fetch_produtos['texto']; ?>
                                    </p>
                                </small>        
                            </div>
                            <div class="card-footer">
                                <form  action="" method="POST">
                                    <input type="hidden" name="imagem_produto" value="<?php echo $fetch_produtos['imagem']; ?>">
                                    <input type="hidden" name="nome_produto" value="<?php echo $fetch_produtos['nome']; ?>">
                                    <input type="hidden" name="nome_produto" value="<?php echo $fetch_produtos['texto']; ?>">
                                    <input type="hidden" name="preco_produto" value="<?php echo $fetch_produtos['preco']; ?>">  
                                    <input type="number" name="quantidade_produto" class="form-control form-control-lg text-center" min="1" value="1">
                                    <input class="btn btn-danger btn-outline-dark text-white mt-auto" type="submit" value="Adicionar ao Carrinho" name="add_carrinho">
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                };
            };

            ?>
        </div>
    </main>
    <hr class="mt-3">


    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center"><strong>Carrinho de Compras  </strong></h3>
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
                    <a href="checkout.php" class="btn btn-danger btn-outline-dark text-white mt-auto mb-4 btn-lg pl-5 pr-5">Checkout</a>
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
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script>
        function addToCard(){
            alert("adicionado")
        }
    </script>
</body>

</html>