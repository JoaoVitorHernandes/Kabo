<?php
include('connection.php');
session_start();

/* dados recebidos */
$Cod_Usuario = $_SESSION['Cod_Usuario'];
$desconto = $_POST['desconto'];
$codCupom = $_POST['codCupom'];
$valorCompra = $_POST['valorTotal'];
$cartaoSelecionado = $_POST['cartaoSelecionado'];
/* variáveis de auxílio */
$dataHoje = date('Y-m-d H:i:s'); // data de hoje

$stmt = $pdo->prepare("SELECT * FROM AdicionaCarrinho WHERE fk_Cod_Usuario = :Cod_Usuario");
$stmt->execute(['Cod_Usuario' => $Cod_Usuario]);
$produtosCarrinho = $stmt->fetchAll();
if (empty($produtosCarrinho)) {
    echo 'Carrinho vazio';
} else {
    try {
        $pdo->beginTransaction();

        // Seleciona os produtos no carrinho
        $stmt = $pdo->prepare("SELECT * FROM AdicionaCarrinho WHERE fk_Cod_Usuario = :Cod_Usuario");
        $stmt->execute(['Cod_Usuario' => $Cod_Usuario]);
        $produtosCarrinho = $stmt->fetchAll();

        $errosProdutos = []; // produtosInsuficientes, produtosEsgotados
        foreach ($produtosCarrinho as $produto) {
            // Verifica a quantidade em estoque
            $stmt = $pdo->prepare("SELECT Qtd_estoque, Cod_Produto FROM Produto_Tipo WHERE Cod_Produto = :Cod_Produto FOR UPDATE");
            $stmt->execute(['Cod_Produto' => $produto['fk_Cod_Produto_Tipo']]);
            $produtoEstoque = $stmt->fetch();

            if ($produtoEstoque['Qtd_estoque'] < $produto['Quantidade']) {
                $errosProdutos[] = $produtoEstoque['Cod_Produto'];
                $errosProdutos[] = $produtoEstoque['Qtd_estoque'];
            }
        }

        if (!empty($errosProdutos)) {
            echo json_encode($errosProdutos);
            $pdo->rollBack();
        } else {
            // Cria o pedido
            $stmt = $pdo->prepare("INSERT INTO Pedido (fk_Cod_Usuario, Dt_Pedido, Forma_Pagamento, Status, Valor_total) VALUES (:Cod_Usuario, :Dt_Pedido, :Forma_Pagamento, 'Em análise', :Valor_total)");
            $stmt->execute([
                'Cod_Usuario' => $Cod_Usuario,
                'Dt_Pedido' => $dataHoje,
                'Forma_Pagamento' => substr($cartaoSelecionado, -4),
                'Valor_total' => $valorCompra
            ]);

            $Cod_Pedido = $pdo->lastInsertId();

            // Transfere os produtos do carrinho para a tabela "tem" e atualiza o estoque
            foreach ($produtosCarrinho as $produto) {
                $stmt = $pdo->prepare("INSERT INTO tem (fk_Cod_Pedido, fk_Cod_Produto_Tipo, Quantidade) VALUES (:Cod_Pedido, :Cod_Produto_Tipo, :Quantidade)");
                $stmt->execute([
                    'Cod_Pedido' => $Cod_Pedido,
                    'Cod_Produto_Tipo' => $produto['fk_Cod_Produto_Tipo'],
                    'Quantidade' => $produto['Quantidade']
                ]);

                // Atualiza a quantidade em estoque
                $stmt = $pdo->prepare("UPDATE Produto_Tipo SET Qtd_estoque = Qtd_estoque - :Quantidade WHERE Cod_Produto = :Cod_Produto");
                $stmt->execute([
                    'Quantidade' => $produto['Quantidade'],
                    'Cod_Produto' => $produto['fk_Cod_Produto_Tipo']
                ]);
            }

            // Se codCupom estiver definido, insere na tabela "Cupom"
            if (isset($codCupom)) {
                $stmt = $pdo->prepare("INSERT INTO Cupom (fk_Cod_Usuario, fk_Cod_Pedido, Desconto, Cod_Uso) VALUES (:Cod_Usuario, :Cod_Pedido, :Desconto, :Cod_Uso)");
                $stmt->execute([
                    'Cod_Usuario' => $Cod_Usuario,
                    'Cod_Pedido' => $Cod_Pedido,
                    'Desconto' => $desconto,
                    'Cod_Uso' => $codCupom
                ]);
            }

            // Esvazia o carrinho
            $stmt = $pdo->prepare("DELETE FROM AdicionaCarrinho WHERE fk_Cod_Usuario = :Cod_Usuario");
            $stmt->execute(['Cod_Usuario' => $Cod_Usuario]);

            $pdo->commit();

            echo 'Compra finalizada';
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo 'Erro: ' . $e->getMessage();
    }
}
