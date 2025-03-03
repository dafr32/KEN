<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Raport członków Komisji Egzaminacyjnych
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    include "head.php";
    require "connect.php"; 

    // Lista nauczycieli 
    $sql = "SELECT Nauczyciele.`ID`, Nauczyciele.`Nazwisko`, Nauczyciele.`Imie` FROM `Nauczyciele` INNER JOIN egzaminy__Komisje ON Nauczyciele.ID = egzaminy__Komisje.idNauczyciela WHERE egzaminy__Komisje.rok = ". $_SESSION['egzaminy-rok']." ORDER BY `Nazwisko`, `Imie`;";
    // $sql = "SELECT `ID`,`Nazwisko`,`Imie` FROM `Nauczyciele` ORDER BY `Nazwisko`, `Imie`;";
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
   .table-header, #TableNauczHeader > div { font-weight: 600; text-align:center; padding: 8px 0;}   
   .rola {   border-left: 1px solid #ccc;}
   
   .table-row.row1 { background-color: #eee }
   .table-row.row2 { background-color: #fff }
   
   .nazwisko { padding-left: 8px;text-align: left; font-weight: 500; cursor:pointer;}
   
   #TableNauczHeader { background: #0d6efd; color: #fff }
   #EgzaminyGrid div {padding: 8px 3px}
   div.table-cell, #TableTeacherBody > div { border-bottom: 1px solid #666; padding: 3px; text-align: center}
   div.table-cell.th { font-weight: 500; text-align:left}   
   .selected-row td, .selected-row div  { background-color: #c87b8e !important; }   
   .selected-row .nazwisko { color: #fff }
   

   #komisjaTable .header th { background: #ffc000;}
   #egzamin { font-weight: 600}
   .form-check .form-check-label { padding-left:5px }
   
   .diagonal-text {            
        transform: rotate(-45deg);
        white-space: nowrap;
        display: inline-block;
        height: 100px;
        bottom: -23px;
        left: 15px;
        position: relative;        
    }


</style>

<div class="container" style="">
        <?php 
        $sql12 = "SELECT * FROM `egzaminy__Role` ";
        $res12 = $conn->query($sql12);        
        if ($res12->num_rows > 0) {    
            $ileRol = $res12->num_rows; 
            $ileRol = 8;
            $proc = 65 / $ileRol;
            $tabRole = array();
            ?>
            <h2 class="text-left my-1">Przydziały <?php echo $_SESSION['egzaminy-rok'] ?></h2>
            <div id="TableNauczHeader" class="border-bottom mt-3" style="width: calc(100% - 15px); display: grid; grid-template-columns: 5% 30% repeat(<?php echo "$ileRol, $proc"; ?>%);">

                <div class="pt-5">lp</div>
                <div class="pt-5">Nazwisko i imię</div>
                <?php
                while($row12 = $res12->fetch_assoc()){
                    echo "<div class='diagonal-text'>".$row12['rola']."</div>";    
                    $rola = $row12['rola'];
                    $tabRole[$rola] = 0;
                }
                echo "<div class='pt-5'>Razem</div>";
            echo "</div>";
        } ?>
        
        <div id="TableTeacherBody" style="max-height: calc(100vh - 400px); overflow: auto;">      
            <?php 
            $i = 1;
            foreach ($tab_nauczyciele as $nauczyciel): 
                foreach ($tabRole as $item => $liczbaWystapien):
                    $tabRole[$item] = 0;
                endforeach;
                $razem = 0;                
                $sql13 = "SELECT Nauczyciele.nazwisko, egzaminy__Role.rola as nameRola, egzaminy__Komisje.rola, COUNT(*) AS liczba_wystapien FROM egzaminy__Komisje INNER JOIN Nauczyciele ON egzaminy__Komisje.idNauczyciela = Nauczyciele.ID INNER JOIN egzaminy__Role ON egzaminy__Komisje.rola = egzaminy__Role.id 
                        WHERE idNauczyciela = ".$nauczyciel['ID']." and egzaminy__Komisje.rok = ". $_SESSION['egzaminy-rok'] ." GROUP BY egzaminy__Komisje.rola;";
                $res13 = $conn->query($sql13);        
                if ($res13->num_rows > 0) {                    
                    
                    while($row13 = $res13->fetch_assoc()){                                        
                        $nameRola = $row13['nameRola'];
                        $liczbaWystapien = $row13['liczba_wystapien'];                                    
                        $tabRole[$nameRola] = $liczbaWystapien;
                        $razem += $liczbaWystapien;
                    }
                }
                if ($i === 1) $cl = "row1"; else $cl = "row2";
            ?>
            <div class="table-row <?php echo $cl ?>" data-id="<?php echo $nauczyciel['ID']; ?>" style="display: grid; grid-template-columns: 5% 30% repeat(<?php echo "$ileRol, $proc"; ?>%); cursor: pointer;">
                <div><?php echo $nauczyciel['lp']; ?></div>
                <div class="nazwisko"><?php echo $nauczyciel['Nazwisko'] ." ".$nauczyciel['Imie']; ?></div>
                <?php
                foreach ($tabRole as $nameRola => $liczbaWystapien) :
                    echo "<div class='rola'>";
                    echo ($liczbaWystapien > 0)?$liczbaWystapien: ""; 
                    echo "</div>";
                endforeach;   
                echo "<div class='bold bg-warning text-dark'>";
                echo ($razem > 0 ) ? $razem:"";
                echo "</div>";
                ?>                                
            </div>
            <?php 
            $i++;
            if($i === 3) $i = 1;
            endforeach; 
            ?>
        </div>
        
</div>