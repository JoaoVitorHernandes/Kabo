<head>
    <link rel="stylesheet" href="../../cadastro/style.css">
</head>
<?php
    include("connection.php");

    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $senhaCriptografada = md5($password);

    $sql = "SELECT Cod_Usuario, Senha, Tipo_Usuario FROM Usuario WHERE Email = '$login'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["Senha"] == $senhaCriptografada) {
                session_start();
                $_SESSION["Cod_Usuario"] = $row["Cod_Usuario"];
                $_SESSION["Tipo_Usuario"] = $row["Tipo_Usuario"];
                header("Location: /kabo/perfil/");
            } else {
?>
    <dialog id="dialogErro">
        <h3 id="dialogTitulo">Erro ao fazer login</h3>
        <p id="avisoDialog">Senha incorreta!</p>
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
            }
        }
    }
    else {
?>
    <dialog id="dialogErro">
        <h3 id="dialogTitulo">Erro ao fazer login</h3>
        <p id="avisoDialog">Login incorreto!</p>
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
    }
?>
