<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <link rel="stylesheet" href="style.css">
    <title>Administracja</title>
</head>

<?php 
  
    session_start();
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
      header('Location: index.php');
  }

    require "connect.php";
    $rok = $_SESSION['rok'];
    $semestr = $_SESSION['semestr'];

    $result = $conn->query("SELECT * FROM nauczyciele WHERe id=".$_SESSION['belfer']);
    $row = $result->fetch_assoc();    
    $belfer = $row['nazwisko'] ;            

    if (isset($_POST['settings'])){
      if(isset($_POST['aktywny'])){
        $akt=1;
      } else {
        $akt=0;
      }
      $result = $conn->query("UPDATE settings SET rok=".$_POST['rok'].", sem='".$_POST['sem']."', pass='".$_POST['pass']."', aktywny=$akt WHERE typ=2");      
      $rok=$_POST['rok'];
      $semestr=$_POST['sem'];
      $_SESSION['rok'] = $rok;
      $_SESSION['semestr'] = $semestr;  
    }

    if (isset($_GET["del_id"])) {       
      $id = $_GET["del_id"];
      echo "id=$id rok=$rok sem=$semestr";
      $a = "DELETE FROM progress WHERE id_ucznia=$id and rok=$rok and sem='$semestr'";
      echo $a;
      $conn->query("DELETE FROM progress WHERE id_ucznia=$id and rok=$rok and sem='$semestr'");
      $conn->query("DELETE FROM wystawione_efekty WHERE id_ucznia=$id and rok=$rok and sem='$semestr'");
      $conn->query("DELETE FROM wystawione_formy WHERE id_ucznia=$id and rok=$rok and sem='$semestr'");
      $conn->query("DELETE FROM wystawione_wnioski WHERE id_ucznia=$id and rok=$rok and sem='$semestr'");     
      unset($_GET["del_id"]);
      header('Location: admin.php');
  }

    echo"<script>
          document.cookie = 'klasa=0';
      </script>"; # reset cookies

?>

<body class="site" id="adminSite">
      <div class="container-fluid border-bottom ">
        <div class="container align-items-center top1 ">
            <div class="d-flex justify-content-center align-items-center ">
                <div class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-decoration-none "
                    style="position:relative">                     
                        <img src="images/LO4_Logo.svg" class="logo">                    
                    <div class="header-left">
                        <h1 class="fs-4">Ocena Efektywności</h1>
                        <h2 class="fs-5"> pomocy psychologiczno-pedagogicznej ucznia</h2>
                    </div>
                </div>
                <div class="text-end">
                  <a href="admin.php"><button type="button" class="btn btn-danger me-2">Ustawienia</button></a>
                  <!-- <a href="analiza.php"><button type="button" class="btn btn-primary me-2">Efekty</button></a> -->
                  <a href="print.php"><button type="button" class="btn btn-primary me-2">Wydruki</button></a>
                  <a href="nauczyciele.php"><button type="button" class="btn btn-primary me-2">Nauczyciele</button></a>
                  <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-5 py-3 my-3 bg-light rounded-3" id="profil" >        
      <div class="container">
        <div class="row py-2">
          <?php
            $result = $conn->query("SELECT * FROM settings WHERE typ=2");
            $row = $result->fetch_assoc();  
          ?>
            <div class="col p-1" >
                <h1><?php echo $belfer; ?></h1>
                <form action="admin.php" method="POST" class="d-flex flex-column">
                  <div class="d-flex mt-2">
                    <div class="d-flex flex-column me-3">
                      <label class="small">ROK SZKOLNY</label>
                      <input type="text" name="rok" width='4' size='4' value="<?php echo $row['rok'];?>">
                    </div>
                    <div class="d-flex flex-column me-3">
                      <label class="small">SEMESTR</label>
                      <input type="text" name="sem" width="10" size='10' value="<?php echo $row['sem'];?>">
                    </div>
                    <div class="d-flex align-items-center">
                    <?php 
                      if ($row['aktywny'] == 1) {
                        $str = " checked";
                      } else {
                        $str = "";
                      }
                    ?>
                      <input class='form-check-input mx-2' type='checkbox' name='aktywny' <?php echo $str ?>>
                      <label class="small">Logowanie włączone</label>
                    </div>
                  </div>
                  <div class="d-flex mt-2 justify-content-between">
                    <div class="d-flex flex-column">
                      <label class="small">hasło dla nauczycieli</label>
                      <input type="text" name="pass" width="10" value="<?php echo $row['pass'];?>">
                    </div>     
                    <button type="submit" name="settings" class="btn btn-primary py-1 px-3">Zapisz</button>
                  </div>
                </form>
            </div>
            
            <div class="col text-center ">
                <h1 class="title">UCZNIOWIE</h1>
            </div>

            <!-- KLASY -->
            
            <div class="col p-1 ">
                <form name="frm_klasy" action="admin.php" method="POST">
                    <!-- klasy 1 -->
                    <div class="row justify-content-start my-1">
                        <?php                        
                        $result = $conn->query("SELECT * FROM `uczniowie` WHERE `rocznik`=$rok GROUP bY `klasa`");
                        $kl=1;                      
                        if ($result->num_rows > 0) {                          
                          while($row = $result->fetch_assoc()) {
                            $a = $row["klasa"];
                            echo "<button type='submit' name='submit_kl' value='$rok$a' class='col mr-1 btn btn-danger kl'>$kl$a</butoon>";
                          }
                        }   
                      ?>
                    </div>

                    <!-- klasy 2 -->
                    <div class="row justify-content-start my-1">
                        <?php
                        $result = $conn->query("SELECT * FROM uczniowie WHERE rocznik=". $rok - 1 ." GROUP bY klasa");
                        $kl=2;                      
                        if ($result->num_rows > 0) {                          
                          while($row = $result->fetch_assoc()) {
                            $a = $row["klasa"];
                            echo "<button type='submit' name='submit_kl' value='". $rok - 1 ."$a' class='col mr-1 btn btn-warning kl'>$kl$a</butoon>";
                          }
                        }   
                        ?>
                    </div>
 
                    <!-- klasy 3 -->
                    <div class="row justify-content-start my-1">
                        <?php
                        $result = $conn->query("SELECT * FROM uczniowie WHERE rocznik=". $rok - 2 ." GROUP bY klasa");
                        $kl=3;                      
                        if ($result->num_rows > 0) {                          
                          while($row = $result->fetch_assoc()) {
                            $a = $row["klasa"];
                            echo "<button type='submit' name='submit_kl' value='". $rok - 2 ."$a' class='col mr-1 btn btn-info kl'>$kl$a</butoon>";
                          }
                        }   
                        ?>
                    </div>

                    <!-- klasy 4 -->
                    <div class="row justify-content-start my-1">
                        <?php
                        $result = $conn->query("SELECT * FROM uczniowie WHERE rocznik=". $rok - 3 ." GROUP bY klasa");
                        $kl=4;                      
                        if ($result->num_rows > 0) {                          
                          while($row = $result->fetch_assoc()) {
                            $a = $row["klasa"];
                            echo "<button type='submit' name='submit_kl' value='". $rok - 3 ."$a' class='col mr-1 btn btn-primary kl'>$kl$a</butoon>";
                          }
                        }   
                        ?>
                    </div>

                    </div>

                </form>
            </div>
        </div>        
      </div>
    </div>


    <?php 
    if  ((isset($_POST['submit_kl'])) || (isset($_SESSION['klasa'])))
    { 
      if  (isset($_POST['submit_kl'])) {
        $_SESSION['klasa'] = substr($_POST['submit_kl'],4,1);
        $_SESSION['rocznik'] = substr($_POST['submit_kl'],0,4);        
        
        $kl = $_SESSION['klasa'];
        $rocznik = intval($_SESSION['rocznik']);

        $Y = date('Y');
        $M = date('n');
        if ($M < 9)
          $ozn_kl = ($Y - $rocznik) . $kl;
        else
          $ozn_kl = ($Y - 1 - $rocznik) . $kl;        

      }
        
    ?>

      <div class="container mt-2 rounded-3">
        <form action="savelist.php" method="POST" id="list">
          <table class="table">
            <thead>
              <tr class="bg-dark text-light">
                <th colspan="2"><h2>Klasa <span id="v_kl"><?php echo $ozn_kl ?></span> - uczniowie z oceną 
                <?php
                if (isset($_SESSION['statusZapisu']))
                {
                  echo "<span class='red'>". $_SESSION['statusZapisu']."</span>";
                  unset($_SESSION['statusZapisu']);
                }
                ?></h2>
                </th>
              </tr>
              <tr>
                <th>Nazwisko i imię</th>
                <th>usuń wpisy</th>
              </tr>
            </thead>
            <tbody>
              <?php  
                $sql = "SELECT * FROM uczniowie WHERE klasa = '$kl' AND rocznik=$rocznik ORDER BY nazwisko";
                // echo $sql;
                $result = $conn->query($sql);                  
                if ($result->num_rows > 0) 
                {  
                    while($row = $result->fetch_assoc()) 
                    {                      
                      $id_ucznia = $row['id'];
                      $a = $row["imie"];
                      $b = $row["nazwisko"];                    
                      echo "<tr><td>";    
                      $sql2 = "SELECT * FROM uczniowie_do_oceny WHERE id_ucznia=$id_ucznia AND rok=$rok AND semestr='$semestr'";
                      // echo $sql2;
                      $result2 = $conn->query($sql2);                  
                      if ($result2->num_rows > 0) 
                      {                                         
                        echo "<input class='form-check-input' type='checkbox' name='lista[]' value='$id_ucznia' id='$id_ucznia' checked>";                                          
                        echo "<label class='form-check-label ps-3 pt-1' for='$id_ucznia'> $b $a </lavel>" ;                        
                        echo "</td><td>";
                        echo "<i class='bi bi-trash3-fill' style='cursor:pointer; font-size:20px;' onclick='delOcedny($id_ucznia, \"$b\")'></i>";
                      } else{
                        echo "<input class='form-check-input' type='checkbox' name='lista[]' value='$id_ucznia' id='$id_ucznia'>";                                          
                        echo "<label class='form-check-label ps-3 pt-1' for='$id_ucznia'> $b $a </lavel>" ;                        
                        echo "</td><td>";
                        echo "";
                      }                                       
                      echo "</td><tr>";
                  }   
                }
              ?>
            </tbody>
          </table>
          <div class="align-bottom p-2 text-end">
            <button type="submit" name="saveList" class="btn btn-primary">Zapisz</button>
          </div>      
        </form>
      </div>

    <?php 
    } 
    ?>

<script>
  function delOcedny(id, nazwa) { 
    const result = confirm("Czy chcesz skasować wszystkie oceny ucznia "+nazwa+" ?");
    if (result === true) {
      window.location.href = `admin.php?del_id=${id}`;
    } else {
      console.log("User clicked Cancel");
    }
                   
    
  }

</script>

</body>

</html>