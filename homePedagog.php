<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">

<head>
<?php
    session_start();    
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Pedagog"){
        header('Location: index.php');
    }
    require "connect.php";
    include "head.php";
?>   
    <title>Wewnątrzszkolny System IT</title>
</head>
<?php 
    // Odczyt roku i miesiąca
    $sql = "SELECT * FROM RokSettings";
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {   
        $row = $result->fetch_assoc();               
        $rokSzk = $row["rokSzk"];
        $semestr = $row["semestr"];                
        
        $_SESSION['rokSzk'] = $rokSzk; 
        $_SESSION['semestr'] = $semestr;    
    }

    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    $teacher = $belfer;
    $teacher_id = $belfer_id;
?>
<body id="site1" class="site">    
    <header class="container-fluid border-bottom">
        <div class="container d-flex justify-content-center align-items-center top1 ">            
            <div class="d-flex align-items-center mb-lg-0 me-lg-auto text-decoration-none">
                <a href="/"><img src="images/LO4_Logo.svg" class="logo"></a>
                <div class="header-left">
                    <h1 class="fs-4">Nadgodziny</h1>
                    <h2 class="fs-5">IV LO im KEN w Bielsku-Białej</h2>
                </div>
            </div>
            <div class="text-end">    
                <a href="home.php"><button type="button" class="btn btn-primary">Powrót</button></a>              
                <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
            </div>            
        </div>
    </header>

    <div class="container-fluid p-3 mb-2 bg-primary bg-gradient text-white border-bottom" id="profil">
        <div class="container">
            <div class="d-flex py-5 justify-content-between">                                
                <div class="d-flex flex-column ">
                    <h1><?php echo $teacher; ?></h1> 
                </div>                   
                <div>                
                    <form id="changePassword" action="login.php" method="POST" class="d-flex mt-3">                    
                        <div class="d-flex">
                            <input type="text" name="user" value="<?php echo $belfer_id ?>" hidden>
                            <div class="mx-2">                            
                                <input type="password" name="new_password1" placeholder="Nowe hasło" class="p-2 text-left">
                            </div>
                            <div class="mx-2">
                                <input type="password" name="new_password2" placeholder="Powtórz nowe hasło" class="p-2 text-left">
                            </div>
                            <div class="mx-2">
                                <button class="btn btn-warning btn-block" name="submitNewPassword" type="submit" for="changePassword">Zmień hasło</button>                        
                            </div>
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

                <div class="col-4 wow fadeIn" >
                    <form action="efektywnosc.php" method="POST" class="">
                        <div class="card h-100" >
                            <img src="images/home1.jpg" class="card-img-top" alt="..." style="height:230px; width: 100%; object-fit:cover">
                            <div class="card-body">
                                <h4 class="card-title">EFEKTYWNOŚĆ</h4>
                                <p class="card-text">Ocena Efektywności pomocy psychologiczno-pedagogicznej ucznia</p>                                                                                                
                            </div>
                            <div class="card-footer text-end border-top-0">
                            <a href="efekt_Pedagog.php" class="btn btn-primary btn-block">Dalej</a>
                            </div>                              
                        </div>      
                    </form>       
                </div> 
                <div class="col-4 wow fadeInUp hide" data-wow-duration="2s"  data-wow-delay="0.5s">                    
                        <div class="card h-100" >
                            <img src="images/home2.jpg" class="card-img-top" alt="..." style="height:230px; width: 100%; object-fit:cover">
                            <div class="card-body">
                                <h4 class="card-title">NAGRODY</h4>
                                <p class="card-text">Wybór uczniów do nagród na zakończenie roku szkolnego</p>                                
                            </div>
                            <div class="card-footer text-end border-top-0">
                                <a href="#" class="btn btn-primary btn-block">Dalej</a>
                            </div>  
                        </div>           
                </div> 

            </div>
        </div>
    </main>
    <?php include "footer.php"; ?>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
            
            var changePassDiv = document.getElementById('changePassDiv');
            // console.log(changePass);
            if (changePass == true) {
                changePassDiv.classList.remove('hide');                
            }else {
                changePassDiv.classList.add('hide');                
            } 
            changePass = false;        

          });
        
        
    </script>
</body>
</html>