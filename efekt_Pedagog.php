<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html lang="pl">

<head>
<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Pedagog"){
        header('Location: index.php');
    }
    require "connect.php";   
    include "head.php";
?>   
    <title>Wewnątrzszkolny System IT</title>
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

<body class="site h-100 d-flex flex-column" id="efektPedagog">  
    <?php   
        // zmiana roku szkolnego 
        if (isset($_POST['changeRokSzk'])){
            $sql = "UPDATE `efektywnosc__AktywnyOkres` SET `rokSzk`='". $_POST["rokSzk"]."',`semestr`='". $_POST["semestr"]."' WHERE 1";
            $conn->query($sql);
        }


        // Aktywny okres 
        $sql = "SELECT * FROM `efektywnosc__AktywnyOkres`";
        $resB = $conn->query($sql);
        if ($resB->num_rows > 0) { 
            $rowB = $resB->fetch_assoc();
            $rokSzk = $rowB['rokSzk'];
            $semestr = $rowB['semestr'];

            $_SESSION['rokSzk'] = $rokSzk;
            $_SESSION['semestr'] = $semestr;
        }

        $rokSzk = $_SESSION['rokSzk'];
        $semestr = $_SESSION['semestr'];
        $belfer = $_SESSION['belfer'];
        $belfer_id = $_SESSION['belfer_id'];


        // roczniki klas 
        $year = date("Y");
        $month = date("n");
        $rok = 0;
        if($month < 9) $rok = 0;  
        $rokcznik1 = $rokSzk - $rok;
        $rokcznik2 = $rokSzk - $rok - 1;
        $rokcznik3 = $rokSzk - $rok - 2;
        $rokcznik4 = $rokSzk - $rok - 3;       


        if (isset($_POST['changeKlasy'])){
            $checkSql = "SELECT count(*) as count FROM `Klasy` WHERE rokSzk = ".$rokSzk;            
            $result = $conn->query($checkSql);
            $row = $result->fetch_assoc();        
            if ($row['count'] > 0) {                
                $sql = "
                    UPDATE `Klasy` SET 
                        `klasa1oznaczenie` = '". $_POST["litKl1"] ."',
                        `klasa2oznaczenie` = '". $_POST["litKl2"] ."',
                        `klasa3oznaczenie` = '". $_POST["litKl3"] ."',
                        `klasa4oznaczenie` = '". $_POST["litKl4"] ."'
                    WHERE rokSzk = ".$rokSzk;
            } else {                
                $sql = "
                    INSERT INTO `Klasy` (`id`, `rokSzk`, `klasa1oznaczenie`, `klasa2oznaczenie`, `klasa3oznaczenie`, `klasa4oznaczenie`)
                    VALUES (
                        null,
                        ".$rokSzk.",
                        '". $_POST["litKl1"] ."',
                        '". $_POST["litKl2"] ."',
                        '". $_POST["litKl3"] ."',
                        '". $_POST["litKl4"] ."'
                    )
                ";
            }
            $conn->query($sql);          
           
        }


        // zmiana klasy 
        if (isset($_GET['submit_kl'])){
            if ($_GET['submit_kl'] == "all"){
                $klasa = "all";
                $rocznik = $rokcznik4;
            } else {
                $klasa = $_GET['submit_kl'][4];
                $rocznik = substr($_GET['submit_kl'], 0, 4);
            }
            
            $_SESSION["klasa"] = $klasa;        
            $_SESSION["rocznik"] = $rocznik;        
        }elseif(!isset($_SESSION["klasa"])) {
            $_SESSION["klasa"] = "A";
            $_SESSION["rocznik"] = $rokSzk;
        }else
            $klasa = $_SESSION["klasa"];
            $rocznik = $_SESSION["rocznik"];

            $_SESSION['content-admin'] = "efekt_Analiza.php";
        if(!isset($_SESSION['content-admin'])){
            $_SESSION['content-admin'] = "efekt_Analiza.php";
            $klasa = "all";
            $_SESSION["klasa"] = "all";
        }
        
        if(!isset($_SESSION["activeMenu"])){
            $_SESSION["activeMenu"] = "Analiza";
        }

        if (isset($_POST["dodajEfekt"])){
            $sql = "INSERT INTO `efektywnosc__ListaEfekty`(`id`, `element`) VALUES (null, '".$_POST['element']."')";
            $conn->query($sql);
        }
        if (isset($_POST["dodajForme"])){
            $sql = "INSERT INTO `efektywnosc__ListaFormy`(`id`, `element`) VALUES (null, '".$_POST['element']."')";
            $conn->query($sql);
        }
        if (isset($_POST["dodajWniosek"])){
            $sql = "INSERT INTO `efektywnosc__ListaWnioski`(`id`, `element`) VALUES (null, '".$_POST['element']."')";
            $conn->query($sql);
        }
    ?>
    
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
                <a href="homePedagog.php"><button type="button" class="btn btn-primary">Powrót</button></a>              
                <a href="logout.php"><button type="button" class="btn btn-dark">Wyloguj się</button></a>
            </div>            
        </div>
    </header>

    <main>
        <div class="container-fluid px-5 py-3 my-3 bg-light rounded-3" id="profil" >        
            <div class="container">
                <div class="row py-2">
                    <div class="col p-1">
                        <h1><?php echo $belfer; ?></h1>
                        <div class="">
                            <form action="efekt_Pedagog.php" method="POST" class="mt-3" style="width: 300px">
                                <div class="d-flex">
                                    <div class="d-flex flex-column me-3">
                                        <label class="small">ROK SZKOLNY</label>
                                        <input type="text" name="rokSzk" width='4' size='4' value="<?php echo $rokSzk;?>">
                                    </div>
                                    <div class="d-flex flex-column me-3">
                                        <label class="small">SEMESTR</label> 
                                        <select name="semestr">
                                        <option value="1" <?php if ($semestr == 1) echo 'selected'; ?>>pierwszy</option>
                                        <option value="2" <?php if ($semestr == 2) echo 'selected'; ?>>drugi</option>                      
                                        </select>                    
                                    </div >
                                    <div class="">
                                        <button type="submit" name="changeRokSzk" class="w-100 h-100 btn btn-primary me-3 px-3">Zmień</button>
                                    </div>
                                    
                                </div>

                                
                            </form>
                            <?php                        
                            $result = $conn->query("SELECT * FROM `Klasy` WHERE `rokSzk`= $rokSzk" );                        
                            if ($result->num_rows > 0) {                          
                                $rowKl = $result->fetch_assoc(); 
                                $kl1 = ord($rowKl["klasa1oznaczenie"]);      
                                $kl2 = ord($rowKl["klasa2oznaczenie"]);      
                                $kl3 = ord($rowKl["klasa3oznaczenie"]);      
                                $kl4 = ord($rowKl["klasa4oznaczenie"]);      
                            } 
                            ?>
                            <form action="efekt_Pedagog.php" method="POST" class="mt-3">
                                Klasy w roku szkolnym
                                <div class="d-flex mt-3">
                                    <div class="d-flex align-items-center">Klasy 1: <input type="text" size="1" name="litKl1" class="mx-2" value="<?php echo chr($kl1);?>" > </div>
                                    <div class="d-flex align-items-center">Klasy 2: <input type="text" size="1" name="litKl2" class="mx-2" value="<?php echo chr($kl2);?>" > </div>
                                    <div class="d-flex align-items-center">Klasy 3: <input type="text" size="1" name="litKl3" class="mx-2" value="<?php echo chr($kl3);?>" > </div>
                                    <div class="d-flex align-items-center">Klasy 4: <input type="text" size="1" name="litKl4" class="mx-2" value="<?php echo chr($kl4);?>" > </div>
                                    <button type="submit" name="changeKlasy" class="btn btn-primary ms-3">Zapisz</button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                
                    <!-- KLASY -->    
                    <div class="col p-1 d-flex justify-content-end">
                        <form name="frm_klasy" class="d-flex align-items-center" action="efekt_Pedagog.php" method="GET">
                            <div>
                            <!-- klasy 1 -->
                                <div class="row justify-content-start my-1">
                                    <?php       
                                        $kl = 1;                                          
                                        for($i=65; $i<=$kl1; $i++){
                                            echo "<button type='submit' name='submit_kl' value='$rokcznik1".chr($i)."' class='col mr-1 btn btn-danger kl'>$kl".chr($i)."</butoon>";                                
                                        }                        
                                    ?>
                                </div>

                                <!-- klasy 2 -->
                                <div class="row justify-content-start my-1">
                                    <?php       
                                        $kl = 2;                                          
                                        for($i=65; $i<=$kl2; $i++){
                                            echo "<button type='submit' name='submit_kl' value='$rokcznik2".chr($i)."' class='col mr-1 btn btn-info kl'>$kl".chr($i)."</butoon>";                                
                                        }                        
                                    ?>
                                </div>
            
                                <!-- klasy 3 -->
                                <div class="row justify-content-start my-1">
                                    <?php       
                                        $kl = 3;                                          
                                        for($i=65; $i<=$kl3; $i++){
                                            echo "<button type='submit' name='submit_kl' value='$rokcznik3".chr($i)."' class='col mr-1 btn btn-warning kl'>$kl".chr($i)."</butoon>";                                
                                        }                        
                                    ?>
                                </div>

                                <!-- klasy 4 -->
                                <div class="row justify-content-start my-1">
                                    <?php       
                                        $kl = 4;                                          
                                        for($i=65; $i<=$kl4; $i++){
                                            echo "<button type='submit' name='submit_kl' value='$rokcznik4".chr($i)."' class='col mr-1 btn btn-success kl'>$kl".chr($i)."</butoon>";                                
                                        }                        
                                    ?>
                                </div>    
                            </div>  
                            <div  class="h-100">
                                <?php echo "<button type='submit' name='submit_kl' value='all' class='h-100 mx-2 btn btn-primary'>wszyscy</butoon>"; ?>
                            </div>                      
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Submenu    -->
        <div class="p-3 text-bg-dark">
            <div class="container">
                <div class="d-flex justify-content-center" id="side-menu">                    
                    <button class="btn btn-primary" id="Uczniowie">Ucznowie</button>
                    <button class="btn btn-primary mx-3" id="Tabele">Tabele wzorów</button>
                    <button class="btn btn-primary" id="Analiza">Efektywność</button>
                </div>
            </div>
        </div>

        <div class="container-fluid my-3" id="contentContainer">         
            <?php             
            if(isset($_SESSION['content-admin']))
                include $_SESSION['content-admin']; 
            ?>
        </div>
    </main>

    <?php include "footer.php"; ?>

    <script>
    $(document).ready(function() {
        // Funkcja do ustawiania klasy dla ostatnio naciśniętego przycisku
        function setLastClickedButton() {
            var lastClickedButtonId = localStorage.getItem("lastClickedButton");
            if (lastClickedButtonId) {
                $("#" + lastClickedButtonId).removeClass("btn-primary").addClass("btn-warning");
            }
        }

        // Ustaw klasę dla ostatnio naciśniętego przycisku przy ładowaniu strony
        setLastClickedButton();

        $("#side-menu button").on("click", function() {
            $(this).removeClass("btn-primary").addClass("btn-warning");
            // Usuń klasę btn-warning i dodaj klasę btn-primary dla pozostałych przycisków
            $("#side-menu button").not(this).removeClass("btn-warning").addClass("btn-primary");

            var id_file = $(this).attr("id");

            // Zapisz ID ostatnio naciśniętego przycisku do localStorage
            localStorage.setItem("lastClickedButton", id_file);

            $.ajax({
                url: "efekt_" + id_file + ".php",
                type: "GET", // Typ żądania
                success: function(response) {
                    $("#contentContainer").html(response);
                }
            });
        });
    });
</script>
    
</body>
</html>