<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>Cadastrar produto</title>
</head>

<body>
    <?php
    include ("../../connection.php");

    session_start();
    if (!isset($_SESSION["Cod_Usuario"])) {
        header("Location: /kabo/index.php");
        exit();
    }

    if ($_SESSION["Tipo_Usuario"] == 0) {
        header("Location: ../../erro.php");
        exit();
    }
    ?>
    <nav>
        <div id="voltar"><a href="../">Cancelar</a></div>

        <div id="area_atual">
            <p>Cadastrar produto</p>
        </div>

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
                    <a href="../../../perfil/"><img src="../img/perfil_padrao.png" alt="">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php 
                } else {
                    $imagemBase64 = base64_encode($imgPerfil); ?>
                    <a href="../../../perfil/"><img src="data:image/jpeg;base64,<?php echo $imagemBase64 ?>"  alt="Perfil">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php
                }
                ?>
        </div>
    </nav>

    <main>
        <p id="caminho">administrar recursos &nbsp; > &nbsp; produtos &nbsp; > &nbsp; cadastrar</p>

        <section class="campo_tipo">
            <select name="tipo" id="tipo">
                <option value="" selected>Selecione um tipo</option>
                <option value="cpu">CPU</option>
                <option value="gpu">GPU</option>
                <option value="placa_mae">Placa mãe</option>
                <option value="ram">Memória RAM</option>
                <option value="armazenamento">Armazenamento</option>
                <option value="fonte">Fonte</option>
                <option value="gabinete">Gabinete</option>
                <option value="monitor">Monitor</option>
                <option value="teclado">Teclado</option>
                <option value="mouse">Mouse</option>
                <option value="headset">Headset</option>
            </select>
        </section>

        <section class="campo_inputs" id="campo_cpu" style="display: none;">
            <p class="titulo_tipo">Cadastrar CPU</p>
            <form id="formCPU" name="formCPU" method="post" action="cadastro_php.php" enctype="multipart/form-data"
                class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file0" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file0" name="img" class="input_file" onchange="validaImagem(this, 0);" required>
                    <img src="" id="imagemCadastro0" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="CPU">
                    <input class="input_grande" type="text" name="descricaoCPU" id="descricaoCPU"
                        placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloCPU" id="modeloCPU" placeholder="Modelo"
                        maxlength="100" required>
                    <input class="input_medio" type="text" name="marcaCPU" id="marcaCPU" placeholder="Marca"
                        maxlength="25" required>
                    <input class="input_pequeno" type="text" name="soqueteCPU" id="soqueteCPU" placeholder="Soquete"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" name="nucleosCPU" id="nucleosCPU" placeholder="Núcleos"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="threadsCPU" id="threadsCPU" placeholder="Threads"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="frequenciaCPU" id="frequenciaCPU"
                        placeholder="Frequência" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="tdpCPU" id="tdpCPU" placeholder="TDP"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tipo_memCPU" id="tipo_memCPU"
                        placeholder="Tipo da memória compatível" maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memCPU" id="vel_memCPU"
                        placeholder="Velocidade da memória compatível" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="text" name="GPUsCPU" id="GPUsCPU"
                        placeholder="Placa de vídeo integrada" maxlength="100" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoCPU" id="precoCPU"
                        placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeCPU" id="quantidadeCPU"
                        placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_gpu" style="display: none;">
            <p class="titulo_tipo">Cadastrar GPU</p>
            <form id="formGPU" name="formGPU" method="post" action="cadastro_php.php" enctype="multipart/form-data"
                class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file1" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file1" name="img" class="input_file" onchange="validaImagem(this, 1);" required>
                    <img src="" id="imagemCadastro1" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="GPU">
                    <input class="input_grande" type="text" name="descricaoGPU" placeholder="Descrição" maxlength="300"
                        required>
                    <input class="input_medio" type="text" name="modeloGPU" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaGPU" placeholder="Marca" maxlength="100" required>
                    <input class="input_pequeno" type="number" name="nucleosGPU" placeholder="Núcleos CUDA"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="capacidade_memoriaGPU"
                        placeholder="Capacidade da Memória" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="velocidadeGPU" placeholder="Velocidade da Memória"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tipo_memGPU" placeholder="Tipo da memória"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" name="tdpGPU" placeholder="TDP" max="2147483647"
                        required>
                    <input class="input_pequeno" type="text" name="conectorGPU" placeholder="Conector" maxlength="20"
                        required>
                    <input class="input_pequeno" type="number" step="0.01" name="pcieGPU" placeholder="PCIe"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="slotGPU" placeholder="Slots"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tamanhoGPU" placeholder="Tamanho" maxlength="30"
                        required>
                    <input class="input_pequeno" type="number" name="quantidadeGPU" id="quantidadeGPU"
                        placeholder="Quantidade" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoGPU" id="precoGPU"
                        placeholder="Preço" max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_placa_mae" style="display: none;">
            <p class="titulo_tipo">Cadastrar placa mãe</p>
            <form id="formPlacaMae" name="formPlacaMae" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file2" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file2" name="img" class="input_file" onchange="validaImagem(this, 2);" required>
                    <img src="" id="imagemCadastro2" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="PlacaMae">
                    <input class="input_grande" type="text" name="descricaoPM" placeholder="Descrição" maxlength="300"
                        required>
                    <input class="input_medio" type="text" name="modeloPM" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaPM" placeholder="Marca" maxlength="100" required>
                    <input class="input_pequeno" type="text" name="tamanhoPM" placeholder="Tamanho" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="soquetePM" placeholder="Soquete" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="chipsetPM" placeholder="Chipset" maxlength="15"
                        required>
                    <input class="input_pequeno" type="text" name="tipo_memPM" placeholder="Tipo da memória compatível"
                        maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memPM"
                        placeholder="Velocidade da memória compatível" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="PCIePM" placeholder="PCIe"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="M2PM" placeholder="Quantiade de conexões M2"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="sataPM" placeholder="Quantiade de conexões SATA"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoPM" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadePM" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_ram" style="display: none;">
            <p class="titulo_tipo">Cadastrar memória RAM</p>
            <form id="formMemRAM" name="formMemRAM" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file3" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file3" name="img" class="input_file" onchange="validaImagem(this, 3);" required>
                    <img src="" id="imagemCadastro3" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="MemRAM">
                    <input class="input_grande" type="text" name="descricaoRAM" placeholder="Descrição" maxlength="300"
                        required>
                    <input class="input_medio" type="text" name="modeloRAM" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaRAM" placeholder="Marca" maxlength="100" required>
                    <input class="input_pequeno" type="text" name="tipo_memRAM" placeholder="Tipo da memória"
                        maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memRAM" placeholder="Velocidade da memória"
                        oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" name="cap_memRAM" placeholder="Capacidade da memória"
                        oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoRAM" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeRAM" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_armazenamento" style="display: none;">
            <p class="titulo_tipo">Cadastrar armazenamento</p>
            <form id="formArma" name="formArma" method="post" action="cadastro_php.php" enctype="multipart/form-data"
                class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file4" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file4" name="img" class="input_file" onchange="validaImagem(this, 4);" required>
                    <img src="" id="imagemCadastro4" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="Armazenamento">
                    <input class="input_grande" type="text" name="descricaoArma" placeholder="Descrição" maxlength="300"
                        required>
                    <input class="input_medio" type="text" name="modeloArma" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaArma" placeholder="Marca" maxlength="100" required>
                    <input class="input_pequeno" type="text" name="tipoArma" placeholder="Tipo de armazenamento"
                        maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoArma" placeholder="Tipo de conexão"
                        maxlength="10" required>
                    <input class="input_pequeno" type="text" name="capacidadeArma" placeholder="Capacidade"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" name="velocidadeArma" placeholder="Velocidade"
                        oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoArma" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeArma" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_fonte" style="display: none;">
            <p class="titulo_tipo">Cadastrar fonte</p>
            <form id="formFonte" name="formFonte" method="post" action="cadastro_php.php" enctype="multipart/form-data"
                class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file5" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file5" name="img" class="input_file" onchange="validaImagem(this, 5);" required>
                    <img src="" id="imagemCadastro5" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="fonte">
                    <input class="input_grande" type="text" name="descricaoFonte" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloFonte" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaFonte" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="number" name="potenciaFonte" placeholder="Potência"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="voltagemFonte" placeholder="Voltagem"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="correnteFonte" placeholder="Corrente"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="certificadoFonte" placeholder="Certificado"
                        maxlength="20" required>
                    <input class="input_pequeno" type="text" name="tamanhoFonte" placeholder="Tamanho" maxlength="20"
                        required>
                    <select name="modularFonte" class="input_pequeno" required>
                        <option value="TRUE">Modular</option>
                        <option value="FALSE">Com cabo</option>
                    </select>
                    <input class="input_pequeno" type="number" step="0.01" name="precoFonte" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeFonte" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_gabinete" style="display: none;">
            <p class="titulo_tipo">Cadastrar gabinete</p>
            <form id="formGabinete" name="formGabinete" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file6" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file6" name="img" class="input_file" onchange="validaImagem(this, 6);" required>
                    <img src="" id="imagemCadastro6" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="gabinete">
                    <input class="input_grande" type="text" name="descricaoGabinete" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloGabinete" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaGabinete" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="text" name="tamanhoGabinete" placeholder="Tamanho do gabinete"
                        maxlength="30" required>
                    <input class="input_pequeno" type="text" name="tamanhoPMGabinete"
                        placeholder="Tamanho da placa mãe compatível" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="tamanhoGPUGabinete"
                        placeholder="Tamanho da gpu compatível" maxlength="30" required>
                    <input class="input_pequeno" type="number" step="0.01" name="slotGabinete"
                        placeholder="Número de slots de gpu" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tamanhoFonteGabinete"
                        placeholder="Tamanho da fonte compatível" maxlength="20" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoGabinete" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeGabinete" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_monitor" style="display: none;">
            <p class="titulo_tipo">Cadastrar monitor</p>
            <form id="formMonitor" name="formMonitor" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file7" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file7" name="img" class="input_file" onchange="validaImagem(this, 7);" required>
                    <img src="" id="imagemCadastro7" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="monitor">
                    <input class="input_grande" type="text" name="descricaoMonitor" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloMonitor" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaMonitor" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="text" name="tamanhoMonitor" placeholder="Tamanho" maxlength="20"
                        required>
                    <input class="input_pequeno" type="text" name="resolucaoMonitor" placeholder="Resolução"
                        maxlength="20" required>
                    <input class="input_pequeno" type="text" name="proporcaoMonitor" placeholder="Proporção"
                        maxlength="5" required>
                    <input class="input_pequeno" type="text" name="tipoMonitor" placeholder="Tipo do painel"
                        maxlength="5" required>
                    <input class="input_pequeno" type="number" name="taxaMonitor" placeholder="Taxa de atualização"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="tempoMonitor"
                        placeholder="Tempo de resposta" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="hdmiMonitor" placeholder="Número de entradas HDMI"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="dpMonitor" placeholder="Número de entradas DP"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoMonitor" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeMonitor" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_teclado" style="display: none;">
            <p class="titulo_tipo">Cadastrar teclado</p>
            <form id="formTeclado" name="formTeclado" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file8" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file8" name="img" class="input_file" onchange="validaImagem(this, 8);" required>
                    <img src="" id="imagemCadastro8" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="teclado">
                    <input class="input_grande" type="text" name="descricaoTeclado" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloTeclado" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaTeclado" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="text" name="tipoTeclado" placeholder="Tipo" maxlength="50"
                        required>
                    <input class="input_pequeno" type="text" name="tamanhoTeclado" placeholder="Tamanho" maxlength="30"
                        required>
                    <input class="input_pequeno" type="text" name="layoutTeclado" placeholder="Layout" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="formatoTeclado" placeholder="Formato" maxlength="5"
                        required>
                    <input class="input_pequeno" type="text" name="switchTeclado" placeholder="Switch" maxlength="30"
                        required>
                    <input class="input_pequeno" type="text" name="corTeclado" placeholder="Cor" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="iluminacaoTeclado" placeholder="Iluminação"
                        maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoTeclado" placeholder="Conexão" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="conexao_tipoTeclado" placeholder="Tipo de conexão"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoTeclado" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeTeclado" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_mouse" style="display: none;">
            <p class="titulo_tipo">Cadastrar mouse</p>
            <form id="formMouse" name="formMouse" method="post" action="cadastro_php.php" enctype="multipart/form-data"
                class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file9" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file9" name="img" class="input_file" onchange="validaImagem(this, 9);" required>
                    <img src="" id="imagemCadastro9" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="mouse">
                    <input class="input_grande" type="text" name="descricaoMouse" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloMouse" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaMouse" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="number" name="dpiMouse" placeholder="DPI" max="2147483647"
                        required>
                    <input class="input_pequeno" type="number" name="pollingMouse" placeholder="Polling Rate"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="botoesMouse" placeholder="Quantidade de botões"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="corMouse" placeholder="Cor" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="iluminacaoMouse" placeholder="Iluminação"
                        maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoMouse" placeholder="Conexão" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="conexao_tipoMouse" placeholder="Tipo de conexão"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoMouse" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeMouse" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_headset" style="display: none;">
            <p class="titulo_tipo">Cadastrar headset</p>
            <form id="formHeadset" name="formHeadset" method="post" action="cadastro_php.php"
                enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file10" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file10" name="img" class="input_file" onchange="validaImagem(this, 10);" required>
                    <img src="" id="imagemCadastro10" class="imagePreview" alt="">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="headset">
                    <input class="input_grande" type="text" name="descricaoHeadset" placeholder="Descrição"
                        maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloHeadset" placeholder="Modelo" maxlength="100"
                        required>
                    <input class="input_medio" type="text" name="marcaHeadset" placeholder="Marca" maxlength="100"
                        required>
                    <input class="input_pequeno" type="number" name="driverHeadset" placeholder="Driver"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="frequencia_audioHeadset"
                        placeholder="Frequência de áudio" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="frequencia_micHeadset"
                        placeholder="Frequência de microfone" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="padraoHeadset" placeholder="Padrão polar"
                        max="2147483647" required>
                    <input class="input_pequeno" type="text" name="corHeadset" placeholder="Cor" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="iluminacaoHeadset" placeholder="Iluminação"
                        maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoHeadset" placeholder="Conexão" maxlength="10"
                        required>
                    <input class="input_pequeno" type="text" name="conexao_tipoHeadset" placeholder="Tipo de conexão"
                        maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoHeadset" placeholder="Preço"
                        max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeHeadset" placeholder="Quantidade"
                        max="2147483647" required>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </section>

    </main>

    <script>

        function limitarNumero(input) {
            var maxLength = 4;
            var valor = input.value;
            if (valor.length > maxLength) {
                input.value = valor.slice(0, maxLength);
            }
        }

        // Função para voltar à página anterior
        document.getElementById('voltar').addEventListener('click', function (e) {
            e.preventDefault();
            history.back();
        });


        document.getElementById('tipo').addEventListener('change', function () {
            // Ocultar todos os campos de entrada e limpar os valores, exceto o input desejado
            document.querySelectorAll('.campo_inputs').forEach(function (campo) {
                campo.style.display = 'none';
                campo.querySelectorAll('input').forEach(function (input) {
                    // Verifique se o input não é o que você deseja excluir
                    if (input.id !== 'tipo_cat') {
                        input.value = '';
                    }
                });
            });
            // Mostrar o campo de entrada correspondente à seleção do usuário
            var tipo = this.value;
            if (tipo) {
                document.getElementById('campo_' + tipo).style.display = 'block';
            }
        });



        // Função para mostrar a imagem selecionada no cadastro
        function validaImagem(input, index) {
            var caminho = input.value;

            if (caminho) {
                var comecoCaminho = (caminho.indexOf('\\') >= 0 ? caminho.lastIndexOf('\\') : caminho.lastIndexOf('/'));
                var nomeArquivo = caminho.substring(comecoCaminho);

                if (nomeArquivo.indexOf('\\') === 0 || nomeArquivo.indexOf('/') === 0) {
                    nomeArquivo = nomeArquivo.substring(1);
                }

                var extensaoArquivo = nomeArquivo.indexOf('.') < 1 ? '' : nomeArquivo.split('.').pop();

                if (extensaoArquivo != 'gif' &&
                    extensaoArquivo != 'png' &&
                    extensaoArquivo != 'jpg' &&
                    extensaoArquivo != 'jpeg') {
                    input.value = '';
                    alert("É preciso selecionar um arquivo de imagem (gif, png, jpg ou jpeg)");
                }
            } else {
                input.value = '';
                alert("Selecione um caminho de arquivo válido");
            }
            if (input.files && input.files[0]) {
                var arquivoTam = input.files[0].size / 1024 / 1024;
                if (arquivoTam < 16) {
                    var reader = new FileReader();
                    reader.onload = function (e) {

                        document.getElementById(`imagemCadastro${index}`).style.visibility = "visible";
                        document.getElementById(`imagemCadastro${index}`).setAttribute('src', e.target.result);


                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    input.value = '';
                    alert("O arquivo precisa ser uma imagem com menos de 16 MB");
                }
            } else {

                document.getElementById(`imagemCadastro${index}`).setAttribute('src', '#');
            }
        }


    </script>
</body>

</html>
