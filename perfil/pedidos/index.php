    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../../img/history.png" type="image/x-icon">
        <link rel="stylesheet" href="style.css">
        <title>Histórico de Pedidos</title>
    </head>

    <body>
        <?php
        include('../../connection.php');
        session_start();

        function similaridade($string1, $string2, $limiar = 70)
        {
            similar_text($string1, $string2, $percent);
            return $percent >= $limiar;
        }

        if (isset($_GET['busca'])) {
            $busca = $_GET['busca'];
            $busca = strtolower($busca);
            if (!empty($busca)) {
                if (similaridade($busca, "cpu")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_CPU > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "gpu")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_GPU > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "placa mae") || similaridade($busca, "mae")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_PlacaMae > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "memoria ram") || similaridade($busca, "ram")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_MemRAM > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "fonte")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Fonte > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "armazenamento")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Armazenamento > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "gabinete")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Gabinete > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "monitor")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Monitor > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "teclado")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Teclado > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "mouse")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Mouse > 0";
                    $result = $conn->query($sql);
                } else if (similaridade($busca, "headset")) {
                    $sql = "SELECT DISTINCT
                                DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                                CASE 
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                    WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                                END AS Mes,
                                DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                                Pedido.Forma_Pagamento,
                                Pedido.Status,
                                Pedido.Valor_total,
                                Pedido.Cod_Pedido 
                            FROM Pedido 
                            INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                            INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' AND Produto_Tipo.fk_Cod_Headset > 0";
                    $result = $conn->query($sql);
                } else {
                    $sql = "SELECT DISTINCT
                            DATE_FORMAT(Pedido.Dt_Pedido, '%e de ') as Dia,
                            CASE 
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'January' THEN 'Janeiro'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'February' THEN 'Fevereiro'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'March' THEN 'Março'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'April' THEN 'Abril'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'May' THEN 'Maio'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'June' THEN 'Junho'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'July' THEN 'Julho'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'August' THEN 'Agosto'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'September' THEN 'Setembro'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'October' THEN 'Outubro'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'November' THEN 'Novembro'
                                WHEN MONTHNAME(Pedido.Dt_Pedido) = 'December' THEN 'Dezembro'
                            END AS Mes,
                            DATE_FORMAT(Pedido.Dt_Pedido, '%Y') as Ano,
                            Pedido.Forma_Pagamento,
                            Pedido.Status,
                            Pedido.Valor_total,
                            Pedido.Cod_Pedido 
                        FROM Pedido 
                        INNER JOIN Tem ON Pedido.Cod_Pedido = Tem.fk_Cod_Pedido
                        INNER JOIN Produto_Tipo ON Tem.fk_Cod_Produto_Tipo = Produto_Tipo.Cod_Produto
                        WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}' 
                            AND (
                                Produto_Tipo.Modelo LIKE '%$busca%' 
                                OR Produto_Tipo.Marca LIKE '%$busca%'
                                OR Pedido.Cod_Pedido = '$busca'
                            )";
                    $result = $conn->query($sql);
                }
            } else {
                $sql = "SELECT 
                    DATE_FORMAT(Dt_Pedido, '%e de ') as Dia,
                    CASE 
                        WHEN MONTHNAME(Dt_Pedido) = 'January' THEN 'Janeiro'
                        WHEN MONTHNAME(Dt_Pedido) = 'February' THEN 'Fevereiro'
                        WHEN MONTHNAME(Dt_Pedido) = 'March' THEN 'Março'
                        WHEN MONTHNAME(Dt_Pedido) = 'April' THEN 'Abril'
                        WHEN MONTHNAME(Dt_Pedido) = 'May' THEN 'Maio'
                        WHEN MONTHNAME(Dt_Pedido) = 'June' THEN 'Junho'
                        WHEN MONTHNAME(Dt_Pedido) = 'July' THEN 'Julho'
                        WHEN MONTHNAME(Dt_Pedido) = 'August' THEN 'Agosto'
                        WHEN MONTHNAME(Dt_Pedido) = 'September' THEN 'Setembro'
                        WHEN MONTHNAME(Dt_Pedido) = 'October' THEN 'Outubro'
                        WHEN MONTHNAME(Dt_Pedido) = 'November' THEN 'Novembro'
                        WHEN MONTHNAME(Dt_Pedido) = 'December' THEN 'Dezembro'
                    END AS Mes,
                    DATE_FORMAT(Dt_Pedido, '%Y') as Ano,
                    Forma_Pagamento,
                    Status,
                    Valor_total,
                    Cod_Pedido 
                FROM Pedido 
                WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}'
                ORDER BY Pedido.Dt_Pedido DESC";
                $result = $conn->query($sql);
            }
        } else {
            $sql = "SELECT 
                DATE_FORMAT(Dt_Pedido, '%e de ') as Dia,
                CASE 
                    WHEN MONTHNAME(Dt_Pedido) = 'January' THEN 'Janeiro'
                    WHEN MONTHNAME(Dt_Pedido) = 'February' THEN 'Fevereiro'
                    WHEN MONTHNAME(Dt_Pedido) = 'March' THEN 'Março'
                    WHEN MONTHNAME(Dt_Pedido) = 'April' THEN 'Abril'
                    WHEN MONTHNAME(Dt_Pedido) = 'May' THEN 'Maio'
                    WHEN MONTHNAME(Dt_Pedido) = 'June' THEN 'Junho'
                    WHEN MONTHNAME(Dt_Pedido) = 'July' THEN 'Julho'
                    WHEN MONTHNAME(Dt_Pedido) = 'August' THEN 'Agosto'
                    WHEN MONTHNAME(Dt_Pedido) = 'September' THEN 'Setembro'
                    WHEN MONTHNAME(Dt_Pedido) = 'October' THEN 'Outubro'
                    WHEN MONTHNAME(Dt_Pedido) = 'November' THEN 'Novembro'
                    WHEN MONTHNAME(Dt_Pedido) = 'December' THEN 'Dezembro'
                END AS Mes,
                DATE_FORMAT(Dt_Pedido, '%Y') as Ano,
                Forma_Pagamento,
                Status,
                Valor_total,
                Cod_Pedido 
            FROM Pedido 
            WHERE fk_Cod_Usuario = '{$_SESSION['Cod_Usuario']}'
            ORDER BY Pedido.Cod_Pedido DESC";
            $result = $conn->query($sql);
        }
        ?>
        <iframe src="../../barrasNav.php" class="iframenav"></iframe>
        <section id="info">
            <div id="pneuMurcho">
                <img src="../../img/history.png" alt="icone quero ir">
                <p id="infoP1">HISTÓRICO DE PEDIDOS</p>
                <p id="infoP2"><?php echo $result->num_rows; ?> pedidos feitos</p>
            </div>
            <form action="" method="get">
                <input type="text" name="busca" id="busca" placeholder="Pesquisar todos os pedidos">
                <input type="submit" value="Buscar" style="display: none;">
            </form>
        </section>

        <section id="pedidos">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data_formatada = $row['Dia'] . $row['Mes'] . ' de ' . $row['Ano'];
                    echo '<div id="caixa_pedidos">';
                    echo '<div id="textoInfo">';
                    echo '<div class="alignStatusPedido">';
                    echo '<div class="alignPedido">';
                    echo '<p id="pedidoP1">Pedido realizado</p>';
                    echo '<p id="statusP1">' . $data_formatada . '</p>';
                    echo '</div>';
                    echo '<div class="alignPedido">';
                    echo '<p id="pedidoP2">Valor total</p>';
                    echo '<p id="statusP2">R$ ' . $row['Valor_total'] . '</p>';
                    echo '</div>';
                    echo '<div class="alignPedido">';
                    echo '<p id="pedidoP3">Status</p>';
                    echo '<p id="statusP3">' . $row['Status'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<p id="pedidoP4">Pedido Nº' . $row['Cod_Pedido'] . '</p>';
                    echo '</div>';
                    $sqlT = "SELECT fk_Cod_Produto_Tipo, Quantidade FROM Tem WHERE fk_Cod_Pedido = '{$row['Cod_Pedido']}'";
                    $resultT = $conn->query($sqlT);
                    if ($resultT && $resultT->num_rows > 0) {
                        while ($rowT = $resultT->fetch_assoc()) {
                            $sqlP = "SELECT Marca, Modelo, Imagem FROM Produto_Tipo WHERE Cod_Produto = '{$rowT['fk_Cod_Produto_Tipo']}'";
                            $resultP = $conn->query($sqlP);
                            $rowP = $resultP->fetch_assoc();
                            echo '<div id="produto_caixa">';
                            echo '<img src="data:image/jpeg;base64, ' . base64_encode($rowP['Imagem']) . ' " alt="">';
                            echo '<div>';
                            echo '<p id="caixaP1">' . $rowP['Marca'] . ' ' . $rowP['Modelo'] . '</p>';
                            echo '<p id="caixaP2">Quantidade: <span id="quantidade">' . $rowT['Quantidade'] . '</span></p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
            } else {
                echo '<div class="avisoPerigoso">';
                echo '<p id="avisoPesquisa">Nenhum pedido encontrado! </p>';

                $sqlb = "SELECT * FROM Pedido WHERE fk_Cod_Usuario = ?";
                $stmt = $conn->prepare($sqlb);
                $stmt->bind_param("i", $_SESSION['Cod_Usuario']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows == 0) { ?>
                    <p id="avisoPesquisa2">Adicione itens aos seu carrinho ou finalize uma compra primeiro!</p>;
                    <div id="divBotoes">
                        <a href="../../" class="botoesCard">Home</a>
                        <a href="../../carrinho/" class="botoesCard">Carrinho</a>
                    </div>
            <?php } else
                    echo '</div>';
            }
            ?>
        </section>
    </body>

    </html>