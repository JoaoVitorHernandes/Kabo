<?php
    // Inicia a sessão
    session_start();

    // Limpa todas as variáveis de sessão
    $_SESSION = array();

    // Destrói a sessão
    session_destroy();

    // Redireciona para a página de login ou outra página desejada
    header("Location: /kabo/");
    exit();
?>
