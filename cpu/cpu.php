<?php
include('../connection.php');
session_start();

$usuario = isset($_SESSION['Cod_Usuario']) ? $_SESSION['Cod_Usuario'] : '';
$id = $_GET['id']; /* id produto */

/* select para produto */
$sqlProduto = "SELECT * FROM Produto_Tipo JOIN CPU ON fk_Cod_CPU = CPU.Cod_CPU WHERE Cod_Produto = $id";
$resultProduto = $conn->query($sqlProduto);
$rowProduto = $resultProduto->fetch_assoc();
$descricao = $rowProduto['Descricao'];
$preco = $rowProduto['Preco'];
$modelo = $rowProduto['Modelo'];
$marca = $rowProduto['Marca'];
$estoque = $rowProduto['Qtd_estoque'];
$imagem = base64_encode($rowProduto['Imagem']);

$descricaoEspecificacoes = 'CPU ' . $marca . ' ' . $modelo . ' ' . $rowProduto['Frequencia'] . 'Hz ' . $rowProduto['Tipo_Mem'] . ' ' . $rowProduto['Nucleos'] . ' núcleos';

/* select para endereço */
if ($usuario != '') {
    $sqlEndereco = "SELECT * FROM Endereco WHERE Cod_Endereco = '{$usuario}'";
    $resultEndereco = $conn->query($sqlEndereco);
    $sqlUsuario = "SELECT * FROM Usuario WHERE Cod_Usuario = '{$usuario}'";
    $resultUsuario = $conn->query($sqlUsuario);
    $rowEndereco = $resultEndereco->fetch_assoc();
    $rowUsuario = $resultUsuario->fetch_assoc();
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <title><?php echo $descricaoEspecificacoes; ?></title>
</head>

<body>
    <iframe src="../barrasNav.php" frameborder="0" class="iframenav"></iframe>

    <div class="moveboxfundo">
        <div class="boxfundo2">
            <div class="alignConteudo">
                <img src="data:image/jpeg;base64,<?php echo $imagem; ?>" alt="" id="fotoProduto">
                <div class="alignTexts">
                    <p id="descricaoMarcaModelo">
                        <?php echo $descricaoEspecificacoes; ?>
                        <input type="hidden" name="codProduto" id="codProduto" value="<?php echo $id; ?>">
                        <input type="hidden" id="codUsuario" value="<?php echo $usuario; ?>">
                    </p>

                    <div class="alignImgTitleDescricao">
                        <img src="../img/escrita.png" alt="">
                        <p id="titleDescricao">DESCRIÇÃO</p>
                    </div>
                    <p id="descricao"><?php echo $descricao; ?></p>
                    <div class="alignImgTitleDescricao">
                        <img src="../img/chip.png" alt="">
                        <p id="titleespecificacoes">ESPECIFICAÇÕES TÉCNICAS</p>
                    </div>

                    <p id="especificacoes"></p>
                    <div class="alignInRow">
                        <p>Marca</p>
                        <p><?php echo $marca; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Modelo</p>
                        <p><?php echo $modelo; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Soquete</p>
                        <p><?php echo $rowProduto['Soquete']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Núcleos</p>
                        <p><?php echo $rowProduto['Nucleos']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Threads</p>
                        <p><?php echo $rowProduto['Threads']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Frequência</p>
                        <p><?php echo $rowProduto['Frequencia']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>TDP</p>
                        <p><?php echo $rowProduto['TDP']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Tipo Memória Compatível</p>
                        <p><?php echo $rowProduto['Tipo_Mem']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Velocidade Memória Compatível</p>
                        <p><?php echo $rowProduto['Vel_Mem']; ?></p>
                    </div>
                    <div class="alignInRow">
                        <p>Placa de Vídeo Integrada</p>
                        <p><?php echo $rowProduto['GPUs']; ?></p>
                    </div>

                </div>

                <div class="areaAddCarrinho">
                    <div class="alignPreco">
                        <p>R$ <?php echo number_format($preco, 2, ',', '.'); ?> </p>
                        <p>&ensp;á vista</p>
                    </div>
                    <p id="textSemJuros">10 x R$ <?php echo number_format($preco / 10, 2, ',', '.'); ?> sem juros no cartão de crédito</p>
                    <?php
                    if ($usuario != '') { ?>
                        <div class="alignDados">
                            <img src="../img/pin.png" id="pinLocal">
                            <div>
                                <p>Enviar para <?php echo (explode(' ', $rowUsuario['Nome'])[0]) ?> - <?php echo $rowEndereco['Cidade'] ?> - <?php echo $rowEndereco['CEP'] ?></p>
                                <p id="entregaGratis">Entrega Grátis</p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($estoque == 0) { ?>
                        <script>
                            var elements = document.getElementsByClassName('areaAddCarrinho');
                            for (var i = 0; i < elements.length; i++) {
                                elements[i].style.display = 'none';
                                elements[i].insertAdjacentHTML('afterend', "<p id='esgotado'>Esgotado!</p>");
                            }
                        </script>
                    <?php }; ?>
                    <div class="quantidade">
                        <p>Quantidade:</p>
                    </div>
                    <div class="number-control">
                        <div class="number-left" id="decrementButton"></div>
                        <input type="number" name="numberInput" id="numberInput" class="number-quantity" min="1" max="<?php echo min(10, $estoque); ?>" value="1" readonly>
                        <div class="number-right" id="incrementButton"></div>
                    </div>

                    <div class="buttonAdd">
                        <img src="../img/carrinho.png" alt="" id="../imgCarrinho">
                        <p>Adicionar ao Carrinho</p>
                    </div>

                    <div class="buttonAdded" style="display: none;">
                        <p>✓ Adicionado com Sucesso</p>
                    </div>

                    <div id="botaoLoginNecessario" style="display: none;">
                        <p>Login necessário</p>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <iframe src="../Rodape.php" frameborder="0" class="iframefooter"></iframe>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../produtos.js"></script>
</body>

</html>