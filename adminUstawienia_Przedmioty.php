<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    }
    require "connect.php"; 
    $_SESSION['content-admin'] = "admin_Ustawienia.php";  
    $_SESSION['content-ustawienia'] = "adminUstawienia_Przedmioty.php";          
?>
<style>
    .table>:not(caption)>*>* {
        padding: 2px 5px;
    }
</style>

<div class="wow fadeIn" >
    <div class="container mt-4" style="max-width: 1000px;">        
        <div class="row">
            <div class="col-sm-12 col-lg-8">
                <table class="table" style="width: fit-content;">
                <thead>
                    <tr>
                        <th>lp</th>
                        <th>Przedmiot</th>                        
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody id="listaPrzedmiotow">
                    <?php  
                    $sqlN = "SELECT * FROM Przedmioty ORDER BY przedmiot ";                    
                    $resultN = $conn->query($sqlN);                  
                    if ($resultN->num_rows > 0) {  
                        $lp = 1;                    
                        while($rowN = $resultN->fetch_assoc()){                      
                            $id = $rowN['ID'];
                            $nazwa = $rowN["przedmiot"];
                            echo "<tr><td>$lp</td>";                                                  
                            echo "<td class='text-left'> $nazwa </td>";   
                            echo "<td class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:18px;' id='$id' data-name='$nazwa' ></i>";                      
                            echo "</td><tr>";
                            $lp++;
                        }   
                    }
                    ?>
                </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-lg-4">
                <h2 class="mb-3"> Dodaj przedmiot</h2>
                <form action="save.php" method="POST" id="FormAdd">
                    <div>
                        <input class="form-control text-left" type="text" id="nazwaPrzedmiotu" name="nazwaPrzedmiotu" size="35" placeholder="język polski..."  required>                                                
                    </div>                    
                    <div class="text-right ">
                        <button name="add_Przedmiot" type="submit" class="btn btn-primary my-4 px-5">Dodaj</button>
                    </div>                    
                </div>
            </div>
        </div>            
    </div>
</div>

<script>

$(document).ready(function() {
    //skasowanie przedmiotu
    $('#listaPrzedmiotow td i').on("click", function() {
        var idP = $(this).attr("id");
        var nazwaP = $(this).attr("data-name");   

        const result = confirm("Czy chcesz skasować przedmiot " + nazwaP + " ?");
        if (result === true) {
            window.location.href = `save.php?del_Przedmiot=${idP}`;
        } else {
            console.log("User clicked Cancel");
        }        
    });
});
  
</script>
