<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<body>
    <?php
        include("connection.php");

        session_start();
        if (!isset($_SESSION["Cod_Usuario"])) {
            header("Location: /kabo/index.php");
            exit();
        }

        if ($_SESSION["Tipo_Usuario"] == 0) {
            header("Location: erro.php");
            exit();
        }
    ?>
    <nav>
        <div id="voltar"><a href="../perfil/">Voltar</a></div>

        <div id="area_atual"><p>Administrar recursos</p></div>

        <div id="perfil">
            <?php
                $sqlP = "SELECT Nome, Imagem FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
                $resultP = $conn->query($sqlP);
                $rowP = $resultP->fetch_assoc();
                $nomeCompleto = $rowP['Nome'];
                $partesNome = explode(' ', $nomeCompleto);
                $_clienteLogado = $partesNome[0];
                $imgPerfil = $rowP['Imagem'];
                if ($imgPerfil == null) {
            ?>
                    <a href="../perfil/"><img src="../img/perfil_padrao.png" alt="">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php 
                } else {
                    $imagemBase64 = base64_encode($imgPerfil); ?>
                    <a href="../perfil/"><img src="data:image/jpeg;base64,<?php echo $imagemBase64 ?>"  alt="Perfil">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php
                }
                ?>
        </div>
    </nav>

    <main>
        <p id="caminho">administrar recursos &nbsp;> </p>

        <section id="menu">
            <div class="opcoes_menu"><a href="produtos/">Produtos</a></div>
            <div class="opcoes_menu"><a href="usuarios/">Usuários</a></div>
            <div class="opcoes_menu"><a href="kits/">Kits personalizados</a></div>
            <div class="opcoes_menu"><a href="cupons/">Cupons</a></div>
            <div class="opcoes_menu"><a href="estatisticas/">Estatísticas</a></div>
            <div class="opcoes_menu"><a href="">Query livre</a></div>
        </section>
    </main>
    
    <script>
    </script>
</body>
</html>
