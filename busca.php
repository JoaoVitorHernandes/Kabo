<?php
include('connection.php');
session_start();

if (isset($_GET['b'])) {
    $busca = trim($_GET['b']);
} else {
    $busca = '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="produtos.css">
    <title><?php echo ($busca == '') ? 'Busca' : '"' . $busca . '"'; ?></title>
</head>

<body>
    <iframe src="barrasNav.php" class="iframenav"></iframe>

    <?php
    $busca = strtolower($busca);
    $sqlProduto = "SELECT * FROM Produto_Tipo WHERE Marca LIKE '%$busca%' OR Modelo LIKE '%$busca%' OR Cod_Produto = '%$busca%'";
    $result = $conn->query($sqlProduto);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0 or $busca == 'armazenamento' or $busca == 'cpu' or $busca == 'fonte' or $busca == 'gabinete' or $busca == 'gpu' or $busca == 'headset' or $busca == 'monitor' or $busca == 'mouse' or $busca == 'placa mae' or $busca == 'ram' or $busca == 'teclado') {
        $busca = $busca;
    } else {
        if ($busca == '') {
            $busca = '';
        } else {
            $busca = 'nada';
        }
    }
    ?>

    <main>
        <?php
        if ($busca != '' and $busca != 'nada') { ?>
            <p id="busca_por">Busca por</p>
            <h1 id="palavra_busca">"<?php echo $busca; ?>"</h1>
        <?php } elseif ($busca == '') { ?>
            <p class="pesquisa_vazia">Pesquise por tipo, marca e modelo!</p>
        <?php } else { ?>
            <p class="pesquisa_vazia">Nenhum item correspondente encontrado!</p>
        <?php } ?>

        <div class="caixas">
            <?php
            if ($busca != '') {
                switch ($busca) {
                    case 'cpu':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, p.Qtd_estoque, CPU.* FROM Produto_Tipo p  
                        JOIN CPU ON p.fk_Cod_CPU = CPU.Cod_CPU 
                        WHERE p.fk_Cod_CPU IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="cpu/cpu.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                        break;
                    case 'gpu':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, GPU.* 
                        FROM Produto_Tipo p 
                        JOIN GPU ON p.fk_Cod_GPU = GPU.Cod_GPU 
                        WHERE p.fk_Cod_GPU IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="gpu/gpu.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                    <div class="linha0">
                                        <div class="moverdescricaocaixa">
                                            <div class="escritacaixa"><?php echo 'GPU ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Tam_Memoria'] . 'GB ' . $row['Tipo_Mem'] . ' ' . $row['Nucleos'] . ' núcleos' ?></div>
                                        </div>
                                        <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                        <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                        break;
                    case 'ram':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Memoria_RAM.* 
                        FROM Produto_Tipo p 
                        JOIN Memoria_RAM ON p.fk_Cod_MemRAM = Memoria_RAM.Cod_MemRAM
                        WHERE p.fk_Cod_MemRAM IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="ram/ram.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                        <?php }
                        break;
                    case 'placa mae':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Placa_Mae.* FROM Produto_Tipo p 
                        JOIN Placa_Mae ON p.fk_Cod_PlacaMae = Placa_Mae.Cod_PlacaMae 
                        WHERE p.fk_Cod_PlacaMae IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="placaMae/placaMae.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                    <div class="linha0">
                                        <div class="moverdescricaocaixa">
                                            <div class="escritacaixa"><?php echo 'Placa mãe ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Soquete'] . ' ' . $row['Tipo_Mem'] . ' ' . $row['Vel_Mem'] . 'Mb/s' ?></div>
                                        </div>
                                        <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                        <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                        break;
                    case 'armazenamento':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Armazenamento.* FROM Produto_Tipo p 
                        JOIN Armazenamento ON p.fk_Cod_Armazenamento = Armazenamento.Cod_Armazenamento
                        WHERE p.fk_Cod_Armazenamento IS NOT NULL LIMIT 10";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="armazenamento/armazenamento.php?id=<?php echo $row['Cod_Produto']; ?>&tipo=Armazenamento" class="linkcaixa">
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
                        <?php }
                        break;
                    case 'fonte':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Fonte.* FROM Produto_Tipo p 
                        JOIN Fonte ON p.fk_Cod_Fonte = Fonte.Cod_Fonte
                        WHERE p.fk_Cod_Fonte IS NOT NULL AND p.Qtd_Estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="fonte/fonte.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                        <?php }
                        break;
                    case 'gabinete':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Gabinete.* FROM Produto_Tipo p 
                    JOIN Gabinete ON p.fk_Cod_Gabinete = Gabinete.Cod_Gabinete
                    WHERE p.fk_Cod_Gabinete IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="gabinete/gabinete.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                    <div class="linha0">
                                        <div class="moverdescricaocaixa">
                                            <div class="escritacaixa"><?php echo 'Gabinete ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Slot_GPU'] . ' slots p/ GPU ' . $row['Tamanho_GPU'] ?></div>
                                        </div>
                                        <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                        <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                        break;
                    case 'monitor':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Monitor.* FROM Produto_Tipo p 
                        JOIN Monitor ON p.fk_Cod_Monitor = Monitor.Cod_Monitor
                        WHERE p.fk_Cod_Monitor IS NOT NULL AND p.Qtd_estoque > 0;";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="monitor/monitor.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                    <div class="linha0">
                                        <div class="moverdescricaocaixa">
                                            <div class="escritacaixa"><?php echo 'Monitor ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Taxa_Att'] . 'Hz  ' . ' ' . $row['Tempo_Resposta'] . 'ms ' . $row['Tamanho'] . ' ' . $row['Tipo_Painel'] . ' ' . $row['Resolucao'] ?></div>
                                        </div>
                                        <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                        <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                        break;
                    case 'mouse':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Mouse.* FROM Produto_Tipo p 
                        JOIN Mouse ON p.fk_Cod_Mouse = Mouse.Cod_Mouse
                        WHERE p.fk_Cod_Mouse IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="mouse/mouse.php?id=<?php echo $row['Cod_Produto']; ?>&tipo=Mouse" class="linkcaixa">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                    <div class="linha0">
                                        <div class="moverdescricaocaixa">
                                            <div class="escritacaixa"><?php echo 'Mouse ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Cor'] . ' ' . $row['DPI'] . 'DPI ' . $row['Tipo_Conexao'] ?></div>
                                        </div>
                                        <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                        <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                    </div>
                                </a>
                            </div>
                        <?php }
                        break;
                    case 'headset':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Headset.* FROM Produto_Tipo p
                        JOIN Headset ON p.fk_Cod_Headset = Headset.Cod_Headset
                        WHERE p.fk_Cod_Headset IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="headset/headset.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                        <?php }
                        break;
                    case 'teclado':
                        $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Teclado.* FROM Produto_Tipo p 
                        JOIN Teclado ON p.fk_Cod_Teclado = Teclado.Cod_Teclado
                        WHERE p.fk_Cod_Teclado IS NOT NULL AND p.Qtd_estoque > 0";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="bordacaixas">
                                <a href="teclado/teclado.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                            <?php }
                        break;

                    default:
                        $sqlProduto = "SELECT * FROM Produto_Tipo WHERE Marca LIKE '%$busca%' OR Modelo LIKE '%$busca%' OR Cod_Produto = '%$busca%' AND Qtd_estoque > 0";
                        $result = $conn->query($sqlProduto);
                        while ($row = $result->fetch_assoc()) {
                            $tipoProduto = '';
                            if ($row['fk_Cod_CPU'] != '') {
                                $tipoProduto = 'cpu';
                            } elseif ($row['fk_Cod_GPU'] != '') {
                                $tipoProduto = 'gpu';
                            } elseif ($row['fk_Cod_MemRAM'] != '') {
                                $tipoProduto = 'ram';
                            } elseif ($row['fk_Cod_PlacaMae'] != '') {
                                $tipoProduto = 'placa mae';
                            } elseif ($row['fk_Cod_Armazenamento'] != '') {
                                $tipoProduto = 'armazenamento';
                            } elseif ($row['fk_Cod_Fonte'] != '') {
                                $tipoProduto = 'fonte';
                            } elseif ($row['fk_Cod_Gabinete'] != '') {
                                $tipoProduto = 'gabinete';
                            } elseif ($row['fk_Cod_Monitor'] != '') {
                                $tipoProduto = 'monitor';
                            } elseif ($row['fk_Cod_Mouse'] != '') {
                                $tipoProduto = 'mouse';
                            } elseif ($row['fk_Cod_Headset'] != '') {
                                $tipoProduto = 'headset';
                            } elseif ($row['fk_Cod_Teclado'] != '') {
                                $tipoProduto = 'teclado';
                            }

                            switch ($tipoProduto) {
                                case 'cpu':
                                    $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, p.Qtd_estoque, CPU.* FROM Produto_Tipo p  
                                    JOIN CPU ON p.fk_Cod_CPU = CPU.Cod_CPU 
                                    WHERE p.fk_Cod_CPU = " . $row['fk_Cod_CPU'];
                                    $resultTipo = $conn->query($sqlTipo);
                                    $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="cpu/cpu.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa">
                                                        <?php echo 'CPU ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Frequencia'] . 'Hz ' . $rowTipo['Tipo_Mem'] . ' ' . $rowTipo['Nucleos'] . ' núcleos' ?>
                                                    </div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x
                                                    R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de
                                                    crédito</p>
                                            </div>
                                        </a>
                                    </div> <?php
                                            break;
                                        case 'gpu':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, p.Qtd_estoque, GPU.* FROM Produto_Tipo p  
                                            JOIN GPU ON p.fk_Cod_GPU = GPU.Cod_GPU 
                                            WHERE p.fk_Cod_GPU = " . $row['fk_Cod_GPU'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc();
                                            ?>
                                    <div class="bordacaixas">
                                        <a href="gpu/gpu.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'GPU ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Tam_Memoria'] . 'GB ' . $rowTipo['Tipo_Mem'] . ' ' . $rowTipo['Nucleos'] . ' núcleos' ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x
                                                    R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de
                                                    crédito</p>
                                            </div>
                                        </a>
                                    </div> <?php
                                            break;
                                        case 'ram':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Memoria_RAM.* 
                                            FROM Produto_Tipo p 
                                            JOIN Memoria_RAM ON p.fk_Cod_MemRAM = Memoria_RAM.Cod_MemRAM
                                            WHERE p.fk_Cod_MemRAM = " . $row['fk_Cod_MemRAM'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="ram/ram.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Memória RAM ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Cap_Mem'] . 'GB ' . $rowTipo['Tipo_Mem'] . ' ' . $rowTipo['Vel_Mem'] . 'Mb/s' ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'placa mae':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Placa_Mae.* 
                                            FROM Produto_Tipo p 
                                            JOIN Placa_Mae ON p.fk_Cod_PlacaMae = Placa_Mae.Cod_PlacaMae
                                            WHERE p.fk_Cod_PlacaMae = " . $row['fk_Cod_PlacaMae'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="placaMae/placaMae.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Placa mãe ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Soquete'] . ' ' . $rowTipo['Tipo_Mem'] . ' ' . $rowTipo['Vel_Mem'] . 'Mb/s' ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'armazenamento':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Armazenamento.* 
                                            FROM Produto_Tipo p 
                                            JOIN Armazenamento ON p.fk_Cod_Armazenamento = Armazenamento.Cod_Armazenamento
                                            WHERE p.fk_Cod_Armazenamento = " . $row['fk_Cod_Armazenamento'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="armazenamento/armazenamento.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo $rowTipo['Tipo'] . ' ' . $rowTipo['Conexao'] . ' ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Capacidade'] . ' ' . $rowTipo['Velocidade'] . 'Mb/s' ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'fonte':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Fonte.* 
                                            FROM Produto_Tipo p 
                                            JOIN Fonte ON p.fk_Cod_Fonte = Fonte.Cod_Fonte
                                            WHERE p.fk_Cod_Fonte = " . $row['fk_Cod_Fonte'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="fonte/fonte.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Fonte ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Potencia'] . 'W ' . $rowTipo['Voltagem'] . ' VCA, ' . $rowTipo['Certificacao'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'gabinete':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Gabinete.* 
                                            FROM Produto_Tipo p 
                                            JOIN Gabinete ON p.fk_Cod_Gabinete = Gabinete.Cod_Gabinete
                                            WHERE p.fk_Cod_Gabinete = " . $row['fk_Cod_Gabinete'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="gabinete/gabinete.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Gabinete ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Slot_GPU'] . ' slots p/ GPU ' . $rowTipo['Tamanho_GPU'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'monitor':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Monitor.* 
                                            FROM Produto_Tipo p 
                                            JOIN Monitor ON p.fk_Cod_Monitor = Monitor.Cod_Monitor
                                            WHERE p.fk_Cod_Monitor = " . $row['fk_Cod_Monitor'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="monitor/monitor.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Monitor ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Taxa_Att'] . 'Hz  ' . ' ' . $rowTipo['Tempo_Resposta'] . 'ms ' . $rowTipo['Tamanho'] . ' ' . $rowTipo['Tipo_Painel'] . ' ' . $rowTipo['Resolucao'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'mouse':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Mouse.* 
                                            FROM Produto_Tipo p 
                                            JOIN Mouse ON p.fk_Cod_Mouse = Mouse.Cod_Mouse
                                            WHERE p.fk_Cod_Mouse = " . $row['fk_Cod_Mouse'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="mouse/mouse.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Mouse ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Cor'] . ' ' . $rowTipo['DPI'] . 'DPI ' . $rowTipo['Tipo_Conexao'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'headset':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Headset.* 
                                            FROM Produto_Tipo p 
                                            JOIN Headset ON p.fk_Cod_Headset = Headset.Cod_Headset
                                            WHERE p.fk_Cod_Headset = " . $row['fk_Cod_Headset'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="headset/headset.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo 'Headset ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Tipo_Conexao'] . ' ' . $rowTipo['Frequencia_Audio'] . 'Hz ' . $rowTipo['Cor'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                        case 'teclado':
                                            $sqlTipo = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Teclado.* 
                                            FROM Produto_Tipo p 
                                            JOIN Teclado ON p.fk_Cod_Teclado = Teclado.Cod_Teclado
                                            WHERE p.fk_Cod_Teclado = " . $row['fk_Cod_Teclado'];
                                            $resultTipo = $conn->query($sqlTipo);
                                            $rowTipo = $resultTipo->fetch_assoc(); ?>
                                    <div class="bordacaixas">
                                        <a href="teclado/teclado.php?id=<?php echo $rowTipo['Cod_Produto']; ?>" class="linkcaixa">
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rowTipo['Imagem']); ?>" alt="" class="fotodentro">
                                            <div class="linha0">
                                                <div class="moverdescricaocaixa">
                                                    <div class="escritacaixa"><?php echo $rowTipo['Tipo'] . ' ' . $rowTipo['Marca'] . ' ' . $rowTipo['Modelo'] . ' ' . $rowTipo['Cor'] . ' ' . $rowTipo['Iluminacao'] ?></div>
                                                </div>
                                                <p class="precocaixa">R$ <?php echo number_format($rowTipo['Preco'], 2, ',', '.'); ?></p>
                                                <p class="parcelamentopreco">10 x R$<?php echo number_format($rowTipo['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                            </div>
                                        </a>
                                    </div><?php
                                            break;
                                    }
                                }
                                break;
                        }
                    } ?>
        </div>
    </main>

    <iframe src="Rodape.php" class="iframefooter"></iframe>

</body>

</html>