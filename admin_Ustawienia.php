<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    }
    require "connect.php";   

    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    

    if(!isset($_SESSION['content-ustawienia'])) $_SESSION['content-ustawienia'] = "adminUstawienia_Nauczyciele.php";
?>

<style>
  #side-menu button {
    margin: 0 10px; 
  }
</style>

<div id="AdminHeader">
    <!-- Nadgodziny  -->  
    <section class="container-fluid bg-body-secondary" id="section1" >        
      <div class="container py-3">
        <div class="row py-2">
          <div class="text-center side-menu bg-2" id="side-menu">
              <h1 class="title mb-3">Ustawienia</h1>
              <div class="d-flex justify-content-center py-3">                    
                    <button class="btn btn-warning" id="Nauczyciele" >Nauczyciele</button>
                    <button class="btn btn-dark" id="Przedmioty">Przedmioty</button>
              </div>
          </div>
        </div>
      </div>
    </section>     
</div>


<div id="AdminBody">
    <div class="container mt-3 text-center" id="contentContainer" style="position: relative";>         
        <?php          
          include $_SESSION['content-ustawienia'];
        ?>    
    </div>
  </div>

<script>

    $(document).ready(function() {  
        
        $("#side-menu button").on("click", function() {
          $("#side-menu button").removeClass("btn-warning").addClass("btn-dark");
          var id_file = $(this).attr("id"); 
          $(this).removeClass("btn-dark").addClass("btn-warning");    
          $.ajax({
            url: "adminUstawienia_"+id_file+".php",
            type: "GET", // Typ żądania            
            success: function(response) {
                $("#contentContainer").html(response); 
            }
        });            
      });
    });

</script>