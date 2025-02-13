<?php

  $servername = "localhost";
  $username = "lo4_wp";
  $password = "aiWbPEH3qykk";
  $dbname = "lo4_wp";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed.". $conn->connect_error);
  }
  
  // Set UTF-8 character set
  $conn->set_charset("utf8");
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>KEN - absolwenci</title>
</head>

<body class="start" onload="showLoginForm('start')" id="bodyStart">
 
  <header>    
    <div class="container-fluid bg-trans-color" >
        <div class="d-flex align-items-center border-bottom">                                   
          <div class="logo me-1">
            <img src="images/LO4_Logo.svg" class="mb-2">
          </div>        
          <div class="">
            <h4>IV LO im.KEN w Bielsku-Białej</h4>
            <p>Terminy egzaminów maturalnych 2024</p>
          </div>                
        </div>
    </div>    
    <img src="images/logo.png" class="logo3" alt="">
  </header>
    
  
  

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>

</html>