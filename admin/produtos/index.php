<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
    <title>Produtos</title>
</head>
<body>
    <?php
        include("../connection.php");

        session_start();
        if (!isset($_SESSION["Cod_Usuario"])) {
            header("Location: /kabo/index.php");
            exit();
        }

        if ($_SESSION["Tipo_Usuario"] == 0) {
            header("Location: ../erro.php");
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
    <nav>
        <div id="voltar"><a href="../">Voltar</a></div>

        <div id="area_atual"><p>Produtos</p></div>

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
                    <a href="../../perfil/"><img src="../img/perfil_padrao.png" alt="">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php 
                } else {
                    $imagemBase64 = base64_encode($imgPerfil); ?>
                    <a href="../../perfil/"><img src="data:image/jpeg;base64,<?php echo $imagemBase64 ?>"  alt="Perfil">
                    <p><?php echo $_clienteLogado ?></p></a>
                <?php
                }
                ?>
        </div>
    </nav>

    <main>
        <p id="caminho">administrar recursos &nbsp; > &nbsp;  produtos  &nbsp; > </p>

        <section id="menu">
            <div class="opcoes_menu"><a href="cadastrar/">Cadastrar</a></div>
            <div class="opcoes_menu"><a href="editar/">Editar</a></div>
            <div class="opcoes_menu"><a href="excluir/">Excluir</a></div>
            <div class="opcoes_menu"><a href="exibir/">Exibir todos</a></div>
        </section>

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

    </script>
</body>
</html>
