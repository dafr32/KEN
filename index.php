<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">

<head>
  <?php 
    session_start();    
    require "connect.php";
    include "head.php";
    if (isset($_SESSION["loginFail"]) && $_SESSION["loginFail"] === true) {
      echo "<script>
              const loginFail = true;
            </script>";
    } else {
      echo "<script>
              const loginFail = false;
            </script>";
    }
    $_SESSION["loginFail"] = false;
  ?>
  <title>KEN - IT</title>
</head>

<body class="start" onload="showLoginForm('start')" id="bodyStart">
  <?php     
    if ( !isset($_SESSION['login']) && !isset($_SESSION['correct']))  {
      $txt = "podaj hasło...";
    } else {
      if($_SESSION['correct']='false'){
        $txt = "złe hasło !!!";
      }
    }
  ?>

  <header>    
    <div class="container-fluid bg-trans-color" >
        <div class="d-flex align-items-center border-bottom">                                   
          <div class="logo me-1">
            <img src="images/LO4_Logo.svg" class="mb-2">
          </div>        
          <div class="">
            <h4>IV LO im.KEN w Bielsku-Białej</h4>
            <p>System zarządzania informacją</p>
          </div>                
        </div>
    </div>    
    <img src="images/logo.png" class="logo3" alt="">
  </header>
    
  
  <section class="home">
      <div class="container" style="position:relative; z-index:1" >
        <div class="row">
          <div class="col-sm-12 col-lg-6 d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
            <div class="panel">
              <div class="karta d-flex ">		
                  <div id="loginFail" class=""><h2 class="text-red">Nieprawidłowe hasło !!!</h2></div>
                  <div class="menu d-flex flex-column pt-5">                      				
                      <button class="btn btn-primary" onclick="showLoginForm('Dyrektor')">Dyrektor</button>
                      <button class="btn btn-primary" onclick="showLoginForm('Nauczyciel')">Nauczyciel</button>
                      <button class="btn btn-primary" onclick="showLoginForm('Pedagog')">Pedagog</button>
                      <button class="btn btn-primary" onclick="showLoginForm('Sekretariat')">Sekretariat</button>
                  </div>                  
                  <form action="login.php" method="POST" id="login-form" class="form"> 
                        <?php    
                          $result = $conn->query("SELECT ID, Imie, Nazwisko FROM Nauczyciele WHERE aktywne=1 ORDER BY Nazwisko");
                          if ($result->num_rows > 0) {
                            $_SESSION['users'] = [];
                            while($row = $result->fetch_assoc()) {
                              $_SESSION['users'][] = $row;
                            }
                          }                          
                        ?>                   
                        <h2 id="title"></h2>
                        <input type="text" name="typ" id="typ" hidden>
                        <label id="lab-login" for="login" class="lab text-left small">Nazwisko i imię:</label>
                        <select id="login" name="user" class="p-2 form-select" required>
                            <option value="-- wybierz imię i nazwisko -- " disabled></option>
                            <?php
                              foreach ($_SESSION['users'] as $index => $user) {
                                echo "<option value='{$index}'>{$user['Nazwisko']} {$user['Imie']}</option>";
                              }
                            ?>
                        </select>
                        <label for="password" id="labHaslo" >Hasło</label>
                        <input type="password" class="form-control text-left" id="password" name="password" placeholder="podaj hasło..." required>
                        <button type="submit" class="btn btn-danger" name="submitLogin" id="submitLogin" onclick="login()">Zaloguj</button>
                  </form>                                
              </div>              
            </div>
          </div>
          <div class="col-sm-12 col-lg-6 pe-5" style="padding-top:15%; padding-left:15%">
            <div> 
              <img src="images/logo-large.png" class="logo2" alt="">     
              <div class="pageTitle">                
                <h2 class="mb-3 font-weight-normal text-white">Wewnątrzszkolny System IT</h2>
                <h4 class="text-white">IV LO im KEN w Bielsku-Białej</h4>
              </div>        
            </div>
          </div>
        </div>
      </div>     
  </section>

  <div class="mt-auto pt-3 border-top text-muted small stopka" >projekt i wykonanie © Dariusz Frączkiewicz, 2023</div>    
    
    <script>
        function showLoginForm(userType) {
            const karta = document.querySelector('.karta');
            const loginForm = document.getElementById('login-form');
            const title = document.getElementById('title');            
            const labLogin = document.getElementById('lab-login');             
            const login = document.getElementById('login'); 
            const labHaslo = document.getElementById('labHaslo');
            const haslo = document.getElementById('password');
            const but = document.getElementById('submitLogin');
            const typ =  document.getElementById('typ');  
            const idFailLogin = document.getElementById('loginFail');

            if (userType === 'start') {              
              if (loginFail === true) {
                idFailLogin.classList.add('show');
                loginFail = false;                
              } else {
                idFailLogin.classList.remove('show');
                loginFail = false;                
              }
            } else {
              idFailLogin.classList.remove('show');
            }
            
            loginForm.classList.remove('show');

            setTimeout(() => {
                if (userType === 'Dyrektor' || userType === 'Pedagog' || userType === 'Sekretariat' ) {                                        
                    labLogin.style.display = 'none';
                    login.style.display = 'none'; 
                    labHaslo.style.display = 'block';  
                    haslo.style.display = 'block';  
                    but.style.display = 'block';                                         
                    title.textContent = userType;
                    typ.value = userType;                                        
                } else if (userType === 'Nauczyciel') {
                    title.textContent = userType;
                    labLogin.style.display = 'block';
                    login.style.display = 'block';
                    labHaslo.style.display = 'block';  
                    haslo.style.display = 'block';  
                    but.style.display = 'block';                      
                    typ.value = userType;
                }else {
                    labLogin.style.display = 'none';
                    login.style.display = 'none';  
                    labHaslo.style.display = 'none';  
                    haslo.style.display = 'none';  
                    but.style.display = 'none'; 
                    title.textContent = "";
                }   
                                
                loginForm.classList.add('show');
                
                setTimeout(() => {
                    // karta.style.backgroundColor = 'white';
                }, 500);
            }, 500);
        }

        function login() {
            const login = document.getElementById('login').value;
            const password = document.getElementById('password').value;            
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>

</html>