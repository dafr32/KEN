<!DOCTYPE html>
<html lang="pl">
 
<head>
    <?php
        session_start();
        // if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        //     header('Location: index.php');
        // }
        require "connect.php";
        include "head.php";

        
    // Odczyt roku i miesiąca
    $sql = "SELECT * FROM RokSettings";
    $result = $conn->query($sql); 
    if ($result->num_rows > 0) {   
        $row = $result->fetch_assoc();                     
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
    
    // Tablica mapowania dni tygodnia
    $daysOfWeek = array(
        "Monday" => "Poniedziałek",
        "Tuesday" => "Wtorek",
        "Wednesday" => "Środa",
        "Thursday" => "Czwartek",
        "Friday" => "Piątek",
        "Saturday" => "Sobota",
        "Sunday" => "Niedziela"
    );

    ?>    
    <title>Wewnątrzszkolny System IT</title>

    <style>
        table {font-size:0.9rem}
        #TableTeacherBody h4 { background-color: #27d0ff9c; border-bottom: 1px solid #ff000036; padding: 4px; }
        #TableTeacherBody { padding: 3px; font-size: 1.5rem}   
        .fr1 { width: 20%}
        .fr2 { width: 40%}
    </style>

</head>

<body id="site1" class="site">    
    <?php include "header1.php"; ?>

    <div class="container-fluid p-3 mb-2 bg-primary bg-gradient border-bottom" id="profil">
    <div class="container">
            <div class="row d-flex py-sm-5 justify-content-between">                                
                <div class="col-sm-12 col-lg-4 flex-column ">
                    <h2><strong><?php echo $teacher; ?></strong></h2> 
                </div>                   
                <div class="col-sm-12 col-lg-8">                
                    <h1 style="color: #0d6efd">Egzaminy maturalne</h1>                    
                </div>
            </div>
        </div>        
    </div>

    <main class="container py-sm-5">
    <h2 class="text-center mb-5">Przydział do komisji egzaminacyjnych</h2>    
        <table id="TableTeacherBody" class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Przedmiot</th>
                    <th class="text-center">Rola</th>
                    <th class="text-center">Sala</th>
                    <th class="text-center">Godzina</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT nazwisko, imie, data, sala, egzaminy__Komisje.rola as r, egzaminy__EgzaminyUstalone.przedmiot, egzaminy__Role.rola, egzaminy__Terminy.godz FROM `egzaminy__Komisje` 
                    INNER JOIN egzaminy__EgzaminyUstalone ON egzaminy__Komisje.idEgzaminu=egzaminy__EgzaminyUstalone.id 
                    INNER JOIN Nauczyciele ON egzaminy__Komisje.idNauczyciela=Nauczyciele.ID 
                    INNER JOIN egzaminy__Terminy ON egzaminy__EgzaminyUstalone.przedmiot=egzaminy__Terminy.przedmiot 
                    INNER JOIN egzaminy__Role ON egzaminy__Komisje.rola=egzaminy__Role.id 
                    WHERE egzaminy__Komisje.idNauczyciela=$belfer_id ORDER BY data";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {                        
                        $dateString = $row['data'] ; // Example date string                        
                        $englishDayOfWeek = date("l", strtotime($dateString)); // Pobranie angielskiego dnia tygodnia
                        if (array_key_exists($englishDayOfWeek, $daysOfWeek)) {
                            $polishDayOfWeek = $daysOfWeek[$englishDayOfWeek]; // Pobranie polskiego dnia tygodnia
                        } else {
                            $polishDayOfWeek = "Nieznany";
                        }
                        $formattedDate = date("j.m.Y", strtotime($dateString));
                        echo "<tr>";
                        echo "<td>$formattedDate (<small>$polishDayOfWeek</small>) </td>";
                        echo "<td>" . $row['przedmiot'] . "</td>";
                        echo "<td class='text-center'>" . $row['rola'] . "</td>";
                        $r = $row['r'];
                        if ( $r == 1 || $r == 2 || $r == 5) {
                            echo "<td class='text-center'>sala: " . $row['sala'] . "</td>";
                            echo "<td class='text-center'>";
                            echo ($row['godz'] == 1) ? "9:00" : "14.00";
                            echo "</td>";
                        } elseif ( $r == 3 || $r == 4 || $r == 6 || $r == 7 ){
                            echo "<td></td>";
                            echo "<td class='text-center'>";
                            echo ($row['godz'] == 1) ? "9:00" : "14.00";
                            echo "</td>";
                        } else {
                            echo "<td></td>"; // Placeholder for empty cell if condition not met
                            echo "<td></td>"; // Placeholder for empty cell if condition not met
                        }
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="text-center">
            <a href="/KEN/files/Procedury - Matura 2024.pdf" class="btn btn-primary">Procedury - Matura 2024</a>
        </div>

    </main>
    <?php include "footer.php"; ?>

    </body>
</html>