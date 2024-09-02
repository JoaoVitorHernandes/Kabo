<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../produtos.css">
    <title>Memória Ram</title>
</head>

<body>
    <?php
    include ('../connection.php');
    session_start();
    ?>
    <iframe src="../barrasNav.php" class="iframenav"></iframe>

    <main>

    <h1 id = "titulo_produto">Memórias RAM</h1>
    <p id = "descricao_tipo">A RAM é uma memória volátil usada para armazenar dados temporariamente enquanto o computador está em funcionamento. Ela fornece acesso rápido aos dados para o processador, sendo essencial para o desempenho do sistema.</p>

    <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Memoria_RAM.* FROM Produto_Tipo p 
                    JOIN Memoria_RAM ON p.fk_Cod_MemRAM = Memoria_RAM.Cod_MemRAM 
                    WHERE p.fk_Cod_MemRAM IS NOT NULL AND p.Qtd_estoque > 0";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="bordacaixas">
                            <a href="ram.php?id=<?php echo $row['Cod_Produto'];?>" class="linkcaixa">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                <div class="linha0">
                                    <div class="moverdescricaocaixa">
                                        <div class="escritacaixa"><?php echo 'Memória RAM ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Cap_Mem'] . 'GB ' . $row['Tipo_Mem'] . ' ' . $row['Vel_Mem'] . 'Mb/s' ?></div>
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