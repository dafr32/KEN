<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    require "connect.php";

    $kod = $_GET['kod'];
    $rok = $_GET['rok'];
    
    $sql = "SELECT * FROM `egzaminy__Uczniowie` WHERE `Kod zdającego` = '$kod' AND `Rok` = '$rok'" ;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $firstRow = $result->fetch_assoc(); // Fetch the first row separately
        
        echo "<h3 >Dane ucznia (kod: $kod)</h3>";
        echo "<h2 class='my-3'>{$firstRow['Nazwisko']} {$firstRow['Imiona']}</h2>";
        
        // Reset the result pointer to the beginning
        $result->data_seek(0);

        echo "<table class='table'>";
        echo "<thead><tr><th>Egzamin</th><th>Sposoby dostosowania</th><th>Sala</th></tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Egzamin'] . "</td>";
            echo "<td>" . $row['Sposoby dostosowania'] . "</td>";
            echo "<td>" . $row['Nr sali'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";

    } else {
        echo "<p>Brak danych dla tego ucznia.</p>";
    }
?>
