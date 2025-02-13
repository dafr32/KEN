<?php
session_start();
if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
    header('Location: index.php');
}

$id = $_GET["id"];
$rok = $_SESSION['rok'];
$semestr = $_SESSION['semestr'];

require "connect.php";

$sql = "SELECT * FROM uczniowie WHERE id=$id";   
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "<div class='d-flex w-100 p-2 bg-info'>"
         ."<h3 class='text-black me-4'>".$row['nazwisko']." ".$row['imie'].":".$row['id']."</h3>
      </div>";


$sql1 = "SELECT * FROM przedmioty ORDER BY przedmiot";   
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) 
{        
    $nr=1;
    while($row1 = $result1->fetch_assoc()) 
    {        
        $id_przedm = $row1['id'];
        $przedm = $row1['przedmiot'];
        if ( $nr % 2 == 0)
           $bg = "#eee";
        else
           $bg = "#fff";
        echo "<div class='col-4'>
                <div class='card w-100 my-2' style='background-color:$bg'>";
                    echo "<h5 class='p-2 bg-dark text-info'>".$przedm."</h5>";                    
                    // nauczyciel 
                    $sql = "SELECT nauczyciele.imie, nauczyciele.nazwisko FROM nauczyciele INNER JOIN progress ON progress.id_nauczyciela=nauczyciele.id WHERE progress.id_ucznia=$id and progress.rok=$rok and progress.sem='$semestr' and progress.przedmiot=$id_przedm";
                    // echo $sql;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row2 = $result->fetch_assoc();
                        echo "<p class='belfer'>".$row2['imie']." ".$row2['nazwisko']."</p>";
                    }

                    $sql = "SELECT * FROM progress WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot='$id_przedm'";   
                    // echo $sql;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<p class='p-2'>Wystawiona ocena: <span class='text-danger fw-bold'>".$row['ocena']."</span></p>";             
                        if ($row['uzasadnienie'] != null){
                            echo "<p class='p-2 fst-italic uzasadnienie'>".$row['uzasadnienie']."</p>";
                        }
                    } 

                    $sql = "SELECT formy.nazwa FROM wystawione_formy INNER JOIN formy ON wystawione_formy.id_formy=formy.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                    // echo $sql;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<h6>Formy pracy z uczniem:</h6>";
                        echo "<ul>";
                        while($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['nazwa'] . "</li>"; 
                        }
                        echo "</ul>";
                    } 

                    $sql = "SELECT efekty.efekt FROM wystawione_efekty INNER JOIN efekty ON wystawione_efekty.id_efekt=efekty.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                    // echo $sql;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<h6>Pomoc przyniosła efekty w postaci:</h6>";
                        echo "<ul>";
                        while($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['efekt'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                        }
                        echo "</ul>";
                    } 

                    $sql = "SELECT ocena.nota FROM wystawione_wnioski INNER JOIN ocena ON wystawione_wnioski.id_oceny=ocena.id WHERE id_ucznia=$id and rok=$rok and sem='$semestr' and przedmiot=$id_przedm";   
                    // echo $sql;
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<h6>Wnioski:</h6>";
                        echo "<ul>";
                        while($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['nota'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                        }
                        echo "</ul>";
                    } 
        echo "</card></div></div>";
        $nr++;
    }
}

?>

