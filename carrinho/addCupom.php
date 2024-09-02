<?php
include('connection.php');
session_start();

$Cod_Usuario = $_SESSION['Cod_Usuario'];
$Cod_Uso = strtoupper(trim($_POST['cupom']));

$stmt = $conn->prepare("SELECT * FROM cupom WHERE Cod_Uso = ? AND fk_Cod_Usuario = ?");
$stmt->bind_param('si', $Cod_Uso, $Cod_Usuario);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($result->num_rows == 0) {
    if ($Cod_Uso == 'TESTE') {
        echo '50,' . $Cod_Uso;
    } elseif ($Cod_Uso == 'GRATIS100') {
        echo '100,' . $Cod_Uso;
    } elseif ($Cod_Uso == 'KABO12') {
        echo '12,' . $Cod_Uso;
    } elseif ($Cod_Uso == 'BEMVINDO') {
        echo '10,' . $Cod_Uso;
    } else {
        echo 'Cupom inválido!';
    }
} elseif ($Cod_Uso == '') {
    echo 'Insira um cupom!';
} else {
    echo 'Cupom já utilizado!';
}
$conn->close();
