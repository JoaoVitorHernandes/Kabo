<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Erro</title>
    <style>
        /*error*/
        .sectionpgerror {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .backgroundboxerror {
            background-color: #1E1E1E;
            width: 580px;
            max-width: 80%;
            height: 380px;
            box-shadow: 0px 0px 250px 20px #663234, 0px 0px 20px 0px #663234 inset;
            border: 1px solid #F03333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .backgroundboxerror img {
            width: 100px;
            height: 45px;
            margin-top: 48px;
        }

        #escritapermissao{
            color: #FFFFFF;
            margin-top: 70px;
            font-size: 19px;
            font-family: "poppins_bold";
        }

        .home_button {
            background-color: #A73437BF;
            width: 130px;
            height: 40px;
            border: 1px solid #F03333;
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #FFFFFF;
            font-family: "poppins_medio";
            font-size: 18px;
        }

        .home_button:link {
            text-decoration: none;
        }
        
        #copyright{
            color: #663234;
            margin-top: 40px;
            font-size: 12px;
            font-family: "poppins_medio";
        }
    </style>
</head>

<body>
    <section class="sectionpgerror">
        <div class="backgroundboxerror">
            <img src="../img/logo_neon.png" alt="">
            <p id="escritapermissao">Você não tem permissão para acessar essa área!!</p>
            <a href="../" class="home_button">Home</a>
            <p id="copyright">&copy; Kabo </p>
        </div>
    </section>
</body>

</html>