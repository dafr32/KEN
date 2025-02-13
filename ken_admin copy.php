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


    if (isset($_GET["section"])){
      $_SESSION['content-admin'] = $_GET["section"];
    }

    if (!isset($_SESSION['content-admin']))
      $_SESSION['content-admin'] = "nadgodziny_okres.php";

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
<body >    
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
    <div class="nav mx-auto" id="AdminMenu">
      <a href="#" id="m1" onclick="menu(1)" class="nav-link px-2 ">Nadgodziny</a>
      <a href="#" id="m2" onclick="menu(2)" class="nav-link px-2 ">Program</a>
      <a href="#" id="m3" onclick="menu(3)" class="nav-link px-2 ">Efektywność</a>
      <a href="#" id="m4" onclick="menu(4)" class="nav-link px-2 ">Nagrody</a>
    </div>
  </div>


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
                    <button class="btn btn-dark" id="okres">Okres rozliczeniowy</button>
                    <button class="btn btn-dark mx-3" id="analiza">Rozliczenia nauczyceli</button>
                    <button class="btn btn-dark" id="nauczyciele">Nauczyciele</button>
              </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Realizacja godzin  -->
    <section class="container-fluid bg-body-secondary hidden" id="section2" >        
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

  <div id="AdminBody">
    <div class="container mt-3 text-center" id="contentContainer" style="position: relative";>         
      <?php 
        if(isset($_SESSION['content-admin']))
          include $_SESSION['content-admin']; 
      ?>
    </div>
  </div>



  <?php include "footer.php"; ?>

<script>

    $(document).ready(function() {  
      $("#AdminMenu").on("click", function() {
        var id_menu = $(this).attr("id"); 
        $.ajax({

        });
      });
      
      $("#side-menu button").on("click", function() {
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

  function activeMenu(id){
    //funkcja usuwa zielony kolor podświetlenia z menu
    var parentDOM = document.getElementById("AdminMenu");
    var menus = parentDOM.querySelectorAll('.nav-link');
    
    menus.forEach(function(item) {
        item.classList.remove('active');
    });
    
    console.log(id);
    var activeMenuItem = document.getElementById("m" + id);
    console.log(activeMenuItem.id);
    if (activeMenuItem) {
        activeMenuItem.classList.add('active');
    }
  }

  function menu(id) {         
    var parentDOM = document.getElementById("AdminHeader");
    var sections = parentDOM.querySelectorAll('section');

    sections.forEach(function(section) {
        if (section.id === "section"+id)
          section.classList.remove('hidden');
        else
          section.classList.add('hidden');
    });                  
    switch (id) {
      case 1:
          sec = "nadgodziny_okres.php";
          break;
      case 2:
          sec = "prog_Analiza.php";
          break;
      default:
          // Handle other cases or provide a default value for sec
          sec = "nadgodziny_okres.php";
          break;
    }    
    window.location.href = `ken_admin.php?section=${sec}&menu=${id}`;
  }

</script>

  
</body>
</html>