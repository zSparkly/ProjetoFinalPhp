<?php
session_start();

// Verifica se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!-- Exibir o cabeçalho com a condição do login -->
<?php include 'templates/header.php'; ?>

<main>
    <?php if ($isLoggedIn): ?>
        <h1>Bem-vindo, <?php echo $_SESSION['user_email']; ?>!</h1>
    <?php else: ?>
        <p>Você não está logado.</p>
    <?php endif; ?>
</main>
<?php include 'config.php'; ?>

<main>

    </section>


    <!-- Modal de Login -->
<div id="signInModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeSignIn">&times;</span>
        <h2>Sign In</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit" class="submit-btn">Log In</button>
        </form>
    </div>
</div>

<!-- Modal de Registro -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeRegister">&times;</span>
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="emailReg" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="passwordReg" name="password" placeholder="Create a password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirm-password" placeholder="Confirm your password" required>

            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</div>

<script>
    // Obter elementos dos modais
    const signInModal = document.getElementById('signInModal');
    const registerModal = document.getElementById('registerModal');

    // Obter os botões que abrem os modais
    const signInBtn = document.getElementById('signInBtn');
    const registerBtn = document.getElementById('registerBtn');

    // Obter os botões de fechar nos modais
    const closeSignIn = document.getElementById('closeSignIn');
    const closeRegister = document.getElementById('closeRegister');

    // Função para abrir o modal de login
    signInBtn.onclick = function() {
        signInModal.style.display = 'flex';
    }

    // Função para abrir o modal de registro
    registerBtn.onclick = function() {
        registerModal.style.display = 'flex';
    }

    // Fechar o modal de login
    closeSignIn.onclick = function() {
        signInModal.style.display = 'none';
    }

    // Fechar o modal de registro
    closeRegister.onclick = function() {
        registerModal.style.display = 'none';
    }

    // Fechar o modal clicando fora do conteúdo
    window.onclick = function(event) {
        // Verificar todos os modais
        if (event.target === signInModal) {
            signInModal.style.display = 'none';
        }
        if (event.target === registerModal) {
            registerModal.style.display = 'none';
        }
        if (event.target === publishModal) {
            publishModal.style.display = 'none';
        }
    };
</script>

<?php
// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {  // Se o usuário estiver logado
    // Exibe o botão de Publicar Card
    echo '<div class="publish-button">';
    echo '<button id="publishBtn" class="publish-btn">Publicar Card</button>';
    echo '</div>';
}
?>
<!-- Modal de Publicação -->
<div id="publishModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closePublish">&times;</span>
        <h2>Publicar Novo Card</h2>
        <form id="publishForm" method="POST" enctype="multipart/form-data">
            <label for="gameImage">Imagem:</label>
            <input type="file" id="gameImage" name="gameImage" accept="image/*" required>

            <label for="gameTitle">Título do Jogo:</label>
            <input type="text" id="gameTitle" name="gameTitle" placeholder="Digite o título do jogo" required>

            <label for="gameDescription">Descrição:</label>
            <textarea id="gameDescription" name="gameDescription" placeholder="Digite a descrição do jogo" required></textarea>

            <button type="submit" class="publish-button">Publicar</button>
        </form>
    </div>
</div>




<script>
    const closePublish = document.getElementById('closePublish');

    // Função para abrir o modal de publicação
    publishBtn.onclick = function() {
        publishModal.style.display = 'flex';
    }

    // Função para fechar o modal de publicação
    closePublish.onclick = function() {
        publishModal.style.display = 'none';
    }
</script>

</main>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gameImage']) && isset($_POST['gameTitle']) && isset($_POST['gameDescription'])) {
    $image = $_FILES['gameImage'];
    $title = $_POST['gameTitle'];
    $description = $_POST['gameDescription'];

    // Lógica para salvar a imagem no servidor
    $imagePath = 'imagens/' . $image['name'];
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Inserir os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO cards (game_image, game_title, game_description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $imagePath, $title, $description);  // "sss" para strings

    if ($stmt->execute()) {
        echo '';
    } else {
        echo '' . $stmt->error;
    }

    // Fechar a preparação
    $stmt->close();
}
?>
<?php
// Selecionar todos os cards do banco de dados
$result = $conn->query("SELECT * FROM cards");

if ($result->num_rows > 0) {
    // Exibir os cards
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="cards">
            <div class="card">
                <img src="' . $row['game_image'] . '" alt="' . $row['game_title'] . '">
                <div class="card-content">
                    <h3 class="card-title">' . $row['game_title'] . '</h3>
                    <p>' . $row['game_description'] . '</p>
                    <button class="card-button">Explore</button>
                </div>
            </div>
        </div>';
    }
} else {
    echo 'Nenhum card encontrado.';
}


// Fechar a conexão
$result->close();
?>
<script>
    // Obter o botão de logout
    const logoutBtn = document.getElementById('logoutBtn');

    // Verificar se o botão de logout existe (ou seja, se o usuário está logado)
    if (logoutBtn) {
        logoutBtn.onclick = function() {
            // Redireciona o usuário para o logout.php, que irá destruir a sessão
            window.location.href = 'logout.php';
        }
    }
</script>


<?php include 'templates/footer.php'; ?>