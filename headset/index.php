<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>Headsets</title>
</head>

<body>
    <?php
    include('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

        <h1 id="titulo_produto">Headsets</h1>
        <p id="descricao_tipo">Headsets são dispositivos de áudio com fones de ouvido e microfone, permitindo ouvir e gravar som. Disponíveis em modelos com fio e sem fio, oferecem recursos como cancelamento de ruído e áudio surround. Amplamente usados em jogos, comunicações online e transmissões ao vivo para uma experiência de áudio imersiva.</p>

        <div class="caixas">
            <?php
            $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Headset.* FROM Produto_Tipo p
                    JOIN Headset ON p.fk_Cod_Headset = Headset.Cod_Headset
                    WHERE p.fk_Cod_Headset IS NOT NULL AND p.Qtd_estoque > 0";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="bordacaixas">
                    <a href="headset.php?id=<?php echo $row['Cod_Produto'];?>" class="linkcaixa">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                        <div class="linha0">
                            <div class="moverdescricaocaixa">
                                <div class="escritacaixa"><?php echo 'Headset ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Tipo_Conexao'] . ' ' . $row['Frequencia_Audio'] . 'Hz ' . $row['Cor'] ?></div>
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