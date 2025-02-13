<!DOCTYPE html>
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
    <title>Wewnątrzszkolny System IT</title>

    <style>
        body {font-family: Arial, Helvetica, sans-serif; background: #fff; }

        .form {
            width: 90%;
        }
        #modalPrzedmioty {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            margin:auto;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            color: #000;
        }

        /* Modal Content */
        #modalPrzedmioty .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        #modalPrzedmioty h2 {
            font-size: 1.6rem;
            font-weight: 600;
            text-align: center; 
            margin-bottom: 30px;
        }

        #modalPrzedmioty .form label {
            
        }
        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


</head>
<?php 
    // Odczyt roku i miesiąca
    $sql = "SELECT * FROM RokSettings";
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {   
        $row = $result->fetch_assoc();       
        $miesiac = $row["miesiacRozliczeniowy"];        
        $rokSzk = $row["rokSzk"];
        $semestr = $row["semestr"];
        
        $_SESSION['rokSzk'] = $rokSzk; 
        $_SESSION['miesiac'] = $miesiac;
        $_SESSION["semestr"] = $semestr;
    } else {
        $miesiac = "";
        $_SESSION['miesiac'] = "";
    }

    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    $teacher = $belfer;
    $teacher_id = $belfer_id;

    // Reset hasła 
    if (isset($_SESSION["changePass"]) && $_SESSION["changePass"] == true) {
        echo "<script>
                var changePass = true;
              </script>";
      } else {
        echo "<script>
                var changePass = false;
              </script>";
      }

    $_SESSION["changePass"] = false;

?>
<body id="homeNauczyciel" class="site">    
    <?php include "header1.php"; ?>

    <div class=" container-fluid p-3 mb-2 bg-primary bg-gradient border-bottom" id="profil">
        <div class="container">
            <div class="row d-flex py-sm-5 justify-content-between">                                
                <div class="col-sm-12 col-lg-4 flex-column ">
                    <h2><strong><?php echo $teacher; ?></strong></h2> 
                </div>                   
                <div class="col-sm-12 col-lg-8 passwords">                                                                              
                            <form id="changePassword" action="login.php" method="POST" class="row d-flex mt-3">  
                            
                            <div class="col-sm-12 col-lg-4 px-2">                            
                                <input type="text" name="user" value="<?php echo $belfer_id ?>" hidden>
                                <input type="password" name="new_password1" placeholder="Nowe hasło" class="p-2 text-left">
                            </div>
                            <div class="col-sm-12 col-lg-4 px-2">
                                <input type="password" name="new_password2" placeholder="Powtórz nowe hasło" class="p-2 text-left">
                            </div>
                            <div class="col-sm-12 col-lg-4 px-2">
                                <button class="btn btn-warning btn-block" name="submitNewPassword" type="submit" for="changePassword">Zmień hasło</button>                        
                            </div>
                            </form>                                       
                    
                    <div id="changePassDiv" class="mt-1 hide"><h3 class="text-red">hasło zostało zmienione !!!</h3></div>            
                </div>
            </div>
        </div>        
    </div>

    <main class="mt-5">
        <div class="container">
            <div class="row">

                <!-- Nadgodziny  -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3" >                    
                    <div class="card h-100 " >
                        <img src="images/home2.jpg" class="card-img-top" alt="..." style="height:190px; width: 100%; object-fit:cover">
                        <div class="card-body">
                            <div class="content">
                                <h3 class="card-title">NADGODZINY</h3>
                                <p class="card-text">System rozliczania nadgodzin</p> 
                            </div>                                                           
                        </div>
                        <div class="card-footer text-end border-top-0">
                            <a href="nadgodziny_Nauczyciel.php"><button class="btn btn-primary btn-block">Dalej</button></a>
                        </div>  
                    </div>           
                </div> 

                <!-- Efektywność  -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3  mb-3">
                    <form action="efekt_Nauczyciel.php" method="POST" class="">
                        <div class="card h-100" >
                            <img src="images/home1.jpg" class="card-img-top" alt="..." style="height:190px; width: 100%; object-fit:cover">
                            <div class="card-body">
                                <div class="content">
                                    <h4 class="card-title">EFEKTYWNOŚĆ</h4>
                                    <p class="card-text">Ocena Efektywności pomocy psychologiczno-pedagogicznej ucznia</p>
                                </div>
                                <label class="fw-bold mt-2">Wybierz przedmiot</label>
                                <select id="przedmiot" name="przedmiot" class="form-select" required>
                                    <option value="" disabled selected>-- Wybierz przedmiot --</option>
                                    <?php
                                    $sql="SELECT * FROM Przedmioty ORDER BY przedmiot";      
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value=". $row["ID"].">". $row["przedmiot"]."</opction>";
                                        }
                                    }
                                    ?>
                                </select>                                
                            </div>
                            <div class="card-footer text-end border-top-0">
                                <button class="btn btn-primary btn-block" name="submitE" type="">Dalej</button>
                            </div>                              
                        </div>      
                    </form>       
                </div> 


                <!-- Realizacja programu nauczania  -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">                    
                    <div class="card h-100" >
                        <img src="images/home3.jpg" class="card-img-top" alt="..." style="height:190px; width: 100%; object-fit:cover">
                        <div class="card-body">
                            <div class="content">
                                <h3 class="card-title">PROGRAM</h3>
                                <p class="card-text">Realizacja Programu Nauczania</p> 
                            </div>                                                           
                        </div>
                        <div class="card-footer text-end border-top-0">
                        <a href="#" id="openModal"><button class="btn btn-primary btn-block">Dalej</button></a>
                        </div>  
                    </div>           
                </div> 

                <!-- Egzaminy  -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">                    
                        <div class="card h-100" >
                            <img src="images/egzamin.jpg" class="card-img-top" alt="..." style="height:190px; width: 100%; object-fit:cover">
                            <div class="card-body">
                                <h4 class="card-title">EGZAMIN MATURALNY</h4>
                                <p class="card-text">Przydział do Komisji Egzaminacyjnych</p>                                
                            </div>
                            <div class="card-footer text-end border-top-0">
                                <a href="teacher_Egzaminy.php"><button class="btn btn-primary btn-block">Dalej</button></a>
                            </div>  
                        </div>           
                </div> 

                <!-- Nagrody  -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3" >                    
                        <div class="card h-100" >
                            <img src="images/home2.jpg" class="card-img-top" alt="..." style="height:190px; width: 100%; object-fit:cover">
                            <div class="card-body">
                                <h4 class="card-title">NAGRODY</h4>
                                <p class="card-text">Wybór uczniów do nagród na zakończenie roku szkolnego</p>                                
                            </div>
                            <div class="card-footer text-end border-top-0">
                                <a href="nagrody.php"><button class="btn btn-primary btn-block">Dalej</button></a>
                            </div>  
                        </div>           
                </div> 

            </div>
        </div>
    </main>


<div id="modalPrzedmioty" class="modal">
    <div class="modal-content">
        <h2>Wybierz swoje przedmioty</h2>
        <form method="POST" action="save.php" >
            <?php
            $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE id_Nauczyciela = $belfer_id AND rokSzk = $rokSzk AND semestr = $semestr";
            $result = $conn->query($sql);
            $tabPrzedmioty = [];
            if ($result->num_rows > 0) {                
                while($row = $result->fetch_assoc()){ 
                    array_push($tabPrzedmioty, $row["id_Przedmiotu"]);
                }
            }

            $sql="SELECT * FROM Przedmioty ORDER BY przedmiot";      
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $idP = $row["ID"];
                    $chck = (in_array($idP, $tabPrzedmioty)) ? "checked" : "";
                    echo "<input class='form-check-input' type='checkbox' name='przedmiot[]' value='$idP' id='ch$idP' $chck > <label for='ch$idP'>" . $row["przedmiot"] . "</label> <br />";
                }
            }
            ?>   
            <div class="mt-4">
                <button type="button" name="" class="btn btn-primary" id="closeModal" >Anuluj</button>
                <button type="submit" name="prog_Przedmioty" class="btn btn-primary">Dalej</button>                    
            </div>         
        </form>
        
    </div>
</div>



    <?php include "footer.php"; ?>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
            
            var changePassDiv = document.getElementById('changePassDiv');
            // console.log(changePass);
            if (changePass == true) {
                changePassDiv.classList.remove('hide');                
            } else {
                changePassDiv.classList.add('hide');                
            } 
            changePass = false;        

            var modal = document.getElementById("modalPrzedmioty");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];
            if (btn) {
                btn.onclick = function() {
                    modal.style.display = "block";
                }
                span.onclick = function() {
                    modal.style.display = "none";
                }
            }

        });

            $(document).ready(function(){
                $("#openModal").click(function(){
                    $("#modalPrzedmioty").show();
                });

                $("#closeModal").click(function(){
                    $("#modalPrzedmioty").hide();
                    // modal.style.display = "none";
                });

                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            });

    </script>



</body>
</html>