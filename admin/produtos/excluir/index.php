<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style.css">
    <title>Excluir produto</title>
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
            } else {
                $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, fk_Cod_GPU, 
                fk_Cod_Fonte, fk_Cod_Gabinete, fk_Cod_KitProduto, fk_Cod_Monitor, fk_Cod_Mouse, fk_Cod_Headset, fk_Cod_MemRAM, 
                fk_Cod_Armazenamento, fk_Cod_Teclado, fk_Cod_CPU, Imagem FROM Produto_Tipo";
                $result = $conn->query($sql); 
            }
        } else {
            $sql = "SELECT Cod_Produto, Descricao, Preco, Modelo, Marca, Qtd_Estoque, fk_Cod_PlacaMae, fk_Cod_GPU, 
            fk_Cod_Fonte, fk_Cod_Gabinete, fk_Cod_KitProduto, fk_Cod_Monitor, fk_Cod_Mouse, fk_Cod_Headset, fk_Cod_MemRAM, 
            fk_Cod_Armazenamento, fk_Cod_Teclado, fk_Cod_CPU, Imagem FROM Produto_Tipo";
            $result = $conn->query($sql);
        }
    ?>
    <nav>
        <div id="voltar"><a href="../">Cancelar</a></div>

        <div id="area_atual">
            <p>Excluir produto</p>
        </div>

        <div id="perfil">
            <?php
            $sqlP = "SELECT Nome, Imagem, Senha FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
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
        <p id="caminho">administrar recursos &nbsp; > &nbsp; produtos &nbsp; > &nbsp; excluir</p>
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-cpu="' . $row['fk_Cod_CPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-gpu="' . $row['fk_Cod_GPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-placa-mae="' . $row['fk_Cod_PlacaMae'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-memram="' . $row['fk_Cod_MemRAM']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-fonte="' . $row['fk_Cod_Fonte']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-armazenamento="' . $row['fk_Cod_Armazenamento']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-gabinete="' . $row['fk_Cod_Gabinete']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-monitor="' . $row['fk_Cod_Monitor']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-teclado="' . $row['fk_Cod_Teclado']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-mouse="' . $row['fk_Cod_Mouse']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-headset="' . $row['fk_Cod_Headset']
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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
                                echo '<div id="botao_excluir_produto" class="botao_excluir_produto" data-fk-cod-placa-mae="' . $row['fk_Cod_PlacaMae'] . '" data-fk-cod-gpu="' 
                                . $row['fk_Cod_GPU'] . '" data-fk-cod-fonte="' . $row['fk_Cod_Fonte'] . '" data-fk-cod-gabinete="' . $row['fk_Cod_Gabinete'] 
                                . '" data-fk-cod-kitproduto="' . $row['fk_Cod_KitProduto'] . '" data-fk-cod-monitor="' . $row['fk_Cod_Monitor'] 
                                . '" data-fk-cod-mouse="' . $row['fk_Cod_Mouse'] . '" data-fk-cod-headset="' . $row['fk_Cod_Headset'] 
                                . '" data-fk-cod-memram="' . $row['fk_Cod_MemRAM'] . '" data-fk-cod-armazenamento="' . $row['fk_Cod_Armazenamento'] 
                                . '" data-fk-cod-teclado="' . $row['fk_Cod_Teclado'] . '" data-fk-cod-cpu="' . $row['fk_Cod_CPU'] 
                                . '" data-marca="' . $row['Marca'] . '" data-preco="' . $row['Preco'] . '" data-qtd_estoque="' . $row['Qtd_Estoque'] 
                                . '" data-modelo="' . $row['Modelo'] . '" data-descricao="' . $row['Descricao'] . '" data-cod_produto="' . $row['Cod_Produto'] 
                                . '" data-imagem="' . base64_encode($row['Imagem']) . '"
                                id="editar_produto_' . $row['Cod_Produto'] . '">Excluir</div>';
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

        <div id="popup" class="popup">
            <span class="close" id="closePopup">&times;</span>
            <div id="titulo_div">

                <div class="popup-content">
                    <span id="titulo">Excluir</span>

                    <form id="form_senha" method="post" action="excluir_php.php" enctype="multipart/form-data" onsubmit="return verificar()">
                        <div style="display: flex; align-items: center;">
                            <input type="hidden" id="tipo_cat" name="tipo_cat" value="">
                            <input type="hidden" id="cod_produto" name="cod_produto" value="">
                            <input type="hidden" id="fk_cod_produto" name="fk_cod_produto" value="">
                            <input type="password" id="senha_excluir" name="senha_excluir" placeholder="Confirme com sua senha" required>
                        </div>

                        <input type="submit" value="Excluir" id="botao_excluir_popup">
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
    <script>
        const txtSenha = document.getElementById('senha_excluir')
        function verificar(){
            if(CryptoJS.MD5(txtSenha.value).toString() === '<?php echo $rowP['Senha']; ?>') {
                return true
            } else {
                window.alert('As senhas não combinam!')
                return false
            }
        }

        document.querySelectorAll('.botao_excluir_produto').forEach(function(botaoEditar) {
            botaoEditar.addEventListener('click', function() {
                document.getElementById("popup").style.display = "block";
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

                // Exibe os campos de edição correspondentes às chaves estrangeiras do produto
                if (fkCodPlacaMae) {
                    document.getElementById('tipo_cat').value = "PM"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodPlacaMae;
                }
                if (fkCodGPU) {
                    document.getElementById('tipo_cat').value = "GPU"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodGPU;
                }
                if (fkCodFonte) {
                    document.getElementById('tipo_cat').value = "Fonte"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodFonte;
                }
                if (fkCodGabinete) {
                    document.getElementById('tipo_cat').value = "Gabinete"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodGabinete;
                }
                if (fkCodMonitor) {
                    document.getElementById('tipo_cat').value = "Monitor"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodMonitor;
                }
                if (fkCodMouse) {
                    document.getElementById('tipo_cat').value = "Mouse"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodMouse;
                }
                if (fkCodHeadset) {
                    document.getElementById('tipo_cat').value = "Headset"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodHeadset;
                }
                if (fkCodMemRAM) {
                    document.getElementById('tipo_cat').value = "RAM"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodMemRAM;
                }
                if (fkCodArmazenamento) {
                    document.getElementById('tipo_cat').value = "Arma"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodArmazenamento;
                }
                if (fkCodTeclado) {
                    document.getElementById('tipo_cat').value = "Teclado"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodTeclado;
                }
                if (fkCodCPU) {
                    document.getElementById('tipo_cat').value = "CPU"
                    document.getElementById('cod_produto').value = cod_produto;
                    document.getElementById('fk_cod_produto').value = fkCodCPU;
                }
            });
        });

        document.getElementById("closePopup").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

        document.getElementById("botao_excluir_popup").addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
        });

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
    </script>
</body>

</html>
