<?php 
include('connection.php');
session_start();

$usuario = isset($_SESSION['Cod_Usuario']) ? $_SESSION['Cod_Usuario'] : '';
$Cod_Produto = $_POST['codProduto'];
$quantidade = $_POST['quantidade'];

// Verificar se o produto já está no carrinho
$query = "SELECT * FROM AdicionaCarrinho WHERE fk_Cod_Usuario = $usuario AND fk_Cod_Produto_Tipo = $Cod_Produto";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    // O produto já está no carrinho
    $row = mysqli_fetch_assoc($result);
    $quantidadeCarrinho = $row['Quantidade'];

    // Verificar se a quantidade do produto no carrinho é menor ou igual ao estoque disponível ou igual a 10
    $query = "SELECT Qtd_estoque FROM Produto_Tipo WHERE Cod_Produto = $Cod_Produto";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $estoque = $row['Qtd_estoque'];

    if(($quantidadeCarrinho + $quantidade) <= min($estoque, 10)) {
        // Atualizar a quantidade do produto no carrinho
        $query = "UPDATE AdicionaCarrinho SET Quantidade = Quantidade + $quantidade WHERE fk_Cod_Usuario = $usuario AND fk_Cod_Produto_Tipo = $Cod_Produto";
        mysqli_query($conn, $query);
    } else if($estoque > 0){
        $minimo = min($estoque, 10);
        $query = "UPDATE AdicionaCarrinho SET Quantidade = $minimo WHERE fk_Cod_Usuario = $usuario AND fk_Cod_Produto_Tipo = $Cod_Produto";
        mysqli_query($conn, $query);
    } else {
        echo "Estoque esgotado!";
    }
} else {
    // O produto não está no carrinho
    // Verificar se o estoque do produto permite a inserção
    $query = "SELECT Qtd_estoque FROM Produto_Tipo WHERE Cod_Produto = $Cod_Produto";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $estoque = $row['Qtd_estoque'];

    if($estoque >= $quantidade) {
        // Inserir o produto no carrinho
        $query = "INSERT INTO AdicionaCarrinho (fk_Cod_Usuario, fk_Cod_Produto_Tipo, Quantidade) VALUES ($usuario, $Cod_Produto, $quantidade)";
        mysqli_query($conn, $query);
    }
    else {
        echo "Estoque esgotado!";
    }
}
?>