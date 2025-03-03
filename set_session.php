<?php
    session_start();
    if (isset($_POST['rok'])) {
        $_SESSION['egzaminy-rok'] = $_POST['rok'];
    }

    if (isset($_POST['idMenu'])) {
        // Sanitizacja danych wejściowych przed wypisaniem ich do JavaScript
        $idMenu = htmlspecialchars($_POST['idMenu'], ENT_QUOTES, 'UTF-8');
        
        // Zapisz idMenu w sesji
        $_SESSION['idMenu'] = $idMenu;
        echo json_encode(["status" => "success", "idMenu" => $_SESSION['idMenu']]);
        // Wypisz do konsoli w JavaScript
        echo "<script>console.log('zapisano', " . json_encode($idMenu) . "); </script>";
    }
    
    

?>
