<?php
if (!isset($_SESSION['Cod_Usuario'])) {
    header('Location: ../login/');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/cart.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Carrinho</title>
    <style>
        #mainCarrinhoVazio {
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 100vh;
            padding: 100px 20px 20px 20px;
        }
        #divCarrinhoVazio{
            background-color: #1e1e1e;
            width: 500px;
            height: 300px;
            box-shadow: inset 0 0 30px rgba(240, 51, 51, 0.5), 0 0 300px rgba(240, 51, 51, 0.5);
            border: 1px solid #f03333;
            padding: 20px;
        }
        #tituloCarrinhoVazio{
            font-family: 'poppins_bold';
            color: #f03333;
            font-size: 20px;
            text-align: center;
            margin-top: 20px;
        }
        #pCarrinhoVazio{
            font-family: 'poppins_medio';
            color: #fff;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
        }
        #aCarrinhoVazio{
            font-family: 'poppins_medio';
            color: #fff;
            font-size: 13px;
            text-align: center;
            margin-top: 20px;
            display: block;
            width: 200px;
            padding: 10px;
            background-color: #f03333;
            border: none;
            border-radius: 2px;
            text-decoration: none;
            margin: 60px auto 20px auto;
            transition: 0.3s;
        }
        #aCarrinhoVazio:hover{
            background-color: #ff4d4d;
        }
    </style>
</head>

<body>
    <nav>
        <div id="divNav1">
            <span id="setaVoltar" onclick="voltar()">&#10094;</span>
            <a href="../"><img src="../img/logo_neon.png" alt="logo" id="logo"></a>
        </div>
        <div id="divNav2">
            <h1 id="tituloCarrinho">Carrinho</h1>
        </div>
        <div id="divNav3">
            <?php
            if ($imgPerfil == null) { ?>
                <a href="../perfil/">
                    <div><img src="../img/perfil_padrao.png" alt="perfil" id="imgPerfil">
                        <p id="nomePerfil"><?php echo $clienteLogado; ?></p>
                    </div>
                </a>
            <?php } else {
                $imagemBase64 = base64_encode($imgPerfil); ?>
                <a href="../perfil/">
                    <div><img src="data:image/jpeg;base64,<?php echo $imagemBase64; ?>" alt="perfil" id="imgPerfil">
                        <p id="nomePerfil"><?php echo $clienteLogado; ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </nav>

    <main id="mainCarrinhoVazio">
        <div id="divCarrinhoVazio">
            <h2 id="tituloCarrinhoVazio">Seu carrinho está vazio</h2>
            <p id="pCarrinhoVazio">Adicione produtos ao seu carrinho para continuar</p>
            <a href="../" id="aCarrinhoVazio">Continuar comprando</a>
        </div>
    </main>

    <script>
        function voltar() {
            window.history.back();
        }
    </script>
</body>

</html>