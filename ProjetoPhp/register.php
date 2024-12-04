<?php
include 'config.php'; // Conectar ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validar se as senhas coincidem
    if ($password !== $confirmPassword) {
        die("As senhas não coincidem. Tente novamente.");
    }

    // Hash seguro da senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Verificar se o email já está registrado
    $checkEmail = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        die("Este email já está registrado. Use outro.");
    } else {
        // Inserir no banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "Registro realizado com sucesso! Você pode fazer login agora.";
            header("Location: index.php"); // Redirecionar para a página principal
            exit;
        } else {
            die("Erro ao registrar: " . $stmt->error);
        }
        $stmt->close();
    }

    $checkEmail->close();
}

$conn->close();
?>
