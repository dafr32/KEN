<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Układanie Komisji Egzaminacyjnych
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    require "connect.php"; 
    
    $_SESSION['content-admin'] = "admin_Egzaminy.php";

    // Lista wszystkich egzaminów i sal
    $sqlLista = "SELECT REPLACE(REPLACE(`Egzamin`, '(M)', ''), '(E)', '') AS przedmiot, `Nr sali` AS sala
                FROM `egzaminy__Uczniowie`
                GROUP BY przedmiot, `sala`
                ORDER BY przedmiot;";
    $resultLista = $conn->query($sqlLista);        
    if ($resultLista->num_rows > 0) {                
        while($rowLista = $resultLista->fetch_assoc()) {   
            if (strpos($rowLista['przedmiot'], "ustny") !== false) continue;            
             
            $sqlEgzamin = "SELECT * FROM `egzaminy__EgzaminyUstalone` WHERE `przedmiot` = '". $rowLista['przedmiot'] ."' AND sala = '".$rowLista['sala']."'";                                                
            $resultEgzamin = $conn->query($sqlEgzamin);  

            // jeśli nie ma egzaminu to dopisz       
            if ($resultEgzamin->num_rows == 0) {                
                // odczytaj ilość uczniów
                $sql = "SELECT count(*) as ile FROM `egzaminy__Uczniowie` WHERE `Egzamin` like '".$rowLista['przedmiot']."%' AND `Nr sali`='".$rowLista['sala']."'";                            
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $ileUczniow = $row['ile'];
                
                //dodaj egzamin
                $sql = "INSERT INTO `egzaminy__EgzaminyUstalone`(`id`, `przedmiot`, `sala`, `osoby`) VALUES (null, ?, ?, ?)";                
                $stmt = $conn->prepare($sql);
                
                $stmt->bind_param('ssi', $rowLista['przedmiot'], $rowLista['sala'] , $ileUczniow);
                $result = $stmt->execute();     
            }                         
        }
    }
    
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

    
    
    $idEgzamin = null;

    // dodaj członka komisji 
    if (isset($_GET['addTeacher'])) {
        $idE = $_GET['egzamin'];
        $idTeacher = $_GET['addTeacher'];
        $rola = $_GET['rola'];
        $sql ="SELECT * FROM `egzaminy__Komisje` WHERE `idNauczyciela`= $idTeacher AND `idEgzaminu`=$idE";        
        $result = $conn->query($sql);        
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO `egzaminy__Komisje`(`id`, `idEgzaminu`, `idNauczyciela`, `rola`) VALUES (null,?,?,?)";
            $stmt = $conn->prepare($sql);
            if($stmt === false) {
                echo "Prepared statement creation failed: " . $conn->error;
                exit;
            }
            $stmt->bind_param('iii',$idE ,$idTeacher , $rola);
            $result = $stmt->execute();   
        }
    }

    if (isset($_GET['delTeacher'])) {
        $idE = $_GET['delE'];
        $idN = $_GET['delTeacher'];
        $sql = "DELETE FROM `egzaminy__Komisje` WHERE `idEgzaminu`= $idE AND `idNauczyciela`= $idN";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin_Egzaminy_Komisje.php?egzamin=$idE");  
        } else {
            echo "Błąd podczas usuwania członka komisji: " . $conn->error;
        }
    }

    if (isset($_GET['egzamin'])) {        
        $idEgzamin = $_GET['egzamin'];                                   
    }

    $_SESSION['content-admin'] = "admin_Egzaminy.php";
    $_SESSION['egzaminy-content'] = "admin_Egzaminy_Komisje.php";

?>


<style>
   table {font-size:0.9rem}
   .table-header, #TableNauczHeader > div { font-weight: 600; text-align:center; padding: 8px 0;}   
   .rola {   border-left: 1px solid #ccc;}
   
   .table-row.row1 { background-color: #eee }
   .table-row.row2 { background-color: #fff }
   
   .nazwisko { padding-left: 8px;text-align: left; font-weight: 500; cursor:pointer;}
   #EgzaminyGrid { background: #0d6efd; color: #fff }
   #EgzaminyGrid div {padding: 8px 3px}
   div.table-cell, #TableTeacherBody > div { border-bottom: 1px solid #666; padding: 3px; text-align: center}
   div.table-cell.th { font-weight: 500; text-align:left}   
   .selected-row td, .selected-row div  { background-color: #c87b8e !important; }   
   .selected-row .nazwisko { color: #fff }
   
   .table>:not(caption)>*>* { padding: 3px 5px }

   #addKomisja option, #addKomisja select { font-size: 0.9rem}

   #komisjaTable .header th { background: #ffc000;}
   #egzamin { font-weight: 600}
   .form-check .form-check-label { padding-left:5px }
   
   .diagonal-text {            
        transform: rotate(-45deg);
        white-space: nowrap;
        display: inline-block;
        height: 100px;
        bottom: -29px;
        left: 6px;
        position: relative;        
    }


</style>


<div class="container p-3">
    <div class=row>    
        <div class="col-8">
            <h2 class="mb-3">Komisje egzaminacyjne </h2>
            <div class="table-responsive">
                <div id="EgzaminyGrid" class="border-bottom" style="width: calc(100% - 15px); display: grid; grid-template-columns: 15% 10% 45% repeat(3, 10%);">                    
                    <div class="table-header">Data</div>
                    <div class="table-header">Godzina</div>
                    <div class="table-header">Egzamin</div>
                    <div class="table-header">Ilość osób</div>
                    <div class="table-header">Sala</div>                    
                    <div class="table-header">Komisja</div>
                </div>
                <div id="TableEgzamin" style="height: 600px; overflow: auto;">    
                    <?php
                    $sqlT = "SELECT *, egzaminy__EgzaminyUstalone.id AS idE 
                            FROM egzaminy__Terminy 
                            INNER JOIN egzaminy__EgzaminyUstalone ON egzaminy__Terminy.przedmiot = egzaminy__EgzaminyUstalone.przedmiot 
                            LEFT JOIN (
                                SELECT idEgzaminu, COUNT(*) AS komisje_count 
                                FROM egzaminy__Komisje 
                                GROUP BY idEgzaminu
                            ) AS komisje ON egzaminy__EgzaminyUstalone.id = komisje.idEgzaminu 
                            ORDER BY egzaminy__Terminy.data, egzaminy__Terminy.przedmiot, egzaminy__EgzaminyUstalone.osoby DESC, egzaminy__EgzaminyUstalone.sala";
                    // echo $sqlT;
                    $resultT = $conn->query($sqlT);
                    if ($resultT->num_rows > 0) { 
                        $i=1;
                        $oldEgzamin = "";
                        $cl = "row1";
                        while($rowT = $resultT->fetch_assoc()) { 
                            $data = date("d-m-Y", strtotime($rowT["data"]));
 
                            if ($oldEgzamin != $rowT["przedmiot"]) {                                
                                if ($cl === "row1") $cl = "row2"; else $cl = "row1";
                            }
                                                            
                                echo "<div class='table-row " . $cl . ($idEgzamin && $idEgzamin === $rowT['id'] ? " selected-row" : "") . "' id='E".$rowT['id']  ."' data-id='" . $rowT['id'] . "'
                                     style='display: grid; cursor: pointer; grid-template-columns: 15% 10% 45% repeat(3, 10%);'>";
                                    echo "<div class='table-cell th>";                                                                   
                                    echo "<div class='table-cell'>$data</div>";                                                                      
                                    echo "<div class='table-cell'>";
                                        echo ($rowT["godz"] == 1) ? "9:00": "14:00";
                                    echo "</div>";
                                    echo "<div class='table-cell text-left'>". $rowT["przedmiot"]."</div>";  
                                    echo "<div class='table-cell'>".$rowT["osoby"]."</div>";
                                    echo "<div class='table-cell'>".$rowT["sala"]."</div>";                                    
                                    echo "<div class='table-cell'>".$rowT['komisje_count']."</div>";
                                echo "</div>";
                            $i++;
                            $oldEgzamin = $rowT["przedmiot"];
                            if($i === 3) $i = 1;
                        }
                    } else {
                        echo "<div colspan='6' style='grid-column: span 6;'>Brak egzaminów</div>";
                    }
                    ?>
                </div>

            </div>    
        </div>
        <div class="col-4 d-flex flex-column">     
            <!-- tabela - lista członków  -->            
            <div id="czlonkowie" class="bg-light py-3 px-1 mb-auto">                                          
                <h2 class="mb-3">Komisja</h2>
                <table id="komisjaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="header">
                            <th>Nauczyciel</th>
                            <th>funkcja</th>
                            <th>Usuń</th>
                        </tr>
                    </thead>
                    <tbody>                                          
                        <?php
                        if ($idEgzamin) {
                            $sqlK = "SELECT ek.*, n.Imie, n.Nazwisko, er.rola AS nazwa_roli
                                    FROM `egzaminy__Komisje` AS ek
                                    INNER JOIN `Nauczyciele` AS n ON ek.`idNauczyciela` = n.`ID`
                                    INNER JOIN `egzaminy__Role` AS er ON ek.`rola` = er.`id`
                                    WHERE ek.`idEgzaminu` = $idEgzamin ORDER BY er.id;";                                
                            // echo $sqlK;
                            $resultK = $conn->query($sqlK);        
                            if ($resultK->num_rows > 0) {
                                while($rowK = $resultK->fetch_assoc()){ 
                                    $idTeacher = $rowK['idNauczyciela'];
                                    echo "<tr>
                                            <td>{$rowK['Nazwisko']} {$rowK['Imie']}</td>
                                            <td>{$rowK['nazwa_roli']}</td>";
                                            echo "<td class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:15px;' onclick='delTeacher( $idEgzamin , $idTeacher)'></i></td>";
                                    echo "</tr>";                                    
                                }                                       
                            } 
                        }
                        ?>
                    </tbody>
                </table>
                <button class="btn btn-primary" onclick="openModal()">Dodaj nauczyciela</button> 
            </div>            
            
            <!-- form dodaj egzamin  -->
            <div id="addKomisja" class="bg-light py-4 px-2 ">
                <h2 class="mb-3" style="font-size:1.6rem">Dodaj egzamin</h2>
                <form action="save.php" method="POST">
                    <?php
                    $sqlNE = "SELECT przedmiot FROM egzaminy__Terminy ORDER BY przedmiot ";
                    $resultNE = $conn->query($sqlNE);
                    if ($resultNE->num_rows > 0) {
                        echo '<select name="EgzaminPrzedmiot" class="form-select" require>';                                               
                        echo '<option value="" disabled selected>Wybierz przedmiot...</option>';                
                            while($rowNE = $resultNE->fetch_assoc()){
                                echo "<option value='{$rowNE['przedmiot']}'>{$rowNE['przedmiot']}</option>";
                            }
                        echo "</select>";
                    }
                    ?>
                    <button class="btn btn-primary mt-3" name="addKomisjaEgzamin" type="submit" >Dodaj komisję</button>
                </form>
            </div>
        </div>
    </div>
</div>
        

<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        margin:auto;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 100%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<section>
    <div id="myModal" class="modal">
        <div class="modal-content" style="max-width: 1400px">
            <div class="row">
                <div class="col-9">
                    <?php 
                    $sql12 = "SELECT * FROM `egzaminy__Role` ";
                    $res12 = $conn->query($sql12);        
                    if ($res12->num_rows > 0) {    
                        $ileRol = $res12->num_rows; 
                        $ileRol = 8;
                        $proc = 65 / $ileRol;
                        $tabRole = array();
                        ?>
                        <div id="TableNauczHeader" class="border-bottom bg-dark text-light mt-3" style="width: calc(100% - 15px); display: grid; grid-template-columns: 5% 30% repeat(<?php echo "$ileRol, $proc"; ?>%);">

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
                        
                        <div id="TableTeacherBody" style="height: 600px; overflow: auto;">      
                            <?php 
                            $i = 1;
                            foreach ($tab_nauczyciele as $nauczyciel): 
                                foreach ($tabRole as $item => $liczbaWystapien):
                                    $tabRole[$item] = 0;
                                endforeach;
                                $razem = 0;                
                                $sql13 = "SELECT Nauczyciele.nazwisko, egzaminy__Role.rola as nameRola, egzaminy__Komisje.rola, COUNT(*) AS liczba_wystapien FROM egzaminy__Komisje INNER JOIN Nauczyciele ON egzaminy__Komisje.idNauczyciela = Nauczyciele.ID INNER JOIN egzaminy__Role ON egzaminy__Komisje.rola = egzaminy__Role.id 
                                        WHERE idNauczyciela = ".$nauczyciel['ID']." GROUP BY egzaminy__Komisje.rola;";
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
                                echo "<div class='bold bg-info text-white'>";
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
                <div class="col-3">

                    <h2 class="mb-3">Komisja</h2>
                    <div id="czlonkowie" class="col bg-light">                          
                        <table id="komisjaTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nauczyciel</th>
                                    <th>funkcja</th>                                    
                                </tr>
                            </thead>
                            <tbody>                                          
                                <?php
                                if ($idEgzamin) {
                                    $sqlK = "SELECT ek.*, n.Imie, n.Nazwisko, er.rola AS nazwa_roli
                                            FROM `egzaminy__Komisje` AS ek
                                            INNER JOIN `Nauczyciele` AS n ON ek.`idNauczyciela` = n.`ID`
                                            INNER JOIN `egzaminy__Role` AS er ON ek.`rola` = er.`id`
                                            WHERE ek.`idEgzaminu` = $idEgzamin;";    
                                    // echo $sqlK;
                                    $resultK = $conn->query($sqlK);        
                                    if ($resultK->num_rows > 0) {
                                        while($rowK = $resultK->fetch_assoc()){ 
                                            $idTeacher = $rowK['idNauczyciela'];
                                            echo "<tr>
                                                    <td>{$rowK['Nazwisko']} {$rowK['Imie']}</td>
                                                    <td>{$rowK['nazwa_roli']}</td>";                                                    
                                            echo "</tr>";                                    
                                        }                                       
                                    } 
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <fieldset id="rola" class="p-2 mt-4 bg-info-subtle" >
                        <legend style="font-size: 1rem; font-weight:600">Rola członka komisji:</legend>
                        <?php
                        $sqlRola = "SELECT * FROM `egzaminy__Role`";
                        $resultRola = $conn->query($sqlRola);        
                        if ($resultRola->num_rows > 0) {
                            while($rowRola = $resultRola->fetch_assoc()){ ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="<?php echo 'rola'.$rowRola['id'] ?>" value="<?php echo $rowRola['id'] ?>" name="typ">
                                    <label class="form-check-label" for="<?php echo 'rola'.$rowRola['id'] ?>"><?php echo $rowRola['rola'] ?></label>
                                </div>
                            <?php
                            }
                        }
                        ?>
                                                        
                    </fieldset>
                    <div class="d-flex justify-content-end mt-2">
                            <button id="addTeacher" class="btn btn-primary me-2" onclick="dodajCzlonka(<?php echo $idEgzamin ?> )">Dodaj członka</button>
                            <button type="button" class="btn btn-primary" onclick="closeModal()">Anuluj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    function openModal() {    
        var modal = document.getElementById("myModal");
        modal.style.display = "block";                
    }

    function closeModal() {    
        var modal = document.getElementById("myModal");
        modal.style.display = "none";                
    }



    // odczytaj rolę zaznaczonego Nauczyciela
    var radios = document.querySelectorAll('input[type="radio"][name="typ"]');    
    function getSelectedValue() {
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                return radios[i].value;
            }
        }
    }


    // odczytaj ID zaznaczonego Nauczyciela
    var teachers = document.querySelectorAll('#TableTeacherBody .table-row');    
    function getSelectedTeacherId() {
        for (var i = 0; i < teachers.length; i++) {
            if (teachers[i].classList.contains('selected-row')) {
                return teachers[i].getAttribute('data-id');
            }
        }
    }

    // odczytaj ID zaznaczonego Egzaminu
    var egzamin = document.querySelectorAll('#TableEgzamin .table-row');    
    function getSelectedEgazminId() {
        for (var i = 0; i < egzamin.length; i++) {
            if (egzamin[i].classList.contains('selected-row')) {
                console.log(egzamin[i].getAttribute('data-id'));
                return egzamin[i].getAttribute('data-id');
            }
        }
    }


    //wybranie egzaminu
    var tableRowsEgzamin = document.querySelectorAll('#TableEgzamin .table-row');
    tableRowsEgzamin.forEach(function(row) {
        row.addEventListener('click', function() {            
            var idE = row.getAttribute('data-id');         
            console.log("id:"+idE);
            $.ajax({
                url: `admin_Egzaminy_Komisje.php?egzamin=${idE}#E${idE}`,                
                type: "GET", // Typ żądania            
                success: function(response) {
                    $("#egzaminy_content").html(response); 
                }
            });   
        });
    });
    

    //wybranie nauczyciela
    var tableRowsTeacher = document.querySelectorAll(' .table-row');
    tableRowsTeacher.forEach(function(row) {
        row.addEventListener('click', function() {
            tableRowsTeacher.forEach(function(row) {
                row.classList.remove('selected-row');
            });
            row.classList.add('selected-row');
            var id = row.getAttribute('data-id');
            // console.log('Wybrany nauczyciel:', id);
        });
    });


    function dodajCzlonka(idE) {            
        var rola = getSelectedValue();        
        var teacher = getSelectedTeacherId();
        console.log(rola+teacher);
        if (rola && teacher) {                        
            $.ajax({
                url: `admin_Egzaminy_Komisje.php?egzamin=${idE}&addTeacher=${teacher}&rola=${rola}#E${idE}`,
                type: "GET", // Typ żądania            
                success: function(response) {
                    $("#egzaminy_content").html(response); 
                }
            });   
        }
    }


    function delTeacher(idE, idN, e) { 
        const result = confirm("Czy chcesz skasować członka?");
        if (result === true) {            
            $.ajax({
                url: `admin_Egzaminy_Komisje.php??egzamin=${e}&delTeacher=${idN}&delE=${idE}`,
                type: "GET", // Typ żądania            
                success: function(response) {
                    $("#egzaminy_content").html(response); 
                }
            }); 
        } else {
            console.log("User clicked Cancel");
        }                       
    }

    
    // Function to scroll to a specific table row by its ID
    function scrollToRow(rowId) {
        var element = document.getElementById(rowId);
        if(element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            console.log('Row with ID ' + rowId + ' not found.');
        }
    }    
</script>
<?php     
    echo "<script> scrollToRow('E' + $idEgzamin); </script>";
?>


