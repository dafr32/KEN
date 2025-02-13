<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        header('Location: index.php');
        exit;
    }
    require "connect.php";   
    include "include/nadgodziny_Functions.php"; 
    $rokSzk = $_SESSION['rokSzk']; 
    $semestr = $_SESSION['semestr'];
    $miesiac =  $_SESSION['miesiac'];
    $ileTygKl4 =  $_SESSION['ileTygKl4'];    

    $_SESSION['content-admin'] = "admin_Nadgodziny.php";    
    $_SESSION['content-nadgodziny'] = "nadgodziny_analiza.php";   
    
     // Odczytanie tygodni rozliczeniowych z ustawień okresu
     $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";                                        
     $resTygodnie = $conn->query($sql); 
     if ($resTygodnie->num_rows > 0) {  
         $ileTyg = $resTygodnie->num_rows ;
         echo "<script>
                var ileTygOkres = $ileTyg;   
               </script>";
     }
?>


<div class="wow fadeIn">
    <h1 class="my-4 title">Miesiąc rozliczeniowy : <span> <?php echo $miesiac ?> </h1>


    <?php
        $s1 = "SELECT sum(`razem_nadgodz`) as nad, sum(`razem_dorazne`) as dor, sum(`razem_indyw`) as ind, sum(`razem_inne`) as inne FROM `godz_Nauczyciele_Rozliczenie_Tydzien` WHERE `miesiac`='$miesiac' AND `rokSzk`=$rokSzk;";
        $r1  = $conn->query($s1);  
        if ($r1->num_rows > 0) 
            $row1 = $r1->fetch_assoc();
    ?>   
    <div class="container3">

        
        <div class="grid-container3 stick bg-light-gray">
                <div class="grid-item stick">lp</div>
                <div class="grid-item stick">Nauczyciel</div>
                <div class="grid-item stick">Ponadw</div>
                <div class="grid-item stick">Zast</div>
                <div class="grid-item stick">Indyw</div>
                <div class="grid-item stick">Inne</div>
                <div class="grid-item stick">Do odrobienia</div>
                <div class="grid-item stick">Dotychczas<br>odrobione</div>
                <div class="grid-item stick">Pozostało <br>do odronienia</div>
                <div class="grid-item stick">Odrobione <br> w tym okresie</div>            
                <div class="grid-item1 stick">Do<br>wypłaty</div>
                <div class="grid-item1 stick"></div>
        </div>
        
        <div class="accordion accordion-flush" id="accordionGodzinyAnaliza">
            <?php
            $sql = "SELECT 
                        Nauczyciele.ID,
                        Nauczyciele.Nazwisko,
                        Nauczyciele.Imie,
                        godz_Nauczyciele_Rozliczenie_Tydzien.miesiac,
                        SUM(godz_Nauczyciele_Rozliczenie_Tydzien.razem_nadgodz) AS suma_razem_nadgodz,
                        SUM(godz_Nauczyciele_Rozliczenie_Tydzien.razem_dorazne) AS suma_razem_dorazne,
                        SUM(godz_Nauczyciele_Rozliczenie_Tydzien.razem_indyw) AS suma_razem_indyw,
                        SUM(godz_Nauczyciele_Rozliczenie_Tydzien.razem_inne) AS suma_razem_inne
                    FROM 
                        godz_Nauczyciele_Rozliczenie_Tydzien
                    RIGHT JOIN Nauczyciele ON godz_Nauczyciele_Rozliczenie_Tydzien.id_nauczyciel = Nauczyciele.ID
                    WHERE 
                        Nauczyciele.aktywne = 1 AND godz_Nauczyciele_Rozliczenie_Tydzien.miesiac = '$miesiac' AND godz_Nauczyciele_Rozliczenie_Tydzien.rokSzk = $rokSzk
                    GROUP BY 
                        Nauczyciele.Nazwisko, Nauczyciele.Imie, Nauczyciele.ID;";
            // echo $sql;
            $result = $conn->query($sql); 
            if ($result->num_rows > 0) { 
                $ileWypelnionych =  $result->num_rows;
                $ileN=0;
                while($row = $result->fetch_assoc()) {  
                    $teacher_id = $row["ID"];                             
                    $ileN++;
                    // --------------------------------------                         
                    // Odczyt ustalonych godzin z okresu rozliczeniowego 
                    $sql2 = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk AND `miesiac`= '$miesiac'";                
                    $result2 = $conn->query($sql2); 
                    if ($result2->num_rows == 0) {  
                        //jeśli nie ma zapisu z aktualnego okresu to pobierz ostatni wpis
                        $sql2 = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk ORDER BY `ID` DESC LIMIT 1";             
                        $result2 = $conn->query($sql2);  
                        if ($result2->num_rows == 0)   $setGodziny = FALSE;
                        else $setGodziny = TRUE;
                    } else
                        $setGodziny = TRUE;     

                    if ($setGodziny){
                        $row2 = $result2->fetch_assoc();                
                        $d1 = $row2["PN"];$d2 = $row2["WT"];$d3 = $row2["SR"];$d4 = $row2["CZ"];$d5 = $row2["PT"];$kl4 = $row2["kl4"];$etat = $row2["etat"];
                    } else {
                        $d1 = 0;$d2 = 0; $d3 = 0;$d4 = 0;$d5 = 0;$kl4 = 0; $etat = 0;  
                    }
                    $totalSum = $d1+$d2+$d3+$d4+$d5;
                    $godzinyBezKlas4 = $totalSum - $kl4;
                                                                
                    if ($kl4 > 0)
                        if ($godzinyBezKlas4 >= $etat)
                            $doOdrobienia = 0;
                        else
                            $doOdrobienia = (($etat - $godzinyBezKlas4) * $ileTygKl4);                
                    else 
                        $doOdrobienia = 0;  

                        // var godzinyBezKlas4 = totalSum - kl4;    
                        // if (godzinyBezKlas4 >= etat)
                        //     x = 0;
                        // else
                        //     x =  ((etat - godzinyBezKlas4) * ileTyg); 


                    // --------------------------------------                 
                    // odczyt zapisanych odpracowanych z aktualnego miesiąca
                    $s = "SELECT * FROM `godz_Nauczyciele_klasy4` WHERE `rokSzk`=$rokSzk AND `miesiac`='$miesiac' AND `id_Nauczyciela`= $teacher_id;";
                    $res = $conn->query($s);             
                    $odrobione=0;                                 
                    if ($res->num_rows > 0) {
                        $ro = $res->fetch_assoc();                                    
                        $odrobione=$ro["odpracowane"];
                    } 
                    // -------------------------------------- 
                    // odczyt dotychczas odpracowanych  
                    $s = "SELECT SUM(`odpracowane`) as suma FROM `godz_Nauczyciele_klasy4` 
                        INNER JOIN `Miesiace` ON `godz_Nauczyciele_klasy4`.`miesiac` = `Miesiace`.`miesiac` 
                        WHERE `godz_Nauczyciele_klasy4`.`id_Nauczyciela` = $teacher_id AND `godz_Nauczyciele_klasy4`.`rokSzk` = $rokSzk 
                        AND `Miesiace`.`nr` < (SELECT `nr` FROM `Miesiace` WHERE `miesiac` = '$miesiac');";
                    // $s = "SELECT SUM(`odpracowane`) as suma FROM `godz_Nauczyciele_klasy4` WHERE `id_Nauczyciela` = $teacher_id AND `rokSzk`= $rokSzk AND `id` < (SELECT `id` FROM `godz_Nauczyciele_klasy4` WHERE `rokSzk` = $rokSzk AND `miesiac` = '$miesiac' AND `id_Nauczyciela`= $teacher_id);";                        
                    // echo $s;
                    $dotychczasOdpracowane = 0;
                    $res = $conn->query($s);
                    if ($res->num_rows > 0){
                        $ro = $res->fetch_assoc();       
                        $dotychczasOdpracowane =  $ro["suma"];                 
                    }         
                    
                    $pozostalo = $doOdrobienia -($dotychczasOdpracowane + $odrobione);
                    $nadg = $row["suma_razem_nadgodz"];
                    if ($nadg < 0 ) $nadg = 0;
                    $dor = $row["suma_razem_dorazne"];
                    $indyw = $row["suma_razem_indyw"];
                    $inne = $row["suma_razem_inne"];
                    $razem = $nadg + $dor + $indyw + $inne - $odrobione; 
                    ?>
                            
                    <div class="accordion-item elementyAccordion">
                        <h2 class="accordion-header">
                            <?php 
                            
                                if( $ileN % 2 == 0 )
                                    $bg_accord = "#374042";
                                else
                                    $bg_accord = "#4a4a4a";                            
                            ?>
                            <button class="accordion-button collapsed" style="background-color:<?php echo $bg_accord ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $teacher_id ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $teacher_id ?>">                                                            
                                <div class="grid-container4"> 
                                    <div class="grid-item "><?php echo $ileN ?></div>                                   
                                    <div class="grid-item text-left ps-1"><?php echo $row["Nazwisko"]." ".$row["Imie"] ?></div>
                                    <div class="grid-item text-blue"><?php echo $nadg ?></div>
                                    <div class="grid-item"><?php echo $dor ?></div>
                                    <div class="grid-item"><?php echo $indyw ?></div>
                                    <div class="grid-item"><?php echo $inne ?></div>
                                    <div class="grid-item bg-gray <?php echo (($doOdrobienia > 0) ? "text-red" : "") ?> "><?php echo $doOdrobienia ?> </div>
                                    <div class="grid-item bg-gray"><?php echo $dotychczasOdpracowane ?> </div>
                                    <div class="grid-item bg-gray <?php echo (($pozostalo > 0) ? "text-green" : "") ?>"><?php echo $pozostalo ?></div>      
                                    <div class="grid-item">
                                        <input type="number" min="0" max="30" id="odrobione" name="odrobione" class="odrobione" value="<?php echo $odrobione; ?>">
                                    </div>                                
                                    <div class="grid-item bold bg-warning py-2 text-red"><?php echo $razem ?></div>                            
                                    <div class="grid-item">
                                        <i class="far fa-floppy-disk save" id="<?php echo $teacher_id ?>" ></i>
                                    </div>                            
                                </div>
                            </button>
                        </h2>
                        <div id="flush-collapse<?php echo $teacher_id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionGodzinyAnaliza">
                            <div class="accordion-body">
                                <?php                            
                                    // include "nadgodziny_User_tydzien.php";                                     
                                    include "nadgodziny_Nauczyciel_Form.php";
                                ?>
                            </div>
                        </div>
                    </div>

                <?php
                }
            } ?>
        </div>
    </div>
</div>         
<?php
// Pozostali co nie wypełnili
$sql = "SELECT 
            Nauczyciele.ID,
            Nauczyciele.Nazwisko, 
            Nauczyciele.Imie, 
            Kwerenda1.ID_rozliczenia
        FROM 
            (SELECT * 
            FROM godz_Nauczyciele_Rozliczenie_Tydzien 
            WHERE miesiac = '$miesiac' AND rokSzk = $rokSzk) as Kwerenda1
        RIGHT JOIN Nauczyciele ON Kwerenda1.id_nauczyciel = Nauczyciele.ID
        WHERE 
            Kwerenda1.ID_rozliczenia IS NULL AND Nauczyciele.aktywne = 1;";

$result = $conn->query($sql); 
if ($result->num_rows > 0) {  
    while($row = $result->fetch_assoc()) {   
        $kl = "pusty";                  
        $sql2 ="SELECT `ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`+ `WT`+ `SR`+ `CZ`+ `PT` as suma, `kl4`, `etat` FROM `godz_Nauczyciele_Godziny` WHERE `rokSzk`= $rokSzk AND `ID_Nauczyciela`=". $row["ID"];
        $result2 = $conn->query($sql2); 
        if ($result2->num_rows > 0 ) { 
            $row2 = $result2->fetch_assoc();
            if ($row2["suma"]>$row2["etat"] )
                $kl .= " brak";                        
        }                    
        ?>  
        <div class="grid-container4 <?php echo $kl ?>" style=" width: calc( 100% - 20px);">                                    
            <div class="grid-item"></div>    
            <div class="grid-item text-left teacher ps-1"><?php echo $row["Nazwisko"]." ".$row["Imie"] ?></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>      
            <div class="grid-item"></div>                            
            <div class="grid-item"></div>                            
        </div>
    <?php
    }
}

?>    


<script src="js/calculateSum.js"></script>

<script>
    function getTextAfterText(element, searchText) {
        const text = element.textContent;
        const index = text.indexOf(searchText);
        if (index !== -1) {
            return text.slice(index + searchText.length);
        }
        return null;
    }

    document.querySelectorAll('.save').forEach(function(icon) {
    icon.addEventListener('click', function() {
        var iconId = this.id;
        var inputElement = this.parentElement.parentElement.querySelector('.odrobione');
        if(inputElement) {
            var inputValue = inputElement.value;
            window.location.href = `ken_admin.php?odrobione=${inputValue}&id=${iconId}`;
            // console.log(inputValue+"id:"+iconId);
        } else {
            // console.log('Nie znaleziono elementu input');
        }
        });
    });

    
    var accordion = document.getElementById("accordionGodzinyAnaliza");
    var elements = accordion.getElementsByTagName("form");
    var ileTygOkres = <?php echo $_SESSION["ileTygodni"] ?>;      
    for (var i = 0; i < elements.length; i++) {
        var id = elements[i].id;        
        // Sprawdź, czy id zawiera słowo "alama"
        if (id.includes("TeacherNadgodziny-ID")) {
        // Wyodrębnij numer po słowie "alama"
        var number = id.replace("TeacherNadgodziny-ID", "");
        // Wypisz numer                
        
        calculateSum(number);
        }
    }

</script>