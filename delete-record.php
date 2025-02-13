<?php
    session_start();
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        header('Location: index.php');
    }
        
    $rokSzk=$_SESSION['rokSzk'];   
    $semestr = $_SESSION['semestr'];         
    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];    
    $filePHP = $_SESSION["filePHP"];


    $id = $_GET['id'];
    $table = $_GET['table'];        
    include "connect.php";
    if ($table == "prog_PrzedmiotyN"){
        $sql = "DELETE FROM `prog_Realizacja` WHERE przedmiot = $id AND rokSzk = $rokSzk AND semestr = $semestr AND id_nauczyciela = $belfer_id";  
        $conn->query($sql);
        
        $sql = "DELETE FROM `prog_PrzedmiotyN` WHERE id_Przedmiotu = $id AND rokSzk = $rokSzk AND semestr = $semestr AND id_nauczyciela = $belfer_id";
        $conn->query($sql);
        header('Location: '. $filePHP .".php");    
    }elseif ($table == "prog_Realizacja"){
        $sql = "DELETE FROM `prog_Realizacja` WHERE id = $id";  
        $conn->query($sql);    
        header('Location: '. $filePHP .".php");  
    }
    
?>