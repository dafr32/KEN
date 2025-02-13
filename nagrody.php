<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html lang="pl">
 
<head>
    <?php
        session_start();
        if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
            header('Location: index.php');
        }
        require "connect.php";
        include "head.php";
    ?> 
    <title>Nagrady końcoworoczne</title>
    <style>
    input#dlaKogo {
        font-family: fantasy;
        font-size: 3rem;
        color: red;
        margin: 30px 0;
    }

    #formNagroda h3 {
        font-size: 2rem;
        color: #000;
        font-family: 'Oswald';
        margin-bottom: 30px;
    }

    textarea#opis {
        font-size: 1.5rem;
        font-family: 'Oswald';
    }
    </style>
</head>
<?php 

  $belfer = $_SESSION['belfer'];
  $belfer_id = $_SESSION['belfer_id'];
  $rokSzk = $_SESSION['rokSzk'];

  if (isset($_GET["del_id"])) {   
    $id = $_GET["del_id"];                   
    unset($_GET["del_id"]);      
    $sql = "DELETE FROM `nagrody_wpisy` WHERE `id`=$id";  
    $conn->query($sql);        
    header("Location: nagrody.php");
  }         

  
  if (isset($_GET["edit_id"])) {      
    $id = $_GET["edit_id"];                   
    unset($_GET["edit_id"]);  
    $sql = "SELECT * FROM `nagrody_wpisy` WHERE `id`=".$id ;                    
    echo $sql;
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc(); 
    $editId = $row["id"];
    $editDla = $row["dla_kogo"];
    $editOpis = $row["tekst_nagrody"];       

  } 

  // echo "<script>  document.cookie = 'klasa=0'; </script>"; # reset cookies      
?>

<body id="site1" class="site wow fadeIn" data-wow-duration="2s">
    <header class="d-flex flex-column border-bottom ">
        <div class="container d-flex justify-content-center align-items-center top1 ">
            <div class="container d-flex flex-wrap justify-content-center align-items-center ">
                <div class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-decoration-none "
                    style="position:relative">
                    <a href="/"><img src="images/LO4_Logo.svg" class="logo"></a>
                    <div class="header-left">
                        <h1 class="fs-4">Nagrody książkowe</h1>
                        <h2 class="fs-5">IV LO im KEN w Bielsku-Białej</h2>
                    </div>
                </div>
                <div class="text-end">
                    <a href="home.php"><button type="button" class="btn btn-primary">Powrót</button></a>
                    <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
                </div>
            </div>
        </div>
    </header>

    <div id="profil" class="container p-3 my-3 bg-light rounded-3">
        <div class="">
            <div class="d-flex py-2">
                <div class="p-1">
                    <h1><?php echo $belfer; ?></h1>
                    <div class="d-flex mt-3">
                        <div class="d-flex flex-column ">
                            <label class="small">ROK SZKOLNY</label>
                            <div class="rok fs-5 fw-bolder"><?php echo "$rokSzk/".$rokSzk+1; ?></div>
                        </div>
                        <div class="d-flex flex-column ms-5 px-5">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Zapisane nagrody -->
    <div class="container">
      <?php  
      $sql = "SELECT * FROM `nagrody_wpisy` WHERE `id_nauczyciela`=".$belfer_id." and `rok`=".$rokSzk ;                    
      // echo $sql;
      $result = $conn->query($sql);  

      if ($result->num_rows > 0) {               
        echo '<div class="accordion accordion-flush" id="accordionKEN">';
          while($row = $result->fetch_assoc()) {
            $id = $row["id"];   
            ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse<?php echo $id ?>" aria-expanded="false"
                        aria-controls="flush-collapse<?php echo $id ?>">
                        <?php echo $row["dla_kogo"];?>
                    </button>
                </h2>
                <div id="flush-collapse<?php echo $id ?>" class="accordion-collapse collapse"
                    data-bs-parent="#accordionKEN">
                    <div class="accordion-body"><?php echo $row["tekst_nagrody"] ?></div>
                    <?php echo "<button class='btn btn-warning mb-3 text-center' style='cursor:pointer;' onclick='delUser($id)'>Usuń wpis</button>"; ?>
                    <?php echo "<button class='btn btn-info mb-3 text-center' style='cursor:pointer;' onclick='editUser($id)'>Edytuj wpis</button>"; ?>
                </div>
            </div>
          <?php            
          }                  
        echo "</div>";
      }?>
    
    </div>


    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <h4 class="bg-light text-center text-info p-4">Nagroda</h4>
                
                <h5 class="mt-3">ZA</h5>
                <div class="bg-body-secondary p-2 ">
                    <p class="px-1 fw-bolder">Formy nagrody:</p>
                    <?php
                    $result = $conn->query("SELECT * FROM nagrody_typ");                  
                    if ($result->num_rows > 0) 
                    {       
                        $lp = 1;
                        while($row = $result->fetch_assoc()) 
                        { 
                            $id_typ = $row['id'];
                            echo '<div class="form-check d-flex">';                            
                            echo "<input class='form-check-input' type='checkbox' value='". $row["typ"]. "' id='checkbox$id_typ'>";
                            echo "<div class='px-1'>". $lp++ ."</div>";
                            echo "<label class='form-check-label' for='checkbox$id_typ'>". $row["typ"]."</label>" ;                        
                            echo "</div>";
                        }    
                    }                                               
                    ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 text-center">
                <div class="row">
                    <form action="save.php" method="POST" id="formNagroda" class="text-center">
                        <h3 class="">NAGRODA</h3>
                        <label for="dlaKogo">DLA</label>
                        <input type="text" id="dlaKogo" name="dlaKogo" class="w-100 text-center"
                            value="<?php echo isset($editDla) ? $editDla : ''; ?>">
                        <input type="hidden" id="idNagroda" name="idNagroda"
                            value="<?php echo isset($editId) ? $editId : ''; ?>">
                        <textarea class="p-1 text-center w-100" id="opis" name="opis"
                            rows="3"><?php echo isset($editOpis) ? $editOpis : ''; ?></textarea>
                        <button class="btn btn-primary btn-block mt-5" name="submitNagrody" type="submit"
                            for="formNagroda">Zapisz</button>
                        <button class="btn btn-primary btn-block mt-5" name="reset" type="reset"
                            for="formNagroda">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pobieramy referencję do wszystkich checkboxów i elementu <div>
        var checkboxes = document.querySelectorAll(".form-check-input");
        var opisTextarea = document.getElementById("opis");
        var dlaKogo = document.getElementById("dlaKogo");
        //  var dlaInput = document.getElementById("dla")   

        // Dodajemy nasłuchiwanie na zmiany stanu checkboxów
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                // Inicjalizujemy tekst na podstawie stanu checkboxów
                // dlaKogo.value = dlaInput.value;
                var tekst = "";
                checkboxes.forEach(function(chk) {
                    if (chk.checked)
                        tekst += chk.value + ", ";
                });

                // Usuwamy ostatnią przecinkę i spację z tekstu
                tekst = tekst.slice(0, -2);

                // Aktualizujemy tekst w <div>
                opisTextarea.value = tekst;
            });
        });

        // Ustawienie wartości 'dlaKogo' na początku

    });


    function delUser(id) {
        const result = confirm("Czy chcesz skasować wp[is?");
        if (result === true) {
            window.location.href = `nagrody.php?del_id=${id}`;
        } else {
            console.log("User clicked Cancel");
        }
    }

    function editUser(id) {
        window.location.href = `nagrody.php?edit_id=${id}`;
    }
    </script>


    <?php include "footer.php"; ?>
</body>

</html>