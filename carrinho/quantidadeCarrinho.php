<?php
include('connection.php');
session_start();

$Cod_Usuario = $_SESSION['Cod_Usuario'];
$Cod_Produto = $_POST['Cod_Produto'];
$quantidade = $_POST['quantidadeProduto'];

// Primeira consulta: obter Qtd_estoque de ProdutoTipo
$stmt = $conn->prepare('SELECT Qtd_estoque FROM Produto_Tipo WHERE Cod_Produto = ?');
$stmt->bind_param('i', $Cod_Produto);
$stmt->execute();
$result = $stmt->get_result();
$estoque = $result->fetch_assoc()['Qtd_estoque'];

// Segunda consulta: obter Quantidade de AdicionaCarrinho
$stmt = $conn->prepare('SELECT Quantidade FROM AdicionaCarrinho WHERE fk_Cod_Usuario = ? AND fk_Cod_Produto_Tipo = ?');
$stmt->bind_param('ii', $Cod_Usuario, $Cod_Produto);
$stmt->execute();
$result = $stmt->get_result();
$quantidadeCarrinho = $result->fetch_assoc()['Quantidade'];

// Updadte de quantidade
if ($estoque > 0 && $quantidadeCarrinho < 10 && $quantidade > 0) {
    $stmt = $conn->prepare('UPDATE AdicionaCarrinho SET Quantidade = ? WHERE fk_Cod_Usuario = ? AND fk_Cod_Produto_Tipo = ?');
    $stmt->bind_param('iii', $quantidade, $Cod_Usuario, $Cod_Produto);
    $stmt->execute();
} else {
    if ($quantidade == 0) {
        $stmt = $conn->prepare('DELETE FROM AdicionaCarrinho WHERE fk_Cod_Usuario = ? AND fk_Cod_Produto_Tipo = ?');
        $stmt->bind_param('ii', $Cod_Usuario, $Cod_Produto);
        $stmt->execute();
    }
}
$stmt->close();
