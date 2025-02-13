<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    }  

    require "connect.php";
    
    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    
    // Odczyt miesiąca rozliczeniowego 
    $sql = "SELECT * FROM RokSettings";
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {        
      $row = $result->fetch_assoc();            
      $setMies = $row["miesiacRozliczeniowy"];
      $miesiac = $row["miesiacRozliczeniowy"];
      $setTygodnieKl4 = $row["ileTygodni"];     //ile tygodni do odpracowania
      $rokSzk = $row["rokSzk"];
      $semestr = $row["semestr"];            
    }else {            
      $rokSzk = 0;
      $semestr = 0;
      $setTygodnieKl4 = 0;
      $setMies = "wrzesień";
    }

    $_SESSION['ileTygKl4'] = $row["ileTygodni"];
    $_SESSION['rokSzk'] = $rokSzk; 
    $_SESSION['semestr'] = $semestr; 
    $_SESSION['miesiac'] = $setMies;  
    $_SESSION["filePHP"] = "ken_admin"; 
   

    // GET - zapisanie zmian godzin odpracowanych 
    if (isset($_GET["odrobione"]) && isset($_GET["id"])){
      $GET_odrobione = $_GET['odrobione'];
      $GET_id = $_GET['id'];
      unset($_GET["odrobione"]);      
      unset($_GET["id"]); 
      $G_sql="SELECT * FROM `godz_Nauczyciele_klasy4` WHERE `id_Nauczyciela`= $GET_id AND `rokSzk`= $rokSzk AND `miesiac`='$setMies';";
      $resultG = $conn->query($G_sql); 
      if ($resultG->num_rows > 0) {  
        $G_sql = "UPDATE `godz_Nauczyciele_klasy4` SET `odpracowane`= $GET_odrobione WHERE `id_Nauczyciela`= $GET_id AND `rokSzk`= $rokSzk AND `miesiac`='$setMies';";
        // echo $G_sql; 
        $conn->query($G_sql);
      }else {
        $G_sql="INSERT INTO `godz_Nauczyciele_klasy4`(`id`, `id_Nauczyciela`, `miesiac`, `rokSzk`, `odpracowane`) VALUES 
        (null,$GET_id,'$setMies', $rokSzk, $GET_odrobione )";
        $conn->query($G_sql);
      }
      // header("Location: ken_admin.php");
    }
?>

<div id="AdminHeader">
    <!-- Nadgodziny  -->  
    <section class="container-fluid bg-body-secondary" id="section1" >        
      <div class="container py-3">
        <div class="row py-2">
          <div class="col-sm-12 col-xl-7 p-1 ">
              <h1><?php echo $belfer; ?></h1>
              <form action="save.php" method="POST" >
                <div class="mt-3">
                  <div class="d-flex">
                    <div class="d-flex flex-column me-3">
                      <label class="small mb-1">ROK SZKOLNY</label>
                      <div class="d-flex" >
                          <input type="text" class="form-control" name="rok" id="rok" size='4' value="<?php echo $rokSzk; ?>" onchange="updateRok2()"> 
                          <span style="font-size: 25px">/</span> 
                          <input type="text" class="form-control bg-1" name="rok2" id="rok2" size='4' value="<?php echo $rokSzk + 1;?>" disabled readonly>
                      </div>
                      <label class="small mb-1 mt-4" for="ileTygodni">Ilość tygodni do odrobienia: </label>
                    </div>
                    <div class="d-flex flex-column me-3">
                      <label class="small mb-1">SEMESTR</label> 
                      <select name="sem" class="form-select">
                        <option value="1" <?php if ($semestr == 1) echo 'selected'; ?>>pierwszy</option>
                        <option value="2" <?php if ($semestr == 2) echo 'selected'; ?>>drugi</option>                      
                      </select> 
                      <input type="number" class="form-control mt-3 mx-auto" name="ileTygodni" id="ileTygodni" value="<?php echo $setTygodnieKl4;?>">
                    </div>   
                    <div class="d-flex flex-column me-3">   
                      <label class="small mb-1">Miesiąc</label>     
                      <input type="text"  class="form-control bg-1 bold" readonly value="<?php echo $setMies ?>">
                      <button type="submit" name="submitRok" id="submitRok" class="btn btn-danger px-3 mt-auto">Zapisz/Zmień</button>
                    </div>
                  </div>                  
                </div>                  
              </form>
          </div>
          
          <div class="col-sm-12 col-xl-5 text-center side-menu bg-2" id="side-menu">
              <h1 class="title mb-3">NADGODZINY</h1>
              <div class="d-flex justify-content-center py-3">
                <button class="btn btn-warning mx-3" id="analiza">Rozliczenia nauczyceli</button>      
                <button class="btn btn-dark" id="okres">Okres rozliczeniowy</button>
              </div>
          </div>

        </div>
      </div>
    </section>
   
</div>

  <div id="AdminBody">
    <div class="container mt-3 text-center" id="contentContainer" style="position: relative";>         
      <?php  
           if (!isset($_SESSION['content-nadgodziny'])) $_SESSION['content-nadgodziny'] = "nadgodziny_analiza.php" ;                    
           include $_SESSION['content-nadgodziny']; 
      ?>
    </div>
  </div>



<script>

    $(document).ready(function() {  
      $("#side-menu button").on("click", function() {
        $("#side-menu button").removeClass("btn-warning").addClass("btn-dark");
        $(this).removeClass("btn-dark").addClass("btn-warning");   
        var id_file = $(this).attr("id");           
        $.ajax({
            url: "nadgodziny_"+id_file+".php",
            type: "GET", // Typ żądania            
            success: function(response) {
                $("#contentContainer").html(response); 
            }
        });            
      });
    });


  function updateRok2() {
    var rokValue = document.getElementById("rok").value;
    var rok2Field = document.getElementById("rok2");      
    if (!isNaN(rokValue)) {
      rok2Field.value = parseInt(rokValue) + 1;
    } else {
      rok2Field.value = 0;
    }
  }



</script>