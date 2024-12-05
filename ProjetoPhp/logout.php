<?php
session_start();

// Destruir todas as variáveis de sessão
session_unset();

// Destruir a sessão
session_destroy();

// Redirecionar para a página inicial (ou outra página de sua escolha)
header("Location: index.php");
exit();
?>
