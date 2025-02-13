<?php
    if (session_status() === PHP_SESSION_NONE) { 
        session_start();
     }        
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){ 
        header('Location: index.php'); 
    }
    require "connect.php";         

    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];
    $klasa = $_SESSION['klasa'];
    $okres = $_SESSION['okres'];
    
    //formularz wyboru ucznia z opinią w pliku efekt_Uczniowie 
    if(isset($_POST['zapiszWybranych'])) {
                
        foreach ($_POST as $key => $value) {   
            if (strpos($key, 'id_uczen') === 0) {
                $id_user = substr($key, 8);
                $sql = "DELETE FROM `efektywnosc__UczniowieOpinia`
                        WHERE rokSzk = $rokSzk AND semestr = '$semestr' AND id_ucznia = $id_user";                            
                // echo "$sql<br>";
                $result = $conn->query($sql);
                if ($result) {
                    // echo "usuniety";
                }
            }
            // Check if the key starts with 'wybrany'
            if (strpos($key, 'wybrany') === 0) {                                
                if ($value === 'on') {
                    $sql = "INSERT INTO efektywnosc__UczniowieOpinia (ID_opinia, id_ucznia, rokSzk, semestr) 
                            VALUES (null, $id_user, $rokSzk, '$semestr')";        

                    echo $sql; // Check the generated SQL query

                    $result = $conn->query($sql);

                    if ($result) {                        
                        echo "Insert query executed successfully.";
                        $_SESSION['statusZapisu'] = "Pomyślnie zaspisano";                        
                    } else {
                        // Error in the insert query
                        echo "Błąd wstawiania: " . $conn->error;
                    }
                }
            } 

            
        }
            
        if($conn)
        {
            $_SESSION['statusZapisu'] = "Pomyślnie zaspisano";
            header('Location: efekt_Pedagog.php');
        }
        header('Location: efekt_Pedagog.php');
    }

    // Efektywność zapis ocen klasy 
    if(isset($_POST['saveOceny'])) {
        $belfer_id = $_SESSION['belfer_id'];
        $przedmiot_id = $_SESSION['przedmiot'];

        $klasa = $_SESSION["klasa"] ;        
        $rocznik = $_SESSION["rocznik"]  ; 

        // odczytaj wszystkich uczniów z opiniami z wybranej klasy 
        $sql = "SELECT * FROM efektywnosc__Uczniowie 
                INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
                WHERE efektywnosc__Uczniowie.rocznik= $rocznik AND efektywnosc__Uczniowie.klasa = '$klasa'";                        
        $result1 = $conn->query($sql);                  
        if ($result1->num_rows > 0){
            while($row = $result1->fetch_assoc()){
                $id = $row['ID'];

                // wnioski 
                $sql = "DELETE FROM `efektywnosc__UczniowieWnioski` WHERE `id_ucznia` = $id AND `id_nauczyciela` = $belfer_id AND `przedmiot` = $przedmiot_id AND `rokSzk` = $rokSzk AND `semestr` = $semestr";  
                // echo $sql;                
                $result = $conn->query($sql);
                $lista = $_POST["wnioski$id"];
                if (!empty($lista)) {                
                    foreach($lista as $item){ 
                        $sql2 = "INSERT INTO `efektywnosc__UczniowieWnioski`(`id`, `id_ucznia`, `id_nauczyciela`, `przedmiot`, `id_wniosek`, `rokSzk`, `semestr`) 
                                VALUES (null, $id, $belfer_id, $przedmiot_id, $item, $rokSzk, $semestr)"; 
                        // echo $sql2;
                        $result2 = $conn->query($sql2);                                          
                    }
                }

                // efekty 
                $sql = "DELETE FROM `efektywnosc__UczniowieEfekty` WHERE id_ucznia=$id AND id_nauczyciela=$belfer_id AND przedmiot=$przedmiot_id AND `rokSzk` = $rokSzk AND `semestr` = $semestr";  
                // echo  $sql2."<br>";   
                $result = $conn->query($sql);

                $lista2 = $_POST["efekty$id"];
                if (!empty($lista2)) {
                    foreach($lista2 as $item){ 
                        $sql2 = "INSERT INTO `efektywnosc__UczniowieEfekty` (`id`, `id_ucznia`, `id_nauczyciela`, `przedmiot`, `id_efekt`, `rokSzk`, `semestr`) 
                                VALUES (null, $id, $belfer_id, $przedmiot_id, $item, $rokSzk, $semestr)"; 
                        $result2 = $conn->query($sql2);                  
                    }
                }
                
                // formy 
                $sql = "DELETE FROM efektywnosc__UczniowieFormy WHERE id_ucznia=$id AND id_nauczyciela=$belfer_id AND przedmiot=$przedmiot_id AND `rokSzk` = $rokSzk AND `semestr` = $semestr";  
                // echo  $sql."<br>";   
                $result = $conn->query($sql);
            
                $lista2 = $_POST["formy$id"];
                if (!empty($lista2)) {
                    foreach($lista2 as $item){
                        $sql2 = "INSERT INTO efektywnosc__UczniowieFormy (`id`, `id_ucznia`, `id_nauczyciela`, `przedmiot`, `id_formy`, `rokSzk`, `semestr` ) 
                                VALUES (null, $id, $belfer_id, $przedmiot_id, $item, $rokSzk, $semestr)"; 
                        // echo  $sql2."<br>";   
                        $result2 = $conn->query($sql2);                  
                    }
                }
                // Ocena 
                $sql = "DELETE FROM efektywnosc__UczniowieOcena WHERE id_ucznia=$id AND id_nauczyciela=$belfer_id AND przedmiot=$przedmiot_id AND `rokSzk` = $rokSzk AND `semestr` = $semestr";  
                // echo  $sql."<br>";   
                $result = $conn->query($sql);
                
                $ocena = $_POST["progress$id"];     
                echo "uzasadnienie: ". $_POST["uzasadnienie$id"];       
                // $uzasadnienie = htmlentities($_POST["uzasadnienie$id"]);  
                $uzasadnienie = $_POST["uzasadnienie$id"];
                echo "uzasadnienie: $uzasadnienie";
                if ($ocena > 0 ) {
                    $sql2 = "INSERT INTO `efektywnosc__UczniowieOcena`(`id`, `id_ucznia`, `id_nauczyciela`, `przedmiot`, `ocena`, `uzasadnienie`, `rokSzk`, `semestr` ) 
                            VALUES (null, $id, $belfer_id, $przedmiot_id, $ocena, '$uzasadnienie', $rokSzk, $semestr)"; 
                    // echo  $sql2."<br>";   
                    $result2 = $conn->query($sql2);                  
                }            
            } 
        }
        $_SESSION['statusZapisuOceny'] = "- zapisano";
        header('Location: efekt_Nauczyciel.php');

    }
    
    // IMPORT the CSV file
    if (isset($_POST['import_Users'])) {
        $csvFile = $_FILES['csvFile']['tmp_name'];
        
        if (($handle = fopen($csvFile, "r")) !== false) {
            // Loop through each row in the CSV file
            fgetcsv($handle, 1000, ";");

            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                if($data[0] != 'Klasa'){  
                    $parts = explode(" ", $data[0]);
                    $klasa = $parts[1];                                    
                    $rocznik = $rokSzk - ($parts[0] - 1);
                    $nazwisko = $data[1];
                    $imie = $data[2];
                    
                    // Insert data into MySQL
                    $sql = "INSERT IGNORE INTO `efektywnosc__Uczniowie`(`ID`, `imie`, `nazwisko`, `klasa`, `rocznik`)
                            VALUES (null, '$imie', '$nazwisko', '$klasa', $rocznik)";                
                    
                    if ($conn->query($sql) === true) {
                        echo "Record inserted successfully.<br>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }    
            fclose($handle);            
            // header('Location: efekt_Pedagog.php');
            // exit(); // Ensure no code is executed after the header() function
        } else {
            echo "Error opening the CSV file.";
        }
    }
    
?>