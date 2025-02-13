<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">
<head> 
    <?php include "head.php"; ?>
    <link rel="stylesheet" href="css/nadgodziny.css">
    <title>Nadgodziny</title>  
    <style> 
      .stick { 
          position: -webkit-sticky;
          position: sticky; 
          top:0; 
          z-index: 100;
      } 
      .container3 { 
          overflow: auto; 
      } 

      .program .lista h3 {
        color: #eee;
      }

      #AdminMenu li {
        cursor: pointer;
      }


      .prog_Analiza .title h3 {
          color: #222;
          margin-bottom: 10px;
      }
      .prog_Analiza .headerTable {        
          align-items: center;
          justify-content: space-between;
          background: #7c7c7cd1;
          padding: 5px 20px;
          margin-bottom: 10px;
      }
      #wydruk .headerTable h3 {
          color: azure;
          font-weight: 300;
          font-size: 1.1rem;
      }
      .prog_Analiza th.col {
          font-size: 0.8rem;
          font-weight: 400;
      }
      
      @media print {      
        @page {
          size: A4;
          margin: 1cm;
        }
      
        #wydruk, #wydruk * {
          visibility: visible;        
        }
        #wydruk img {
          display: none;
        }
        .page {
          clear: both;
          page-break-after: always;
        }
        #wydruk .headerTable h3 {
          color: #000 !important;        
          font-weight: 600;
        }

      }


    </style>  
</head>

<?php 
    session_start();
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    } 

    require "connect.php";

    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
        
    //----------------------------------------------------------------
    // Odczyt miesiąca rozliczeniowego 
    //----------------------------------------------------------------
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
    //----------------------------------------------------------------

    if (!isset($_SESSION['content-admin']))
      $_SESSION['content-admin'] = "admin_Nadgodziny.php";


    // zmiana roku szkolnego Efektywności
    if (isset($_POST['changeRokSzk'])){
      $sql = "UPDATE `efektywnosc__AktywnyOkres` SET `rokSzk`='". $_POST["rokSzk"]."',`semestr`='". $_POST["semestr"]."' WHERE 1";
      $conn->query($sql);
    }


    //----------------------------------------------------------------
    // GET - zapisanie zmian godzin odpracowanych 
    //----------------------------------------------------------------
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
    //----------------------------------------------------------------




    // roczniki klas 
    $year = date("Y");
    $month = date("n");
    $rok = 0;
    if($month < 9) $rok = 0;  
    $rokcznik1 = $rokSzk - $rok;
    $rokcznik2 = $rokSzk - $rok - 1;
    $rokcznik3 = $rokSzk - $rok - 2;
    $rokcznik4 = $rokSzk - $rok - 3;       

    // zmiana klasy 
    if (isset($_GET['submit_kl'])){
        if ($_GET['submit_kl'] == "all"){
            $klasa = "all";
            $rocznik = $rokcznik4;
        } else {
            $klasa = $_GET['submit_kl'][4];
            $rocznik = substr($_GET['submit_kl'], 0, 4);
        }
        
        $_SESSION["klasa"] = $klasa;        
        $_SESSION["rocznik"] = $rocznik;  
        $_SESSION['efekt-content'] = "admin_Uczniowie.php";
    }elseif(!isset($_SESSION["klasa"])) {
        $_SESSION["klasa"] = "A";
        $_SESSION["rocznik"] = $rokSzk;
    }else
        $klasa = $_SESSION["klasa"];
        $rocznik = $_SESSION["rocznik"];


?>

<body id="body">    
  <header class="container-fluid border-bottom">
      <div class="container d-flex justify-content-center align-items-center top1 ">            
          <div class="d-flex align-items-center mb-lg-0 me-lg-auto text-decoration-none">
              <a href="/"><img src="images/LO4_Logo.svg" class="logo"></a>
              <div class="header-left">
                      <h1 class="fs-4">Wewnątrzszkolny System IT</h1>
                      <h2 class="fs-5">panel zarządzania dyrektora</h2>
                  </div>
              </div>
              <div class="text-end">
                <!-- <a href="admin.php"><button type="button" class="btn btn-primary me-2">Uczniowie</button></a>
                <a href="analiza.php"><button type="button" class="btn btn-primary me-2">Efekty</button></a>
                <a href="print.php"><button type="button" class="btn btn-primary me-2">Wydruki</button></a> -->
                <a href="logout.php"><button type="button" class="btn btn-primary">Wyloguj się</button></a>
              </div>
          </div>
      </div>
  </header>

  <div class="navbar bg-dark">
    <ul class="nav mx-auto" id="AdminMenu">
      <li id="Nadgodziny" class="nav-link px-2 ">Nadgodziny</a>
      <li id="Program" class="nav-link px-2 ">Program</a>
      <li id="Efektywnosc" class="nav-link px-2 ">Efektywność</a>
      <li id="Egzaminy" class="nav-link px-2 ">Egzaminy</a>
      <li id="Ustawienia" class="nav-link px-2 ">Ustawienia</a>
    </ul>
  </div>

  <div id="AdminBody" class="container-fluid" style="flex:1" >         
    <?php  include $_SESSION['content-admin']; ?>
  </div>
  

<script>

  function activeMenu(id){
    //funkcja usuwa zielony kolor podświetlenia z menu
    var parentDOM = document.getElementById("AdminMenu");
    var menus = parentDOM.querySelectorAll('.nav-link');
    
    menus.forEach(function(item) {
        item.classList.remove('active');
    });        
    var activeMenuItem = document.getElementById(id);    
    if (activeMenuItem) {
        activeMenuItem.classList.add('active');
    }
  }

    $(document).ready(function() {  
      $("#AdminMenu li").on("click", function() {
        var id_menu = $(this).attr("id"); 
        activeMenu(id_menu);
        $.ajax({
          url: "admin_"+id_menu+".php",
            type: "GET", // Typ żądania            
            success: function(response) {
                $("#AdminBody").html(response); 
            }
        });
      });           

    });

    
    function printDiv() {
    var printContents = document.getElementById('printDiv').innerHTML;
    var originalContents = document.body.innerHTML;

    // Use window.print() to trigger the print dialog
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    // Add an event listener for the 'afterprint' event to restore the original content
    window.addEventListener('afterprint', function () {
      document.body.innerHTML = originalContents;
    });
  }
   
  
</script>

<?php include "footer.php"; ?>
</body>
</html>