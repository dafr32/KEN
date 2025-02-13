<?php
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false" || $_SESSION["typ"]!="Dyrektor"){
        header('Location: index.php');
    }
    require "connect.php";   
    $_SESSION['content-admin'] = "admin_Efektywnosc.php"; 


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
   

<div class="container-fluid px-5 py-3 my-3 bg-light rounded-3" id="profil" >        
    <div class="container">
        <div class="row py-2">
            <div class="col p-1">
                <h1><?php echo $belfer; ?></h1>
                <form action="ken_admin.php" method="POST" class="d-flex mt-3">
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
                    </div class="">
                    <button type="submit" name="changeRokSzk" class="btn btn-primary px-3">Zmień</button>
                </form>
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
                <div id="form_klasy" class="d-flex align-items-center">
                    <div>
                    <!-- klasy 1 -->
                        <div class="row justify-content-start my-1">
                            <?php       
                                $kl = 1;                                          
                                for($i=65; $i<=$kl1; $i++){
                                    echo "<button type='submit' name='submit_kl' id='$rokcznik1".chr($i)."' class='col mr-1 btn btn-danger kl'>$kl".chr($i)."</butoon>";                                
                                }                        
                            ?>
                        </div>

                        <!-- klasy 2 -->
                        <div class="row justify-content-start my-1">
                            <?php       
                                $kl = 2;                                          
                                for($i=65; $i<=$kl2; $i++){
                                    echo "<button type='submit' name='submit_kl' id='$rokcznik2".chr($i)."' class='col mr-1 btn btn-info kl'>$kl".chr($i)."</butoon>";                                
                                }                        
                            ?>
                        </div>
    
                        <!-- klasy 3 -->
                        <div class="row justify-content-start my-1">
                            <?php       
                                $kl = 3;                                          
                                for($i=65; $i<=$kl3; $i++){
                                    echo "<button type='submit' name='submit_kl' id='$rokcznik3".chr($i)."' class='col mr-1 btn btn-warning kl'>$kl".chr($i)."</butoon>";                                
                                }                        
                            ?>
                        </div>

                        <!-- klasy 4 -->
                        <div class="row justify-content-start my-1">
                            <?php       
                                $kl = 4;                                          
                                for($i=65; $i<=$kl4; $i++){
                                    echo "<button type='submit' name='submit_kl' id='$rokcznik4".chr($i)."' class='col mr-1 btn btn-success kl'>$kl".chr($i)."</butoon>";                                
                                }                        
                            ?>
                        </div>    
                    </div>  
                    <div  class="h-100">
                        <?php echo "<button type='submit' name='submit_kl' id='all' class='h-100 mx-2 btn btn-primary'>wszyscy</butoon>"; ?>
                    </div>                      
                </div>
            </div>

        </div>
    </div>
</div>


<div class="container my-3" id="Efekt-content">             
</div>
    

<script>

    $(document).ready(function() {  
        $("#form_klasy button").on("click", function() {
            var klasa = $(this).attr("id");                             
            $.ajax({
            url: "efekt_Analiza.php",
                type: "GET", // Typ żądania   
                data: {klasa: klasa },         
                success: function(response) {
                    $("#Efekt-content").html(response); 
                }
            });
        });           

    });

        
</script>
    
