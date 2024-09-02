<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>CPUs</title>
</head>

<body>
    <?php
    include('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

        <h1 id="titulo_produto">CPUs</h1>
        <p id="descricao_tipo">A CPU, ou processador, é o cérebro do seu desktop, responsável por dar vida a tudo. Imagine um chefe de cozinha recebendo pedidos (instruções) de programas e os dividindo em tarefas para seus funcionários (núcleos) executarem. Mais núcleos significam mais rapidez!</p>

        <div class="caixas">
            <?php
            $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, p.Qtd_estoque, CPU.* FROM Produto_Tipo p  
                    JOIN CPU ON p.fk_Cod_CPU = CPU.Cod_CPU 
                    WHERE p.fk_Cod_CPU IS NOT NULL AND p.Qtd_estoque > 0";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="bordacaixas">
                    <a href="cpu.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                        <div class="linha0">
                            <div class="moverdescricaocaixa">
                                <div class="escritacaixa">
                                    <?php echo 'CPU ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Frequencia'] . 'Hz ' . $row['Tipo_Mem'] . ' ' . $row['Nucleos'] . ' núcleos' ?>
                                </div>
                            </div>
                            <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                            <p class="parcelamentopreco">10 x
                                R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de
                                crédito</p>
                        </div>
                    </a>
                </div>
            <?php }
            $conn->close() ?>
        </div>
    </main>

    <iframe src="../Rodape.php" class="iframefooter"></iframe>

</body>

</html>