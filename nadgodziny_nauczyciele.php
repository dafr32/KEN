<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        header('Location: index.php');
    }  
    require "connect.php";
    $_SESSION['content-admin'] = "nadgodziny_nauczyciele.php";  
    $userExist = "";
?>
  
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php"; ?>
    <title>Nauczyciele</title>
</head>

<?php   
    // GET 
    // GET - skasowanie nauczyciela
    if (isset($_GET["del_id"])) {            
        $G_sql="DELETE FROM `Nauczyciele` WHERE ID = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();
    
        $G_sql="DELETE FROM `godz_Nauczyciele_Godziny` WHERE ID = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();
        
        $G_sql="DELETE FROM `godz_Nauczyciele_Rozliczenie_Tydzien` WHERE ID = ?";
        $stmt = $conn->prepare($G_sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();

        unset($_GET["del_id"]);   
        header("Location: ken_admin.php");
    }

    // GET - aktualizacja nauczyciela
    if (isset($_GET["update_ID"])) { 
        if (isset($_GET["update_Pass"])){
            $hashed_password = password_hash($_GET["update_Pass"], PASSWORD_ARGON2I);
            $G_sql="UPDATE `Nauczyciele` SET `haslo`= ?,`first_login`= 1,`aktywne`= ? WHERE `ID`= ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("sii", $hashed_password, $_GET["update_Active"],$_GET["update_ID"] );
        }else{            
            $G_sql="UPDATE `Nauczyciele` SET `aktywne`= ? WHERE `ID`= ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("i", $_GET["update_ID"] );
        }
        $stmt->execute();        
        header("Location: ken_admin.php");
    }

    // GET - dodanie nauczyciela
    if (isset($_POST["add_User"])) {
        if (isset($_POST["nazwisko"]) && isset($_POST["imie"]) && isset($_POST["haslo"])){
            $nazw=$_POST["nazwisko"];
            $imie=$_POST["imie"];            
            $hashed_password = password_hash($_POST["haslo"], PASSWORD_ARGON2I);
            echo "$imie $nazw ". $_POST["haslo"] ;
            $G_sql = "SELECT * FROM Nauczyciele WHERE `Nazwisko` = ? AND `Imie` = ?";
            $stmt = $conn->prepare($G_sql);
            $stmt->bind_param("ss", $nazw, $imie);
            $stmt->execute(); 
            $resultG = $stmt->get_result(); 
            if ($resultG->num_rows > 0) {
                $userExist = "Nauczyciel już jest na liście";
            }else {
                $G_sql = "INSERT INTO `Nauczyciele`(`ID`, `Nazwisko`, `Imie`, `haslo`, `first_login`, `email`, `aktywne`) 
                          VALUES (null,?,?,?,1,'',1)";                          
                $stmt = $conn->prepare($G_sql);
                $stmt->bind_param("sss", $nazw, $imie,$hashed_password );
                $stmt->execute();
                header("Location: ken_admin.php");
            }
        }                
    }
    
?>

<div class="wow fadeIn">
    <div class="container mt-4">        
        <div class="row">
            <div class="col-sm-12 col-lg-8">
                <table class="table" style="width: fit-content;">
                <thead>
                    <tr>
                        <th>lp</th>
                        <th>Nazwisko i imię</th>
                        <th>Aktywny</th>
                        <th>Ustaw hasło</th>
                        <th>Zapisz</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                    $sqlN = "SELECT * FROM Nauczyciele ORDER BY aktywne DESC, Nazwisko, Imie";                    
                    $resultN = $conn->query($sqlN);                  
                    if ($resultN->num_rows > 0) {  
                        $lp = 1;                    
                        while($rowN = $resultN->fetch_assoc()){                      
                            $id_naucz = $rowN['ID'];
                            $a = $rowN["Imie"];
                            $b = $rowN["Nazwisko"];    
                            $akt = $rowN["aktywne"] ==  1  ? "": "text-gray";                  
                            echo "<tr><td>$lp</td>";                                                  
                            echo "<td class='$akt'> $b $a </td>";   
                            echo "<td class='text-center'><input id='aktywny_$id_naucz' class='form-check-input' type='checkbox' name='aktywny' " . ($rowN['aktywne'] == 1 ? 'checked' : '') . " /></td>";
                            echo "<td><input id='password_$id_naucz' type='text' name='password' class=''></td>";
                            echo "<td class='text-center text-grey'><i class='bi bi-save-fill text-grey' style='cursor:pointer; font-size:20px;' onclick='updateUser($id_naucz,\"$b\")'></i>";                      
                            echo "<td class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:20px;' onclick='delUser($id_naucz,\"$b\")'></i>";                      
                            echo "</td><tr>";
                            $lp++;
                        }   
                    }
                    ?>
                </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-lg-4">
                <h2 class="mb-3"> Dodaj nauczyciela</h2>
                <form action="nadgodziny_nauczyciele.php" method="POST" >
                    <div>
                        <input class="form-control text-left" type="text" name="nazwisko" size="35" placeholder="nazwisko..."  required>                        
                        <input class="form-control text-left my-2" type="text" name="imie" size="15" placeholder="imię..."  required>                    
                        <input class="form-control text-left " type="text" name="haslo" size="15" placeholder="hasło..."  required>                    
                    </div>                    
                    <div class="text-right ">
                        <button type="submit" name="add_User" class="btn btn-primary my-4 px-5">Dodaj</button>
                    </div>                    
                </form>
            </div>
        </div>            
    </div>
</div>




<script>
  function delUser(id, nazwa) { 
    const result = confirm("Czy chcesz skasować nauczyciela "+nazwa+" ?");
    if (result === true) {
      window.location.href = `nadgodziny_nauczyciele.php?del_id=${id}`;
    } else {
      console.log("User clicked Cancel");
    }                       
  }

  function updateUser(id, nazwa) { 
    const result = confirm("Czy chcesz zapisać zmiany dla nauczyciela "+nazwa+" ?");
    if (result === true) {
        const actID = document.getElementById("aktywny_" + id);
        var act = 0;
        const pass = document.getElementById("password_" + id).value;

        if (actID.checked)
            act = 1;        
        console.log(id +"; active:" + act +"  pass="+pass );
        if (pass != null){
            window.location.href = `nadgodziny_nauczyciele.php?update_ID=${id}&update_Active=${act}&update_Pass=${pass}`;    
        }else{
            window.location.href = `nadgodziny_nauczyciele.php?update_ID=${id}&update_Active=${act}`;
        }
    } else {
        console.log("User clicked Cancel");
    }                       
  }

  
</script>

</body>
</html>