<style>
    h5 { font-size: 1rem; color:#000; background: rgb(121 162 199);  }
    h5 span{ color:#fff}
    .table>:not(caption)>*>* {
        padding: 2px 5px; 
    }
</style>

<?php
   // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Raport Komisji Egzaminacyjnych
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    require "connect.php"; 

?>

<div class="mt-2 ms-2">
    <?php
    $sqlLista = "SELECT * FROM `egzaminy__EgzaminyUstalone`";
    $resultLista = $conn->query($sqlLista);        
    if ($resultLista->num_rows > 0) {
        echo '<div class="" style="max-width:800px">';
        while($rowLista = $resultLista->fetch_assoc()) {   
            $idEgzamin = $rowLista['id'] ?>
            
                <h5 class="p-2">
                    <?php 
                        echo $rowLista['przedmiot'] . "<span> sala:". $rowLista['sala'] ."</span>";
                    ?>
                </h5>
                <div id="czlonkowie" class="col bg-light">                          
                    <table id="komisjaTable" class="table table-bordered table-striped">
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
            
        <?php
        }
        echo "</div>";
    }
?>
</div>