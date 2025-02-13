<?php
session_start();
if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
    header('Location: index.php');
}
$id = $_GET["id"];
$rocznik = $_GET["rocznik"];
$rok = $_SESSION['rok'];
$kl = $_SESSION['klasa'];
$semestr = $_SESSION['semestr'];

require "connect.php";
echo "$id, $rocznik<br>";
if ($id==0){
    $sql = "SELECT * FROM uczniowie INNER JOIN uczniowie_do_oceny ON uczniowie.id=uczniowie_do_oceny.id_ucznia WHERE uczniowie.klasa='$kl' AND rocznik=$rocznik order by uczniowie.nazwisko";   
    $res = $conn->query($sql);
}else{
    $sql = "SELECT * FROM uczniowie WHERE id=$id";   
    $res = $conn->query($sql);
}
if ($res->num_rows > 0) {    
    while($w = $res->fetch_assoc())
    {
        $id = $w['id'];        
        echo "<table class='table table-bordered' id='wydruk'>
            <thead>
                <tr>
                    <th colspan='4'>
                        <h3 class='text-black'>".$w['nazwisko']." ".$w['imie']." - klasa ".$w['klasa']." <img id='print'src='images/print.svg'  onclick='printDiv()''></h3>
                        
                    </th>
                </tr>
                <tr class='bg-secondary'>
                    <th scope='col'>OCENA</th>
                    <th scope='col'>FORMY</th>
                    <th scope='col'>EFEKTY</th>  
                    <th scope='col'>WNIOSKI</th>
                </tr>
            </thead>";
        $result1=$conn->query("SELECT * FROM przedmioty ORDER BY przedmiot");           
        if ($result1->num_rows > 0) 
        {        
            $nr=1;
            while($row1 = $result1->fetch_assoc()) 
            {        
                $id_przedm = $row1['id'];
                $przedm = $row1['przedmiot'];
                // echo "$przedm <br>";
                echo "<tr class='table-primary'>                
                        <th colspan='4'>".$przedm;                    
                        // nauczyciel 
                        $sql = "SELECT nauczyciele.imie, nauczyciele.nazwisko FROM nauczyciele INNER JOIN progress ON progress.id_nauczyciela=nauczyciele.id WHERE progress.id_ucznia=$id and progress.rok=$rok and progress.sem='$semestr' and progress.przedmiot=$id_przedm";
                        // echo $sql;
                        $result2 = $conn->query($sql);
                        if ($result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            echo " - <span class='text-danger fw-medium'>".$row2['imie']." ".$row2['nazwisko']."</span>";
                        };
                    echo "</th>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>";
                            $sql = "SELECT * FROM progress WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot='$id_przedm'";   
                            // echo $sql;
                            $result3 = $conn->query($sql);
                            if ($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                echo $row3['ocena'];
                                if ($row3['uzasadnienie'] != null){
                                    echo "<p class='p-2 fst-italic uzasadnienie'>".$row3['uzasadnienie']."</p>";
                                }
                            } 
                    echo "</td>";
                    echo "<td>";
                        $sql = "SELECT formy.nazwa FROM wystawione_formy INNER JOIN formy ON wystawione_formy.id_formy=formy.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                        // echo $sql;
                        $result4 = $conn->query($sql);
                        if ($result4->num_rows > 0) {                        
                            echo "<ul>";
                            while($row4 = $result4->fetch_assoc()) {
                                echo "<li>" . $row4['nazwa'] . "</li>"; 
                            }
                            echo "</ul>";
                        } 
                    echo "</td>";
                    echo "<td>";
                        $sql = "SELECT efekty.efekt FROM wystawione_efekty INNER JOIN efekty ON wystawione_efekty.id_efekt=efekty.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                        // echo $sql;
                        $result5 = $conn->query($sql);
                        if ($result5->num_rows > 0) {                        
                            echo "<ul>";
                            while($row5 = $result5->fetch_assoc()) {
                                echo "<li>" . $row5['efekt'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                            }
                            echo "</ul>";
                        } 
                    echo "</td>";
                    echo "<td>";
                        $sql = "SELECT ocena.nota FROM wystawione_wnioski INNER JOIN ocena ON wystawione_wnioski.id_oceny=ocena.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                        // echo $sql;
                        $result6 = $conn->query($sql);
                        if ($result6->num_rows > 0) {
                            echo "<ul>";
                            while($row6 = $result6->fetch_assoc()) {
                                echo "<li>" . $row6['nota'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                            }
                            echo "</ul>";
                        } 
                    echo "</td>";
                echo "</tr>";                
            }
        }
        echo "</table>";
    }
}
?>

