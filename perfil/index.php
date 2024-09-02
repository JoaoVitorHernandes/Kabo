<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <title>Perfil</title>
</head>

<html>

<body>
    <?php
    include('../connection.php');
    session_start();
    $sqlN = "SELECT Nome FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultN = $conn->query($sqlN);
    $rowN = $resultN->fetch_assoc();
    $nomeCompleto = $rowN['Nome'];

    $sqlE = "SELECT Email FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultE = $conn->query($sqlE);
    $rowE = $resultE->fetch_assoc();
    $EmailCompleto = $rowE['Email'];

    $sqlI = "SELECT Imagem FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultI = $conn->query($sqlI);
    $rowI = $resultI->fetch_assoc();
    $imgPerfil = $rowI['Imagem'];

    $sqlP = "SELECT COUNT(*) AS Total_Pedido FROM Pedido WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultP = $conn->query($sqlP);
    $rowP = $resultP->fetch_assoc();
    $PedidoCompleto = $rowP['Total_Pedido'];

    $sqlC = "SELECT SUM(Quantidade) AS Total_Quantidade FROM AdicionaCarrinho WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultC = $conn->query($sqlC);
    $rowC = $resultC->fetch_assoc();
    $TotalQuantidade = ($rowC['Total_Quantidade'] > 0 ? $rowC['Total_Quantidade'] : 0);

    $sqlCartao = "SELECT COUNT(*) AS Total_Cartao FROM Cartao_Pagamento WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultCartao = $conn->query($sqlCartao);
    $rowCartao = $resultCartao->fetch_assoc();
    $TotalCartao = ($rowCartao['Total_Cartao'] > 0 ? $rowCartao['Total_Cartao'] : 0);

    if (!isset($_SESSION["Cod_Usuario"])) {
        header("Location: /kabo/");
        exit();
    }
    ?>
    <div id="div_perfil">

        <span id="voltar_home"><a href="../">&times;</a></span>

        <a title="Voltar à Home" href="../"><img src="../img/logo_neon.png" alt="Logo Kabo" id="logo"></a>

        <div id="user_name">
            <?php
            if ($imgPerfil == null) { ?>
                <img src="../img/perfil_padrao.png" alt="foto de perfil" id="foto_perfil">
            <?php } else {
                $imagemBase64 = base64_encode($imgPerfil); ?>
                <img src="data:image/jpeg;base64,<?php echo $imagemBase64 ?>" alt="foto de perfil" id="foto_perfil">
            <?php } ?>

            <div id="nome_email">
                <p id="nome_completo"><?php echo $nomeCompleto ?></p>
                <p id="email_user"><?php echo $EmailCompleto ?></p>
                <?php if ($_SESSION["Tipo_Usuario"] == 1) : ?>
                    <div id="botoes_editar_admin">
                        <a href="editar/" id="botao_editar">Editar</a>
                        <a href="../admin/" id="botao_admin">Admin</a>
                    </div>
                <?php else : ?>
                    <div id="botoes_editar_admin">
                        <a href="editar/" id="botao_editar">Editar</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="destinos_salvos">
            <span id="titulo_destinos">Dados</span>

            <a href="pedidos/">
                <div class="quero_fui"><img src="../img/history.png" alt="icone quero ir">
                    <p>Histórico de pedidos</p><span><?php echo $PedidoCompleto ?> pedidos</span>
                </div>
            </a>

            <a href="../carrinho/">
                <div class="quero_fui"><img src="../img/cart.png" alt="icone já fui">
                    <p>Carrinho</p><span><?php echo $TotalQuantidade?> itens</span>
                </div>
            </a>

            <a href="cartoes/">
                <div class="quero_fui"><img src="../img/card.png" alt="icone já fui">
                    <p>Meus cartões</p><span><?php echo $TotalCartao;?> adicionados</span>
                </div>
            </a>
        </div>

        <span id="botao_sair"><a href="../admin/login/logout.php">Sair</a></span>

        <p id="text123"><a href="../">&copy;kabo</a></p>
    </div>

    <script>

    </script>
</body>

</html>
