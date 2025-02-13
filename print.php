<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">   </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Administracja - Wydruki</title>
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
  </style>
</head>

<body class="site" id="adminSite">
    <?php   
      session_start();
      if (!isset($_SESSION['login']) || ($_SESSION['login']=='true' && $_SESSION['typ']!=1)){
        header('Location: index.php');
      }

      require "connect.php";
      $rok = $_SESSION['rok'];
      $semestr = $_SESSION['semestr'];

      $result = $conn->query("SELECT * FROM nauczyciele WHERe id=".$_SESSION['belfer']);
      $row = $result->fetch_assoc();    
      $belfer = $row['nazwisko'] ; 

      if (isset($_POST['settings'])){
        $rok=$_POST['rok'];
        $semestr=$_POST['sem'];
        $_SESSION['rok'] = $rok;
        $_SESSION['semestr'] = $semestr;  
      }

      echo"<script>
            document.cookie = 'klasa=0';
        </script>"; # reset cookies
  ?>

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
                    <a href="admin.php"><button type="button" class="btn btn-primary me-2">Uczniowie</button></a>
                    <!-- <a href="analiza.php"><button type="button" class="btn btn-primary me-2">Efekty</button></a> -->
                    <a href="print.php"><button type="button" class="btn btn-danger me-2">Wydruki</button></a>
                    <a href="nauczyciele.php"><button type="button" class="btn btn-primary me-2">Nauczyciele</button></a>
                    <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-5 py-3 my-3 bg-light rounded-3" id="profil">
        <div class="container">
            <div class="row py-2">
                <div class="col p-1">
                    <h1><?php echo $belfer; ?></h1>
                    <form action="print.php" method="POST" class="d-flex mt-3">
                        <div class="d-flex flex-column me-3">
                            <label class="small">ROK SZKOLNY</label>
                            <input type="text" name="rok" width='4' size='4' value="<?php echo $rok;?>">
                        </div>
                        <div class="d-flex flex-column me-3">
                            <label class="small">SEMESTR</label>
                            <select name="sem">
                                <option value="pierwszy" <?php if ($semestr == 'pierwszy') echo 'selected'; ?>>pierwszy
                                </option>
                                <option value="drugi" <?php if ($semestr == 'drugi') echo 'selected'; ?>>drugi</option>
                            </select>
                        </div>
                        <button type="submit" name="settings" class="btn btn-primary px-3">Zmień</button>
                    </form>
                </div>
                <div class="col text-center ">
                    <h1 class="title">WYDRUKI</h1>
                </div>

            <!-- KLASY -->            
            <div class="col p-1 ">
                <form name="frm_klasy" action="print.php" method="POST">
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
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="bg-secondary text-light">
                    <div class="w-100 bg-dark p-2 text-center">
                        <h3>Klasa <span id="v_kl"><?php echo $ozn_kl; ?></span></h3>
                    </div>
                    <div class="border-1 p-2">
                        <?php  
                  $sql = "SELECT * FROM uczniowie INNER JOIN uczniowie_do_oceny ON uczniowie.id=uczniowie_do_oceny.id_ucznia
                          WHERE uczniowie.klasa = '$kl' AND uczniowie_do_oceny.rok=$rok AND uczniowie_do_oceny.semestr='$semestr' AND rocznik=$rocznik ORDER BY nazwisko";                     
                  $result1 = $conn->query($sql);                  
                  if ($result1->num_rows > 0) 
                  {  
                    echo "<ul id='listaUzytkownikow'>";
                    echo "<li id='0'>Wszyscy</li>";
                    while($row = $result1->fetch_assoc()) 
                    {
                        $id_ucznia = $row['id'];
                        $a = $row["imie"];
                        $b = $row["nazwisko"];                         
                        echo "<li id='$id_ucznia'>$b $a </li> ";
                    }
                    echo "</ul>";
                  }
                  ?>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <div class="row" id="printDiv"> </div>
            </div>
        </div>
    </div>
    <?php
  }
  ?>
  <script>
    $(document).ready(function() {
        $("#listaUzytkownikow li").on("click", function() {
            var id_usera = $(this).attr("id");
            $.ajax({
                url: "getdata2.php", // Ścieżka do pliku PHP obsługującego żądanie
                type: "GET", // Typ żądania
                data: {
                    id: id_usera,
                    rocznik: <?php echo $rocznik ?>
                }, // Przekazanie id jako dane do pliku PHP
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