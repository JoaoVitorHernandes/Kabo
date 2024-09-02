<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>Fontes</title>
</head>

<body>
    <?php
    include('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

        <h1 id="titulo_produto">Fontes</h1>
        <p id="descricao_tipo">As fontes de alimentação são essenciais para os computadores, convertendo a corrente elétrica para fornecer energia aos componentes. Elas garantem que todos os outros dispositivos do computador recebam a energia necessária para funcionar corretamente.</p>

        <div class="caixas">
            <?php
            $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Fonte.* FROM Produto_Tipo p 
                    JOIN Fonte ON p.fk_Cod_Fonte = Fonte.Cod_Fonte
                    WHERE p.fk_Cod_Fonte IS NOT NULL AND p.Qtd_Estoque > 0";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="bordacaixas">
                    <a href="fonte.php?id=<?php echo $row['Cod_Produto'];?>" class="linkcaixa">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                        <div class="linha0">
                            <div class="moverdescricaocaixa">
                                <div class="escritacaixa"><?php echo 'Fonte ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Potencia'] . 'W ' . $row['Voltagem'] . ' VCA, ' . $row['Certificacao'] ?></div>
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