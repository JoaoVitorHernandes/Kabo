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

    $tipo_cat = $_POST['tipo_cat'];
    if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
        $image = $_FILES['img']['tmp_name'];
        $imgContent = file_get_contents($image);
        if ($imgContent === false) {
            $imgContent = null;
        } else {
            $imgContent = addslashes($imgContent);
        }
    } else {
        $imgContent = null;
    }

    if ($tipo_cat == "CPU"){
        $Descricao = $_POST['descricaoCPU'];
        $Modelo = $_POST['modeloCPU'];
        $Marca = $_POST['marcaCPU'];
        $Preco = $_POST['precoCPU'];
        $Quantidade = $_POST['quantidadeCPU'];
        $Soquete = $_POST['soqueteCPU'];
        $Nucleos = $_POST['nucleosCPU'];
        $Threads = $_POST['threadsCPU'];
        $Frequencia = $_POST['frequenciaCPU'];
        $TDP = $_POST['tdpCPU'];
        $Tipo_mem = $_POST['tipo_memCPU'];
        $Vel_mem = $_POST['vel_memCPU'];
        $GPUs = $_POST['GPUsCPU'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO CPU (Soquete, Frequencia, Nucleos, Threads, TDP, Tipo_Mem, Vel_Mem, GPUs) VALUES ('$Soquete', $Frequencia, $Nucleos, $Threads, $TDP, '$Tipo_mem', $Vel_mem, '$GPUs')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_CPU FROM CPU WHERE Soquete = '$Soquete' AND Frequencia >= $Frequencia AND Nucleos = $Nucleos AND Threads = $Threads AND TDP = $TDP AND Tipo_Mem = '$Tipo_mem' AND Vel_Mem = $Vel_mem AND GPUs = '$GPUs'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_CPU, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_CPU']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "GPU") {
        $Descricao = $_POST['descricaoGPU'];
        $Modelo = $_POST['modeloGPU'];
        $Marca = $_POST['marcaGPU'];
        $Preco = $_POST['precoGPU'];
        $Quantidade = $_POST['quantidadeGPU'];
        $PCIE = $_POST['pcieGPU'];
        $Nucleos = $_POST['nucleosGPU'];
        $Capacidade = $_POST['capacidade_memoriaGPU'];
        $Velocidade = $_POST['velocidadeGPU'];
        $TDP = $_POST['tdpGPU'];
        $SLOT = $_POST['slotGPU'];
        $Tamanho = $_POST['tamanhoGPU'];
        $TipoMem = $_POST['tipo_memGPU'];
        $Conector = $_POST['conectorGPU'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO GPU (PCIe, Nucleos, Tam_Memoria, Vel_Mem, TDP, Slot, Tamanho, Tipo_Mem, Conector)
                VALUES ($PCIE, $Nucleos, $Capacidade, $Velocidade, $TDP, $SLOT, '$Tamanho', '$TipoMem', '$Conector')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_GPU FROM GPU WHERE PCIe >= $PCIE AND Nucleos = $Nucleos AND Tam_Memoria = $Capacidade AND Vel_Mem = $Velocidade AND TDP = $TDP AND Slot >= $SLOT AND Tamanho = '$Tamanho' AND Tipo_Mem = '$TipoMem' AND Conector = '$Conector'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_GPU, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_GPU']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }

                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "PlacaMae") {
        $Descricao = $_POST['descricaoPM'];
        $Modelo = $_POST['modeloPM'];
        $Marca = $_POST['marcaPM'];
        $Preco = $_POST['precoPM'];
        $Quantidade = $_POST['quantidadePM'];
        $Tamanho = $_POST['tamanhoPM'];
        $Soquete = $_POST['soquetePM'];
        $Chipset = $_POST['chipsetPM'];
        $Tipo_mem = $_POST['tipo_memPM'];
        $Vel_mem = $_POST['vel_memPM'];
        $PCIe = $_POST['PCIePM'];
        $M2 = $_POST['M2PM'];
        $SATA = $_POST['sataPM'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Placa_Mae (Soquete, Tipo_Mem, Vel_Mem, PCIe, M2, SATA, Tamanho, Chipset) VALUES ('$Soquete', '$Tipo_mem', $Vel_mem, $PCIe, $M2, $SATA, '$Tamanho', '$Chipset')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_PlacaMae FROM Placa_Mae WHERE Soquete = '$Soquete' AND PCIe >= $PCIe AND Tipo_Mem = '$Tipo_mem' AND Vel_Mem = $Vel_mem AND M2 = $M2 AND SATA = $SATA AND Tamanho = '$Tamanho' AND Chipset = '$Chipset'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_PlacaMae, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_PlacaMae']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "MemRAM") {
        $Descricao = $_POST['descricaoRAM'];
        $Modelo = $_POST['modeloRAM'];
        $Marca = $_POST['marcaRAM'];
        $Preco = $_POST['precoRAM'];
        $Quantidade = $_POST['quantidadeRAM'];
        $Tipo_Mem = $_POST['tipo_memRAM'];
        $Vel_Mem = $_POST['vel_memRAM'];
        $Cap_Mem = $_POST['cap_memRAM'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Memoria_Ram (Tipo_Mem, Vel_Mem, Cap_Mem) VALUES ('$Tipo_Mem', $Vel_Mem, $Cap_Mem)";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_MemRAM FROM Memoria_Ram WHERE Tipo_Mem = '$Tipo_Mem' AND Vel_Mem = $Vel_Mem AND Cap_Mem = $Cap_Mem";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_MemRAM, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_MemRAM']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Armazenamento"){
        $Descricao = $_POST['descricaoArma'];
        $Modelo = $_POST['modeloArma'];
        $Marca = $_POST['marcaArma'];
        $Preco = $_POST['precoArma'];
        $Quantidade = $_POST['quantidadeArma'];
        $Tipo = $_POST['tipoArma'];
        $Conexao = $_POST['conexaoArma'];
        $Capacidade = $_POST['capacidadeArma'];
        $Velocidade = $_POST['velocidadeArma'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Armazenamento (Tipo, Capacidade, Velocidade, Conexao) VALUES ('$Tipo', '$Capacidade', $Velocidade, '$Conexao')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Armazenamento FROM Armazenamento WHERE Tipo = '$Tipo' AND Capacidade = '$Capacidade' AND Velocidade = $Velocidade AND Conexao = '$Conexao'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Armazenamento, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Armazenamento']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "fonte"){
        $Descricao = $_POST['descricaoFonte'];
        $Modelo = $_POST['modeloFonte'];
        $Marca = $_POST['marcaFonte'];
        $Preco = $_POST['precoFonte'];
        $Quantidade = $_POST['quantidadeFonte'];
        $Potencia = $_POST['potenciaFonte'];
        $Voltagem = $_POST['voltagemFonte'];
        $Corrente = $_POST['correnteFonte'];
        $Certificacao = $_POST['certificadoFonte'];
        $Tamanho = $_POST['tamanhoFonte'];
        $Modular = $_POST['modularFonte'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Fonte (Potencia, Voltagem, Corrente, Certificacao, Tamanho, Modular) VALUES ($Potencia, $Voltagem, $Corrente, '$Certificacao', '$Tamanho', $Modular)";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Fonte FROM Fonte WHERE Potencia = $Potencia AND Voltagem = $Voltagem AND Corrente = $Corrente AND Certificacao = '$Certificacao' AND Tamanho = '$Tamanho' AND Modular = $Modular";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Fonte, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Fonte']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }

    } else if ($tipo_cat == "gabinete") {
        $Descricao = $_POST['descricaoGabinete'];
        $Modelo = $_POST['modeloGabinete'];
        $Marca = $_POST['marcaGabinete'];
        $Preco = $_POST['precoGabinete'];
        $Quantidade = $_POST['quantidadeGabinete'];
        $Tamanho = $_POST['tamanhoGabinete'];
        $Tamanho_PM = $_POST['tamanhoPMGabinete'];
        $Tamanho_GPU = $_POST['tamanhoGPUGabinete'];
        $Slot_GPU = $_POST['slotGabinete'];
        $Tamanho_FT = $_POST['tamanhoFonteGabinete'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Gabinete (Tamanho, Tamanho_PM, Tamanho_FT, Tamanho_GPU, Slot_GPU) VALUES ('$Tamanho', '$Tamanho_PM', '$Tamanho_FT', '$Tamanho_GPU', $Slot_GPU)";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Gabinete FROM Gabinete WHERE Tamanho = '$Tamanho' AND Tamanho_PM = '$Tamanho_PM' AND Tamanho_FT = '$Tamanho_FT' AND Tamanho_GPU = '$Tamanho_GPU' AND Slot_GPU >= $Slot_GPU";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Gabinete, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Gabinete']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "monitor") {
        $Descricao = $_POST['descricaoMonitor'];
        $Modelo = $_POST['modeloMonitor'];
        $Marca = $_POST['marcaMonitor'];
        $Preco = $_POST['precoMonitor'];
        $Quantidade = $_POST['quantidadeMonitor'];
        $Tamanho = $_POST['tamanhoMonitor'];
        $Resolucao = $_POST['resolucaoMonitor'];
        $Proporcao = $_POST['proporcaoMonitor'];
        $Tipo_Painel = $_POST['tipoMonitor'];
        $Taxa_Att = $_POST['taxaMonitor'];
        $Tempo_Resposta = $_POST['tempoMonitor'];
        $HDMI = $_POST['hdmiMonitor'];
        $DP = $_POST['dpMonitor'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Monitor (Tamanho, Resolucao, Proporcao, Tipo_Painel, Taxa_Att, Tempo_Resposta, HDMI, DP) VALUES ('$Tamanho', '$Resolucao', '$Proporcao', '$Tipo_Painel', $Taxa_Att, $Tempo_Resposta, $HDMI, $DP)";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Monitor FROM Monitor WHERE Tamanho = '$Tamanho' AND Resolucao = '$Resolucao' AND Proporcao = '$Proporcao' AND Tipo_Painel = '$Tipo_Painel' AND Taxa_Att = $Taxa_Att AND Tempo_Resposta >= $Tempo_Resposta AND HDMI = $HDMI AND DP = $DP";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Monitor, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Monitor']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "teclado") {
        $Descricao = $_POST['descricaoTeclado'];
        $Modelo = $_POST['modeloTeclado'];
        $Marca = $_POST['marcaTeclado'];
        $Preco = $_POST['precoTeclado'];
        $Quantidade = $_POST['quantidadeTeclado'];
        $Tipo = $_POST['tipoTeclado'];
        $Tamanho = $_POST['tamanhoTeclado'];
        $Layout = $_POST['layoutTeclado'];
        $Formato = $_POST['formatoTeclado'];
        $Switch = $_POST['switchTeclado'];
        $Cor = $_POST['corTeclado'];
        $Iluminacao = $_POST['iluminacaoTeclado'];
        $Conexao = $_POST['conexaoTeclado'];
        $Tipo_Conexao = $_POST['conexao_tipoTeclado'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Teclado (Tipo, Tamanho, Layout, Formato, Switch, Cor, Iluminacao, Conexao, Tipo_Conexao) VALUES ('$Tipo', '$Tamanho', '$Layout', '$Formato', '$Switch', '$Cor', '$Iluminacao', '$Conexao', '$Tipo_Conexao')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Teclado FROM Teclado WHERE Tipo = '$Tipo' AND Tamanho = '$Tamanho' AND Layout = '$Layout' AND Formato = '$Formato' AND Switch = '$Switch' AND Cor = '$Cor' AND Iluminacao = '$Iluminacao' AND Conexao = '$Conexao' AND Tipo_Conexao = '$Tipo_Conexao'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Teclado, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Teclado']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "mouse") {
        $Descricao = $_POST['descricaoMouse'];
        $Modelo = $_POST['modeloMouse'];
        $Marca = $_POST['marcaMouse'];
        $Preco = $_POST['precoMouse'];
        $Quantidade = $_POST['quantidadeMouse'];
        $DPI = $_POST['dpiMouse'];
        $Polling_Rate = $_POST['pollingMouse'];
        $Botoes = $_POST['botoesMouse'];
        $Cor = $_POST['corMouse'];
        $Iluminacao = $_POST['iluminacaoMouse'];
        $Conexao = $_POST['conexaoMouse'];
        $Tipo_Conexao = $_POST['conexao_tipoMouse'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Mouse (DPI, Polling_Rate, Botoes, Cor, Iluminacao, Conexao, Tipo_Conexao) VALUES ($DPI, $Polling_Rate, $Botoes, '$Cor', '$Iluminacao', '$Conexao', '$Tipo_Conexao')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Mouse FROM Mouse WHERE DPI = $DPI AND Polling_Rate = $Polling_Rate AND Botoes = $Botoes AND Cor = '$Cor' AND Iluminacao = '$Iluminacao' AND Conexao = '$Conexao' AND Tipo_Conexao = '$Tipo_Conexao'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Mouse, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Mouse']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }

    } else if ($tipo_cat == 'headset'){
        $Descricao = $_POST['descricaoHeadset'];
        $Modelo = $_POST['modeloHeadset'];
        $Marca = $_POST['marcaHeadset'];
        $Preco = $_POST['precoHeadset'];
        $Quantidade = $_POST['quantidadeHeadset'];
        $Cor = $_POST['corHeadset'];
        $Iluminacao = $_POST['iluminacaoHeadset'];
        $Conexao = $_POST['conexaoHeadset'];
        $Tipo_Conexao = $_POST['conexao_tipoHeadset'];
        $Driver = $_POST['driverHeadset'];
        $Frequencia_Audio = $_POST['frequencia_audioHeadset'];
        $Frequencia_Mic = $_POST['frequencia_micHeadset'];
        $Padrao_Polar = $_POST['padraoHeadset'];

        try {
            $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
            $checkResult = $conn->query($checkQuery);
            if ($checkResult && $checkResult->num_rows > 0) {
                throw new Exception('Modelo de produto já existente!');
            } else {
                $sql = "INSERT INTO Headset (Driver, Frequencia_Audio, Frequencia_Mic, Padrao_Polar, Cor, Iluminacao, Conexao, Tipo_Conexao) VALUES ($Driver, $Frequencia_Audio, $Frequencia_Mic, $Padrao_Polar, '$Cor', '$Iluminacao', '$Conexao', '$Tipo_Conexao')";
                if ($conn->query($sql) === TRUE) {
                    $sqlCod = "SELECT Cod_Headset FROM Headset WHERE Driver = $Driver AND Frequencia_Audio = $Frequencia_Audio AND Frequencia_Mic = $Frequencia_Mic AND Padrao_Polar = $Padrao_Polar AND Cor = '$Cor' AND Iluminacao = '$Iluminacao' AND Conexao = '$Conexao' AND Tipo_Conexao = '$Tipo_Conexao'";
                    $resultCod = $conn->query($sqlCod);
                    $row = $resultCod->fetch_assoc();
                    $sqlP = "INSERT INTO Produto_Tipo (Descricao, Preco, Modelo, Marca, Qtd_estoque, fk_Cod_Headset, Imagem) VALUES ('$Descricao', $Preco, '$Modelo', '$Marca', $Quantidade, {$row['Cod_Headset']}, '$imgContent')";
                    if ($conn->query($sqlP) === TRUE) {
                        header("Location: /kabo/admin/produtos");
                        exit;
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');
                }
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    }

?>
