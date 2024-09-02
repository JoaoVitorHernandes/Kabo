<?php
include ('../../connection.php');
session_start();

$codCartao = $_POST["cod_cartao"];
$dataVencimento = $_POST['data_vencimento'];
$titularCartao = $_POST['titular_cartao'];

list($month, $year) = explode('/', $dataVencimento);
$vencimentoFormatted = $year . '-' . $month . '-01';

$stmt = $conn->prepare("UPDATE Cartao_pagamento SET Dt_Vencimento = ?, Nome_Titular = ? WHERE Cod_Cartao = ?");
$stmt->bind_param("ssi", $vencimentoFormatted, $titularCartao, $codCartao);
$resultEditarCartao = $stmt->execute();

if ($resultEditarCartao) {
    header("Location: ../cartoes/");
    exit;
} else {
    echo "Erro ao atualizar o cartão: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>