<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Raport członków Komisji Egzaminacyjnych
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    include "head.php";
    require "connect.php"; 

    // Lista nauczycieli 
    $sql = "SELECT `ID`,`Nazwisko`,`Imie` FROM `Nauczyciele` ORDER BY `Nazwisko`, `Imie`;";
    $result = $conn->query($sql);
    $tab_nauczyciele = array(); 
    if ($result->num_rows > 0) {
        $lp = 1; // Inicjalizacja zmiennej licznika
        while($row = $result->fetch_assoc()) {
            $row['lp'] = $lp; // Dodanie kolumny "lp" z numerem wiersza
            $tab_nauczyciele[] = $row;
            $lp++; // Zwiększenie licznika o 1
        }
    }    
?>
<style>
    table {font-size:0.9rem}
    #TableTeacherBody h4 { background-color: #27d0ff9c; border-bottom: 1px solid #ff000036; padding: 4px; }
    #TableTeacherBody > div { padding: 3px; }   
    .fr1 { width: 20%}
    .fr2 { width: 40%}
</style>

<div class="container" style="max-width: 1000px">        
<h2 class="text-center my-5">Lista nauczycieli i komisji egzaminacyjnej</h2>
        <div id="TableTeacherBody" style="max-height: calc(100vh - 355px); overflow: auto;">      
            <?php 
            $i = 1;
            foreach ($tab_nauczyciele as $nauczyciel): 
                echo "<h4 class='mt-2'>".$nauczyciel['Nazwisko']." ".$nauczyciel['Imie']."</h4>";
                $sql ="SELECT nazwisko, imie, data, sala, egzaminy__Terminy.godz, egzaminy__EgzaminyUstalone.przedmiot, egzaminy__Role.id as r, egzaminy__Role.rola FROM `egzaminy__Komisje` 
                    INNER JOIN egzaminy__EgzaminyUstalone ON egzaminy__Komisje.idEgzaminu=egzaminy__EgzaminyUstalone.id 
                    INNER JOIN Nauczyciele ON egzaminy__Komisje.idNauczyciela=Nauczyciele.ID 
                    INNER JOIN egzaminy__Terminy ON egzaminy__EgzaminyUstalone.przedmiot=egzaminy__Terminy.przedmiot 
                    INNER JOIN egzaminy__Role ON egzaminy__Komisje.rola=egzaminy__Role.id 
                    WHERE egzaminy__Komisje.idNauczyciela=" . $nauczyciel['ID'] ." ORDER BY data";
                $result = $conn->query($sql);  
                if ($result->num_rows > 0) {
                    while( $row = $result->fetch_assoc()){
                        echo "<div class='d-flex'>";
                            echo "<div class='fr1 '>".$row['data']."</div>";
                            echo "<div class='fr2 text-left'>".$row['przedmiot']."</div>";
                            echo "<div class='fr1 '>".$row['rola']."</div>";                           
                            $r = $row['r'];
                            if ( $r == 1 || $r == 2 || $r == 5) {
                                echo "<div class='fr1 '>sala: ".$row['sala']."</div>";     
                                echo "<div class='fr1 '>godz: ";                               
                                echo ($row['godz'] == 1) ? "9:00" : "14.00";
                                echo "</div>";  
                            } elseif ( $r == 3 || $r == 4 || $r == 6 || $r == 7 ) {
                                echo "<div class='fr1 '></div>";
                                echo "<div class='fr1 '>godz: ";   
                                echo ($row['godz'] == 1) ? "9:00" : "14.00";   
                                echo "</div>";                              
                            }else  {
                                echo "<div class='fr1 '></div>";
                                echo "<div class='fr1 '></div>";
                            }
                        echo "</div>";
                    }
                }
                $i++;                
            endforeach; 
            ?>
        </div>
        
</div>