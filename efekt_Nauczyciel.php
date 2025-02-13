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

    <script>
        var sub = false;
        // Funkcja ustawiająca postęp na pasku
        function setProgress(id_ucznia, value) {
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
    
</head>
<?php

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


    // zmiana klasy 
    if (isset($_GET['submit_kl'])){
        $klasa = $_GET['submit_kl'][4];
        $rocznik = substr($_GET['submit_kl'], 0, 4);
        $_SESSION["klasa"] = $klasa;        
        $_SESSION["rocznik"] = $rocznik;        
    }elseif(!isset($_SESSION["klasa"])) {
        $_SESSION["klasa"] = "A";
        $_SESSION["rocznik"] = $rokcznik1;
    }

    $klasa = $_SESSION["klasa"];
    $rocznik = $_SESSION["rocznik"];
    
    // nazwa przedmiotu 
    if (isset($_POST["przedmiot"])) {
        $przedmiot_id = $_POST["przedmiot"];
        
        $sql = "SELECT * FROM Przedmioty WHERE ID = $przedmiot_id";                    
        $resP = $conn->query($sql);
        $rowP = $resP->fetch_assoc();

        $przedmiot = $rowP["przedmiot"];
        $_SESSION["przedmiotN"] = $przedmiot;
        $_SESSION["przedmiot"] = $przedmiot_id;               
    }
    
    if(isset($_SESSION["przedmiot"])) $przedmiot_id = $_SESSION["przedmiot"];
    if(isset($_SESSION["przedmiotN"])) $przedmiot = $_SESSION["przedmiotN"];  
?>
<body class="site" id="efektPedagog">  

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

    <main>
        <div class="container-fluid px-5 py-3 my-3 bg-light rounded-3" id="profil" >        
            <div class="container d-flex justify-content-between">        
                <div class="p-1">
                    <h1><?php echo $belfer; ?></h1>
                    <h3><?php echo $przedmiot; ?></h3>
                    <div class="d-flex mt-3">
                        <div class="d-flex flex-column me-3">
                            <label class="small">ROK SZKOLNY</label>
                            <input type="text" name="rok" width='4' size='4' value="<?php echo $rokSzk;?>" disabled>
                        </div>
                        <div class="d-flex flex-column me-3">
                            <label class="small">SEMESTR</label> 
                            <input type="text" name="semestr" value="<?php echo ($semestr == 1) ? 'pierwszy' : 'drugi' ?>" disabled>                                                              
                        </div>                
                    </div>
                </div>
                    
                <!-- KLASY -->    
                <div class="col p-1 d-flex justify-content-end">
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
                    <form name="frm_klasy" class="d-flex align-items-center" action="efekt_Nauczyciel.php" method="GET">
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
                    </form>
                </div>
            </div>
        </div>


    <!-- Lista uczniów z klasy   -->
        <div class="container d-flex flex-column mt-2 rounded-3">
            <div class="p-1 mb-2 header-klasa border-bottom" >
                <h2>Klasa <span id="v_kl">
                    <?php 
                        $rocznik1 = $rokSzk - $rocznik - $rok + 1;
                        echo $rocznik1.$_SESSION['klasa']; 
                    ?></span> 
                    <?php
                    if (isset($_SESSION['statusZapisuOceny'])) {
                        echo "<span class='red'>". $_SESSION['statusZapisuOceny']."</span>";
                        unset($_SESSION['statusZapisuOceny']);
                    }
                    ?>
                </h2>
            </div>
            <div class="mt-2">
                <div class="container">
                    <?php 
                    //Uczniowie zapisani na rok Szkolny 
                    $checked = "";
                    $sql = "SELECT * FROM `efektywnosc__Uczniowie` INNER JOIN efektywnosc__UczniowieOpinia ON efektywnosc__Uczniowie.ID = efektywnosc__UczniowieOpinia.id_ucznia 
                            WHERE efektywnosc__Uczniowie.rocznik = $rocznik AND efektywnosc__Uczniowie.klasa = '$klasa' AND efektywnosc__UczniowieOpinia.rokSzk = $rokSzk ";                                                
                    // echo $sql;
                    $result1 = $conn->query($sql); 
                    $statusStudents = [];                
                    if ($result1->num_rows > 0) {  ?>
                        <!-- Uczniowie               -->
                        <form action="savelist.php" method="POST" onsubmit="return val()" id="userForm">
                            <div class='accordion accordion-flush' id='accordionEfekt'>       
                                <?php      
                                while($rowUser = $result1->fetch_assoc()) {
                                    $id_ucznia = $rowUser['ID'];
                                    $imie = $rowUser["imie"];
                                    $nazw = $rowUser["nazwisko"]; 
                                    $markStatus = 1;
                                    ?> 
                                    <div class='accordion-item'>
                                        <h2 class='accordion-header'>                                
                                            <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse<?php echo $id_ucznia?>' aria-expanded='true' aria-controls='collapse<?php echo $id_ucznia?>'>
                                                <?php    
                                                    echo  "<span id='studentName$id_ucznia' >$nazw $imie</span>";                                     
                                                ?>
                                            </button>
                                        </h2>                                                                                  
                                        <div id='collapse<?php echo $id_ucznia?>' class='accordion-collapse collapse' aria-labelledby='heading<?php echo $id_ucznia?>' data-bs-parent='#accordionEfekt'>
                                            <div class='accordion-body'>
                                                <div class="container ">
                                                        <div class="row">
                                                            <div class="col-6 my-3">
                                                                <!-- PROGRESSBAR  -->
                                                                <?php  
                                                                    $stanP = false;                                      
                                                                    $sql = "SELECT * FROM `efektywnosc__UczniowieOcena`
                                                                            WHERE id_ucznia=$id_ucznia AND `id_nauczyciela`=$belfer_id AND `przedmiot`=$przedmiot_id AND `rokSzk` = $rokSzk AND semestr = $semestr";                                           
                                                                    $result = $conn->query($sql);                                                          
                                                                    if ($result->num_rows > 0) { 
                                                                        $stanP = true;
                                                                        $row = $result->fetch_assoc();                                                                                  
                                                                        $ocena = $row['ocena'];                                          
                                                                        $uzasadnienie = $row['uzasadnienie'];                                                                                                                              
                                                                    } else {    
                                                                        $markStatus = 0;
                                                                        $ocena = 0;
                                                                        $uzasadnienie = "";                                          
                                                                    }                                        
                                                                ?>
                                                                <h5> Ocena efektywności pomocy psychologiczno-pedagogicznej</h5>
                                                                <div class="progress mt-4">                                            
                                                                    <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" <?php echo "id='myProgressBar$id_ucznia' " ?>></div>                                            
                                                                    <?php echo "<input type='hidden' id='progress$id_ucznia' name='progress$id_ucznia' value='$ocena'>"; ?> 
                                                                </div>
                                                                <div class="row my-4 text-end">
                                                                    <div class="offset-1 col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 1)'" ?> >1</button></div>
                                                                    <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 2)'" ?> >2</button></div>
                                                                    <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 3)'" ?> >3</button></div>
                                                                    <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 4)'" ?> >4</button></div>
                                                                    <div class="col"><button class="btn btn-primary" <?php echo "onclick='setProgress($id_ucznia, 5)'" ?> >5</button></div>                                            
                                                                </div>   
                                                                <?php
                                                                    echo "<script>setProgress($id_ucznia, $ocena)</script>";
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
                                                                $sql = $conn->query("SELECT * FROM efektywnosc__ListaFormy");                  
                                                                if ($sql->num_rows > 0) { ?>                                    
                                                                    <div class='form-check'>                                                    
                                                                        <?php
                                                                            $stanF = false;
                                                                            while($q4_row = $sql->fetch_assoc()) 
                                                                            { 
                                                                                $id_formy = $q4_row['id'];
                                                                                echo "
                                                                                <div class='form-check'>";    
                                                                                    // sprawdzenie czy jest zaznaczona opja
                                                                                    $sql5 = "SELECT * FROM `efektywnosc__UczniowieFormy` 
                                                                                            WHERE `id_ucznia`=$id_ucznia AND `id_nauczyciela`=$belfer_id AND `przedmiot`=$przedmiot_id AND `rokSzk` = $rokSzk AND semestr = $semestr AND `id_formy` = $id_formy";                                                                                     
                                                                                    $key2 = 'formy'. $id_ucznia.'[]';
                                                                                    $q5 = $conn->query($sql5);                  
                                                                                    if ($q5->num_rows > 0) {   
                                                                                        $stanF = true;                                                             
                                                                                        echo "<input class='form-check-input' type='checkbox' name='$key2' value='".$q4_row['id']."' id='f".$q4_row['id']."' checked>";
                                                                                    }else {                                                                                                                                                                                
                                                                                        echo "<input class='form-check-input' type='checkbox' name='$key2' value=".$q4_row['id']." id='f".$q4_row['id']."' >";
                                                                                    }
                                                                                    echo "<label class='form-check-label' for='f".$q4_row['id']."'>". $q4_row['element'] ."</lavel>" ;                        
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
                                                                $q4 = $conn->query("SELECT * FROM efektywnosc__ListaEfekty");                  
                                                                if ($q4->num_rows > 0) { ?>                                    
                                                                    <div class='form-check'>                                                    
                                                                        <?php
                                                                            $stanE = false;
                                                                            while($q4_row = $q4->fetch_assoc()) 
                                                                            { 
                                                                                $id_efekt = $q4_row['id'];
                                                                                echo "
                                                                                <div class='form-check'>";    
                                                                                // sprawdzenie czy jest zaznaczona opja
                                                                                $sql5 = "SELECT * FROM `efektywnosc__UczniowieEfekty` 
                                                                                        WHERE `id_ucznia`=$id_ucznia AND `id_nauczyciela`=$belfer_id AND `przedmiot`=$przedmiot_id AND `rokSzk` = $rokSzk AND semestr = $semestr AND `id_efekt` = $id_efekt ";                                              
                                                                                $key1 = 'efekty'. $id_ucznia.'[]';
                                                                                $q5 = $conn->query($sql5);                  
                                                                                if ($q5->num_rows > 0) {   
                                                                                    $stanE = true;                                                                                                                                                 
                                                                                    echo "<input class='form-check-input' type='checkbox' name='$key1' value='".$q4_row['id']."' id='E".$q4_row['id']."' checked>";
                                                                                }else {                                                                                    
                                                                                    echo "<input class='form-check-input' type='checkbox' name='$key1' value=".$q4_row['id']." id='E".$q4_row['id']."'>";
                                                                                }
                                                                                echo "<label class='form-check-label' for='E".$q4_row['id']."'>". $q4_row['element'] ."</lavel>" ;                        
                                                                                echo 
                                                                                "</div>";
                                                                            }                                                   
                                                                        ?>                                           
                                                                    </div>
                                                                <?php 
                                                                } ?> 
                                                            </div>

                                                            <!-- Wnioski---------------------------------- -->
                                                            <div class="col-4 bg-body-secondary p-2">
                                                                <h5 class="bg-dark text-center text-info">Wnioski</h5>
                                                                <p class="px-1 fw-bolder">Wnioski do dalszej pracy:</p>                                        
                                                                <!-- Lista wnioskow -->                                         
                                                                <?php
                                                                $q4 = $conn->query("SELECT * FROM efektywnosc__ListaWnioski");                  
                                                                if ($q4->num_rows > 0) { ?>                                    
                                                                    <div class='form-check'>                                                    
                                                                        <?php
                                                                        $stanW = false;
                                                                        while($q4_row = $q4->fetch_assoc()) 
                                                                        { 
                                                                            $id_wniosek = $q4_row['id'];
                                                                            echo "
                                                                            <div class='form-check'>";    
                                                                                // sprawdzenie czy jest zaznaczona opja
                                                                                $sql5 = "SELECT * FROM `efektywnosc__UczniowieWnioski` 
                                                                                        WHERE `id_ucznia`=$id_ucznia AND `id_nauczyciela`=$belfer_id AND `przedmiot`=$przedmiot_id AND `rokSzk` = $rokSzk AND semestr = $semestr AND `id_wniosek` = $id_wniosek";                                              
                                                                                $key2 = 'wnioski'. $id_ucznia.'[]';
                                                                                $q5 = $conn->query($sql5);                  
                                                                                if ($q5->num_rows > 0) {   
                                                                                    $stanW = true;                                                             
                                                                                    echo "<input class='form-check-input' type='checkbox' name='$key2' value='".$q4_row['id']."' id='W".$q4_row['id']."' checked>";
                                                                                }else {
                                                                                    $markStatus = false;
                                                                                    echo "<input class='form-check-input' type='checkbox' name='$key2' value=".$q4_row['id']." id='W".$q4_row['id']."'>";
                                                                                }
                                                                                echo "<label class='form-check-label' for='W".$q4_row['id']."'>". $q4_row['element'] ."</lavel>" ;                        
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
                                        <?php 
                                            $statusStudents[] = [$id_ucznia, $stanW, $stanE, $stanF, $stanP];                                        
                                        ?>
                                    </div>
                                <?php  
                                } ?>
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
    </main>
    <?php include "footer.php"; ?>

    <script>
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

        let jsVariable = <?php echo json_encode($statusStudents); ?>;
        jsVariable.forEach((student, index) => {
            let allTrue = student.slice(1, 5).every(value => value === true);           
            let kolor = allTrue ? 'yellow' : 'red';
            let ob = document.getElementById('studentName'+student[0]);
            ob.classList.add(kolor);
            console.log(`Student ${student[0]}: Kolor - ${kolor}`);
        });                      

    </script>    
</body>

</html>
