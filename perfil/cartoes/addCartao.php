<?php
include ('../../connection.php');
session_start();

$nomeTitular = $conn->real_escape_string($_POST["nomeTitular"]);
$CPF = $conn->real_escape_string($_POST["CPF"]);
$vencimento = $conn->real_escape_string($_POST["vencimento"]);
$CVC = $conn->real_escape_string($_POST["CVC"]);
$numero = $conn->real_escape_string($_POST["numero"]);
$codUsuario = $_SESSION['Cod_Usuario'];

list($month, $year) = explode('/', $vencimento);
$vencimentoFormatted = $year . '-' . $month . '-01';

$checkCardQuery = $conn->prepare("SELECT * FROM Cartao_pagamento WHERE Numero = ? AND fk_Cod_Usuario = ?");
$checkCardQuery->bind_param("si", $numero, $codUsuario);
$checkCardQuery->execute();
$checkCardQuery->store_result();

if ($checkCardQuery->num_rows > 0) {
    header("Location: ../cartoes/?error=exists");
    exit();
} else {
    $addcartao = $conn->prepare("INSERT INTO Cartao_pagamento (Nome_Titular, CPF_Titular, Dt_Vencimento, CVC, Numero, fk_Cod_Usuario) VALUES (?, ?, ?, ?, ?, ?)");
    $addcartao->bind_param("sssssi", $nomeTitular, $CPF, $vencimentoFormatted, $CVC, $numero, $codUsuario);

    if ($addcartao->execute()) {
        header("Location: ../cartoes/?success=added");
        exit();
    } else {
        echo "Erro ao adicionar o cartão: " . $conn->error;
    }

    $addcartao->close();
}

$checkCardQuery->close();
$conn->close();
?>