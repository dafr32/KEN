<style>

</style>

<?php
   // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Raport Sale Egzaminacyjne
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    require "connect.php"; 

    $rok = $_SESSION['egzaminy-rok'];
?>

<style>
    .legenda span {font-weight: 600}
</style>

<div class="mt-2" style="max-width:800px; margin-left:auto; margin-right:auto">
    <?php
    $sqlLista = "SELECT * FROM `egzaminy__EgzaminyUstalone` 
                INNER JOIN egzaminy__Terminy ON egzaminy__EgzaminyUstalone.przedmiot = egzaminy__Terminy.przedmiot 
                WHERE sala != 'NULL' AND egzaminy__Terminy.rok = ". $_SESSION['egzaminy-rok']."
                ORDER BY data , `sala` ASC";
    // echo $sqlLista;
    $resultLista = $conn->query($sqlLista);        
    if ($resultLista->num_rows > 0) {
        echo '<div class="" style="max-width:800px">';
        while($rowLista = $resultLista->fetch_assoc()) {               
            $idEgzamin = $rowLista['id'];
            $przedmiot = $rowLista['przedmiot'];
            $data = $rowLista['data'];
            $sala = ltrim($rowLista['sala']);             
            $godz = ($rowLista['godz'] == 1 ) ? "9:00":"14:00";
            ?>            
            <div style="max-width: 1000px; padding:10px;">
                <header class="bg-light p-2">
                    <div class="small">IV LO im KEN w Bielsku-Białej</div>
                    <h1 class="text-center">Egzamin maturalny</h1>
                    <div class="d-flex my-3">
                        <div class="legenda me-5">data: <span><?php echo $data ?></span></div>
                        <div class="legenda">godzina: <span><?php echo $godz ?></span></div> 
                    </div>
                    <div class="d-flex justify-content-between">
                        <h2 class='text-center'><?php echo $przedmiot ?></h2>
                        <div class="legenda">sala:<span><?php echo $sala ?></span> 
                </header>
                <main> 
                <?php
                $sqlU = "SELECT eu.`Nazwisko`,  eu.`Imiona`, eu.`Kod zdającego` as kod,  eu.`Nr sali` as sala
                        FROM `egzaminy__EgzaminyUstalone` ee
                        JOIN `egzaminy__Uczniowie` eu ON REPLACE(REPLACE(eu.`Egzamin`, '(M)', ''), '(E)', '') = ee.`przedmiot`
                        WHERE ee.`przedmiot` = '$przedmiot' AND ee.rok = $rok AND TRIM(eu.`Nr sali`) = '$sala' GROUP BY eu.`Kod zdającego`; ";
                // echo $sqlU;
                $resultU = $conn->query($sqlU);        
                if ($resultU->num_rows > 0) { ?>
                    <table class="table">
                        <thead>
                            <tr>
                            <th>lp</th>
                            <th>Nazwisko i imię<th>
                            <th>Kod</th>
                            <th>sala</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    $lp=1;
                    while($rowU = $resultU->fetch_assoc()) {  
                        $kod = $rowU['kod']; 
                        echo "<tr>"; 
                            echo "<td>$lp</td>";
                            echo "<td>". $rowU['Nazwisko'] . "</td>";
                            echo "<td>". $rowU['Imiona'] . "</td>";
                            echo "<td>". $rowU['kod'] . "</td>";
                            echo "<td>". $rowU['sala'] . "</td>";
                        echo "</tr>";
                        $lp++; 
                    }
                    echo "</tbody>";
                } ?>
                 </table>
                </main>
            </div>
        <?php
        }
    }?>