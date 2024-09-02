<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>Exibir produtos</title>
</head>

<body>
    <?php
        include('../../connection.php');
        session_start();
        if (!isset($_SESSION["Cod_Usuario"])) {
            header("Location: /kabo/index.php");
            exit();
        }

        if ($_SESSION["Tipo_Usuario"] == 0) {
            header("Location: ../../erro.php");
            exit();
        }

        $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, fk_Cod_GPU, 
        fk_Cod_Fonte, fk_Cod_Gabinete, fk_Cod_KitProduto, fk_Cod_Monitor, fk_Cod_Mouse, fk_Cod_Headset, fk_Cod_MemRAM, 
        fk_Cod_Armazenamento, fk_Cod_Teclado, fk_Cod_CPU, Imagem FROM Produto_Tipo";
        $result = $conn->query($sql);
    ?>
    <nav>
        <div id="voltar"><a href="../">Cancelar</a></div>

        <div id="area_atual">
            <p>Exibir produtos</p>
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
            if ($imgPerfil == null) { ?>
                <a href="../../../perfil/"><img src="../../../img/perfil_padrao.png" alt="perfil">
                <p><?php echo $_clienteLogado ?></p></a>
            <?php } else {
                $imagemBase64 = base64_encode($imgPerfil); ?>
                <a href="../../../perfil/"><img src="data:image/jpeg;base64,<?php echo $imagemBase64 ?>" alt="Perfil">
                <p><?php echo $_clienteLogado ?></p></a>
            <?php } ?>
        </div>
    </nav>

    <main>
        <p id="caminho">administrar recursos &nbsp; > &nbsp; produtos &nbsp; > &nbsp; exibir</p>

        <div id="div_exibicao" style="display: flex;">
            <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="caixa_produto">';
                        echo '<div class="imagem_produto"><img src="data:image/jpeg;base64, ' . base64_encode($row['Imagem']) . ' " alt=""></div>';
                        echo '<div class="nome_produto"><p>' . $row['Marca'] . " " . $row['Modelo'] . '</p></div>';
                        echo '<div class="preco_produto"><p>R$' . $row['Preco'] . '</p></div>';
                        echo '<div class="qtd_produto"><p>' . $row['Qtd_Estoque'] . ' unidades</p></div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="avisoPerigoso">';
                    echo '<p id="avisoPesquisa">Nenhum resultado encontrado.</p>';
                    echo '</div>';
                }
            ?>
        </div>

    </main>
</body>

</html>
