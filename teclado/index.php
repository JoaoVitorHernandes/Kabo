<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>Teclados</title>
</head>

<body>
    <?php
    include('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

        <h1 id="titulo_produto">Teclados</h1>
        <p id="descricao_tipo">Teclados são dispositivos de entrada essenciais para inserir dados em computadores. Vêm em diferentes layouts e designs, incluindo teclados padrão e ergonômicos. Amplamente utilizados em uma variedade de aplicativos, desde digitação até jogos e programação.</p>

        <div class="caixas">
            <?php
            $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Teclado.* FROM Produto_Tipo p 
                    JOIN Teclado ON p.fk_Cod_Teclado = Teclado.Cod_Teclado
                    WHERE p.fk_Cod_Teclado IS NOT NULL AND p.Qtd_estoque > 0";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="bordacaixas">
                    <a href="teclado.php?id=<?php echo $row['Cod_Produto'];?>" class="linkcaixa">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                        <div class="linha0">
                            <div class="moverdescricaocaixa">
                                <div class="escritacaixa"><?php echo $row['Tipo'] . ' ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Cor'] . ' ' . $row['Iluminacao'] ?></div>
                            </div>
                            <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                            <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </main>

    <iframe src="../Rodape.php" class="iframefooter"></iframe>

</body>

</html>