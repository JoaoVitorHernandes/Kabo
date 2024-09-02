<?php
include("../../connection.php");
session_start();

$Nome = $_POST['txtNome'];
$Genero = $_POST['selectGenero'];
$Senha = $_POST['txtSenha'];
$senhaCriptografada = md5($Senha);
$CEP = $_POST['txtCEP'];
$Logradouro = $_POST['txtLogradouro'];
$Bairro = $_POST['txtBairro'];
$Numero = $_POST['txtNumero'];
$Cidade = $_POST['txtCidade'];
$Estado = $_POST['txtEstado'];
if (isset($_FILES['imgPerfil']) && $_FILES['imgPerfil']['tmp_name'] != '') {
    $image = $_FILES['imgPerfil']['tmp_name'];
    $imgContent = file_get_contents($image);
    if ($imgContent === false) {
        $imgContent = null;
    } else {
        $imgContent = addslashes($imgContent);
    }
} else {
    $imgContent = null;
}

if (empty($Senha)) {
    try {
        // Verificar se o endereço já existe
        $sqlE = "SELECT Cod_Endereco FROM Endereco WHERE CEP = '$CEP' AND Logradouro = '$Logradouro' AND Bairro = '$Bairro' AND Cidade = '$Cidade' AND Estado = '$Estado' AND Numero = $Numero";
        $resultE = $conn->query($sqlE);
        if ($resultE->num_rows > 0) {
            // O endereço já existe, obter o Cod_Endereco
            $row = $resultE->fetch_assoc();
            $Cod_Endereco = $row['Cod_Endereco'];
        } else {
            // O endereço não existe, inserir novo endereço
            $sqlE = "INSERT INTO Endereco (CEP, Logradouro, Bairro, Cidade, Estado, Numero) VALUES ('$CEP', '$Logradouro', '$Bairro', '$Cidade', '$Estado', $Numero)";
            if ($conn->query($sqlE) === TRUE) {
                // Obter o Cod_Endereco do novo endereço
                $Cod_Endereco = $conn->insert_id;
            } else {
                throw new Exception('Ocorreu um erro ao inserir o novo endereço!');
            }
        }
        // Atualizar o usuário
        if ($imgContent !== null) {
            $sql = "UPDATE Usuario SET Nome = '$Nome', Genero = '$Genero', fk_Cod_Endereco = $Cod_Endereco, Imagem = '$imgContent' WHERE Cod_Usuario = {$_SESSION['Cod_Usuario']}";
        } else {
            $sql = "UPDATE Usuario SET Nome = '$Nome', Genero = '$Genero', fk_Cod_Endereco = $Cod_Endereco WHERE Cod_Usuario = {$_SESSION['Cod_Usuario']}";
        }
        if ($conn->query($sql) === TRUE) {
            header("Location: /kabo/perfil/");
            exit;
        } else {
            throw new Exception('Ocorreu um erro ao atualizar o usuário!');
        }
    } catch (Exception $e) { ?>
        <head>
            <link rel="stylesheet" href="style.css">
        </head>
        <dialog id="dialogErro">
            <h3 id="dialogTitulo">Erro ao editar perfil</h3>
            <p id="avisoDialog"><?php echo $e->getMessage() ?></p>
            <button id="botaoDialog">Ok</button>
        </dialog>

        <script>
            var dialog = document.querySelector('#dialogErro');
            var botaoDialog = document.querySelector('#botaoDialog');
            botaoDialog.onclick = function() {
                dialog.classList.add('fadeOut');
                setTimeout(function() {
                    dialog.close();
                }, 201);
                history.go(-1);
            };

            dialog.classList.remove('fadeOut');
            dialog.showModal();
        </script>
    <?php
        exit;
    }
} else {
    try {
        if ($imgContent !== null) {
            $sql = "UPDATE Usuario SET Nome = '$Nome', Genero = '$Genero', Imagem = '$imgContent', Senha = '$senhaCriptografada' WHERE Cod_Usuario = {$_SESSION['Cod_Usuario']}";
        } else {
            $sql = "UPDATE Usuario SET Nome = '$Nome', Genero = '$Genero', Senha = '$senhaCriptografada' WHERE Cod_Usuario = {$_SESSION['Cod_Usuario']}";
        }
        if ($conn->query($sql) === TRUE) {
            $sqlC = "SELECT Cod_Usuario FROM Usuario WHERE CPF = '$CPF'";
            $resultC = $conn->query($sqlC);
            $row = $resultC->fetch_assoc();
            // Verificar se o endereço já existe
            $sqlE = "SELECT Cod_Endereco FROM Endereco WHERE CEP = '$CEP' AND Logradouro = '$Logradouro' AND Bairro = '$Bairro' AND Cidade = '$Cidade' AND Estado = '$Estado' AND Numero = $Numero";
            $resultE = $conn->query($sqlE);
            if ($resultE->num_rows > 0) {
                // O endereço já existe, obter o Cod_Endereco
                $row = $resultE->fetch_assoc();
                $Cod_Endereco = $row['Cod_Endereco'];
            } else {
                // O endereço não existe, inserir novo endereço
                $sqlE = "INSERT INTO Endereco (CEP, Logradouro, Bairro, Cidade, Estado, Numero) VALUES ('$CEP', '$Logradouro', '$Bairro', '$Cidade', '$Estado', $Numero)";
                if ($conn->query($sqlE) === TRUE) {
                    // Obter o Cod_Endereco do novo endereço
                    $Cod_Endereco = $conn->insert_id;
                } else {
                    throw new Exception('Ocorreu um erro ao inserir o novo endereço.');
                }
            }
            header("Location: /kabo/perfil/");
            exit;
        } else {
            throw new Exception('Ocorreu um erro ao executar a operação!');
        }
    } catch (Exception $e) { ?>

        <head>
            <link rel="stylesheet" href="style.css">
        </head>
        <dialog id="dialogErro">
            <h3 id="dialogTitulo">Erro ao editar perfil</h3>
            <p id="avisoDialog"><?php echo $e->getMessage() ?></p>
            <button id="botaoDialog">Ok</button>
        </dialog>

        <script>
            var dialog = document.querySelector('#dialogErro');
            var botaoDialog = document.querySelector('#botaoDialog');
            botaoDialog.onclick = function() {
                dialog.classList.add('fadeOut');
                setTimeout(function() {
                    dialog.close();
                }, 201);
                history.go(-1);
            };

            dialog.classList.remove('fadeOut');
            dialog.showModal();
        </script>
<?php
        exit;
    }
}
