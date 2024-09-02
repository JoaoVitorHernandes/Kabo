<?php 
include('connection.php');
session_start();

if (!isset($_SESSION['Cod_Usuario'])) {
    header('Location: ../login/');
}
else{
    /* select para saber se usuario tem produto adicionado ao carrinho */
    $Cod_Usuario = $_SESSION['Cod_Usuario'];
    $queryCarrinho = "SELECT SUM(quantidade) as total FROM AdicionaCarrinho WHERE fk_Cod_Usuario = ?";
    $stmt = $conn->prepare($queryCarrinho);
    $stmt->bind_param("i", $Cod_Usuario);
    $stmt->execute();
    $resultCarrinho = $stmt->get_result();
    $row = $resultCarrinho->fetch_assoc();
    $quantidadeItens = $row['total'];

    /* select para selecionar tudo do usuario antes de abrir o carrinho*/
    $sqlUsuario = "SELECT * FROM Usuario WHERE Cod_Usuario = '{$_SESSION['Cod_Usuario']}'";
    $resultUsuario = $conn->query($sqlUsuario);
    $rowUsuario = $resultUsuario->fetch_assoc();
    $nomeCompleto = $rowUsuario['Nome'];
    $partesNome = explode(' ', $nomeCompleto);
    $clienteLogado = $partesNome[0];
    $imgPerfil = $rowUsuario['Imagem'];
    

    /* abre o carrinho de acordo com a quantidade */
    if($quantidadeItens > 0){
        include('carrinho.php');
    } else {
        include('carrinhoVazio.php');
    }


}
?>