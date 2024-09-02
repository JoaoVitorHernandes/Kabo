<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>Editar produto</title>
</head>

<?php 
    include("../../connection.php");

    session_start();
    if (!isset($_SESSION["Cod_Usuario"])) {
        header("Location: /kabo/index.php");
        exit();
    }

    if ($_SESSION["Tipo_Usuario"] == 0) {
        header("Location: ../../erro.php");
        exit();
    }

    function similaridade($string1, $string2, $limiar = 70) {
        similar_text($string1, $string2, $percent);
        return $percent >= $limiar;
    }

    if (isset($_GET['busca'])) {
        $busca = $_GET['busca'];
        $busca = strtolower($busca);        
        if (!empty($busca)) {
            if (similaridade($busca, "cpu")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_CPU, Imagem FROM Produto_Tipo WHERE fk_Cod_CPU > 0";
            } else if (similaridade($busca, "gpu")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_GPU, Imagem FROM Produto_Tipo WHERE fk_Cod_GPU > 0";
            } else if (similaridade($busca, "placa mae") || similaridade($busca, "mae")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, Imagem FROM Produto_Tipo WHERE fk_Cod_PlacaMae > 0";
            } else if (similaridade($busca, "memoria ram") || similaridade($busca, "ram")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_MemRAM , Imagem FROM Produto_Tipo WHERE fk_Cod_MemRAM  > 0";
            } else if (similaridade($busca, "fonte")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Fonte , Imagem FROM Produto_Tipo WHERE fk_Cod_Fonte  > 0";
            } else if (similaridade($busca, "armazenamento")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Armazenamento , Imagem FROM Produto_Tipo WHERE fk_Cod_Armazenamento > 0";
            } else if (similaridade($busca, "gabinete")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Gabinete , Imagem FROM Produto_Tipo WHERE fk_Cod_Gabinete > 0";
            } else if (similaridade($busca, "monitor")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Monitor , Imagem FROM Produto_Tipo WHERE fk_Cod_Monitor > 0";
            } else if (similaridade($busca, "teclado")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Teclado , Imagem FROM Produto_Tipo WHERE fk_Cod_Teclado > 0";
            } else if (similaridade($busca, "mouse")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Mouse , Imagem FROM Produto_Tipo WHERE fk_Cod_Mouse > 0";
            } else if (similaridade($busca, "headset")) {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_Headset , Imagem FROM Produto_Tipo WHERE fk_Cod_Headset > 0";
            } else {
                $busca = mysqli_real_escape_string($conn, $busca);
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, fk_Cod_GPU, 
                fk_Cod_Fonte, fk_Cod_Gabinete, fk_Cod_KitProduto, fk_Cod_Monitor, fk_Cod_Mouse, fk_Cod_Headset, fk_Cod_MemRAM, 
                fk_Cod_Armazenamento, fk_Cod_Teclado, fk_Cod_CPU, Imagem FROM Produto_Tipo WHERE Modelo LIKE '%$busca%' OR Marca LIKE '%$busca%' OR Cod_Produto = '$busca'";
            }
            $result = $conn->query($sql);
        }
    } else {
        $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, fk_Cod_GPU, 
        fk_Cod_Fonte, fk_Cod_Gabinete, fk_Cod_KitProduto, fk_Cod_Monitor, fk_Cod_Mouse, fk_Cod_Headset, fk_Cod_MemRAM, 
        fk_Cod_Armazenamento, fk_Cod_Teclado, fk_Cod_CPU, Imagem FROM Produto_Tipo";
        $result = $conn->query($sql);
    }
?>

<body>
    <nav>
        <div id="voltar"><a href="../">Cancelar</a></div>

        <div id="area_atual">
            <p>Editar produto</p>
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
        <p id="caminho">administrar recursos &nbsp; > &nbsp; produtos &nbsp; > &nbsp; editar</p>

        <section id="pesquisa">
            <form action="" method="get">
                <input type="text" name="busca" id="busca" placeholder="Buscar produto">
                <input type="submit" value="Buscar" style="display: none;">
            </form>

            <div id="resultado_pesquisa">
                <?php
                    if (!empty($busca) && similaridade($busca, "cpu")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-cpu="' . $row['fk_Cod_CPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "gpu")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-gpu="' . $row['fk_Cod_GPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "placa mae") || !empty($busca) && similaridade($busca, "mae")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-placa-mae="' . $row['fk_Cod_PlacaMae'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "memoria ram") || !empty($busca) && similaridade($busca, "ram")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-memram="' . $row['fk_Cod_MemRAM']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "fonte")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-fonte="' . $row['fk_Cod_Fonte']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "armazenamento")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-armazenamento="' . $row['fk_Cod_Armazenamento']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "gabinete")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-gabinete="' . $row['fk_Cod_Gabinete']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "monitor")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-monitor="' . $row['fk_Cod_Monitor']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "teclado")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-teclado="' . $row['fk_Cod_Teclado']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "mouse")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-mouse="' . $row['fk_Cod_Mouse']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else if (!empty($busca) && similaridade($busca, "headset")) {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-headset="' . $row['fk_Cod_Headset']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    } else {
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="caixa_produto">';
                                echo '<div class="botao_editar_produto" data-fk-cod-placa-mae="' . $row['fk_Cod_PlacaMae'] . '" data-fk-cod-gpu="' 
                                . $row['fk_Cod_GPU'] . '" data-fk-cod-fonte="' . $row['fk_Cod_Fonte'] . '" data-fk-cod-gabinete="' . $row['fk_Cod_Gabinete'] 
                                . '" data-fk-cod-kitproduto="' . $row['fk_Cod_KitProduto'] . '" data-fk-cod-monitor="' . $row['fk_Cod_Monitor'] 
                                . '" data-fk-cod-mouse="' . $row['fk_Cod_Mouse'] . '" data-fk-cod-headset="' . $row['fk_Cod_Headset'] 
                                . '" data-fk-cod-memram="' . $row['fk_Cod_MemRAM'] . '" data-fk-cod-armazenamento="' . $row['fk_Cod_Armazenamento'] 
                                . '" data-fk-cod-teclado="' . $row['fk_Cod_Teclado'] . '" data-fk-cod-cpu="' . $row['fk_Cod_CPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Editar</div>';
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
                    }
                
                ?>
            </div>
        </section>

        <section class="campo_inputs" id="campo_cpu" style="display: none;">
            <p class="titulo_tipo">Editar CPU</p>
            <form id="formCPU" name="formCPU" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file0" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file0" name="img" class="input_file" onchange="validaImagem(this, 0);">
                    <img src="" id="imagemCadastro0" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_catCPU" name="tipo_cat" value="CPU">
                    <input type="hidden" id="cod_produtoCPU" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoCPU" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoCPU" id="descricaoCPU" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloCPU" id="modeloCPU" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaCPU" id="marcaCPU" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="soqueteCPU" id="soqueteCPU" placeholder="Soquete" maxlength="10" required>
                    <input class="input_pequeno" type="number" name="nucleosCPU" id="nucleosCPU" placeholder="Núcleos" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="threadsCPU" id="threadsCPU" placeholder="Threads" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="frequenciaCPU" id="frequenciaCPU" placeholder="Frequência" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="tdpCPU" id="tdpCPU" placeholder="TDP" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tipo_memCPU" id="tipo_memCPU" placeholder="Tipo da memória compatível" maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memCPU" id="vel_memCPU" placeholder="Velocidade da memória compatível" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="text" name="GPUsCPU" id="GPUsCPU" placeholder="Placa de vídeo integrada" maxlength="100" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoCPU" id="precoCPU" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeCPU" id="quantidadeCPU" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_gpu" style="display: none;">
            <p class="titulo_tipo">Editar GPU</p>
            <form id="formGPU" name="formGPU" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file1" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file1" name="img" class="input_file" onchange="validaImagem(this, 1);">
                    <img src="" id="imagemCadastro1" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="GPU">
                    <input type="hidden" id="cod_produtoGPU" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoGPU" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoGPU" id="descricaoGPU" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloGPU" id="modeloGPU" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaGPU" id="marcaGPU" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="number" name="nucleosGPU" id="nucleosGPU" placeholder="Núcleos CUDA" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="capacidade_memoriaGPU" id="capacidade_memoriaGPU" placeholder="Capacidade da Memória" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="velocidadeGPU" id="velocidadeGPU" placeholder="Velocidade da Memória" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tipo_memGPU" id="tipo_memGPU" placeholder="Tipo da memória" maxlength="10" required>
                    <input class="input_pequeno" type="number" name="tdpGPU" id="tdpGPU" placeholder="TDP" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="conectorGPU" id="conectorGPU" placeholder="Conector" maxlength="20" required>
                    <input class="input_pequeno" type="number" step="0.01" name="pcieGPU" id="pcieGPU" placeholder="PCIe" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="slotGPU" id="slotGPU" placeholder="Slots" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tamanhoGPU" id="tamanhoGPU" placeholder="Tamanho" maxlength="30" required>
                    <input class="input_pequeno" type="number" name="quantidadeGPU" id="quantidadeGPU" placeholder="Quantidade" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoGPU" id="precoGPU" placeholder="Preço" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_placa_mae" style="display: none;">
            <p class="titulo_tipo">Editar placa mãe</p>
            <form id="formPlacaMae" name="formPlacaMae" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file2" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file2" name="img" class="input_file" onchange="validaImagem(this, 2);">
                    <img src="" id="imagemCadastro2" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="PlacaMae">
                    <input type="hidden" id="cod_produtoPM" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoPM" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoPM" id="descricaoPM" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloPM" id="modeloPM" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaPM" id="marcaPM" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tamanhoPM" id="tamanhoPM" placeholder="Tamanho" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="soquetePM" id="soquetePM" placeholder="Soquete" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="chipsetPM" id="chipsetPM" placeholder="Chipset" maxlength="15" required>
                    <input class="input_pequeno" type="text" name="tipo_memPM" id="tipo_memPM" placeholder="Tipo da memória compatível" maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memPM" id="vel_memPM" placeholder="Velocidade da memória compatível" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="PCIePM" id="PCIePM" placeholder="PCIe" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="M2PM" id="M2PM" placeholder="Quantiade de conexões M2" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="sataPM" id="sataPM" placeholder="Quantiade de conexões SATA" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoPM" id="precoPM" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadePM" id="quantidadePM" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_ram" style="display: none;">
            <p class="titulo_tipo">Editar memória RAM</p>
            <form id="formMemRAM" name="formMemRAM" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file3" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file3" name="img" class="input_file" onchange="validaImagem(this, 3);">
                    <img src="" id="imagemCadastro3" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="MemRAM">
                    <input type="hidden" id="cod_produtoRAM" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoRAM" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoRAM" id="descricaoRAM" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloRAM" id="modeloRAM" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaRAM" id="marcaRAM" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tipo_memRAM" id="tipo_memRAM" placeholder="Tipo da memória" maxlength="4" required>
                    <input class="input_pequeno" type="number" name="vel_memRAM" id="vel_memRAM" placeholder="Velocidade da memória" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" name="cap_memRAM" id="cap_memRAM" placeholder="Capacidade da memória" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoRAM" id="precoRAM" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeRAM" id="quantidadeRAM" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_armazenamento" style="display: none;">
            <p class="titulo_tipo">Editar armazenamento</p>
            <form id="formArma" name="formArma" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file4" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file4" name="img" class="input_file" onchange="validaImagem(this, 4);">
                    <img src="" id="imagemCadastro4" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="Armazenamento">
                    <input type="hidden" id="cod_produtoArma" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoArma" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoArma" id="descricaoArma" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloArma" id="modeloArma" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaArma" id="marcaArma" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tipoArma" id="tipoArma" placeholder="Tipo de armazenamento" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoArma" id="conexaoArma" placeholder="Tipo de conexão" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="capacidadeArma" id="capacidadeArma" placeholder="Capacidade" maxlength="10" required>
                    <input class="input_pequeno" type="number" name="velocidadeArma" id="velocidadeArma" placeholder="Velocidade" oninput="limitarNumero(this)" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoArma" id="precoArma" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeArma" id="quantidadeArma" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_fonte" style="display: none;">
            <p class="titulo_tipo">Editar fonte</p>
            <form id="formFonte" name="formFonte" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file5" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file5" name="img" class="input_file" onchange="validaImagem(this, 5);">
                    <img src="" id="imagemCadastro5" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="fonte">
                    <input type="hidden" id="cod_produtoFonte" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoFonte" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoFonte" id="descricaoFonte" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloFonte" id="modeloFonte" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaFonte" id="marcaFonte" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="number" name="potenciaFonte" id="potenciaFonte" placeholder="Potência" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="voltagemFonte" id="voltagemFonte" placeholder="Voltagem" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="correnteFonte" id="correnteFonte" placeholder="Corrente" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="certificadoFonte" id="certificadoFonte" placeholder="Certificado" maxlength="20" required>
                    <input class="input_pequeno" type="text" name="tamanhoFonte" id="tamanhoFonte" placeholder="Tamanho" maxlength="20" required>
                    <select name="modularFonte" id="modularFonte" class="input_pequeno" required>
                        <option value="TRUE">Modular</option>
                        <option value="FALSE">Com cabo</option>
                    </select>
                    <input class="input_pequeno" type="number" step="0.01" name="precoFonte" id="precoFonte" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeFonte" id="quantidadeFonte" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_gabinete" style="display: none;">
            <p class="titulo_tipo">Editar gabinete</p>
            <form id="formGabinete" name="formGabinete" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file6" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file6" name="img" class="input_file" onchange="validaImagem(this, 6);">
                    <img src="" id="imagemCadastro6" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="gabinete">
                    <input type="hidden" id="cod_produtoGabinete" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoGabinete" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoGabinete" id="descricaoGabinete" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloGabinete" id="modeloGabinete" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaGabinete" id="marcaGabinete" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tamanhoGabinete" id="tamanhoGabinete" placeholder="Tamanho do gabinete" maxlength="30" required>
                    <input class="input_pequeno" type="text" name="tamanhoPMGabinete" id="tamanhoPMGabinete" placeholder="Tamanho da placa mãe compatível" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="tamanhoGPUGabinete" id="tamanhoGPUGabinete" placeholder="Tamanho da gpu compatível" maxlength="30" required>
                    <input class="input_pequeno" type="number" step="0.01" name="slotGabinete" id="slotGabinete" placeholder="Número de slots de gpu" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="tamanhoFonteGabinete" id="tamanhoFonteGabinete" placeholder="Tamanho da fonte compatível" maxlength="20" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoGabinete" id="precoGabinete" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeGabinete" id="quantidadeGabinete" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_monitor" style="display: none;">
            <p class="titulo_tipo">Editar monitor</p>
            <form id="formMonitor" name="formMonitor" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file7" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file7" name="img" class="input_file" onchange="validaImagem(this, 7);">
                    <img src="" id="imagemCadastro7" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="monitor">
                    <input type="hidden" id="cod_produtoMonitor" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoMonitor" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoMonitor" id="descricaoMonitor" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloMonitor" id="modeloMonitor" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaMonitor" id="marcaMonitor" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tamanhoMonitor" id="tamanhoMonitor" placeholder="Tamanho" maxlength="20" required>
                    <input class="input_pequeno" type="text" name="resolucaoMonitor" id="resolucaoMonitor" placeholder="Resolução" maxlength="20" required>
                    <input class="input_pequeno" type="text" name="proporcaoMonitor" id="proporcaoMonitor" placeholder="Proporção" maxlength="5" required>
                    <input class="input_pequeno" type="text" name="tipoMonitor" id="tipoMonitor" placeholder="Tipo do painel" maxlength="5" required>
                    <input class="input_pequeno" type="number" name="taxaMonitor" id="taxaMonitor" placeholder="Taxa de atualização" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="tempoMonitor" id="tempoMonitor" placeholder="Tempo de resposta" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="hdmiMonitor" id="hdmiMonitor" placeholder="Número de entradas HDMI" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="dpMonitor" id="dpMonitor" placeholder="Número de entradas DP" max="2147483647" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoMonitor" id="precoMonitor" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeMonitor" id="quantidadeMonitor" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_teclado" style="display: none;">
            <p class="titulo_tipo">Editar teclado</p>
            <form id="formTeclado" name="formTeclado" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file8" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file8" name="img" class="input_file" onchange="validaImagem(this, 8);">
                    <img src="" id="imagemCadastro8" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="teclado">
                    <input type="hidden" id="cod_produtoTeclado" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoTeclado" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoTeclado" id="descricaoTeclado" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloTeclado" id="modeloTeclado" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaTeclado" id="marcaTeclado" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="text" name="tipoTeclado" id="tipoTeclado" placeholder="Tipo" maxlength="50" required>
                    <input class="input_pequeno" type="text" name="tamanhoTeclado" id="tamanhoTeclado" placeholder="Tamanho" maxlength="30" required>
                    <input class="input_pequeno" type="text" name="layoutTeclado" id="layoutTeclado" placeholder="Layout" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="formatoTeclado" id="formatoTeclado" placeholder="Formato" maxlength="5" required>
                    <input class="input_pequeno" type="text" name="switchTeclado" id="switchTeclado" placeholder="Switch" maxlength="30" required>
                    <input class="input_pequeno" type="text" name="corTeclado" id="corTeclado" placeholder="Cor" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="iluminacaoTeclado" id="iluminacaoTeclado" placeholder="Iluminação" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoTeclado" id="conexaoTeclado" placeholder="Conexão" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexao_tipoTeclado" id="conexao_tipoTeclado" placeholder="Tipo de conexão" maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoTeclado" id="precoTeclado" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeTeclado" id="quantidadeTeclado" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_mouse" style="display: none;">
            <p class="titulo_tipo">Editar mouse</p>
            <form id="formMouse" name="formMouse" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file9" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file9" name="img" class="input_file" onchange="validaImagem(this, 9);">
                    <img src="" id="imagemCadastro9" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="mouse">
                    <input type="hidden" id="cod_produtoMouse" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoMouse" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoMouse" id="descricaoMouse" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloMouse" id="modeloMouse" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaMouse" id="marcaMouse" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="number" name="dpiMouse" id="dpiMouse" placeholder="DPI" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="pollingMouse" id="pollingMouse" placeholder="Polling Rate" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="botoesMouse" id="botoesMouse" placeholder="Quantidade de botões" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="corMouse" id="corMouse" placeholder="Cor" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="iluminacaoMouse" id="iluminacaoMouse" placeholder="Iluminação" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoMouse" id="conexaoMouse" placeholder="Conexão" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexao_tipoMouse" id="conexao_tipoMouse" placeholder="Tipo de conexão" maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoMouse" id="precoMouse" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeMouse" id="quantidadeMouse" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

        <section class="campo_inputs" id="campo_headset" style="display: none;">
            <p class="titulo_tipo">Editar headset</p>
            <form id="formHeadset" name="formHeadset" method="post" action="editar_php.php" enctype="multipart/form-data" class="form_cadastro">
                <div class="div_input_imagem">
                    <label for="input_file10" class="label_input_file">Escolher arquivo</label>
                    <input type="file" id="input_file10" name="img" class="input_file" onchange="validaImagem(this, 10);">
                    <img src="" id="imagemCadastro10" class="imagePreview" alt="" style="visibility: visible;">
                </div>
                <div class="input_textos">
                    <input type="hidden" id="tipo_cat" name="tipo_cat" value="headset">
                    <input type="hidden" id="cod_produtoHeadset" name="cod_produto" value="">
                    <input type="hidden" id="fk_cod_produtoHeadset" name="fk_cod_produto" value="">
                    <input class="input_grande" type="text" name="descricaoHeadset" id="descricaoHeadset" placeholder="Descrição" maxlength="300" required>
                    <input class="input_medio" type="text" name="modeloHeadset" id="modeloHeadset" placeholder="Modelo" maxlength="100" readonly>
                    <input class="input_medio" type="text" name="marcaHeadset" id="marcaHeadset" placeholder="Marca" maxlength="100" readonly>
                    <input class="input_pequeno" type="number" name="driverHeadset" id="driverHeadset" placeholder="Driver" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="frequencia_audioHeadset" id="frequencia_audioHeadset" placeholder="Frequência de áudio" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="frequencia_micHeadset" id="frequencia_micHeadset" placeholder="Frequência de microfone" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="padraoHeadset" id="padraoHeadset" placeholder="Padrão polar" max="2147483647" required>
                    <input class="input_pequeno" type="text" name="corHeadset" id="corHeadset" placeholder="Cor" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="iluminacaoHeadset" id="iluminacaoHeadset" placeholder="Iluminação" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexaoHeadset" id="conexaoHeadset" placeholder="Conexão" maxlength="10" required>
                    <input class="input_pequeno" type="text" name="conexao_tipoHeadset" id="conexao_tipoHeadset" placeholder="Tipo de conexão" maxlength="10" required>
                    <input class="input_pequeno" type="number" step="0.01" name="precoHeadset" id="precoHeadset" placeholder="Preço" max="2147483647" required>
                    <input class="input_pequeno" type="number" name="quantidadeHeadset" id="quantidadeHeadset" placeholder="Quantidade" max="2147483647" required>
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </section>

    </main>

    <script>

        document.querySelector('#pesquisa form').addEventListener('submit', function(e) {
            e.preventDefault(); // Impede que o formulário seja submetido normalmente
            // Mostra a div "resultado_pesquisa"
            document.getElementById('resultado_pesquisa').style.display = 'flex';
        });

        // Função para mostrar a div "resultado_pesquisa" ao submeter o formulário
        document.querySelector('#pesquisa form').addEventListener('submit', function(e) {
            e.preventDefault(); // Impede que o formulário seja submetido normalmente
            var searchTerm = document.getElementById('busca').value.trim(); // Obtém o termo de pesquisa
            if (searchTerm !== '') {
                // Se o termo de pesquisa não estiver vazio, redireciona a página para incluir o termo na URL
                window.location.href = window.location.pathname + '?busca=' + encodeURIComponent(searchTerm);
            }
        });

        // Função para mostrar a div "resultado_pesquisa" se houver um termo de busca na URL
        window.addEventListener('DOMContentLoaded', function() {
            var searchTerm = new URLSearchParams(window.location.search).get('busca');
            if (searchTerm) {
                // Se houver um termo de busca na URL, exibe a div "resultado_pesquisa"
                document.getElementById('resultado_pesquisa').style.display = 'flex';
            }
        });

    // Função para exibir os campos de edição correspondentes às chaves estrangeiras do produto
        document.querySelectorAll('.botao_editar_produto').forEach(function(botaoEditar) {
            botaoEditar.addEventListener('click', function() {
                // Oculta todos os campos de edição
                document.querySelectorAll('.campo_inputs').forEach(function(campo) {
                    campo.style.display = 'none';
                });
                // Obtém as informações das chaves estrangeiras do atributo de dados do botão "Editar" clicado
                var fkCodPlacaMae = this.dataset.fkCodPlacaMae;
                var fkCodGPU = this.dataset.fkCodGpu;
                var fkCodFonte = this.dataset.fkCodFonte;
                var fkCodGabinete = this.dataset.fkCodGabinete;
                var fkCodKitProduto = this.dataset.fkCodKitproduto;
                var fkCodMonitor = this.dataset.fkCodMonitor;
                var fkCodMouse = this.dataset.fkCodMouse;
                var fkCodHeadset = this.dataset.fkCodHeadset;
                var fkCodMemRAM = this.dataset.fkCodMemram;
                var fkCodArmazenamento = this.dataset.fkCodArmazenamento;
                var fkCodTeclado = this.dataset.fkCodTeclado;
                var fkCodCPU = this.dataset.fkCodCpu;
                var cod_produto = this.dataset.cod_produto;

                var marca = this.dataset.marca;
                var modelo = this.dataset.modelo;
                var qtd_estoque = this.dataset.qtd_estoque;
                var preco = this.dataset.preco;
                var descricao = this.dataset.descricao;
                var imagem = this.dataset.imagem;
                // Exibe os campos de edição correspondentes às chaves estrangeiras do produto
                if (fkCodPlacaMae) {
                    document.getElementById('campo_placa_mae').style.display = 'block';
                    fetch('detalhes.php?pm=' + fkCodPlacaMae)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoPM').focus();

                        document.getElementById('tamanhoPM').value = productData.Tamanho;
                        document.getElementById('soquetePM').value = productData.Soquete;
                        document.getElementById('chipsetPM').value = productData.Chipset;
                        document.getElementById('tipo_memPM').value = productData.Tipo_Mem;
                        document.getElementById('vel_memPM').value = productData.Vel_Mem;
                        document.getElementById('PCIePM').value = productData.PCIe;
                        document.getElementById('M2PM').value = productData.M2;
                        document.getElementById('sataPM').value = productData.SATA;

                        document.getElementById('marcaPM').value = marca;
                        document.getElementById('modeloPM').value = modelo;
                        document.getElementById('quantidadePM').value = qtd_estoque;
                        document.getElementById('precoPM').value = preco;
                        document.getElementById('descricaoPM').value = descricao;
                        document.getElementById('imagemCadastro2').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoPM').value = cod_produto;
                        document.getElementById('fk_cod_produtoPM').value = fkCodPlacaMae;
                    });
                }
                if (fkCodGPU) {
                    document.getElementById('campo_gpu').style.display = 'block';
                    fetch('detalhes.php?gpu=' + fkCodGPU)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoGPU').focus()

                        document.getElementById('nucleosGPU').value = productData.Nucleos;
                        document.getElementById('capacidade_memoriaGPU').value = productData.Tam_Memoria;
                        document.getElementById('velocidadeGPU').value = productData.Vel_Mem;
                        document.getElementById('tipo_memGPU').value = productData.Tipo_Mem;
                        document.getElementById('tdpGPU').value = productData.TDP;
                        document.getElementById('conectorGPU').value = productData.Conector;
                        document.getElementById('pcieGPU').value = productData.PCIe;
                        document.getElementById('slotGPU').value = productData.Slot;
                        document.getElementById('tamanhoGPU').value = productData.Tamanho;

                        document.getElementById('marcaGPU').value = marca;
                        document.getElementById('modeloGPU').value = modelo;
                        document.getElementById('quantidadeGPU').value = qtd_estoque;
                        document.getElementById('precoGPU').value = preco;
                        document.getElementById('descricaoGPU').value = descricao;
                        document.getElementById('imagemCadastro1').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoGPU').value = cod_produto;
                        document.getElementById('fk_cod_produtoGPU').value = fkCodGPU;
                    });
                }
                if (fkCodFonte) {
                    document.getElementById('campo_fonte').style.display = 'block';
                    fetch('detalhes.php?fonte=' + fkCodFonte)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoFonte').focus()

                        document.getElementById('potenciaFonte').value = productData.Potencia;
                        document.getElementById('voltagemFonte').value = productData.Voltagem;
                        document.getElementById('correnteFonte').value = productData.Corrente;
                        document.getElementById('certificadoFonte').value = productData.Certificacao;
                        document.getElementById('tamanhoFonte').value = productData.Tamanho;

                        document.getElementById('marcaFonte').value = marca;
                        document.getElementById('modeloFonte').value = modelo;
                        document.getElementById('quantidadeFonte').value = qtd_estoque;
                        document.getElementById('precoFonte').value = preco;
                        document.getElementById('descricaoFonte').value = descricao;
                        document.getElementById('imagemCadastro5').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoFonte').value = cod_produto;
                        document.getElementById('fk_cod_produtoFonte').value = fkCodFonte;
                    });
                }
                if (fkCodGabinete) {
                    document.getElementById('campo_gabinete').style.display = 'block';
                    fetch('detalhes.php?gabinete=' + fkCodGabinete)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoGabinete').focus()

                        document.getElementById('tamanhoGabinete').value = productData.Tamanho;
                        document.getElementById('tamanhoPMGabinete').value = productData.Tamanho_PM;
                        document.getElementById('tamanhoGPUGabinete').value = productData.Tamanho_GPU;
                        document.getElementById('slotGabinete').value = productData.Slot_GPU;
                        document.getElementById('tamanhoFonteGabinete').value = productData.Tamanho_FT;


                        document.getElementById('marcaGabinete').value = marca;
                        document.getElementById('modeloGabinete').value = modelo;
                        document.getElementById('quantidadeGabinete').value = qtd_estoque;
                        document.getElementById('precoGabinete').value = preco;
                        document.getElementById('descricaoGabinete').value = descricao;
                        document.getElementById('imagemCadastro6').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoGabinete').value = cod_produto;
                        document.getElementById('fk_cod_produtoGabinete').value = fkCodGabinete;
                    });
                }
                if (fkCodMonitor) {
                    document.getElementById('campo_monitor').style.display = 'block';
                    fetch('detalhes.php?monitor=' + fkCodMonitor)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoMonitor').focus()

                        document.getElementById('tamanhoMonitor').value = productData.Tamanho;
                        document.getElementById('resolucaoMonitor').value = productData.Resolucao;
                        document.getElementById('proporcaoMonitor').value = productData.Proporcao;
                        document.getElementById('tipoMonitor').value = productData.Tipo_Painel;
                        document.getElementById('taxaMonitor').value = productData.Taxa_Att;
                        document.getElementById('tempoMonitor').value = productData.Tempo_Resposta;
                        document.getElementById('hdmiMonitor').value = productData.HDMI;
                        document.getElementById('dpMonitor').value = productData.DP;

                        document.getElementById('marcaMonitor').value = marca;
                        document.getElementById('modeloMonitor').value = modelo;
                        document.getElementById('quantidadeMonitor').value = qtd_estoque;
                        document.getElementById('precoMonitor').value = preco;
                        document.getElementById('descricaoMonitor').value = descricao;
                        document.getElementById('imagemCadastro7').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoMonitor').value = cod_produto;
                        document.getElementById('fk_cod_produtoMonitor').value = fkCodMonitor;
                    });
                }
                if (fkCodMouse) {
                    document.getElementById('campo_mouse').style.display = 'block';
                    fetch('detalhes.php?mouse=' + fkCodMouse)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoMouse').focus()

                        document.getElementById('dpiMouse').value = productData.DPI;
                        document.getElementById('pollingMouse').value = productData.Polling_Rate;
                        document.getElementById('botoesMouse').value = productData.Botoes;
                        document.getElementById('pollingMouse').value = productData.Polling_Rate;
                        document.getElementById('corMouse').value = productData.Cor;
                        document.getElementById('iluminacaoMouse').value = productData.Iluminacao;
                        document.getElementById('conexaoMouse').value = productData.Conexao;
                        document.getElementById('conexao_tipoMouse').value = productData.Tipo_Conexao;


                        document.getElementById('marcaMouse').value = marca;
                        document.getElementById('modeloMouse').value = modelo;
                        document.getElementById('quantidadeMouse').value = qtd_estoque;
                        document.getElementById('precoMouse').value = preco;
                        document.getElementById('descricaoMouse').value = descricao;
                        document.getElementById('imagemCadastro9').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoMouse').value = cod_produto;
                        document.getElementById('fk_cod_produtoMouse').value = fkCodMouse;
                    });
                }
                if (fkCodHeadset) {
                    document.getElementById('campo_headset').style.display = 'block';
                    fetch('detalhes.php?headset=' + fkCodHeadset)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoHeadset').focus()

                        document.getElementById('driverHeadset').value = productData.Driver;
                        document.getElementById('frequencia_audioHeadset').value = productData.Frequencia_Audio;
                        document.getElementById('frequencia_micHeadset').value = productData.Frequencia_Mic;
                        document.getElementById('padraoHeadset').value = productData.Padrao_Polar;
                        document.getElementById('corHeadset').value = productData.Cor;
                        document.getElementById('iluminacaoHeadset').value = productData.Iluminacao;
                        document.getElementById('conexaoHeadset').value = productData.Conexao;
                        document.getElementById('conexao_tipoHeadset').value = productData.Tipo_Conexao;


                        document.getElementById('marcaHeadset').value = marca;
                        document.getElementById('modeloHeadset').value = modelo;
                        document.getElementById('quantidadeHeadset').value = qtd_estoque;
                        document.getElementById('precoHeadset').value = preco;
                        document.getElementById('descricaoHeadset').value = descricao;
                        document.getElementById('imagemCadastro10').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoHeadset').value = cod_produto;
                        document.getElementById('fk_cod_produtoHeadset').value = fkCodHeadset;
                    });
                }
                if (fkCodMemRAM) {
                    document.getElementById('campo_ram').style.display = 'block';
                    fetch('detalhes.php?ram=' + fkCodMemRAM)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoRAM').focus()

                        document.getElementById('tipo_memRAM').value = productData.Tipo_Mem;
                        document.getElementById('vel_memRAM').value = productData.Vel_Mem;
                        document.getElementById('cap_memRAM').value = productData.Cap_Mem;

                        document.getElementById('marcaRAM').value = marca;
                        document.getElementById('modeloRAM').value = modelo;
                        document.getElementById('quantidadeRAM').value = qtd_estoque;
                        document.getElementById('precoRAM').value = preco;
                        document.getElementById('descricaoRAM').value = descricao;
                        document.getElementById('imagemCadastro3').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoRAM').value = cod_produto;
                        document.getElementById('fk_cod_produtoRAM').value = fkCodMemRAM;
                    });
                }
                if (fkCodArmazenamento) {
                    document.getElementById('campo_armazenamento').style.display = 'block';
                    fetch('detalhes.php?arma=' + fkCodArmazenamento)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoArma').focus()

                        document.getElementById('tipoArma').value = productData.Tipo;
                        document.getElementById('conexaoArma').value = productData.Conexao;
                        document.getElementById('capacidadeArma').value = productData.Capacidade;
                        document.getElementById('velocidadeArma').value = productData.Velocidade;


                        document.getElementById('marcaArma').value = marca;
                        document.getElementById('modeloArma').value = modelo;
                        document.getElementById('quantidadeArma').value = qtd_estoque;
                        document.getElementById('precoArma').value = preco;
                        document.getElementById('descricaoArma').value = descricao;
                        document.getElementById('imagemCadastro4').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoArma').value = cod_produto;
                        document.getElementById('fk_cod_produtoArma').value = fkCodArmazenamento;
                    });
                }
                if (fkCodTeclado) {
                    document.getElementById('campo_teclado').style.display = 'block';
                    fetch('detalhes.php?teclado=' + fkCodTeclado)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoTeclado').focus()

                        document.getElementById('tipoTeclado').value = productData.Tipo;
                        document.getElementById('tamanhoTeclado').value = productData.Tamanho;
                        document.getElementById('layoutTeclado').value = productData.Layout;
                        document.getElementById('formatoTeclado').value = productData.Formato;
                        document.getElementById('switchTeclado').value = productData.Switch;
                        document.getElementById('corTeclado').value = productData.Cor;
                        document.getElementById('iluminacaoTeclado').value = productData.Iluminacao;
                        document.getElementById('conexaoTeclado').value = productData.Conexao;
                        document.getElementById('conexao_tipoTeclado').value = productData.Tipo_Conexao;


                        document.getElementById('marcaTeclado').value = marca;
                        document.getElementById('modeloTeclado').value = modelo;
                        document.getElementById('quantidadeTeclado').value = qtd_estoque;
                        document.getElementById('precoTeclado').value = preco;
                        document.getElementById('descricaoTeclado').value = descricao;
                        document.getElementById('imagemCadastro8').src = "data:image/jpeg;base64," + imagem;

                        document.getElementById('cod_produtoTeclado').value = cod_produto;
                        document.getElementById('fk_cod_produtoTeclado').value = fkCodTeclado;
                    });
                }
                if (fkCodCPU) {
                    document.getElementById('campo_cpu').style.display = 'block';
                    fetch('detalhes.php?cpu=' + fkCodCPU)
                    .then(response => response.json())
                    .then(productData => {  
                        document.getElementById('descricaoCPU').focus()

                        document.getElementById('soqueteCPU').value = productData.Soquete;
                        document.getElementById('frequenciaCPU').value = productData.Frequencia;
                        document.getElementById('nucleosCPU').value = productData.Nucleos;
                        document.getElementById('threadsCPU').value = productData.Threads;
                        document.getElementById('tipo_memCPU').value = productData.Tipo_Mem;
                        document.getElementById('vel_memCPU').value = productData.Vel_Mem;
                        document.getElementById('GPUsCPU').value = productData.GPUs;
                        document.getElementById('tdpCPU').value = productData.TDP;

                        document.getElementById('marcaCPU').value = marca;
                        document.getElementById('modeloCPU').value = modelo;
                        document.getElementById('quantidadeCPU').value = qtd_estoque;
                        document.getElementById('precoCPU').value = preco;
                        document.getElementById('descricaoCPU').value = descricao;
                        document.getElementById('imagemCadastro0').src = "data:image/jpeg;base64," + imagem;


                        document.getElementById('cod_produtoCPU').value = cod_produto;
                        document.getElementById('fk_cod_produtoCPU').value = fkCodCPU;
                    });
                }
            });
        });

        // Função para tornar os inputs somente para leitura após o envio do formulário
        var forms = document.querySelectorAll('.form_cadastro');
        // Adiciona um ouvinte de evento a cada formulário
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                // Percorre todos os inputs do formulário
                var inputs = form.querySelectorAll('input');
                inputs.forEach(function(input) {
                    // Torna o input somente para leitura
                    input.readOnly = true;
                });
            });
        });

        // Função para mostrar a imagem selecionada no cadastro
        function uploadImg(index) {
            document.getElementById(`botao_upload${index}`).addEventListener('click', function() {
                document.getElementById(`input_file${index}`).click();
            });

            document.getElementById(`input_file${index}`).addEventListener('change', function(e) {
                var nome_arquivo = e.target.files[0].name;
                document.getElementById(`nome_arquivo${index}`).value = nome_arquivo;

                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(`imagePreview${index}`).innerHTML = '<img src="' + e.target.result + '">';
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        }

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
