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
    $Cod_Produto = $_POST['cod_produto'];
    $fk_Cod_Produto = $_POST['fk_cod_produto'];
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_CPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null){
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE CPU SET Soquete = '$Soquete', Frequencia = $Frequencia, Nucleos = $Nucleos, Threads = $Threads, TDP = $TDP, Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, GPUs = '$GPUs' WHERE Cod_CPU = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_CPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE CPU SET Soquete = '$Soquete', Frequencia = $Frequencia, Nucleos = $Nucleos, Threads = $Threads, TDP = $TDP, Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, GPUs = '$GPUs' WHERE Cod_CPU = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_CPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE CPU SET Soquete = '$Soquete', Frequencia = $Frequencia, Nucleos = $Nucleos, Threads = $Threads, TDP = $TDP, Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, GPUs = '$GPUs' WHERE Cod_CPU = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_CPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE CPU SET Soquete = '$Soquete', Frequencia = $Frequencia, Nucleos = $Nucleos, Threads = $Threads, TDP = $TDP, Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, GPUs = '$GPUs' WHERE Cod_CPU = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_CPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_GPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE GPU SET PCIe = $PCIE, Nucleos = $Nucleos, Tam_Memoria = $Capacidade, Vel_Mem = $Velocidade, TDP = $TDP, Slot = $SLOT, Tamanho = '$Tamanho', Tipo_Mem = '$TipoMem', Conector = '$Conector' WHERE Cod_GPU = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_GPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE GPU SET PCIe = $PCIE, Nucleos = $Nucleos, Tam_Memoria = $Capacidade, Vel_Mem = $Velocidade, TDP = $TDP, Slot = $SLOT, Tamanho = '$Tamanho', Tipo_Mem = '$TipoMem', Conector = '$Conector' WHERE Cod_GPU = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_GPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE GPU SET PCIe = $PCIE, Nucleos = $Nucleos, Tam_Memoria = $Capacidade, Vel_Mem = $Velocidade, TDP = $TDP, Slot = $SLOT, Tamanho = '$Tamanho', Tipo_Mem = '$TipoMem', Conector = '$Conector' WHERE Cod_GPU = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_GPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE GPU SET PCIe = $PCIE, Nucleos = $Nucleos, Tam_Memoria = $Capacidade, Vel_Mem = $Velocidade, TDP = $TDP, Slot = $SLOT, Tamanho = '$Tamanho', Tipo_Mem = '$TipoMem', Conector = '$Conector' WHERE Cod_GPU = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_GPU = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_PlacaMae = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Placa_Mae SET Soquete = '$Soquete', Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, PCIe = $PCIe, M2 = $M2, SATA = $SATA, Tamanho = '$Tamanho', Chipset = '$Chipset' WHERE Cod_PlacaMae = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_PlacaMae = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Placa_Mae SET Soquete = '$Soquete', Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, PCIe = $PCIe, M2 = $M2, SATA = $SATA, Tamanho = '$Tamanho', Chipset = '$Chipset' WHERE Cod_PlacaMae = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_PlacaMae = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Placa_Mae SET Soquete = '$Soquete', Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, PCIe = $PCIe, M2 = $M2, SATA = $SATA, Tamanho = '$Tamanho', Chipset = '$Chipset' WHERE Cod_PlacaMae = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_PlacaMae = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Placa_Mae SET Soquete = '$Soquete', Tipo_Mem = '$Tipo_mem', Vel_Mem = $Vel_mem, PCIe = $PCIe, M2 = $M2, SATA = $SATA, Tamanho = '$Tamanho', Chipset = '$Chipset' WHERE Cod_PlacaMae = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_PlacaMae = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_MemRAM = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Memoria_Ram SET Tipo_Mem = '$Tipo_Mem', Vel_Mem = $Vel_Mem, Cap_Mem = $Cap_Mem WHERE Cod_MemRAM = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_MemRAM = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Memoria_Ram SET Tipo_Mem = '$Tipo_Mem', Vel_Mem = $Vel_Mem, Cap_Mem = $Cap_Mem WHERE Cod_MemRAM = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_MemRAM = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                }
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Memoria_Ram SET Tipo_Mem = '$Tipo_Mem', Vel_Mem = $Vel_Mem, Cap_Mem = $Cap_Mem WHERE Cod_MemRAM = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_MemRAM = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Memoria_Ram SET Tipo_Mem = '$Tipo_Mem', Vel_Mem = $Vel_Mem, Cap_Mem = $Cap_Mem WHERE Cod_MemRAM = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_MemRAM = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Armazenamento = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Armazenamento SET Tipo = '$Tipo', Capacidade = '$Capacidade', Velocidade = $Velocidade, Conexao = '$Conexao' WHERE Cod_Armazenamento = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Armazenamento = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Armazenamento SET Tipo = '$Tipo', Capacidade = '$Capacidade', Velocidade = $Velocidade, Conexao = '$Conexao' WHERE Cod_Armazenamento = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Armazenamento = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Armazenamento SET Tipo = '$Tipo', Capacidade = '$Capacidade', Velocidade = $Velocidade, Conexao = '$Conexao' WHERE Cod_Armazenamento = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Armazenamento = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Armazenamento SET Tipo = '$Tipo', Capacidade = '$Capacidade', Velocidade = $Velocidade, Conexao = '$Conexao' WHERE Cod_Armazenamento = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Armazenamento = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Fonte = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Fonte SET Potencia = $Potencia, Voltagem = $Voltagem, Corrente = $Corrente, Certificacao = '$Certificacao', Tamanho = '$Tamanho', Modular = $Modular WHERE Cod_Fonte = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Fonte = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Fonte SET Potencia = $Potencia, Voltagem = $Voltagem, Corrente = $Corrente, Certificacao = '$Certificacao', Tamanho = '$Tamanho', Modular = $Modular WHERE Cod_Fonte = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Fonte = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Fonte SET Potencia = $Potencia, Voltagem = $Voltagem, Corrente = $Corrente, Certificacao = '$Certificacao', Tamanho = '$Tamanho', Modular = $Modular WHERE Cod_Fonte = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Fonte = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Fonte SET Potencia = $Potencia, Voltagem = $Voltagem, Corrente = $Corrente, Certificacao = '$Certificacao', Tamanho = '$Tamanho', Modular = $Modular WHERE Cod_Fonte = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Fonte = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Gabinete = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Gabinete SET Tamanho = '$Tamanho', Tamanho_PM = '$Tamanho_PM', Tamanho_FT = '$Tamanho_FT', Tamanho_GPU = '$Tamanho_GPU', Slot_GPU = $Slot_GPU WHERE Cod_Gabinete = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Gabinete = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Gabinete SET Tamanho = '$Tamanho', Tamanho_PM = '$Tamanho_PM', Tamanho_FT = '$Tamanho_FT', Tamanho_GPU = '$Tamanho_GPU', Slot_GPU = $Slot_GPU WHERE Cod_Gabinete = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Gabinete = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                }
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Gabinete SET Tamanho = '$Tamanho', Tamanho_PM = '$Tamanho_PM', Tamanho_FT = '$Tamanho_FT', Tamanho_GPU = '$Tamanho_GPU', Slot_GPU = $Slot_GPU WHERE Cod_Gabinete = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Gabinete = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Gabinete SET Tamanho = '$Tamanho', Tamanho_PM = '$Tamanho_PM', Tamanho_FT = '$Tamanho_FT', Tamanho_GPU = '$Tamanho_GPU', Slot_GPU = $Slot_GPU WHERE Cod_Gabinete = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Gabinete = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Monitor = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Monitor SET Tamanho = '$Tamanho', Resolucao = '$Resolucao', Proporcao = '$Proporcao', Tipo_Painel = '$Tipo_Painel', Taxa_Att = $Taxa_Att, Tempo_Resposta = $Tempo_Resposta, HDMI = $HDMI, DP = $DP WHERE Cod_Monitor = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Monitor = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Monitor SET Tamanho = '$Tamanho', Resolucao = '$Resolucao', Proporcao = '$Proporcao', Tipo_Painel = '$Tipo_Painel', Taxa_Att = $Taxa_Att, Tempo_Resposta = $Tempo_Resposta, HDMI = $HDMI, DP = $DP WHERE Cod_Monitor = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Monitor = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Monitor SET Tamanho = '$Tamanho', Resolucao = '$Resolucao', Proporcao = '$Proporcao', Tipo_Painel = '$Tipo_Painel', Taxa_Att = $Taxa_Att, Tempo_Resposta = $Tempo_Resposta, HDMI = $HDMI, DP = $DP WHERE Cod_Monitor = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Monitor = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Monitor SET Tamanho = '$Tamanho', Resolucao = '$Resolucao', Proporcao = '$Proporcao', Tipo_Painel = '$Tipo_Painel', Taxa_Att = $Taxa_Att, Tempo_Resposta = $Tempo_Resposta, HDMI = $HDMI, DP = $DP WHERE Cod_Monitor = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Monitor = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Teclado = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Teclado SET Tipo = '$Tipo', Tamanho = '$Tamanho', Layout = '$Layout', Formato = '$Formato', Switch = '$Switch', Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Teclado = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Teclado = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Teclado SET Tipo = '$Tipo', Tamanho = '$Tamanho', Layout = '$Layout', Formato = '$Formato', Switch = '$Switch', Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Teclado = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Teclado = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Teclado SET Tipo = '$Tipo', Tamanho = '$Tamanho', Layout = '$Layout', Formato = '$Formato', Switch = '$Switch', Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Teclado = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Teclado = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Teclado SET Tipo = '$Tipo', Tamanho = '$Tamanho', Layout = '$Layout', Formato = '$Formato', Switch = '$Switch', Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Teclado = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Teclado = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Mouse = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Mouse SET DPI = $DPI, Polling_Rate = $Polling_Rate, Botoes = $Botoes, Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Mouse = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Mouse = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Mouse SET DPI = $DPI, Polling_Rate = $Polling_Rate, Botoes = $Botoes, Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Mouse = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Mouse = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Mouse SET DPI = $DPI, Polling_Rate = $Polling_Rate, Botoes = $Botoes, Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Mouse = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Mouse = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Mouse SET DPI = $DPI, Polling_Rate = $Polling_Rate, Botoes = $Botoes, Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Mouse = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Mouse = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
            $checkQuery0 = "SELECT Modelo FROM Produto_Tipo WHERE fk_Cod_Headset = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
            $checkResult0 = $conn->query($checkQuery0);
            $row = $checkResult0->fetch_assoc();
            if ($imgContent !== null) {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Headset SET Driver = $Driver, Frequencia_Audio = $Frequencia_Audio, Frequencia_Mic = $Frequencia_Mic, Padrao_Polar = $Padrao_Polar,  Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Headset = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Imagem = '$imgContent' WHERE fk_Cod_Headset = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Headset SET Driver = $Driver, Frequencia_Audio = $Frequencia_Audio, Frequencia_Mic = $Frequencia_Mic, Padrao_Polar = $Padrao_Polar,  Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Headset = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo', Imagem = '$imgContent' WHERE fk_Cod_Headset = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            } else {
                if ($row['Modelo'] === $Modelo) {
                    $sql = "UPDATE Headset SET Driver = $Driver, Frequencia_Audio = $Frequencia_Audio, Frequencia_Mic = $Frequencia_Mic, Padrao_Polar = $Padrao_Polar,  Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Headset = $fk_Cod_Produto";
                    if ($conn->query($sql) === TRUE) {
                        $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade WHERE fk_Cod_Headset = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
                        if ($conn->query($sqlP) === TRUE) {
                            header("Location: /kabo/admin/produtos");
                            exit;
                        } else {
                            throw new Exception('Ocorreu um erro ao executar a operação.');
                        }
                    } else {
                        throw new Exception('Ocorreu um erro ao executar a operação.');
                    }
                } else {
                    $checkQuery = "SELECT * FROM Produto_Tipo WHERE Modelo = '$Modelo'";
                    $checkResult = $conn->query($checkQuery);
                    if ($checkResult && $checkResult->num_rows > 0) {
                        throw new Exception('Modelo de produto já existente!');
                    } else {
                        $sql = "UPDATE Headset SET Driver = $Driver, Frequencia_Audio = $Frequencia_Audio, Frequencia_Mic = $Frequencia_Mic, Padrao_Polar = $Padrao_Polar,  Cor = '$Cor', Iluminacao = '$Iluminacao', Conexao = '$Conexao', Tipo_Conexao = '$Tipo_Conexao' WHERE Cod_Headset = $fk_Cod_Produto";
                        if ($conn->query($sql) === TRUE) {
                            $sqlP = "UPDATE Produto_Tipo SET Descricao = '$Descricao', Preco = $Preco, Marca = '$Marca', Qtd_estoque = $Quantidade, Modelo = '$Modelo' WHERE fk_Cod_Headset = $fk_Cod_Produto AND Cod_Produto = $Cod_Produto";
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
                } 
            }

        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    }

?>
