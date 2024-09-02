<?php

    // Connect to the database
    include("../../connection.php");

    // Check if a product ID was provided in the request
    if (isset($_GET['cpu'])) {
        $Cod_CPU = $_GET['cpu'];
        $sql = "SELECT * FROM CPU WHERE Cod_CPU = $Cod_CPU";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['gpu'])){
        $Cod_GPU = $_GET['gpu'];
        $sql = "SELECT * FROM GPU WHERE Cod_GPU = $Cod_GPU";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['pm'])){
        $Cod_PlacaMae = $_GET['pm'];
        $sql = "SELECT * FROM Placa_Mae WHERE Cod_PlacaMae = $Cod_PlacaMae";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['ram'])){
        $Cod_MemRAM = $_GET['ram'];
        $sql = "SELECT * FROM Memoria_Ram WHERE Cod_MemRAM = $Cod_MemRAM";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['arma'])){
        $Cod_Armazenamento = $_GET['arma'];
        $sql = "SELECT * FROM Armazenamento WHERE Cod_Armazenamento = $Cod_Armazenamento";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['fonte'])){
        $Cod_Fonte = $_GET['fonte'];
        $sql = "SELECT * FROM Fonte WHERE Cod_Fonte = $Cod_Fonte";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['gabinete'])){
        $Cod_Gabinete = $_GET['gabinete'];
        $sql = "SELECT * FROM Gabinete WHERE Cod_Gabinete = $Cod_Gabinete";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['monitor'])){
        $Cod_Monitor = $_GET['monitor'];
        $sql = "SELECT * FROM Monitor WHERE Cod_Monitor = $Cod_Monitor";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['teclado'])){
        $Cod_Teclado = $_GET['teclado'];
        $sql = "SELECT * FROM Teclado WHERE Cod_Teclado = $Cod_Teclado";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['mouse'])){
        $Cod_Mouse = $_GET['mouse'];
        $sql = "SELECT * FROM Mouse WHERE Cod_Mouse = $Cod_Mouse";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    } else if (isset($_GET['headset'])){
        $Cod_Headset = $_GET['headset'];
        $sql = "SELECT * FROM Headset WHERE Cod_Headset = $Cod_Headset";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $productData = mysqli_fetch_assoc($result);
            $jsonData = json_encode($productData);
            echo $jsonData;
        }
    }
?>