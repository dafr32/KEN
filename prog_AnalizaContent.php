
<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || ($_SESSION["typ"]!="Pedagog" && $_SESSION["typ"]!="Dyrektor")){
        header('Location: index.php');
    }
    require "connect.php";
    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];

    $id = $_GET['id'];
    $imie = $_GET['imie'];
    $nazw = $_GET['nazw'];
?>


<div class="prog_Analiza" id='wydruk'>    
    <?php
    if($nazw==="all")
        $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE rokSzk = $rokSzk AND semestr = $semestr GROUP BY id_Nauczyciela";
    else
        $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE id_Nauczyciela = $id AND rokSzk = $rokSzk AND semestr = $semestr GROUP BY id_Nauczyciela" ;
    
    $resultUser = $conn->query($sql);

    if ($resultUser->num_rows > 0) {            
        while($rowUser = $resultUser->fetch_assoc()) {
            echo "<div class='page'>";
                $id = $rowUser['id_Nauczyciela'];
                $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE id_Nauczyciela = $id AND rokSzk = $rokSzk AND semestr = $semestr";
                $result = $conn->query($sql);
                $sqlB = "SELECT Nazwisko, Imie FROM Nauczyciele INNER JOIN prog_PrzedmiotyN WHERE Nauczyciele.ID = $id";
                $resultB = $conn->query($sqlB);
                $rowB = $resultB->fetch_assoc();
                echo "<div class='title'> <h3 class='w=100'>". $rowB["Nazwisko"]. " " . $rowB["Imie"] . " <img id='print'src='images/print.svg'  onclick='printDiv()''> </h3> </div>";
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {  
                        
                        $result2 = $conn->query("SELECT * FROM `Przedmioty` WHERE ID = ".$row['id_Przedmiotu']);
                        $rowP = $result2->fetch_assoc();
                        $idP = $rowP['ID'];
                        $przedm = $rowP['przedmiot'];
                        echo "<div class='headerTable'> 
                                <h3 > $przedm </h3> 
                            </div>";
                            ?>
                        <div class="">
                            <table id="<?php echo "table" ?>" class="table table-striped table-bordered mt-4">
                                <thead>
                                    <tr class="text-center">
                                        <th class="col">lp</th>
                                        <th class="col" style="min-width: 90px">Klasa<br>(klasa - grupa)</th>
                                        <th class="col">liczba godzin zrealizowanych</th>
                                        <th class="col">Podstawę programową zrealizowałem(am) zgodnie z przyjętym planem pracy dydaktycznej</th>
                                        <th class="col">Do realizacji w nastepnym roku szkolnym/semestrze pozostało (podać dział lub niezrealizowaną partię materiału)</th>            
                                    </tr>
                                </thead>                    
                                <tbody  id="tableBody">  
                                    <?php                                                  
                                        $sql = "SELECT * FROM prog_Realizacja WHERE rokSzk = $rokSzk AND semestr = $semestr AND id_nauczyciela = $id AND przedmiot = $idP ORDER BY klasa";                        
                                        $result2 = $conn->query($sql);   
                                        $i = 1;                                             
                                        while($row2 = $result2->fetch_assoc()){ 
                                            $idClass = $row2['id']; ?>                                
                                            <tr>
                                                <td><?php echo $i ?></td>                                
                                                <td class="text-center"><?php echo $row2['klasa'] ?></td>                                
                                                <td class="text-center"><?php echo $row2['godz'] ?></td>                                                                
                                                <?php $check = ($row2['zrealizowany'] == 1) ? "tak" : "nie"; ?>
                                                <td class="text-center" style="width: 250px"> <?php echo $check ?></td>                                                                
                                                <td class="text-center"><?php echo $row2['uzasadnienie'] ?></td>                    
                                            </tr>
                                            <?php
                                            $i++; 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    }
                }
            echo "</div>";
        }
    }
    ?>

</div>

<script>
  $(document).ready(function() {   
      console.log("pass");  
      document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }); 
</script>