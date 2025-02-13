<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    }
    require "connect.php"; 
    $_SESSION['content-admin'] = "admin_Ustawienia.php";  
    $_SESSION['content-ustawienia'] = "adminUstawienia_Nauczyciele.php";          
?>
    

<style>
    .table>:not(caption)>*>* {
        padding: 2px 5px;
    }
</style>

<div class="wow fadeIn">
    <div class="container mt-4" style="max-width:1000px">        
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
                                echo "<td class='text-left $akt'> $b $a </td>";   
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
                <div class="sider">
                    <h2 class="mb-3"> Dodaj nauczyciela</h2>
                    <form action="save.php" method="POST" >
                        <div>
                            <input class="form-control text-left" type="text" name="nazwisko" size="35" placeholder="nazwisko..."  required>                        
                            <input class="form-control text-left my-2" type="text" name="imie" size="15" placeholder="imię..."  required>                    
                            <input class="form-control text-left " type="text" name="haslo" size="15" placeholder="hasło..."  required>                    
                        </div>                    
                        <div class="text-right ">
                            <button type="submit" name="add_Nauczyciel" class="btn btn-primary my-4 px-5">Dodaj</button>
                        </div>                    
                    </form>
                </div>
                <div class="sider mt-4">
                    <h2 class="mb-3"> Zmiana hasła<br /> Dyrektora</h2>
                    <form id="changePassword" action="save.php" method="POST" class="mt-3">                              
                        <div class="">                            
                            <input type="text" name="user" value="<?php echo $belfer_id ?>" hidden>
                            <input type="password" name="new_password1" placeholder="Nowe hasło" class="form-control text-left">
                        </div>
                        <div class="my-2">
                            <input type="password" name="new_password2" placeholder="Powtórz nowe hasło" class="form-control text-left">
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary btn-block" name="submitNewPasswordAdmin" type="submit" for="changePassword">Zmień hasło</button>                        
                        </div>
                    </form>   
                </div>
            </div>
        </div>            
    </div>
</div>




<script>
  function delUser(id, nazwa) { 
    const result = confirm("Czy chcesz skasować nauczyciela "+nazwa+" ?");
    if (result === true) {
      window.location.href = `save.php?del_Nauczyciel=${id}`;
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
        // console.log(id +"; active:" + act +"  pass="+pass );
        if (pass != null){
            window.location.href = `save.php?update_Nauczyciel=${id}&update_Active=${act}&update_Pass=${pass}`;    
        }else{
            window.location.href = `save.php?update_Nauczyciel=${id}&update_Active=${act}`;
        }
    } else {
        console.log("User clicked Cancel");
    }                       
  }
  
</script>
