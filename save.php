<?php
    session_start();
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        header('Location: index.php');
    }
        
    $rokSzk=$_SESSION['rokSzk']; 
    $semestr = $_SESSION['semestr']; 
    $miesiac = $_SESSION['miesiac'];
    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    $filePHP = $_SESSION["filePHP"];

    // -------------------------------------------------------------------------------------------------------- 
    // aktualizacja Roku Szkolnego, semestru w panelu Dyrektora 
    if (isset($_POST["submitRok"])) {
        include "connect.php";
        $rokSzk=$_POST['rok'];
        $semestr=$_POST['sem'];    
        $ileTygodni=$_POST["ileTygodni"];

        $sql = "SELECT * FROM `RokSettings`";
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {                    
            $sql = "UPDATE `RokSettings` SET `rokSzk` = ?, `semestr` = ?, `ileTygodni` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $rokSzk, $semestr, $ileTygodni );
            $stmt->execute();
        } else {
            $sql = "INSERT INTO `RokSettings`(`rokSzk`, `semestr`, `ileTygodni`, `miesiacRozliczeniowy`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);            
            $stmt->bind_param("iiis", $rokSzk, $semestr, $ileTygodni, $okres);
            $stmt->execute();
        }
        $conn->close();
        $_SESSION['rok'] = $rokSzk;
        $_SESSION['semestr'] = $semestr;  
        $_SESSION['ileTygodni'] = $ileTygodni;  

        header('Location: ken_admin.php');
    }

    // -------------------------------------------------------------------------------------------------------- 
    // aktualizacja miesiąca rozliczeniowego w panelu Dyrektora 
    if (isset($_POST["submitMiesiac"])) {
        include "connect.php";
        $rokSzk=$_SESSION['rokSzk'];
        $okres=$_POST["miesiac"];
    
        $sql = "SELECT * FROM `RokSettings`";
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {                   
            $sql = "UPDATE `RokSettings` SET `miesiacRozliczeniowy` = ?";
            $stmt = $conn->prepare($sql);            
            $stmt->bind_param("s", $okres);
            $stmt->execute();
            $conn->close();
        } 
        
        header('Location: ken_admin.php');
        exit;
    }
    
    // -------------------------------------------------------------------------------------------------------- 
    if (isset($_POST["saveUser"])) {
        include "connect.php";
        $belfer_id = $_SESSION['belfer_id'];
        if(isset($_POST["passwd"]))
        {            
            $passwd = md5($_POST["passwd"]);
            $sql="UPDATE `Nauczyciele` SET `haslo`='". $passwd ."' WHERE `ID`=".$belfer_id;            
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
              } else {
                echo "Error updating record: " . $conn->error;
              }
        }

        if (isset($_POST["email"]))
        {
            $sql="UPDATE `Nauczyciele` SET `email`='". $_POST["email"] ."' WHERE `ID`=".$belfer_id;
            echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
              } else {
                echo "Error updating record: " . $conn->error;
              }
        }
        $_SESSION['savePasswd']="true";
        $conn->close();
        header('Location: home.php');
        exit;

    } 


    // -------------------------------------------------------------------------------------------------------- 
    // Zapis nagrody dodanej przez nauczyciela w panelu Nagrody 

    if (isset($_POST["submitNagrody"]))  {           
        if (isset($_POST["dlaKogo"]) && isset($_POST["opis"])) {
            include "connect.php";

            $id = $_POST["idNagroda"]; 
            $dla = $_POST["dlaKogo"];
            $opis =  $_POST["opis"];  
            // Zamiana ostatniego przecinka na słowo "oraz"
            $lastCommaPos = strrpos($opis, ',');
            if ($lastCommaPos !== false) {
                $opis = substr_replace($opis, ' oraz', $lastCommaPos, 1);
            }

            $belfer_id = $_SESSION['belfer_id'];
            $rokSzk = $_SESSION['rokSzk'];

            if ($id != null ) {                  
                $sql = "UPDATE `nagrody_wpisy` SET `dla_kogo` = ?, `tekst_nagrody` = ? WHERE `id` = ?";
                $stmt = $conn->prepare($sql);                
                $stmt->bind_param("ssi", $dla, $opis, $id);
                $stmt->execute();
            } else {   
                echo "OK";             
                $sql = "INSERT INTO `nagrody_wpisy`(`id_nauczyciela`, `dla_kogo`, `tekst_nagrody`, `rok`) VALUES (?, ?, ?, ?)";                
                $stmt = $conn->prepare($sql);                
                $stmt->bind_param("issi", $belfer_id, $dla, $opis, $rokSzk);
                $stmt->execute();
            }
            $conn->close();            
        }        
        header('Location: nagrody.php');
        exit;
    }

    // -------------------------------------------------------------------------------------------------------- 
    // Nadgodziny
    // -------------------------------------------------------------------------------------------------------- 
    // Zapisanie ustawień godzin w tygodniu nauczyciela

    if (isset($_POST["saveUserGodziny"]))  { 
        include "connect.php";
        $rokSzk=$_SESSION['rokSzk'];        
        $miesiac = $_SESSION['miesiac'];
        $belfer = $_SESSION['belfer'];
        $belfer_id = $_POST['TeacherID'];

        $d1 = isset($_POST['PN']) ? $_POST['PN'] : 0;
        $d2 = isset($_POST['WT']) ? $_POST['WT'] : 0;
        $d3 = isset($_POST['SR']) ? $_POST['SR'] : 0;
        $d4 = isset($_POST['CZ']) ? $_POST['CZ'] : 0;
        $d5 = isset($_POST['PT']) ? $_POST['PT'] : 0;

        $kl4 = isset($_POST['kl4']) ? $_POST['kl4'] : 0;
        $etat = isset($_POST['etat']) ? $_POST['etat'] : 0;

        $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = ? AND `rokSzk` = ? AND `miesiac` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $belfer_id, $rokSzk, $miesiac);
        $stmt->execute();        
        $result = $stmt->get_result();    
        if ($result->num_rows > 0) {        
            // Jeśli rekord istnieje, zaktualizuj go
            $updateSql = "UPDATE `godz_Nauczyciele_Godziny` SET 
            `PN` = ?,
            `WT` = ?,
            `SR` = ?,
            `CZ` = ?,
            `PT` = ?,
            `kl4` = ?,
            `etat` = ?
            WHERE `ID_Nauczyciela` = ? AND `rokSzk` = ? AND `miesiac` = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("iiiiiiiiis", $d1, $d2, $d3, $d4, $d5, $kl4, $etat, $belfer_id, $rokSzk, $miesiac);
            $stmt->execute();
        } else {
            // Jeśli rekord nie istnieje, dodaj nowy
            // $insertSql = "INSERT INTO `godz_Nauczyciele_Godziny` (`ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`, `WT`, `SR`, `CZ`, `PT`, `kl4`, `etat`)
            //             VALUES ($belfer_id, $rokSzk, '$miesiac', $d1, $d2, $d3, $d4, $d5, $kl4, $etat)";
            
            // $insertResult = $conn->query($insertSql);

            $insertSql = "INSERT INTO `godz_Nauczyciele_Godziny` (`ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`, `WT`, `SR`, `CZ`, `PT`, `kl4`, `etat`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertSql);            
            $stmt->bind_param("iisiiiiiii", $belfer_id, $rokSzk, $miesiac, $d1, $d2, $d3, $d4, $d5, $kl4, $etat);
            $stmt->execute();
        }
        $conn->close();
        header("Location: $filePHP.php");       
        exit; 
        
    }

    // -------------------------------------------------------------------------------------------------------- 
    // Zapisanie okresu rozliczeniowego nauczyciela

    if (isset($_POST["submitOkres"]))  {
        include "connect.php";
        $rokSzk=$_SESSION['rokSzk'];        
        $miesiac = $_SESSION['miesiac'];
        $belfer = $_SESSION['belfer'];
        $belfer_id = $_POST['TeacherID'];
                
        // <!-- Odczytanie ID tygodni rozliczeniowych dla z danego okresu rozliczeniowego  -->        
        $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";        
        $result = $conn->query($sql); 
        if ($result->num_rows > 0) {                                  
            $week = 1;
            while($row = $result->fetch_assoc()) {   
                $tydzien_id = $row["ID"];
                echo "nauczyciel:  $belfer_id, tydz: $tydzien_id <br>";                               

                // sprawdzenie czy jest już wpisany rekord dla danego tygodnia 
                $sql2 = "SELECT * FROM (`godz_Nauczyciele_Rozliczenie_Tydzien` 
                        INNER JOIN godz_TydzienRozliczeniowy ON godz_Nauczyciele_Rozliczenie_Tydzien.id_tydzien = godz_TydzienRozliczeniowy.ID) 
                        WHERE `id_nauczyciel` = ? AND `id_tydzien` = ?";                
                $stmt = $conn->prepare($sql2);                            
                $stmt->bind_param("ii", $belfer_id, $tydzien_id);
                // echo $sql2 . "<br>";
                $stmt->execute();        
                $result2 = $stmt->get_result();  
                // jeśli jest już wpis tygodnia to nadpisz zmiany 
                if ($result2->num_rows > 0) {                                                                                
                    $row2 = $result2->fetch_assoc();
                    $id_week = $row2['ID_rozliczenia'];       
                    $sql3 = "UPDATE `godz_Nauczyciele_Rozliczenie_Tydzien` 
                             SET miesiac = '$miesiac', rokSzk = $rokSzk, ";
                            for ($day=1; $day<=5; $day++){
                                $wolne = isset($_POST["wolne".$week."-".$day]) ? $_POST["wolne".$week."-".$day] : null;
                                $wypracowane = isset($_POST["planowe".$week."-".$day]) ? $_POST["planowe".$week."-".$day] : null;
                                $x1 = isset($_POST["dorazne".$week."-".$day]) ? $_POST["dorazne".$week."-".$day] : 0;
                                $x2 = isset($_POST["indyw".$week."-".$day]) ? $_POST["indyw".$week."-".$day] : 0;
                                $x3 = isset($_POST["inne".$week."-".$day]) ? $_POST["inne".$week."-".$day] : 0;
                                $txt = "`D$day"."_wolne` = '".$wolne."', `D$day"."_wypracowane` = '".$wypracowane."' ,`D$day"."_dorazne` = $x1, `D$day"."_indyw` = $x2, `D$day"."_inne` = $x3,";
                                $sql3 .= $txt;
                            }                            
                            $sql3 .= "`etat`= " . $_POST['etat-'.$week] . ",";
                            $sql3 .= "`norma`= '" . $_POST['norma-'.$week] . "',";
                            $sql3 .= "`nadgodziny`= '" . $_POST['nadgodziny-'.$week] . "',";
                            $r1 = $_POST['razemRealizacja'.$week];               
                            $r2 = $_POST["razemDorazne".$week];     
                            $r3 = $_POST["razemIndyw".$week];       
                            $r4 = $_POST["razemInne".$week];
                    $txt .= "`razem_nadgodz`= $r1,`razem_dorazne`= $r2,`razem_indyw`= $r3,`razem_inne`= $r4 
                    WHERE godz_Nauczyciele_Rozliczenie_Tydzien.ID_rozliczenia = $id_week";                            
                    
                    $sql3 .= $txt;
                    // echo $sql3."<br><br>";
                    $conn->query($sql3);                                            
                } 
                // jeśli brak wpisu tygodnia to dodaj rekord
                else {
                    // INSERT 

                    $txt = "INSERT INTO `godz_Nauczyciele_Rozliczenie_Tydzien`(`ID_rozliczenia`, `id_tydzien`, `miesiac`, `rokSzk`, `id_nauczyciel`, `D1_wolne`, `D1_wypracowane`, `D1_dorazne`, `D1_indyw`, `D1_inne`, `D2_wolne`, `D2_wypracowane`, `D2_dorazne`, `D2_indyw`, `D2_inne`, `D3_wolne`, `D3_wypracowane`, `D3_dorazne`, `D3_indyw`, `D3_inne`, `D4_wolne`, `D4_wypracowane`, `D4_dorazne`, `D4_indyw`, `D4_inne`, `D5_wolne`, `D5_wypracowane`, `D5_dorazne`, `D5_indyw`, `D5_inne`, `etat`, `norma`, `nadgodziny`, `razem_nadgodz`, `razem_dorazne`, `razem_indyw`, `razem_inne`) 
                    VALUES (
                    null, $tydzien_id, '$miesiac', $rokSzk, $belfer_id, ";
                    for ($day=1; $day<=5; $day++){
                        $x = isset($_POST["wolne".$week."-".$day]) ? $_POST["wolne".$week."-".$day] : null;
                        $txt = $txt . "'" .$x."', ";
                        $x = isset($_POST["planowe".$week."-".$day]) ? $_POST["planowe".$week."-".$day] : null;
                        $txt .= "$x, ";
                        $x = isset($_POST["dorazne".$week."-".$day]) ? $_POST["dorazne".$week."-".$day] : 0;
                        $txt .= "$x, ";
                        $x = isset($_POST["indyw".$week."-".$day]) ? $_POST["indyw".$week."-".$day] : 0;
                        $txt .= "$x, ";
                        $x = isset($_POST["inne".$week."-".$day]) ? $_POST["inne".$week."-".$day] : 0;        
                        $txt .= "$x, ";                                                                        
                    }
                    $txt .= $_POST['etat-'.$week]. ", ";
                    $txt .= $_POST['norma-'.$week]. ", ";
                    $txt .= $_POST['nadgodziny-'.$week]. ", ";
                    $txt .= $_POST['razemRealizacja'.$week].", ";               
                    $txt .= $_POST["razemDorazne".$week].", ";     
                    $txt .= $_POST["razemIndyw".$week].", ";       
                    $txt .= $_POST["razemInne".$week]. ");";
                    echo "$txt<br><br>";
                    $conn->query($txt);
                }
                $week++;
            }
        }
        $_SESSION["zapis"]="zapisano !";
        header("Location: $filePHP.php");    
        exit;

    }


    // -------------------------------------------------------------------------------------------------------- 
    // Zapisanie okresu rozliczeniowego przez Dyrektora

    if (isset($_POST["setOkres"]))  { 
        include "connect.php";
        $rokSzk = $_SESSION['rokSzk']; 
        $miesiac =  $_SESSION['miesiac'];
    
        for ( $week = 1; $week <= 5; $week++ ) {            
                
            $id = $_POST["W$week-ID"];              
            $data = isset($_POST["W".$week."-Data"]) && $_POST["W".$week."-Data"] != "" ? $_POST["W".$week."-Data"] : 'null';                
            
            // odczyt dni do tablicy
            $day = [];
            for ($d = 1; $d <= 5; $d++) {                            
                $dayValue = isset($_POST["W".$week."-D".$d]) && $_POST["W".$week."-D".$d] == "on" ? 1 : 0;
                $day[] = $dayValue;
            }

            $prevPlan = isset($_POST["W$week-prev"]) && $_POST["W$week-prev"] == "on" ? 1 : 0;            
            $sql = "";
            
            // jeśli jest ID to zaktualizuj lub usuń 
            if ( $id != 'null') {                
                if  ($data == 'null' ) {    // jeśli data jest pusta to usuń wpis 
                    $sql = "DELETE FROM `godz_TydzienRozliczeniowy` WHERE `ID`= $id"; 
                } else {                    // jeśli data jest wypełniona to zaktualizuj
                    //zapisanie dni wolnych
                    $sql = "UPDATE `godz_TydzienRozliczeniowy` SET 
                            `DataPoczatkowa` = '$data',
                            `D1` = {$day[0]},
                            `D2` = {$day[1]},
                            `D3` = {$day[2]},
                            `D4` = {$day[3]},
                            `D5` = {$day[4]},
                            `prevPlan` = $prevPlan
                            WHERE `ID`= $id";
                }
            } elseif ( $data != 'null' ) { // jeśli ID = null to dodaj jeśli jest data
                // Insert jeśli brak                    
                $sql = "INSERT INTO `godz_TydzienRozliczeniowy`(`ID`,`rokSzk`, `miesiac`, `DataPoczatkowa`, `D1`, `D2`, `D3`, `D4`, `D5`, `prevPlan`) 
                        VALUES (null, 
                            $rokSzk, 
                            '$miesiac', 
                            '$data', 
                            {$day[0]}, 
                            {$day[1]}, 
                            {$day[2]}, 
                            {$day[3]}, 
                            {$day[4]},
                            $prevPlan)";
            }
            
            if ( !empty($sql) ){
                echo  $sql . "<br>";
                $conn->query($sql);     
            }
        }

        header('Location: ken_admin.php');  
        exit;
    }
    
    
    // -------------------------------------------------------------------------------------------------------- 
    // Zapisanie okresu rozliczeniowego przez Dyrektora
    if (isset($_POST["prog_Przedmioty"]))  { 
        include "connect.php";
        foreach($_POST['przedmiot'] as $item){
            $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE id_Nauczyciela = $belfer_id AND rokSzk = $rokSzk AND semestr = $semestr AND id_Przedmiotu = $item";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {                   
                $sql = "INSERT INTO `prog_PrzedmiotyN`(`id`, `id_Nauczyciela`, `id_Przedmiotu`, `rokSzk`, `semestr`) 
                        VALUES (NULL, $belfer_id, $item, $rokSzk, $semestr)";
                $conn->query($sql);  
            }
            echo "$sql<br>";
        }    
        header('Location: prog_Realizacja.php');    
        exit;                                
    }
// --------------------------------------------------------------------------- 

    
// -------------------------------------------------------------------------------------------------------- 
// Zapisanie klasy do przedmiotów zrealizowanych
    if (isset($_POST['progDodajKlase'])){
        include "connect.php";
        $przedmiot = $_POST['przedmiot'];
        $klasa = $_POST['klasa'];
        $sql = "SELECT * FROM prog_Realizacja WHERE klasa = '$klasa' AND przedmiot = $przedmiot AND rokSzk = $rokSzk AND semestr = $semestr AND id_nauczyciela = $belfer_id";        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<script> alert('Klasa juz jest na liście !');</script>";
        }else {        
            $godz = $_POST['godz']; 
            $zrealizowany = ($_POST['zrealizowany'] == "on") ? 1 : 0;                                     
            $uzasadnienie = ($_POST['uzasadnienie'] != "" ) ? $_POST['uzasadnienie'] : "";                       
                        
            $sql = "INSERT INTO `prog_Realizacja` 
                    (`id`, `klasa`, `godz`, `zrealizowany`, `uzasadnienie`, `rokSzk`, `semestr`, `id_nauczyciela`, `przedmiot`) 
                    VALUES 
                    (null, '$klasa', $godz, $zrealizowany, '$uzasadnienie', $rokSzk, $semestr, $belfer_id, $przedmiot)";         
            $result = $conn->query($sql);
        }

        header('Location: prog_Realizacja.php');    
        exit;

    }       

// -------------------------------------------------------------------------------------------------------- 
// Ustawienia - przedmioty
// -------------------------------------------------------------------------------------------------------- 
    // skasowanie przedmiotu
    if (isset($_GET["del_Przedmiot"])) { 
        include "connect.php"; 
        $id = $_GET["del_Przedmiot"];         
        $G_sql="DELETE FROM `Przedmioty` WHERE ID = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        unset($_POST["del_Przedmiot"]);   
        header("Location: ken_admin.php");
    }

    // dodanie przedmiotu
    if (isset($_POST["add_Przedmiot"])) {
        include "connect.php";
        $nazwa=$_POST["nazwaPrzedmiotu"];
        $sql = "SELECT * FROM Przedmioty WHERE `przedmiot` = ?";        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nazwa);
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        echo $sql;
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO `Przedmioty` (`ID`, `przedmiot`) VALUES (null,?)";  
            echo $sql;                        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nazwa );
            $stmt->execute();           
        }
        header("Location: ken_admin.php");
    }                
    
// -------------------------------------------------------------------------------------------------------- 
// Ustawienia - Nauczyciele
// -------------------------------------------------------------------------------------------------------- 

    // GET - skasowanie nauczyciela
    if (isset($_GET["del_Nauczyciel"])) { 
        include "connect.php";

        $id = $_GET["del_Nauczyciel"];

        $G_sql="DELETE FROM `godz_Nauczyciele_klasy4` WHERE id_Nauczyciela = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        

        $G_sql="DELETE FROM `godz_Nauczyciele_Godziny` WHERE ID_Nauczyciela = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $G_sql="DELETE FROM `godz_Nauczyciele_Rozliczenie_Tydzien` WHERE id_nauczyciel = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $ip);
        $stmt->execute();

        $G_sql="DELETE FROM `Nauczyciele` WHERE ID = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        unset($_GET["del_Nauczyciel"]);   
        header("Location: ken_admin.php");
    }

    // GET - aktualizacja nauczyciela
    if (isset($_GET["update_Nauczyciel"])) { 
        // nadgodziny_nauczyciele.php?update_Nauczyciel=${id}&update_Active=${act}&update_Pass=${pass}
        include "connect.php";
        $id = $_GET["update_Nauczyciel"];
        if (isset($_GET["update_Pass"])){
            $hashed_password = password_hash($_GET["update_Pass"], PASSWORD_ARGON2I);
            $G_sql="UPDATE `Nauczyciele` SET `haslo`= ?,`first_login`= 1,`aktywne`= ? WHERE `ID`= ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("sii", $hashed_password, $_GET["update_Active"], $id );
        }else{            
            $G_sql="UPDATE `Nauczyciele` SET `aktywne`= ? WHERE `ID`= ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("i", $id );
        }
        $stmt->execute();  
        unset($_GET["update_Nauczyciel"]);      
        header("Location: ken_admin.php");
    }

    // POST dodanie nauczyciela
    if (isset($_POST["add_Nauczyciel"])) {        
        if (isset($_POST["nazwisko"]) && isset($_POST["imie"]) && isset($_POST["haslo"])){
            include "connect.php";
            $nazw=$_POST["nazwisko"];
            $imie=$_POST["imie"];            
            $hashed_password = password_hash($_POST["haslo"], PASSWORD_ARGON2I);
            // echo "$imie $nazw ". $_POST["haslo"] ;
            $G_sql = "SELECT * FROM Nauczyciele WHERE `Nazwisko` = ? AND `Imie` = ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("ss", $nazw, $imie);
            $stmt->execute(); 
            $resultG = $stmt->get_result(); 
            if ($resultG->num_rows > 0) {
                $userExist = "Nauczyciel już jest na liście";
            }else {
                $G_sql = "INSERT INTO `Nauczyciele`(`ID`, `Nazwisko`, `Imie`, `haslo`, `first_login`, `email`, `aktywne`) 
                          VALUES (null,?,?,?,1,'',1)";                          
                $stmt = $conn->prepare($G_sql);
                $stmt->bind_param("sss", $nazw, $imie,$hashed_password );
                $stmt->execute();                
            }
        }                

        header("Location: ken_admin.php");
    }


// -------------------------------------------------------------------------------------------------------- 
// Ustawienia - Egzaminy
// -------------------------------------------------------------------------------------------------------- 

    if( isset($_POST['updateEgzaminy'])){
        $ilePrzedm = $_SESSION[ 'ilePrzedmiotowEgzamin' ]; 
        include "connect.php";       
        for($i=1; $i<=$ilePrzedm;$i++) {
            $id = $_POST['id'.$i]; 
            $p = $_POST['przedmiot'.$i];
            $d = $_POST['data'.$i];
            $g = $_POST['godz'.$i];
            echo " $ilePrzedm - $id $p $d $g <br>";
            // $sql = "UPDATE `egzaminy__Terminy` SET `przedmiot`='$p' , `data`='$d', `godz`=$g WHERE id = $id";            
            // echo "$sql<br>";
            $sql = "UPDATE `egzaminy__Terminy` SET `przedmiot`=?, `data`=?, `godz`=? WHERE id = ?";                        
            $stmt = $conn->prepare($sql);
            if($stmt === false) {
                echo "Prepared statement creation failed: " . $conn->error;
                exit;
            }
            $stmt->bind_param('ssii', $p, $d, $g, $id);
            $result = $stmt->execute();            
        }
        header("Location: ken_admin.php");
    }


    if( isset($_POST['DodajEgzamin'])){
        $p = $_POST['przedmiot'];
        $d = $_POST['data'];
        $g = $_POST['godz'];        
        $rok = $_POST['rok'];        

        include "connect.php";   
        // sprawdzenie czy już przedmiot jest 
        $sql = "SELECT id FROM egzaminy__Terminy WHERE przedmiot = '$p' AND rok = $rok";               
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {            
            $sql = "INSERT INTO `egzaminy__Terminy`(`id`, `przedmiot`, `data`, `godz`, `rok`) VALUES (null,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            if($stmt === false) {
                echo "Prepared statement creation failed: " . $conn->error;
                exit;
            }
            $stmt->bind_param('ssii', $p, $d, $g, $rok);
            $result = $stmt->execute(); 
             
        }   
        // header("Location: ken_admin.php");
    }


    // if( isset($_POST['addKomisjaEgzamin'])) {
    //     include "connect.php";   
    //     $p = $_POST['EgzaminPrzedmiot'];
    //     $rok = $_POST["rok"];

    //     $sql = "SELECT * FROM egzaminy__EgzaminyUstalone WHERE przedmiot = '$p' AND sala = null";
    //     echo $sql;
    //     $result = $conn->query($sql);
    //     if ($result->num_rows == 0) {
    //         $sql = "INSERT INTO `egzaminy__EgzaminyUstalone`(`id`, `przedmiot`, `sala`, `osoby`, `rok`) 
    //                 VALUES (null, ?, null, null, ?)";
    //         $stmt = $conn->prepare($sql);
    //         if($stmt === false) {
    //             echo "Prepared statement creation failed: " . $conn->error;
    //             exit;
    //         }
    //         $stmt->bind_param('s', $p);
    //         $result = $stmt->execute();  
    //     }
    //     header("Location: ken_admin.php");
    // }



    if (isset($_POST['addKomisjaEgzamin'])) {
        include "connect.php";   
        $p = $_POST['EgzaminPrzedmiot'];
        $rok = $_POST["rok"];
    
        // Poprawione zapytanie SQL - użycie IS NULL zamiast = null
        $sql = "SELECT * FROM egzaminy__EgzaminyUstalone WHERE przedmiot = ? AND sala IS NULL";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Prepared statement creation failed: " . $conn->error;
            exit;
        }
    
        // Bindowanie parametrów (string 's' dla przedmiotu)
        $stmt->bind_param('s', $p);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Jeśli nie ma wyników, wstaw nowy egzamin
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO `egzaminy__EgzaminyUstalone`(`przedmiot`, `sala`, `osoby`, `rok`) 
                    VALUES (?, NULL, NULL, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo "Prepared statement creation failed: " . $conn->error;
                exit;
            }
    
            // Bindowanie parametrów (string 's' dla przedmiotu, int 'i' dla roku)
            $stmt->bind_param('si', $p, $rok);
            if (!$stmt->execute()) {
                echo "Query execution failed: " . $stmt->error;
                exit;
            }
        }
    
        // Zamknięcie połączenia i przekierowanie
        $stmt->close();
        $conn->close();
        header("Location: ken_admin.php");
        exit();
    }

    






    if (isset($_POST['submitNewPasswordAdmin'])) {
        include "connect.php";   
        $new_password1 = $_POST['new_password1'] ?? null;
        $new_password2 = $_POST['new_password2'] ?? null;
        $typ = $_SESSION["typ"] ?? null;        
        if ($new_password1 && $new_password2 && $typ) {
            // Sprawdź, czy hasła są zgodne
            if ($new_password1 === $new_password2) {                
                // Można dodać walidację hasła, np. długość, obecność cyfr, liter itp.                
                $hashed_password = password_hash($new_password1, PASSWORD_ARGON2I);                                    
                $update_sql = "UPDATE Passwords SET haslo = ? WHERE typKonta = ?";                
                $stmt = $conn->prepare($update_sql);
                echo 1;
                if($stmt === false) {
                    echo "Prepared statement creation failed: " . $conn->error;
                    exit;
                }
                echo 1;
                $stmt->bind_param("ss", $hashed_password, $typ);                
                if ($stmt->execute()) {                        
                    echo "Hasło zostało zaktualizowane.";
                    $_SESSION["changePass"] = true;
                    $_SESSION['correct'] = 'true';
                    header('Location: ken_admin.php');
                    exit(); // zakończ skrypt po przekierowaniu
                } else {
                    echo "Błąd aktualizacji hasła: " . $stmt->error;
                }                                      
            } else {
                echo "Hasła nie są zgodne.";
            }
        } else {
            echo "Nieprawidłowe dane wejściowe.";
        }      
    }
    

?>