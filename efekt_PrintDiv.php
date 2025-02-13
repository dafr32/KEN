<style>
    #wydruk thead th, td {
        padding: 10px;
        border: 0;
    }
    #wydruk thead h3 span {
        color: #ec3f79;
        text-transform: uppercase;
    }
    
    #wydruk thead .header {
        background: #aaa;
    }

    #wydruk tbody th, td {
        padding: 3px;
        border: 0;
    }

    #wydruk ul {    
        padding-left: 1rem;
        margin-bottom: 0 !important;
    }

    .title * {
        padding: 0;
        margin: 0;
        text-align: center;
    }
</style>


<?php   
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || ($_SESSION["typ"]!="Pedagog" && $_SESSION["typ"]!="Dyrektor")){
        header('Location: index.php');
    }
    require "connect.php";
    $_SESSION['content-admin'] = "admin_Efektywnosc.php";  
    
    $id = $_GET["id"];
    $semestr = $_GET["semestr"];
    $klasa = $_GET["klasa"];
    $rocznik = $_GET["rocznik"];
    
    $rokSzk = $_SESSION['rokSzk'];
    $semestrN = ($_SESSION['semestr'] == 1) ? "pierwszy" : "drugi";
    
    echo "<div class='title' id='wait'>proszę czekać</div>";    
      
    if ( $klasa == 'all'){    
        // lista wszyscy w szkole     
        // $sql = "SELECT * FROM `efektywnosc__Uczniowie` INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
        //         WHERE efektywnosc__Uczniowie.rocznik >= ". ($rocznik - 4) ." AND efektywnosc__Uczniowie.rocznik <= $rocznik AND  efektywnosc__UczniowieOpinia.rokSzk = $rokSzk AND efektywnosc__UczniowieOpinia.semestr = $semestr
        //         ORDER BY efektywnosc__Uczniowie.rocznik DESC, efektywnosc__Uczniowie.klasa, nazwisko, imie;";                                                        
        $sql = "SELECT * FROM `efektywnosc__Uczniowie`
                INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia
                WHERE efektywnosc__UczniowieOpinia.rokSzk = $rokSzk";  

    } elseif ($id == 0) { 
        // lista cała klasa 
        $sql = "SELECT * FROM `efektywnosc__Uczniowie` INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
        WHERE efektywnosc__Uczniowie.klasa = '$klasa' AND efektywnosc__Uczniowie.rocznik = $rocznik AND  efektywnosc__UczniowieOpinia.rokSzk=$rokSzk"; 
    }else{
        // lista dla ucznia 
        $sql = "SELECT * FROM `efektywnosc__Uczniowie`
                INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia                
                WHERE `id_ucznia`=$id AND `rokSzk`=$rokSzk";                                                
        
        // $sql = "SELECT * FROM `efektywnosc__Uczniowie` INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
        //         WHERE efektywnosc__Uczniowie.ID = $id AND efektywnosc__UczniowieOpinia.rokSzk = $rokSzk AND efektywnosc__UczniowieOpinia.semestr = $semestr;";
       
    }        

    // echo $sql;
        
    $resultUser = $conn->query($sql);

    if ($resultUser->num_rows > 0) {    
        echo "<script>document.getElementById('wait').style.display = 'none';</script>";
        echo "<div class='title'>
                <h2 class='w=100'>Ocena efektywności</h2>
                <h4>rok szk.$rokSzk/".($rokSzk+1).", semestr: $semestrN</h4>
              </div>";
        while($rowUser = $resultUser->fetch_assoc()) {
            $id = $rowUser['ID'];     
            $kl = $rowUser['klasa'];
            $rocznik = $rowUser['rocznik'];
            // roczniki klas 
            $Y = date("Y");
            $M = date("n");            
            if($M < 9) 
                $rocznik1 = ($Y - $rocznik) . $kl;
            else
                $rocznik1 = ($Y - 1 - $rocznik) . $kl;             
            echo "<table class=' ' id='wydruk'>
                <thead>
                    <tr>
                        <th colspan='4'>
                            <h3 class='bold'><span>".$rowUser['nazwisko']." ".$rowUser['imie']."</span> - klasa $rocznik1  <img id='print'src='images/print.svg'  onclick='printDiv()''></h3>                            
                        </th>
                    </tr>
                    <tr class='header'>
                        <th scope='col'>OCENA</th>
                        <th scope='col'>FORMY</th>
                        <th scope='col'>EFEKTY</th>  
                        <th scope='col'>WNIOSKI</th>
                    </tr>
                </thead>";
            $result1=$conn->query("SELECT * FROM Przedmioty ORDER BY przedmiot");           
            if ($result1->num_rows > 0) {        
                $nr=1;
                while($row1 = $result1->fetch_assoc()) {        
                    $id_przedm = $row1['ID'];
                    $przedm = $row1['przedmiot'];
                    ?>
                        <tr class='table-primary'>                
                            <th colspan='4' class="bold border-bottom">
                                <!-- przedmiot i nauczyciel  -->
                                <?php 
                                echo $przedm;
                                $sql = "SELECT * FROM ((`efektywnosc__UczniowieEfekty` INNER JOIN efektywnosc__UczniowieFormy ON efektywnosc__UczniowieEfekty.id_ucznia = efektywnosc__UczniowieFormy.id_ucznia) 
                                        INNER JOIN Nauczyciele ON efektywnosc__UczniowieEfekty.id_nauczyciela = Nauczyciele.ID )
                                        WHERE efektywnosc__UczniowieEfekty.id_ucznia = $id AND efektywnosc__UczniowieEfekty.rokSzk = $rokSzk AND efektywnosc__UczniowieEfekty.semestr = $semestr AND efektywnosc__UczniowieEfekty.przedmiot = $id_przedm";
                                // echo $sql;
                                $res = $conn->query($sql);
                                if ($res->num_rows > 0) {
                                    $row2 = $res->fetch_assoc();
                                    echo " - <span class='text-danger fw-medium'>". $row2['Imie']." ".$row2['Nazwisko']." </span>";
                                }?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <!-- Ocena  -->
                                <?php 
                                $sql = "SELECT * FROM `efektywnosc__UczniowieOcena` WHERE id_ucznia = $id AND rokSzk = $rokSzk AND semestr = $semestr AND przedmiot = $id_przedm;";
                                // echo $sql;
                                $res = $conn->query($sql);
                                if ($res->num_rows > 0) {
                                    $row3 = $res->fetch_assoc();
                                    echo "<span class='text-danger fw-medium'>". $row3['ocena'] ."</span> <br />";
                                    echo $row3['uzasadnienie'];
                                }?>                                                                   
                            </td>
                            <td>
                                <!-- Formy  -->
                                <?php
                                $sql = "SELECT * FROM `efektywnosc__UczniowieFormy` INNER JOIN `efektywnosc__ListaFormy` ON `efektywnosc__UczniowieFormy`.id_formy = `efektywnosc__ListaFormy`.id WHERE id_ucznia = $id AND rokSzk = $rokSzk AND semestr = $semestr AND przedmiot = $id_przedm;";
                                // echo $sql;
                                $res = $conn->query($sql);
                                if ($res->num_rows > 0) {                        
                                    echo "<ul>";
                                    while($row4 = $res->fetch_assoc()) {
                                        echo "<li>" . $row4['element'] . "</li>"; 
                                    }
                                    echo "</ul>";
                                } ?> 
                            </td>
                            <td>
                                <!-- Efekty  -->
                                <?php
                                $sql = "SELECT * FROM `efektywnosc__UczniowieEfekty` INNER JOIN `efektywnosc__ListaEfekty` ON `efektywnosc__UczniowieEfekty`.id_efekt = `efektywnosc__ListaEfekty`.id WHERE id_ucznia = $id AND rokSzk = $rokSzk AND semestr = $semestr AND przedmiot = $id_przedm;";
                                // echo $sql;
                                $res = $conn->query($sql);
                                if ($res->num_rows > 0) {                        
                                    echo "<ul>";
                                    while($row5 = $res->fetch_assoc()) {
                                        echo "<li>" . $row5['element'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                                    }
                                    echo "</ul>";
                                } ?>
                            </td>
                            <td>
                                <!-- Wnioski  -->
                                <?php
                                $sql = "SELECT * FROM `efektywnosc__UczniowieWnioski` INNER JOIN `efektywnosc__ListaWnioski` ON `efektywnosc__UczniowieWnioski`.id_wniosek = `efektywnosc__ListaWnioski`.id WHERE id_ucznia = $id AND rokSzk = $rokSzk AND semestr = $semestr AND przedmiot = $id_przedm;";
                                // echo $sql;
                                $res = $conn->query($sql);
                                if ($res->num_rows > 0) {
                                    echo "<ul>";
                                    while($row6 = $res->fetch_assoc()) {
                                        echo "<li>" . $row6['element'] . "</li>"; // Wygenerowanie elementu listy z nazwiskiem
                                    }
                                    echo "</ul>";
                                } ?>
                            </td>
                        </tr>
                    <?php
                    }
                }
            echo "</table>";
        }
    }
?>

<script>
    $(document).ready(function() {               
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }); 
</script>