<?php
if(isset($_POST['submit'])){

    include_once('config.php');

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nascimento = $_POST['nascimento'];

    $result = mysqli_query($conn, "INSERT INTO produtostab(nome,sobrenome,email,senha,nascimento) 
    VALUES ('$nome','$sobrenome','$email','$senha','$nascimento')");
    }

?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    <title>Formulário de Clientes</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
<a href="login.php" class="btn btn-dark  text-white mt-auto mb-2">Voltar</a>    
    <div class="box">
        <form action="cadastro.php" method="POST">
        <fieldset>
            <legend><b>Sistema de Cadastro</b></legend>
            <br>
            <div class="inputbox">
                <input type="text" name="nome" id="inome" class="inputuser" required>
                <label for="inome" class="labelInput">Nome</label
                <br>
            </div>

            <div class="inputbox">
                <input type="text" name="sobrenome" id="isobrenome" class="inputuser" required>
                <label for="isobrenome" class="labelInput">Sobrenome</label>
            </div>
            <br><br>

            <div class="inputbox">
                <input type="email" name="email" id="iemail" class="inputuser" required>
                <label for="iemail" class="labelInput" >E-mail</label>
            </div>

            <br><br>
            <div class="inputbox">
                <input type="password" name="senha" id="isenha" class="inputuser" required>
                <label for="isenha" class="labelInput">Senha</label>
            </div>
            <br><br>

            <div class="inputbox">
                <input type="password" name="senha" id="isenha" class="inputuser" required>
                <label for="isenha" class="labelInput">Confirmar Senha</label>
            </div>


            <div class="inputbox">
                <label for="inascimento">Data de Nascimento</label>
                <input type="date" name="nascimento" id="inascimento" required>
            </div>
            <br><br>        
            <input type="submit" name="submit" id="submit">
            
        </fieldset>
        </form>

    </div>
</body>
</html>