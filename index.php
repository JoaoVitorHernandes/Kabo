<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Kabo</title>
</head>

<body>
    <?php
    include('connection.php');
    session_start();
    ?>
    <iframe src="barrasNav.php" class="iframenav" style="height: 132px;"></iframe>

    <section>
        <div class="slideshow-container">

            <a href="" class="mySlides">
                <img src="img/propaganda1.png" class="propaganda">
            </a>

            <a href="" class="mySlides">
                <img src="img/propaganda2.png" class="propaganda">
            </a>

            <a href="" class="mySlides">
                <img src="img/propaganda3.png" class="propaganda">
            </a>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

        </div>

        <script>
            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                if (n > slides.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                slides[slideIndex - 1].style.display = "block";
            }
        </script>
    </section>

    <section class="moveboxfundo">
        <div class="boxfundo">

            <div class="titulocaixa">
                <p>CPUs</p>
                <a href="cpu/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, CPU.* FROM Produto_Tipo p  
                    JOIN CPU ON p.fk_Cod_CPU = CPU.Cod_CPU 
                    WHERE p.fk_Cod_CPU IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="bordacaixas">
                            <a href="cpu/cpu.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagem']); ?>" alt="" class="fotodentro">
                                <div class="linha0">
                                    <div class="moverdescricaocaixa">
                                        <div class="escritacaixa"><?php echo 'CPU ' . $row['Marca'] . ' ' . $row['Modelo'] . ' ' . $row['Frequencia'] . 'Hz ' . $row['Tipo_Mem'] . ' ' . $row['Nucleos'] . ' núcleos' ?></div>
                                    </div>
                                    <p class="precocaixa">R$ <?php echo number_format($row['Preco'], 2, ',', '.'); ?></p>
                                    <p class="parcelamentopreco">10 x R$<?php echo number_format($row['Preco'] / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>GPUs</p>
                <a href="gpu/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, GPU.* FROM Produto_Tipo p 
                    JOIN GPU ON p.fk_Cod_GPU = GPU.Cod_GPU 
                    WHERE p.fk_Cod_GPU IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Placa mãe</p>
                <a href="placaMae/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Placa_Mae.* FROM Produto_Tipo p 
                    JOIN Placa_Mae ON p.fk_Cod_PlacaMae = Placa_Mae.Cod_PlacaMae 
                    WHERE p.fk_Cod_PlacaMae IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>

            <div class="titulocaixa">
                <p>Marcas</p>
            </div>
            <div class="linkmovecaixasrecomendadas">
                <div class="movecaixasrecomendadas">
                    <a href="busca.php?b=intel" class="bordacaixasrecomendadas">
                        <img src="img/Intel-logo.png" class="caixasrecomendadas">
                        <p class="marca">Intel</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=amd" class="bordacaixasrecomendadas">
                        <img src="img/amd-logo.png" class="caixasrecomendadas">
                        <p class="marca">AMD</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=kingston" class="bordacaixasrecomendadas">
                        <img src="img/kingston-logo.jpg" class="caixasrecomendadas">
                        <p class="marca">Kingston</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=razer" class="bordacaixasrecomendadas">
                        <img src="img/razer-logo.png" class="caixasrecomendadas">
                        <p class="marca">Razer</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>

                </div>
                <div class="movecaixasrecomendadas">
                    <a href="busca.php?b=logitech" class="bordacaixasrecomendadas">
                        <img src="img/logitech-logo.png" class="caixasrecomendadas">
                        <p class="marca">Logitech</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=corsair" class="bordacaixasrecomendadas">
                        <img src="img/corsair-logo.png" class="caixasrecomendadas">
                        <p class="marca">Corsair</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=hyperX" class="bordacaixasrecomendadas">
                        <img src="img/hyper-x-logo.png" class="caixasrecomendadas">
                        <p class="marca">HyperX</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>
                    <a href="busca.php?b=msi" class="bordacaixasrecomendadas">
                        <img src="img/msi-logo.png" class="caixasrecomendadas">
                        <p class="marca">MSI</p>
                        <p class="verprodutos">ver produtos ></p>
                    </a>

                </div>
            </div>

            <div class="titulocaixa">
                <p>Memória RAM</p>
                <a href="ram/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Memoria_RAM.* FROM Produto_Tipo p 
                    JOIN Memoria_RAM ON p.fk_Cod_MemRAM = Memoria_RAM.Cod_MemRAM 
                    WHERE p.fk_Cod_MemRAM IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>
            <div class="titulocaixa">
                <p>Armazenamento</p>
                <a href="armazenamento/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Armazenamento.* FROM Produto_Tipo p 
                    JOIN Armazenamento ON p.fk_Cod_Armazenamento = Armazenamento.Cod_Armazenamento
                    WHERE p.fk_Cod_Armazenamento IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="bordacaixas">
                            <a href="armazenamento/armazenamento.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Fontes</p>
                <a href="fonte/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Fonte.* FROM Produto_Tipo p 
                    JOIN Fonte ON p.fk_Cod_Fonte = Fonte.Cod_Fonte
                    WHERE p.fk_Cod_Fonte IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Gabinetes</p>
                <a href="gabinete/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Gabinete.* FROM Produto_Tipo p 
                    JOIN Gabinete ON p.fk_Cod_Gabinete = Gabinete.Cod_Gabinete
                    WHERE p.fk_Cod_Gabinete IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Monitores</p>
                <a href="monitor/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Monitor.* FROM Produto_Tipo p 
                    JOIN Monitor ON p.fk_Cod_Monitor = Monitor.Cod_Monitor
                    WHERE p.fk_Cod_Monitor IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10;";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Mouses</p>
                <a href="mouse/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Mouse.* FROM Produto_Tipo p 
                    JOIN Mouse ON p.fk_Cod_Mouse = Mouse.Cod_Mouse
                    WHERE p.fk_Cod_Mouse IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="bordacaixas">
                            <a href="mouse/mouse.php?id=<?php echo $row['Cod_Produto']; ?>" class="linkcaixa">
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Headsets</p>
                <a href="headset/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Headset.* FROM Produto_Tipo p
                    JOIN Headset ON p.fk_Cod_Headset = Headset.Cod_Headset
                    WHERE p.fk_Cod_Headset IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10";
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
                    <?php } ?>
                </div>

                <button class="setadireita">&#10095;</button>
            </div>


            <div class="titulocaixa">
                <p>Teclados</p>
                <a href="teclado/">Ver todos ></a>
            </div>
            <div class="joinboxelements">
                <button class="setaesquerda">&#10094;</button>

                <div class="caixas">
                    <?php
                    $sql = "SELECT p.Cod_Produto, p.Marca, p.Modelo, p.Preco, p.Imagem, Teclado.* FROM Produto_Tipo p 
                    JOIN Teclado ON p.fk_Cod_Teclado = Teclado.Cod_Teclado
                    WHERE p.fk_Cod_Teclado IS NOT NULL AND p.Qtd_estoque > 0 LIMIT 10;";
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
                    <?php } ?>
                </div>
                <button class="setadireita">&#10095;</button>
            </div>


    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const joinBoxElements = document.querySelectorAll('.joinboxelements');

            joinBoxElements.forEach(function(joinBox) {
                const setaEsquerda = joinBox.querySelector('.setaesquerda');
                const setaDireita = joinBox.querySelector('.setadireita');
                const caixas = joinBox.querySelector('.caixas');

                setaDireita.addEventListener('click', function() {
                    caixas.scrollBy({
                        left: 700,
                        behavior: 'smooth'
                    });
                });

                setaEsquerda.addEventListener('click', function() {
                    caixas.scrollBy({
                        left: -700,
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>

    <iframe src="Rodape.php" class="iframefooter"></iframe>
</body>

</html>