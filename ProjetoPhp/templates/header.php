<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neoplay</title>
    <link rel="stylesheet" href="styles.css?v=1.0">
</head>
<body>
<header>
    <div class="logo">
        <img src="imagens/Logo.png" alt="Neoplay Logo">
    </div>


    <div class="auth-buttons">
        <?php
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user_id'])) {  // Se o usuário NÃO estiver logado
            // Exibe os botões de Sign In e Register
            echo '<button class="sign-in" id="signInBtn">Sign In</button>';
            echo '<button class="register" id="registerBtn">Register</button>';
        } else {  // Se o usuário ESTIVER logado
            // Exibe apenas o botão de Logout
            echo '<a href="logout.php"><button class="logout">Logout</button></a>';
        }
        ?>
    </div>
</header>
