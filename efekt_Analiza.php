<?php   
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" ){
        header('Location: index.php');
    }
    require "connect.php";

    $_SESSION['content-admin'] = "admin_Efektywnosc.php"; 

    if(isset($_GET['klasa'])){
      if($_GET['klasa'] === "all") {        
        $klasa =  "all";
      }else {
        $rocznik = substr($_GET['klasa'], 0, 4);
        $klasa = substr($_GET['klasa'], -1);
      }      
    }else{
      $klasa = $_SESSION["klasa"];    
      $rocznik = $_SESSION["rocznik"];
    }
      
    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];

    // roczniki klas 
    $year = date("Y");
    $month = date("n");
    $rok = 0;
    if($month < 9) $rok = -1;
    $rokcznik1 = $rokSzk - $rok;
    $rokcznik2 = $rokSzk - $rok - 1;
    $rokcznik3 = $rokSzk - $rok - 2;
    $rokcznik4 = $rokSzk - $rok - 3;     

    // $_SESSION['content-admin'] = "efekt_Analiza.php"; 

?>


<style>
    @media print {      
      @page {
        size: A4;
        margin: 1cm;
      }
     
      #printDiv, #printDiv * {
        visibility: visible;        
      }
      #wydruk img {
        display: none;
      }
      table {
        clear: both;
        page-break-after: always;
      }

    }

    @keyframes blink {
      0% { opacity: 1; }
      50% { opacity: 0; }
      100% { opacity: 1; }
    }
    .blink {
      animation: blink 1s infinite;
    }

</style>

    
<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="bg-secondary text-light">
                <div class="w-100 bg-dark p-2 text-center">
                    <h3>
                      <?php 
                        if ($klasa != "all") echo "Klasa <span id='v_kl'>$klasa</span>";
                        else echo "Wszyscy uczniowie";
                      ?> 
                    </h3>
                </div>
                <div class="border-1 p-2">
                    <?php  
                    if ($klasa == "all")
                      $sql = "SELECT * FROM efektywnosc__Uczniowie INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia WHERE efektywnosc__UczniowieOpinia.rokSzk = $rokSzk                               
                              ORDER BY efektywnosc__Uczniowie.rocznik DESC, efektywnosc__Uczniowie.klasa, nazwisko, imie;";
                    else
                      $sql = "SELECT * FROM efektywnosc__Uczniowie INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
                              WHERE efektywnosc__UczniowieOpinia.rokSzk = $rokSzk AND efektywnosc__Uczniowie.klasa = '$klasa' AND efektywnosc__Uczniowie.rocznik = $rocznik
                              ORDER BY efektywnosc__Uczniowie.rocznik, efektywnosc__Uczniowie.klasa, nazwisko, imie;";                                                    
                      // echo $sql;  
                    $result1 = $conn->query($sql);                  
                    if ($result1->num_rows > 0) {  
                      echo "<ul id='listaUzytkownikow'>";
                      echo "<li id='0' data-rocznik='$rocznik' data-klasa='$klasa'>Wszyscy</li>";
                      while ($row = $result1->fetch_assoc()) {
                          $id_ucznia = $row['ID'];
                          $a = $row["imie"];
                          $b = $row["nazwisko"];  
                          $rok = 0;
                          if($month < 9) $rok = 1;  
                          $kl = $row["klasa"];                              
                          $rocznik = $row["rocznik"] ;
                          $year = date("Y");
                          $rk = $year - $rocznik - $rok + 1;
                          echo "<li id='$id_ucznia' data-rocznik='$rocznik' data-klasa='$kl'><span class='text-green'>$rk$kl</span> : $b $a </li> ";
                      }
                      echo "</ul>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="row" id="printDiv">

            </div>
        </div>
    </div>
</div>



  <script>
    $(document).ready(function() {
        $("#listaUzytkownikow li").on("click", function() {
            var id_usera = $(this).attr("id");
            var rocznik = $(this).attr("data-rocznik");
            var klasa = $(this).attr("data-klasa");
            if(klasa=="all") {
              $("#printDiv").html("<div class='title blink' id='wait'>proszę czekać, trwa generowanie raportu ...</div>");
            }
            $.ajax({
                url: "efekt_PrintDiv.php", 
                type: "GET", 
                data: {
                    id: id_usera,
                    semestr: <?php echo $semestr; ?>,
                    rocznik: rocznik,
                    klasa: klasa
                },
                success: function(response) {
                    $("#printDiv").html(response); // Wyświetlanie odpowiedzi na stronie
                }
            });
        });
    });


    
    function printDiv() {
      // Use window.print() to trigger the print dialog
      var printContents = document.getElementById('printDiv').innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  
  </script>
</body>

</html>