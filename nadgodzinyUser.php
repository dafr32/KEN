<!-- 
    ****************************************************************
    Podstrona Nadgodziny dla Nauczyciela
    ---------------------------------------------
    - HEADER
        - Nazwisko i imię oraz aktualny miesiąc rozliczeniowy ustawiony przez administratora
        - 
    - MAIN
        - includowany plik nadgodziny_User_tydzien.php
    ****************************************************************
 -->
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">
 
<head>
    <?php
        if (session_status() === PHP_SESSION_NONE) { session_start(); }        
        if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){ header('Location: index.php'); }
        require "connect.php";     
        include "head.php";
        $_SESSION["filePHP"] = "nadgodzinyUser";     
    ?>    
    <title>Nadgodziny</title>
    <style>
        .user_godziny label { height: 50px; font-size: 0.9rem }
        .user_godziny label {
            height: 50px;
            font-size: 0.8rem;
            display: flex;
            align-items: flex-end;            
            justify-content: center;            
        }
        .user_godziny input {text-align: center;}
        .table_nadgodziny tbody tr > th, .table_nadgodziny tfoot tr > th {
            text-align: right;
            font-size:0.8rem;
        }
        .table_nadgodziny tbody tr > td {
            text-align:center;
        }
        .tableTydzen th, 
        .tableTydzen td { 
            padding:5px 2px; 
            text-align:center;
            font-size: 0.9rem;
        }


    </style>    
</head>
<?php 
    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];
    // Odczyt miesiąca rozliczeniowego 
    $sql = "SELECT * FROM RokSettings";
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {   
        $row = $result->fetch_assoc();       
        $miesiac = $row["miesiacRozliczeniowy"];
        $setTygodnieKl4 = $row["ileTygodni"]; //ile tygodni do odpracowania
        $rokSzk = $row["rokSzk"];         
        $_SESSION['ileTygKl4'] = $row["ileTygodni"];
        $_SESSION['rokSzk'] = $rokSzk; 
        $_SESSION['miesiac'] = $miesiac;
    } else {
        $miesiac = "";
    }


    // Odczytanie tygodni rozliczeniowych z ustawień okresu
    $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";                                        
    $resTygodnie = $conn->query($sql); 
    if ($resTygodnie->num_rows > 0) {  
        $ileTyg = $resTygodnie->num_rows ;
        echo "<script>
                 var ileTygOkres = $ileTyg;   
            </script>";
    }

    if (!isset($_SESSION["zapis"])) $_SESSION["zapis"]="";
    
    $teacher = $belfer;
    $teacher_id = $belfer_id;
?>

<body id="NadgodzinyUser" > 
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
                <a href="home_Nauczyciel.php"><button type="button" class="btn btn-primary">Powrót</button></a>              
                <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
            </div>            
        </div>
    </header>

    <div class="container-fluid bg-body-tertiary border-bottom" id="profil">
        <div class="container">
            <div class="d-flex py-5">                                
                <div class="d-flex flex-column ">
                    <h1><?php echo $teacher; ?></h1> 
                </div>
                <div class="d-flex flex-column text-center w-25">
                    <label class="small">MIESIĄC ROZLICZENIOWY</label>
                    <div class="rok fs-5 fw-bolder "><?php echo $miesiac; ?></div>
                </div>
                <div class="w-25 text-center">
                    <h1 class="text-red"><?php echo $_SESSION["zapis"]; $_SESSION["zapis"]="" ?></h1> 
                </div>                
            </div>
        </div>        
    </div>


    
    <div class="container-fluid" id="teacherWeeks">
        <?php include "nadgodziny_User_tydzien.php"; ?>
    </div>


    <script src="js/calculateSum.js"></script>

    <script>        
        calculateSum(<?php echo $teacher_id ?>);
    </script>

    <?php include "footer.php"; ?>
</body>

</html>