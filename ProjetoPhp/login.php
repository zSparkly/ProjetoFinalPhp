<?php
// Conexão com o banco de dados
$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog"; // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $senha = $_POST['password']; // Senha inserida pelo usuário

    // Verificar se o email existe no banco de dados
    $checkEmail = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        // O e-mail existe, agora verificamos a senha
        $checkEmail->bind_result($id, $hashedPassword);
        $checkEmail->fetch();

        // Verificar se a senha fornecida corresponde à senha no banco (utilizando password_verify)
        if (password_verify($senha, $hashedPassword)) {
            // Senha correta, faça o login
            session_start(); // Inicia a sessão para armazenar os dados do usuário
            $_SESSION['user_id'] = $id; // Armazena o ID do usuário na sessão
            $_SESSION['user_email'] = $email; // Armazena o email na sessão
            
            // Redirecionar para a página inicial do site
            header("Location: index.php"); // Substitua 'index.php' pelo nome da sua página inicial
            exit(); // Certifique-se de que o script pare após o redirecionamento
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "E-mail não registrado.";
    }

    $checkEmail->close();
}

// Fechar a conexão
$conn->close();
?>
