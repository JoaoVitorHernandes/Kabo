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
    $cod_produto = $_POST['cod_produto'];
    $fk_cod_produto = $_POST['fk_cod_produto'];

    if ($tipo_cat == "CPU"){
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_CPU = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM CPU WHERE Cod_CPU = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "GPU") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_GPU = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM GPU WHERE Cod_GPU = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "PM") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_PlacaMae = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Placa_Mae WHERE Cod_PlacaMae = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Fonte") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Fonte = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Fonte WHERE Cod_Fonte = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Gabinete") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Gabinete = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Gabinete WHERE Cod_Gabinete = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Monitor") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Monitor = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Monitor WHERE Cod_Monitor = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Mouse") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Mouse = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Mouse WHERE Cod_Mouse = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Headset") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Headset = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Headset WHERE Cod_Headset = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "RAM") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_MemRAM = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Memoria_Ram WHERE Cod_MemRAM = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Arma") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Armazenamento = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Armazenamento WHERE Cod_Armazenamento = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    } else if ($tipo_cat == "Teclado") {
        try {
            $sqlP = "DELETE FROM Produto_Tipo WHERE Cod_Produto = $cod_produto AND fk_Cod_Teclado = $fk_cod_produto";
            if ($conn->query($sqlP) === TRUE) {
                $sql = "DELETE FROM Teclado WHERE Cod_Teclado = $fk_cod_produto";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /kabo/admin/produtos");
                } else {
                    throw new Exception('Ocorreu um erro ao executar a operação.');  
                }
            } else {
                throw new Exception('Ocorreu um erro ao executar a operação.');
            }
        } catch (Exception $e) {
            echo '<script>alert("'.$e->getMessage().'"); history.go(-1);</script>';
            exit;
        }
    }
?>