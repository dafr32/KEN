
<?php   
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    require "connect.php";

    if(!isset($_SESSION["klasa"])) {
        $klasa = "all";
        $rocznik = $rokSzk;
    } else {
        $klasa = $_SESSION["klasa"]; 
        $rocznik = $_SESSION["rocznik"]; 
    }
        
    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];

    // roczniki klas 
    $year = date("Y");
    $month = date("n");
    $rok = 0;
    if($month < 9) $rok = 1;
    $rokcznik1 = $rokSzk - $rok;
    $rokcznik2 = $rokSzk - $rok - 1;
    $rokcznik3 = $rokSzk - $rok - 2;
    $rokcznik4 = $rokSzk - $rok - 3;    

    $_SESSION['content-admin'] = "efekt_Uczniowie.php";

    // GET 
    // GET - skasowanie ucznia
    if (isset($_GET["del_id"])) {    
        
        
        $sql = "DELETE FROM `efektywnosc__UczniowieEfekty` WHERE id_ucznia = ?";
        $stmt = $conn ->prepare($sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();

        $sql = "DELETE FROM `efektywnosc__UczniowieFormy` WHERE id_ucznia = ? ";
        $stmt = $conn ->prepare($sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();

        $sql = "DELETE FROM `efektywnosc__UczniowieOcena` WHERE id_ucznia = ?";
        $stmt = $conn ->prepare($sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();

        $sql = "DELETE FROM `efektywnosc__UczniowieWnioski` WHERE id_ucznia = ? ";
        $stmt = $conn ->prepare($sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();

        $G_sql="DELETE FROM `efektywnosc__Uczniowie` WHERE ID = ? ";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();
    
        unset($_GET["del_id"]);   
        header("Location: efekt_Pedagog.php");
    }
    
    // GET - dodanie ucznia
    if (isset($_GET["add_User"])) {
        if (isset($_GET["nazwisko"]) && isset($_GET["imie"]) && isset($_GET["klasa"])){
            $nazw=$_GET["nazwisko"];
            $imie=$_GET["imie"];            
            $klasa=$_GET["klasa"];            
            $rocznik=$_GET["rocznik"];                        
            $G_sql = "SELECT * FROM efektywnosc__Uczniowie WHERE nazwisko = ? AND imie = ? AND klasa = ? AND rocznik = ?" ;            
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("sssi", $nazw, $imie, $klasa, $rocznik);
            $stmt->execute(); 
            $resultG = $stmt->get_result(); 
            if ($resultG->num_rows > 0) {
                $userExist = "Uczeń już jest na liście";
            }else {
                $G_sql = "INSERT INTO `efektywnosc__Uczniowie`(`ID`, `nazwisko`, `imie`, `klasa`, `rocznik`) 
                          VALUES (null,?,?,?,?)";                          
                $stmt = $conn->prepare($G_sql);
                $stmt->bind_param("sssi", $nazw, $imie, $klasa, $rocznik );
                $stmt->execute();
                header("Location: efekt_Pedagog.php");
            }
        }                
    }
?>
<!-- efekt_Uczniowie.php -->
<div class="">
    <div class="container mt-4">                
        <div class="row">
            <div class="col-sm-12 col-lg-8">
                <h2 class="mb-5">
                    <?php 
                        if ($klasa != "all") echo "Klasa $klasa";
                        else echo "Wszyscy uczniowie";
                     ?> 
                </h2>
                <form action='savelist.php' method='POST'>
                    <table class="table" style="width: fit-content;">
                        <thead>
                            <tr>
                                <th>lp</th>
                                <th style="width:400px">Nazwisko i imię</th>
                                <th>Rocznik</th> 
                                <th>Klasa</th>   
                                <th>Opinia</th>
                                <th>Usuń</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                            if ($klasa == "all")
                                $sqlN = "SELECT * FROM efektywnosc__Uczniowie WHERE rocznik >= $rokcznik4 AND rocznik< $rokcznik1 
                                        ORDER BY rocznik DESC, klasa, nazwisko, imie";
                            else
                                $sqlN = "SELECT * FROM efektywnosc__Uczniowie WHERE efektywnosc__Uczniowie.rocznik = $rocznik AND efektywnosc__Uczniowie.klasa = '$klasa' 
                                        ORDER BY nazwisko, imie";
                            // echo $sqlN;
                            $resultN = $conn->query($sqlN);                  
                            if ($resultN->num_rows > 0) {  
                                $lp = 1;                               
                                while($rowN = $resultN->fetch_assoc()){                      
                                    $id_user = $rowN['ID'];                                                         
                                    $a = $rowN["imie"];
                                    $b = $rowN["nazwisko"]; 
                                    $rk = $rowN["rocznik"];   
                                    $kl = $rowN["klasa"];                                     
                                    echo "<tr>
                                            <td>
                                                $lp
                                                <input type='text' name='id_uczen$id_user' value='$id_user' hidden>
                                            </td>";                                                  
                                    echo "<td > $b $a </td>"; 
                                    echo "<td class='text-center'> $rk </td>"; 
                                    echo "<td class='text-center'>$kl</td>";
                                    // znajdż czy zaznaczony 
                                    $checked = "";
                                    $sqlS = "SELECT * FROM `efektywnosc__Uczniowie` INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
                                            WHERE efektywnosc__Uczniowie.ID = $id_user AND efektywnosc__UczniowieOpinia.rokSzk = $rokSzk AND efektywnosc__UczniowieOpinia.semestr = '$semestr';";
                                            //  echo $sqlS;
                                    $result = $conn->query($sqlS);
                                    if ($result && $result->num_rows > 0) {
                                        // Use a loop if there are multiple rows, but for simplicity, we'll use only the first row
                                        $rowS = $result->fetch_assoc();
                                        $checked = $rowS['id_ucznia'];       
                                    }
                                    echo "<td class='text-center'><input type='checkbox' name='wybrany$id_user' class='form-check-input' ";
                                        if ($checked != "") echo "checked='checked'";
                                    echo "></td>"; 
                                    echo "<td class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:20px;' onclick='delUser($id_user,\"$b\")'></i>";                                                  
                                    echo "</td><tr>";
                                    $lp++;
                                }                               
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="submit" name="zapiszWybranych" class="btn btn-primary">
                </form>
            </div>
            <div class="col-sm-12 col-lg-4">
                <h2 class="mb-3"> Dodaj ucznia</h2>
                <form action="efekt_Uczniowie.php" method="GET" >
                    <div>
                        <input class="form-control text-left" type="text" name="nazwisko" size="35" placeholder="nazwisko..."  required>                        
                        <input class="form-control text-left my-2" type="text" name="imie" size="15" placeholder="imię..."  required>                    
                        <div class="d-flex justify-content-between">
                            <input class="form-control text-left " type="text" name="rocznik" size="5" placeholder="rocznik..."  required>                    
                            <input class="form-control text-left " type="text" name="klasa" size="5" placeholder="klasa..."  required>                    
                        </div>
                    </div>                    
                    <div class="text-right ">
                        <button type="submit" name="add_User" class="btn btn-primary my-4 px-5">Dodaj</button>
                    </div>                    
                </form>

                <hr>
                <h3 class="mb-3">Import uczniów z pliku .csv</h3>
                <form action="savelist.php" method="POST" enctype="multipart/form-data">
                    <label for="csvFile">Select CSV File:</label>
                    <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                    <div class="text-right ">
                        <button type="submit" name="import_Users" class="btn btn-primary my-4 px-5">Import</button>
                    </div>
                </form>

            </div>
        </div>            
    </div>
</div>



<script>
  function delUser(id, nazwa) { 
    const result = confirm("Czy chcesz skasować ucznia "+nazwa+" ?");
    if (result === true) {
      window.location.href = `efekt_Uczniowie.php?del_id=${id}`;
    } else {
      console.log("User clicked Cancel");
    }                       
  }  
</script>
