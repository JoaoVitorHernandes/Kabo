<?php
include ('../../connection.php');
session_start();

$codCartao = $_POST["cod_cartao"];

$deleteCartao = "DELETE FROM Cartao_pagamento WHERE Cod_Cartao = $codCartao";
$resultDeleteCartao = $conn->query($deleteCartao);
exec($resultDeleteCartao);
if (isset($resultDeleteCartao)) {
    header("Location: ../cartoes/");
}

?>