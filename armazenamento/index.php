<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>Armazenamento</title>
</head>

<body>
    <?php
    include('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

        <h1 id="titulo_produto">Armazenamentos</h1>
        <p id="descricao_tipo">Armazenamento em computadores são dispositivos como HDDs e SSDs, usados para reter dados permanentemente. HDDs usam discos magnéticos, enquanto SSDs usam memória flash, oferecendo velocidades de leitura e gravação mais rápidas. Essenciais para armazenar e acessar dados eficientemente.</p>

        <div class="caixas">
            <?php
            $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Armazenamento.* 
                    FROM Produto_Tipo p 
                    JOIN Armazenamento ON p.fk_Cod_Armazenamento = Armazenamento.Cod_Armazenamento
                    WHERE p.fk_Cod_Armazenamento IS NOT NULL AND p.Qtd_estoque > 0";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="bordacaixas">
                    <a href="armazenamento.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                        <div class="linha0">
                            <div class="moverdescricaocaixa">
                                <div class="escritacaixa"><?php echo $row['Tipo'] . ' ' . $row['Conexao'] . ' ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Capacidade'] . ' ' . $row['Velocidade'] . 'Mb/s' ?></div>
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