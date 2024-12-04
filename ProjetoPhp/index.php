<?php include 'templates/header.php'; ?>
<?php include 'config.php'; ?>

<main>
    <section class="hero">

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

<!-- Botão de Publicar -->
<button id="publishBtn" class="publish-btn">Publicar Card</button>

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

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gameImage']) && isset($_POST['gameTitle']) && isset($_POST['gameDescription'])) {
    $image = $_FILES['gameImage'];
    $title = $_POST['gameTitle'];
    $description = $_POST['gameDescription'];

    // Lógica para salvar a imagem no servidor
    $imagePath = 'imagens/' . $image['name'];
    move_uploaded_file($image['tmp_name'], $imagePath);

    // Exibir o card recém-publicado dentro de um contêiner .cards
    echo '
    <div class="cards">
        <div class="card">
            <img src="' . $imagePath . '" alt="' . $title . '">
            <div class="card-content">
                <h3 class="card-title">' . $title . '</h3>
                <p>' . $description . '</p>
                <button class="card-button">Explore</button>
            </div>
        </div>
    </div>';
}

?>


</main>

<?php include 'templates/footer.php'; ?>
