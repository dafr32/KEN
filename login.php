<?php
session_start();
require "connect.php";

// $typ = $_SESSION["typ"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    

    // zmiana hasła 
    if (isset($_POST['submitNewPassword'])) {
        $new_password1 = $_POST['new_password1']; 
        $new_password2 = $_POST['new_password2']; 
        $typ = $_SESSION["typ"];
        
        if ($new_password1 === $new_password2) {
            $user_id =  $_POST["user"];            
            $hashed_password = password_hash($new_password1, PASSWORD_ARGON2I);

            if ($typ == "Dyrektor" || $typ == "Pedagog" || $typ == "Sekretariat") {                
                $update_sql = "UPDATE Passwords SET haslo = ?, first_login = 0 WHERE typKonta = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ss", $hashed_password, $typ);                
            } else {
                $update_sql = "UPDATE Nauczyciele SET haslo = ?, first_login = 0 WHERE ID = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("si", $hashed_password, $user_id);
            }

            if ($stmt->execute()) {                
                echo "Hasło zostało zaktualizowane.";
                $_SESSION["changePass"] = true;
            } else {
                echo "Błąd aktualizacji hasła: " . $conn->error;
            }
            
            $_SESSION['correct'] = 'true';

            if ($typ == "Dyrektor") {                            
                header('Location: ken_admin.php');
            } elseif ($typ == "Pedagog") {
                header('Location: homePedagog.php');
            } elseif ($typ == "Nauczyciel") {
                header('Location: home_Nauczyciel.php');
            } 
        }
    }


    // Logowanie 
    if (isset($_POST['submitLogin'])) {
        $false_login = true;
        $correct = false;
        $first = false;        
        $_SESSION['correct'] = $correct;

        if (isset($_POST['typ']) && isset($_POST['password'])) {
            $_SESSION['typ'] = $_POST['typ'];
            $typ = $_POST['typ'];
            $password = $_POST["password"];
            $typ = filter_var($typ, FILTER_SANITIZE_SPECIAL_CHARS);

            if ($typ == "Dyrektor" || $typ == "Pedagog" || $typ == "Sekretariat") {
                $q = $conn->prepare("SELECT * FROM `Passwords` WHERE `typKonta` = ? LIMIT 1");
                $q->bind_param("s", $typ);
                $q->execute();
                $result = $q->get_result();
                if ($result->num_rows > 0) {
                    $qrow = $result->fetch_assoc();                    
                    if ($qrow['haslo'] == "ken" && $qrow['first_login'] == 1) {
                        $first = true;
                    } else if (password_verify($password, $qrow['haslo'])) {

                        if ($typ == "Dyrektor") $location = "ken_admin.php";
                        elseif ($typ == "Pedagog") $location = "homePedagog.php";
                        elseif ($typ == "Sekretariat") $location = "ken_admin.php";
                        $_SESSION['belfer_id'] = $typ;
                        $_SESSION['belfer'] = $typ;

                        $correct = true;
                    } else {
                        $_SESSION["loginFail"] = true;
                        $false_login = false;
                    }
                }
            } else if ($typ == "Nauczyciel") {

                // Odczytanie id usera z tablicy sesji 
                if (isset($_SESSION['users'])){
                    $user_id = $_SESSION['users'][$_POST["user"]]['ID'];
                }
                // $user_id = $_POST["user"];
                $q = $conn->prepare("SELECT * FROM Nauczyciele WHERE ID = ?");
                $q->bind_param("i", $user_id);
                $q->execute();
                $result = $q->get_result();
                if ($result->num_rows > 0) {
                    $qrow = $result->fetch_assoc();
                    $belfer = $qrow['Imie'] . " " . $qrow['Nazwisko'];
                    
                    if (password_verify($password, $qrow['haslo'])) {
                        if ($qrow['first_login'] == 1) {
                            $first = true;
                        } else                            
                            $belfer_id = $user_id;
                            $location = "home_Nauczyciel.php";
                            $_SESSION['belfer_id'] = $user_id;
                            $_SESSION['belfer'] = $belfer;

                            $correct = TRUE;
                    } else {
                        $false_login = FALSE;
                        $_SESSION["loginFail"] = true;
                    }                    
                } 
            }             
            if ($first) {   
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function () {
                            var modal = document.getElementById("myModal");
                            modal.style.display = "block";
                        });
                    </script>';
            } elseif ($correct) {
                $_SESSION['correct'] = 'true';
                header('Location:' . $location);
            } else {
                $_SESSION['correct'] = 'false';
                header('Location: index.php');
            }
        }
    }
} 

?>




<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {font-family: Arial, Helvetica, sans-serif; background: #fff; }

        /* The Modal (background) */
        .modal {
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
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
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
<body>
<div id="myModal" class="modal">
    <div class="modal-content  w-50">
        <h2>Zmień hasło</h2>
        <form method="post" action="login.php" class="form">
        <input type="text" name="user" value="<?php echo $user_id ?>" hidden><br>    
        <input type="text" name="typ" value="<?php echo $typ ?>" hidden><br>    
        <input type="password" class="form-control" name="new_password1" placeholder="Nowe hasło" ><br>
        <input type="password" class="form-control" name="new_password2" placeholder="Powtórz nowe hasło" ><br>
        <button type="submit" name="submitNewPassword" class="btn btn-primary">Zmień hasło</button>        
        <button type="button" name="" class="btn btn-primary" onclick="window.location.href='index.php'">Anuluj</button>
        </form>
        
    </div>
</div>

<script>

    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>