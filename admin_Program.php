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

?>

<div id="AdminHeader">
  <!-- Realizacja godzin  -->
  <section class="container-fluid bg-body-secondary" id="section2" >        
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
                    <!-- <label class="small mb-1 mt-4" for="ileTygodni">Ilość tygodni do odrobienia: </label> -->
                  </div>
                  <div class="d-flex flex-column me-3">
                    <label class="small mb-1">SEMESTR</label> 
                    <select name="sem" class="form-select">
                      <option value="1" <?php if ($semestr == 1) echo 'selected'; ?>>pierwszy</option>
                      <option value="2" <?php if ($semestr == 2) echo 'selected'; ?>>drugi</option>                      
                    </select> 
                    <input type="hidden" class="form-control mt-3 mx-auto" name="ileTygodni" id="ileTygodni" value="<?php echo $setTygodnieKl4;?>">
                  </div>   
                  <div class="d-flex flex-column me-3">   
                    <!-- <label class="small mb-1">Miesiąc</label>      -->
                    <input type="hidden"  class="form-control bg-1 bold" readonly value="<?php echo $setMies ?>">
                    <button type="submit" name="submitRok" id="submitRok" class="btn btn-danger px-3 mt-auto">Zapisz/Zmień</button>
                  </div>
                </div>                  
              </div>                  
            </form>
        </div>
        
        <div class="col-sm-12 col-xl-5 text-center " >
            <h2 class="title mb-3">Realizacja <br />Programu Nauczania</h2>
        </div>
      </div>
    </div>
  </section>    
</div>


<div class="container program mt-4">
    <div class="row">
        <div class="col-3 lista">
            <div class="bg-dark text-light text-left p-2">
                <div class="w-100 bg-secondary p-2 text-center">
                    <h3>Nauczyciel</h3>
                </div>
                <div class="border-1 p-2">
                    <?php  
                    $sql = "SELECT ID, Nazwisko, Imie, tab.id_nauczyciela as belf FROM `Nauczyciele` LEFT JOIN ( SELECT `id_nauczyciela` FROM `prog_Realizacja` WHERE `rokSzk`= 2023 AND `semestr`= 1 GROUP BY `id_nauczyciela`) as tab ON Nauczyciele.ID = tab.id_nauczyciela WHERE aktywne = 1 ORDER BY Nauczyciele.Nazwisko, Nauczyciele.ID";
                    // echo $sql;  
                    $result = $conn->query($sql);                  
                    if ($result->num_rows > 0) {  
                      echo "<ul id='listaUzytkownikow'>";
                      echo "<li id='0' data-imie='all' data-nazw='all' >Wszyscy - wydruk</li>";
                      while ($row = $result->fetch_assoc()) {                          
                          $id = $row['ID'];
                          $imie = $row["Imie"]; 
                          $nazw = $row["Nazwisko"]; 
                                            
                          if ($row["belf"] == NULL) {
                            $color = "#666";
                          } else {
                            $sql2 = "SELECT * FROM prog_Realizacja WHERE rokSzk = $rokSzk AND semestr = $semestr AND id_nauczyciela = $id AND `zrealizowany` = 0";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0)  
                              $color = "red";
                            else
                              $color = "#00ffe8f5";                                                                                         
                          }
                          echo "<li id='$id' data-imie='$imie' data-nazw='$nazw' style='color:$color'>$nazw $imie</li> ";
                      }
                      echo "</ul>";
                  }                  
                    ?>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="row" id="printDiv"> 
              
            </div>
        </div>
    </div>
</div>


<script>
  $(document).ready(function() {
    $("#listaUzytkownikow li").on("click", function() {
      var id_usera = $(this).attr("id");
      var imie = $(this).data("imie"); 
      var nazw = $(this).data("nazw"); 
      $.ajax({
          url: "prog_AnalizaContent.php", 
          type: "GET", 
          data: {
              id: id_usera,                    
              imie: imie, 
              nazw: nazw, 
          }, 
          success: function(response) {
              $("#printDiv").html(response); 
          }
      });
    });
  });
</script>