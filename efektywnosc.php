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
    <link rel="stylesheet" href="style.css">
    <title>Ocena efektywności</title>
</head>
<?php 
    session_start();
    require "connect.php";
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
      header('Location: index.php');
  }

    if ( !$_SESSION['przedmiot']){
      $przedmiot_id = $_POST['przedmiot'];
      $result = $conn->query("SELECT * FROM przedmioty WHERe id=$przedmiot_id");
      $row = $result->fetch_assoc();
      $przedmiot = $row['przedmiot'];
      $_SESSION['przedmiot']=$_POST['przedmiot'];
    }
    
    $przedmiot_id = $_SESSION['przedmiot'];
    $rok = $_SESSION['rok'];
    $semestr = $_SESSION['semestr'];

    $belfer_id = $_SESSION['belfer_id'];
    $belfer = $_SESSION['belfer'];
 
    echo"<script>
          document.cookie = 'klasa=0';
      </script>"; # reset cookies      

?>

<script>
  var sub = false;
  // Funkcja ustawiająca postęp na pasku
  function setProgress(id_ucznia,value) {
      // Obliczanie szerokości paska na podstawie wartości przycisku
      var progressBar = document.getElementById("myProgressBar"+id_ucznia);
      progressBar.style.width = (value * 20) + "%";
      progressBar.className = 'progress-bar';
      progressBar.classList.add("bar_" + value);
      // progressBar.setAttribute("aria-valuenow", value * 20);
      progressBar.innerHTML = (value * 20) + "%";
      
      var progress = document.getElementById("progress"+id_ucznia);
      progress.value = value;

      var objUzasadnij = document.getElementById("uzasadnienie"+id_ucznia);
      if (value <= 3) {        
        objUzasadnij.style.background = "#fff";
        objUzasadnij.setAttribute("placeholder", "Podaj uzasadnuienie...");
        objUzasadnij.disabled = false;
      }else {
        objUzasadnij.style.background = "#ddd";
        objUzasadnij.setAttribute("placeholder", "");
        objUzasadnij.disabled = true;
      }
    }
</script>
<body id="site1" class="site">
    <header class="d-flex flex-column border-bottom ">
        <div class="container d-flex justify-content-center align-items-center top1 ">
            <div class="container d-flex flex-wrap justify-content-center align-items-center ">
                <div class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-decoration-none "
                    style="position:relative">
                    <a href="/">
                        <img src="images/LO4_Logo.svg" class="logo">
                    </a>
                    <div class="header-left">
                        <h1 class="fs-4">Ocena Efektywności</h1>
                        <h2 class="fs-5"> pomocy psychologiczno-pedagogicznej ucznia</h2>
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
            <div class="container-fluid d-flex py-2">
                <div class="p-1">
                    <h1><?php echo $belfer; ?></h1>
                    <h3><?php echo $przedmiot; ?> </h3>
                    <div class="d-flex mt-3">
                      <div class="d-flex flex-column ">
                        <label class="small">ROK SZKOLNY</label>
                        <div class="rok fs-5 fw-bolder"><?php echo "$rok/".$rok+1; ?></div>
                      </div>
                      <div class="d-flex flex-column ms-5 px-5">
                        <label class="small">SEMESTR</label>
                        <div class="rok fs-5 fw-bolder"><?php echo $semestr ?></div>
                      </div>
                    </div>
                </div>
                
                <!-- KLASY -->      
                <div class="ms-auto p-1">
                  <form name="frm_klasy" action="efektywnosc.php" method="POST">
                      <!-- klasy 1 -->
                      <div class="row justify-content-start my-1">
                          <?php                        
                          $result = $conn->query("SELECT * FROM `uczniowie` WHERE `rocznik`=$rok GROUP BY `klasa`");
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
                  </form>            
              </div>
            </div>
        </div>        
    </div>

    <!-- Lista uczniów z klasy   -->
    <?php 
    if  ((isset($_POST['submit_kl'])) || (isset($_SESSION['klasa'])))
    { 

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
    ?>

    <div class="container d-flex flex-column mt-2 rounded-3">
        <div class="p-1 mb-2 header-klasa border-bottom" >
          <h2>Klasa <span id="v_kl"><?php echo $_SESSION['klasa']; ?></span> 
              <?php
              if (isset($_SESSION['statusZapisuOceny']))
              {
                echo "<span class='red'>". $_SESSION['statusZapisuOceny']."</span>";
                unset($_SESSION['statusZapisuOceny']);
              }
              ?>
          </h2>
        </div>
        <div class="mt-2">
          <div class="container">
            <?php  
            $sql = "SELECT * FROM uczniowie INNER JOIN uczniowie_do_oceny ON uczniowie.id=uczniowie_do_oceny.id_ucznia
                    WHERE uczniowie.klasa = '$kl' AND uczniowie_do_oceny.rok=$rok AND uczniowie_do_oceny.semestr='$semestr' AND rocznik=$rocznik ORDER BY nazwisko";                    
            // echo $sql;
            $result1 = $conn->query($sql);                  
            if ($result1->num_rows > 0) 
            {                        
            ?>
              <!-- Uczniowie               -->
              <form action="savelist.php" method="POST" onsubmit="return val()" id="userForm">
              <div class='accordion accordion-flush' id='accordionKEN'>       
                  <?php      
                  while($row = $result1->fetch_assoc()) 
                  {
                      $id_ucznia = $row['id'];
                      $a = $row["imie"];
                      $b = $row["nazwisko"]; 
                    ?> 
                      <div class='accordion-item'>
                          <h2 class='accordion-header'>
                            <?php
                            echo "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$id_ucznia' aria-expanded='true' aria-controls='collapse$id_ucznia'>";
                            $sql2 ="select uczniowie.id, progress.ocena, progress.uzasadnienie, wystawione_efekty.id_efekt, wystawione_formy.id_formy, wystawione_wnioski.id_oceny from (((uczniowie inner join progress on uczniowie.id = progress.id_ucznia) inner join wystawione_efekty on uczniowie.id = wystawione_efekty.id_ucznia) inner join wystawione_formy on uczniowie.id = wystawione_formy.id_ucznia) inner join wystawione_wnioski on uczniowie.id = wystawione_wnioski.id_ucznia where (((wystawione_efekty.id_nauczyciela)=$belfer_id) and ((wystawione_efekty.przedmiot)=$przedmiot_id) and ((wystawione_efekty.rok)=$rok) and ((wystawione_efekty.sem)='$semestr') and ((progress.id_nauczyciela)=$belfer_id) and ((progress.przedmiot)=$przedmiot_id) and ((progress.rok)=$rok) and ((progress.sem)='$semestr') and ((wystawione_formy.id_nauczyciela)=$belfer_id) and ((wystawione_formy.przedmiot)=$przedmiot_id) and ((wystawione_formy.rok)=$rok) and ((wystawione_formy.sem)='$semestr') and ((wystawione_wnioski.id_nauczyciela)=$belfer_id) and ((wystawione_wnioski.przedmiot)=$przedmiot_id) and ((wystawione_wnioski.rok)=$rok) and ((wystawione_wnioski.sem)='$semestr') and (uczniowie.id=$id_ucznia));";
                              // $sql2 = "SELECT * FROM `wystawione_wnioski` WHERE `id_ucznia`= $id_ucznia AND `id_nauczyciela`= $belfer_id and `przedmiot`= $przedmiot_id and `rok`= $rok and `sem`= '$semestr'" ;                      
                              // echo $sql2;
                                $result2 = $conn->query($sql2);                  
                                if ($result2->num_rows > 0) 
                                { 
                                    echo  "<span class='yellow'>$b $a</span>";                               
                                } else {
                                    echo  "<span class='red'>$b $a</span>";                                                             
                                } 
                                ?>
                              </button>
                          </h2>    
                          <!-- <?php echo $sql2; ?> -->
                          <?php                           
                          echo 
                          "<div id='collapse$id_ucznia' class='accordion-collapse collapse' aria-labelledby='heading$id_ucznia' data-bs-parent='#accordionKEN'>"; ?>
                              <div class='accordion-body'>

                                <div class="container ">
                                  <div class="row">
                                    <div class="col-6 my-3">
                                      <!-- PROGRESSBAR  -->
                                      <?php                                        
                                        $sql = "SELECT ocena, uzasadnienie FROM `progress` WHERE `id_ucznia`= $id_ucznia AND `id_nauczyciela`= $belfer_id and `przedmiot`= $przedmiot_id and `rok`= $rok and `sem`= '$semestr'";                                           
                                        $result = $conn->query($sql);                                                          
                                        if ($result->num_rows > 0) { 
                                          $row = $result->fetch_assoc();                                                                                  
                                          $progress = $row['ocena'];                                          
                                          $uzasadnienie = $row['uzasadnienie'];                                                                                                                              
                                        } else {                                          
                                          $progress = 0;
                                          $uzasadnienie = "nic";                                          
                                        }
                                        
                                      ?>
                                        <h5> Ocena efektywności pomocy psychologiczno-pedagogicznej</h5>
                                        <div class="progress mt-4">                                            
                                          <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" <?php echo "id='myProgressBar$id_ucznia' " ?>></div>                                            
                                          <?php echo "<input type='hidden' id='progress$id_ucznia' name='progress$id_ucznia' value='$progress'>"; ?> 
                                        </div>
                                        <div class="row my-4 text-end">
                                            <div class="offset-1 col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 1)'" ?> >1</button></div>
                                            <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 2)'" ?> >2</button></div>
                                            <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 3)'" ?> >3</button></div>
                                            <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 4)'" ?> >4</button></div>
                                            <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 5)'" ?> >5</button></div>                                            
                                        </div>   
                                           <?php
                                            echo "<script>setProgress($id_ucznia, $progress)</script>";
                                          ?>                                                                         
                                    </div> 
                                    <div class="col-6 p-3 text-center">
                                      <h5> Uzasadnienie oceny (jeżeli mniejsza niz 4)</h5>
                                      <textarea class="p-1" rows="4" cols="50" <?php echo "id='uzasadnienie$id_ucznia' name='uzasadnienie$id_ucznia' value='$uzasadnienie'" ?> form="userForm"><?php echo $uzasadnienie ?></textarea>
                                    </div>                                   
                                  </div>


                                  <div class="row align-items-start">

                                      <!-- FORMY ---------------------------  -->
                                      <div class="col-4 bg-body-secondary p-2">
                                        <h5 class="bg-dark text-center text-info">FORMY</h5>
                                        <p class="px-1 fw-bolder">Formy pracy z uczniem:</p> 
                                        <?php
                                          $q4 = $conn->query("SELECT * FROM formy");                  
                                          if ($q4->num_rows > 0) 
                                          {                                             
                                            ?>                                    
                                            <div class='form-check'>                                                    
                                                  <?php
                                                    while($q4_row = $q4->fetch_assoc()) 
                                                    { 
                                                        $id_formy = $q4_row['id'];
                                                        echo "
                                                        <div class='form-check'>";    
                                                          // sprawdzenie czy jest zaznaczona opja
                                                          $sql5 = "SELECT * FROM `wystawione_formy` WHERE `id_ucznia`= $id_ucznia AND `id_nauczyciela`= $belfer_id and `przedmiot`= $przedmiot_id and `rok`= $rok and `sem`= '$semestr' and `id_formy`= $id_formy";  
                                                          // echo $sql5;
                                                          $key2 = 'formy'. $id_ucznia.'[]';
                                                          $q5 = $conn->query($sql5);                  
                                                          if ($q5->num_rows > 0) {                                                                
                                                            echo "<input class='form-check-input' type='checkbox' name='$key2' value='".$q4_row['id']."' id='".$q4_row['id']."' checked>";
                                                          }else {
                                                            echo "<input class='form-check-input' type='checkbox' name='$key2' value=".$q4_row['id']." id=".$q4_row['id'].">";
                                                          }
                                                          echo "<label class='form-check-label' for=".$q4_row['id'].">". $q4_row['nazwa'] ."</lavel>" ;                        
                                                        echo 
                                                        "</div>";
                                                    }                                                   
                                                  ?>                                           
                                            </div>
                                          <?php 
                                          } ?> 
                                      </div>

                                      <!-- EFEKTY---------------------------------- -->
                                      <div class="col-4 bg-light p-2 ">
                                        <h5 class="bg-dark text-center text-info">EFEKTY</h5>
                                        <p class="px-1 fw-bolder">Pomoc przyniosła efekty w postaci:</p> 
                                        <?php
                                          $q4 = $conn->query("SELECT * FROM efekty");                  
                                          if ($q4->num_rows > 0) 
                                          {                                             
                                            ?>                                    
                                            <div class='form-check'>                                                    
                                                  <?php
                                                    while($q4_row = $q4->fetch_assoc()) 
                                                    { 
                                                        $id_efekt = $q4_row['id'];
                                                        echo "
                                                        <div class='form-check'>";    
                                                          // sprawdzenie czy jest zaznaczona opja
                                                          $sql5 = "SELECT * FROM `wystawione_efekty` WHERE `id_ucznia`= $id_ucznia AND `id_nauczyciela`= $belfer_id and `przedmiot`= $przedmiot_id and `rok`= $rok and `sem`= '$semestr' and `id_efekt`= $id_efekt";   
                                                          $key1 = 'efekty'. $id_ucznia.'[]';
                                                          $q5 = $conn->query($sql5);                  
                                                          if ($q5->num_rows > 0) {                                                                
                                                            echo "<input class='form-check-input' type='checkbox' name='$key1' value='".$q4_row['id']."' id='".$q4_row['id']."' checked>";
                                                          }else {
                                                            echo "<input class='form-check-input' type='checkbox' name='$key1' value=".$q4_row['id']." id=".$q4_row['id'].">";
                                                          }
                                                          echo "<label class='form-check-label' for=".$q4_row['id'].">". $q4_row['efekt'] ."</lavel>" ;                        
                                                        echo 
                                                        "</div>";
                                                    }                                                   
                                                  ?>                                           
                                            </div>
                                          <?php 
                                          } ?> 
                                      </div>

                                      <!-- WNIOSKI---------------------------------- -->
                                      <div class="col-4 bg-body-secondary p-2">
                                          <h5 class="bg-dark text-center text-info">WNIOSKI</h5>
                                          <p class="px-1 fw-bolder">Wnioski do dalszej pracy:</p>                                        
                                          <!-- Lista wnioskow -->                                         
                                          <?php
                                          $q4 = $conn->query("SELECT * FROM ocena");                  
                                          if ($q4->num_rows > 0) 
                                          {                                             
                                            ?>                                    
                                            <div class='form-check'>                                                    
                                                  <?php
                                                    while($q4_row = $q4->fetch_assoc()) 
                                                    { 
                                                        $id_oceny = $q4_row['id'];
                                                        echo "
                                                        <div class='form-check'>";    
                                                          // sprawdzenie czy jest zaznaczona opja
                                                          $sql5 = "SELECT * FROM `wystawione_wnioski` WHERE `id_ucznia`= $id_ucznia AND `id_nauczyciela`= $belfer_id and `przedmiot`= $przedmiot_id and `rok`= $rok and `sem`= '$semestr' and `id_oceny`= $id_oceny";                                                                                                                    
                                                          $key2 = 'wnioski'. $id_ucznia.'[]';
                                                          $q5 = $conn->query($sql5);                  
                                                          if ($q5->num_rows > 0) {                                                                
                                                            echo "<input class='form-check-input' type='checkbox' name='$key2' value='".$q4_row['id']."' id='".$q4_row['id']."' checked>";
                                                          }else {
                                                            echo "<input class='form-check-input' type='checkbox' name='$key2' value=".$q4_row['id']." id=".$q4_row['id'].">";
                                                          }
                                                          echo "<label class='form-check-label' for=".$q4_row['id'].">". $q4_row['nota'] ."</lavel>" ;                        
                                                        echo 
                                                        "</div>";
                                                    }                                                   
                                                  ?>                                           
                                            </div>
                                          <?php 
                                          } ?> 
                                      </div> 
                                      
                                  </div>
                                </div>
                              </div>
                            </div>
                      </div>
                  <?php  
                  } 
                  ?>
              </div>
              <div class="align-bottom p-2 text-end">
                  <button type="submit" name="saveOceny" class="btn btn-primary" onclick="set_submit();">Zapisz</button>
              </div>    
              </form>
            <?php              
            } ?>
        </div>
        </div>
    </div>
  <?php 
  }  
  ?>



    <script>
      function getCookie(cookiename) {
        // Get name followed by anything except a semicolon
        var cookiestring=RegExp(cookiename+"=[^;]+").exec(document.cookie);
        // Return everything after the equal sign, or an empty string if the cookie name not found
        return decodeURIComponent(!!cookiestring ? cookiestring.toString().replace(/^[^=]+./,"") : "");
      }

      function resetCookies(){          
          document.cookie = 'klasa=0';
      }

      function f_kl(kl) {
        var klaska = kl;
        document.getElementById('v_kl').textContent = kl; 
        document.cookie = 'klasa='+kl;
        console.log(kl);  
        return                  
      }


      function dodajNote() {        
        var txt = document.getElementById("ocena").value;
        var ul = document.getElementById("list");
        var li = document.createElement("li");
        var children = ul.children.length + 1
        li.setAttribute("id", "el"+children)
        li.appendChild(document.createTextNode(txt));
        ul.appendChild(li);
      }

      function logout(){  
        unset($_SESSION["login"]);        
        window.location.href = 'index.php';        
      }

      function set_submit(){
        sub = true;
      }

      function val(){
        if (sub == true) 
          return true;
        else 
          return false;
      }

      
      
    </script>

</body>

</html>