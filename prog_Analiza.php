<?php   
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || ($_SESSION["typ"]!="Pedagog" && $_SESSION["typ"]!="Dyrektor")){
        header('Location: index.php');
    }    
    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];
?>
<style>
   
    
</style>


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
            <h1 class="title mb-3">Realizacja Programu Nauczania</h1>
            <!-- <div class="d-flex justify-content-center py-3">
                  <button class="btn btn-dark" id="okres">Okres rozliczeniowy</button>
                  <button class="btn btn-dark mx-3" id="analiza">Rozliczenia nauczyceli</button>
                  <button class="btn btn-dark" id="nauczyciele">Nauczyciele</button>
            </div> -->
        </div>

      </div>
    </div>
  </section>    
</div>


<div class="container-fluid program">
    <div class="row">
        <div class="col-3 lista">
            <div class="bg-dark text-light text-left p-2">
                <div class="w-100 bg-secondary p-2 text-center">
                    <h3>Nauczyciel</h3>
                </div>
                <div class="border-1 p-2">
                    <?php  
                    $sql = "SELECT ID, Nazwisko, Imie, tab.id_nauczyciela as belf FROM `Nauczyciele` LEFT JOIN ( SELECT `id_nauczyciela` FROM `prog_Realizacja` WHERE `rokSzk`= 2023 AND `semestr`= 1 GROUP BY `id_nauczyciela`) as tab ON Nauczyciele.ID = tab.id_nauczyciela ORDER BY Nauczyciele.Nazwisko, Nauczyciele.ID";
                    // echo $sql;  
                    $result = $conn->query($sql);                  
                    if ($result->num_rows > 0) {  
                      echo "<ul id='listaUzytkownikow'>";
                      echo "<li id='0' data-imie='all' data-nazw='all' >Wszyscy</li>";
                      while ($row = $result->fetch_assoc()) {                          
                          $id = $row['ID'];
                          $imie = $row["Imie"]; // Corrected variable name
                          $nazw = $row["Nazwisko"]; // Corrected variable name
                                            
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
            <div class="row" id="printDiv"> </div>
        </div>
    </div>
</div>


<script>
  $(document).ready(function() {
    $("#listaUzytkownikow li").on("click", function() {
      var id_usera = $(this).attr("id");
      var imie = $(this).data("imie"); // assuming imie is stored as a data attribute
      var nazw = $(this).data("nazw"); // assuming nazw is stored as a data attribute  
      console.log("pass");    
      $.ajax({
          url: "prog_AnalizaContent.php", // Ścieżka do pliku PHP obsługującego żądanie
          type: "GET", // Typ żądania
          data: {
              id: id_usera,                    
              imie: imie, // corrected syntax
              nazw: nazw, // corrected syntax
          }, // Przekazanie id, imie, and nazw jako dane do pliku PHP
          success: function(response) {
              $("#printDiv").html(response); // Wyświetlanie odpowiedzi na stronie
          }
      });

    });
  });

</script>