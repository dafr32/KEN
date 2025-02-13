<?php

    // Nadgodziny funkcje 

 
        

    // --------------------------------------------------------------------------------------------------- 
    //klasa dla okresu rozliczeniowego - panel Dyrektora   
    class tWeek {
        public $id;
        public $data;
        public $D1;
        public $D2;
        public $D3;
        public $D4;
        public $D5;
        public $prevPlan;
        public $ileTygKl4;

        public function __construct($id, $data, $D1, $D2, $D3, $D4, $D5, $zmiana, $ileTygKl4) {
            $this->id = $id;
            $this->data = $data;
            $this->D1 = $D1;
            $this->D2 = $D2;
            $this->D3 = $D3;
            $this->D4 = $D4;
            $this->D5 = $D5;
            $this->prevPlan = $zmiana;
            $this->ileTygKl4 = $ileTygKl4;
        }
    }

    // --------------------------------------------------------------------------------------------------- 
    // klasy dla Nauczyciela 
    // --------------------------------------------------------------------------------------------------- 

    // Godziny planowe - tydzień

    class tPlanowe {
        public $mies;
        public $etat;
        public $D1;
        public $D2;
        public $D3;
        public $D4;
        public $D5;
        public $norma;
        public $nadgodziny;
        public $klasy4;

        public function __construct($mies, $etat, $D1, $D2, $D3, $D4, $D5, $norma, $nadg, $klasy4) {
            $this->mies = $mies;
            $this->etat = $etat;
            $this->D1 = $D1;
            $this->D2 = $D2;
            $this->D3 = $D3;
            $this->D4 = $D4;
            $this->D5 = $D5;
            $this->norma = $norma;
            $this->nadgodziny = $nadg;
            $this->klasy4 = $klasy4;
        }
    }


    // rozliczenia nauczyciela - dzień w tygodniu 

    class tDzien {        
        public $wolne;        
        public $wypracowane;        
        public $dorazne;
        public $indywidualne;
        public $inne;
                
        public function __construct($wolne, $wypracowane, $dorazne, $indywidualne, $inne) {            
            $this->wolne = $wolne;            
            $this->wypracowane = $wypracowane;            
            $this->dorazne = $dorazne;
            $this->indywidualne = $indywidualne;
            $this->inne = $inne;
        }
    }
    
    // rozliczenia nauczyciela - tydzień 

    class tTydzien {
        public $id;
        public $D1;
        public $D2;
        public $D3;
        public $D4;
        public $D5;
        public $etat;
        public $norma;
        public $nadgodziny;
        public $razemZrealizowane;
        public $razemDorazne;
        public $razemIndywidualne;
        public $razemInne;
    
        // Konstruktor klasy
        public function __construct($id, $D1, $D2, $D3, $D4, $D5, $etat, $norma, $nadgodziny, $razemZrealizowane, $razemDorazne, $razemIndywidualne, $razemInne) {
            $this->id = $id;
            $this->D1 = $D1;
            $this->D2 = $D2;
            $this->D3 = $D3;
            $this->D4 = $D4;
            $this->D5 = $D5;
            $this->etat = $etat;
            $this->norma = $norma;
            $this->nadgodziny = $nadgodziny;
            $this->razemZrealizowane = $razemZrealizowane;
            $this->razemDorazne = $razemDorazne;
            $this->razemIndywidualne = $razemIndywidualne;
            $this->razemInne = $razemInne;
        }
    }
                       
    function ileMiesiecy( $tabTygodnie) {
        $m = array();
        foreach ( $tabTygodnie as $t) {
            $miesiac = date('m', strtotime($t->data)); 
            if (!in_array($miesiac, $m)) { 
                $m[] = $miesiac; 
            }
        }
        return count($m);
    }


    function Norma($wiersz){
        $etat = $wiersz["etat"];
        $workDays = array_filter([$wiersz["PN"], $wiersz["WT"], $wiersz["SR"], $wiersz["CZ"], $wiersz["PT"]], function($day) {
            return $day > 0; 
        });      
        if (count($workDays) > 0)                        
            return $etat / count($workDays);          
        else
            return 0;
    }

    function Nadgodziny($wiersz){
        $etat = $wiersz["etat"];
        $suma = $wiersz["PN"] + $wiersz["WT"] + $wiersz["SR"] + $wiersz["CZ"] + $wiersz["PT"];
        // echo "suma godzin:". ($suma - $etat);
        return ($suma - $etat);  
    }

    function Nadgodziny2($wiersz){
        $etat = $wiersz["etat"];
        $suma = $wiersz["D1"] + $wiersz["D2"] + $wiersz["D3"] + $wiersz["D4"] + $wiersz["D5"];
        // echo "suma godzin:". ($suma - $etat);
        return ($suma - $etat);  

    }

    // ************************************************************************ 
    // Odczyt tygodni rozlicznieowych
    // ************************************************************************ 
    function readData($teacher_id) {        
        require "connect.php";    
        $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";
        // echo $sql;
        $result = $conn->query($sql); 
        $ileTyg = $result->num_rows ;                  //$ileTyg - ilość tygodni w okresie rozliczeniowym
        echo "<script> var ileTygOkres = $ileTyg;  </script>";
        global $tabTygodnie;
        $tabTygodnie = array();
        if ($result->num_rows > 0) {             
            while ($row = $result->fetch_assoc())  {                                      
                $rokSzk = $row["rokSzk"];   
                $miesiac = $row["miesiacRozliczeniowy"];
                $setTygodnieKl4 = $row["ileTygodni"];           //ile tygodni do odpracowania
                $_SESSION['rokSzk'] = $rokSzk; 
                $_SESSION['miesiac'] = $miesiac;
                $_SESSION['ileTygKl4'] = $row["ileTygodni"];  
                            
                $tydzien = new tWeek( $row["ID"], $row["DataPoczatkowa"], $row["D1"], $row["D2"], $row["D3"], $row["D4"], $row["D5"], $row["prevPlan"], $row["ileTygodni"]);
                $tabTygodnie[] = $tydzien;            
            }             
        } else {
            $miesiac = "";
            exit;
        }
    
    
    // ************************************************************************ 
    // Odczyt ustalonych godzin planowych z okresu rozliczeniowego Nauczyciela
    // ************************************************************************ 
        
        // Jeżeli jeden miesiąc to odczytaj ostatni zapis godzin w tygodniu lub wyzeruj
        // Jeżeli dwa to odczytaj planowany i poprzedni
        
        // odczytaj miesiąc aktualny, jeśli nie ma to utwórz z poprzedniego lub dodaj 0 
        $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk AND `miesiac`= '$miesiac'";        
        $result = $conn->query($sql);
        if ( $result->num_rows > 0 ) {
            $row1 = $result->fetch_assoc();              
            $tydzien = new tPlanowe(
                $row1["miesiac"],
                $row1["etat"],
                $row1["PN"],
                $row1["WT"],
                $row1["SR"],
                $row1["CZ"],
                $row1["PT"],
                Norma($row1),
                Nadgodziny($row1),
                $row1["kl4"]
            );            
            $tabPlanTygodnie[] = $tydzien;            
        } else {
            // przepisz do bazy liczby z poprzedniego okresu 
            $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` 
                    INNER JOIN Miesiace ON godz_Nauczyciele_Godziny.miesiac = Miesiace.miesiac 
                    WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk  
                    ORDER BY Miesiace.nr DESC 
                    LIMIT 1";  
            // echo $sql;                       
            $result = $conn -> query($sql);
            if ( $result->num_rows > 0 ) {
                $row1 = $result->fetch_assoc();
                $sql2 = "INSERT INTO `godz_Nauczyciele_Godziny`(`ID`, `ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`, `WT`, `SR`, `CZ`, `PT`, `kl4`, `etat`) VALUES (
                            null, $teacher_id, $rokSzk, '$miesiac', {$row1['PN']}, {$row1['WT']}, {$row1['SR']}, {$row1['CZ']}, {$row1['PT']}, {$row1['kl4']}, {$row1['etat']})";
                $result = $conn->query($sql2);                        
                header("Location: nadgodziny_Nauczyciel.php");
            } else {
                //brak poprzednich wpisów
                $sql2 = "INSERT INTO `godz_Nauczyciele_Godziny`(`ID`, `ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`, `WT`, `SR`, `CZ`, `PT`, `kl4`, `etat`) VALUES (
                    null, $teacher_id, $rokSzk, '$miesiac', 0, 0, 0, 0, 0, 0, 18)";
                $result = $conn->query($sql2);                        
                // header("Location: nadgodziny_Nauczyciel.php");
            }        
        }
        
        // zapisz dane tygodni z godzinami planowanymi do tablicy $tabPlanTygodnie    
        global $tabPlanTygodnie;
        $tabPlanTygodnie = array();
        $sql = "SELECT *, Miesiace.miesiac AS mies FROM `godz_Nauczyciele_Godziny` 
                INNER JOIN Miesiace ON godz_Nauczyciele_Godziny.miesiac = Miesiace.miesiac 
                WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk  
                ORDER BY Miesiace.nr DESC 
                LIMIT 2";  
        // echo $sql;
        $result = $conn->query($sql);
        while ($row1 = $result->fetch_assoc()) {          
            $tydzien = new tPlanowe(
                $row1["mies"],
                $row1["etat"],
                $row1["PN"],
                $row1["WT"],
                $row1["SR"],
                $row1["CZ"],
                $row1["PT"],
                Norma($row1),
                Nadgodziny($row1),
                $row1["kl4"]
            );            
            $tabPlanTygodnie[] = $tydzien; 
        }
    

        // odczytanie zapisu godzin Nauczyciela dla danego tygodnia lub przypisanie godzinych planowych
        global $tabTygodnieNauczyciel;
        $tabTygodnieNauczyciel = array();    
        foreach ($tabTygodnie as $tydzien) {
            $idTyg = $tydzien->id;        
            $sql = "SELECT * FROM (`godz_Nauczyciele_Rozliczenie_Tydzien` INNER JOIN godz_TydzienRozliczeniowy ON godz_Nauczyciele_Rozliczenie_Tydzien.id_tydzien=godz_TydzienRozliczeniowy.ID) WHERE `id_nauczyciel`= $teacher_id  AND `id_tydzien` = $idTyg";
            // echo $sql."<br>";
            $result = $conn->query($sql);                
            if ($result->num_rows > 0) {
                // jeśli jest zapis dla tygodnia to odczytaj z bazy 
                $row = $result->fetch_assoc();                        
                $dni = [];            
                for ($i = 1; $i <= 5; $i++) {
                    $dni[] = new tDzien(
                        $row["D${i}_wolne"],
                        $row["D${i}_wypracowane"],
                        $row["D${i}_dorazne"],
                        $row["D${i}_indyw"],
                        $row["D${i}_inne"]
                    );
                }            
                
                $t = new tTydzien(
                    $idTyg,
                    $dni[0],
                    $dni[1],
                    $dni[2],
                    $dni[3],
                    $dni[4],
                    $row["etat"],
                    $row["norma"],                    
                    $row["nadgodziny"],                    
                    $row["razem_nadgodz"],
                    $row["razem_dorazne"],
                    $row["razem_indyw"],
                    $row["razem_inne"]
                );
                
                $tabTygodnieNauczyciel[] = $t;
            }else {
							
                // jeśli nie ma jeszcze wpisu to przypisz dane domyślne z planu
                $dni = [];            
                if ($tydzien->prevPlan == 1){
                    $wypr =     $tabPlanTygodnie[1]; 
                    $etat =     $tabPlanTygodnie[1]->etat;               
                    $norma =    $tabPlanTygodnie[1]->norma; 
                    $nadg =     $tabPlanTygodnie[1]->nadgodziny; 
                } else{
                    //$wypr =     if isset($tabPlanTygodnie[0])$tabPlanTygodnie[0] else 0;
					$wypr = isset($tabPlanTygodnie[0]) ? $tabPlanTygodnie[0] : 0;
                    $etat = isset(    $tabPlanTygodnie[0]->etat ) ? $tabPlanTygodnie[0]->etat : 0 ;               
                    $norma = isset(   $tabPlanTygodnie[0]->norma) ? $tabPlanTygodnie[0]->norma : 0;  
                    $nadg = isset(    $tabPlanTygodnie[0]->nadgodziny) ? $tabPlanTygodnie[0]->nadgodziny : 0; 
                }
                    // echo "zmiana: $tydzien->zmiana ; norma: $norma<br>";           
                for ($i = 1; $i <= 5; $i++) {
                    $dni[] = new tDzien(
                        null,
                         isset($wypr->{"D".$i}) ? $wypr->{"D".$i} : 0,
                        0,
                        0,
                        0
                    );
                }  
                $t = new tTydzien(
                    $idTyg,
                    $dni[0],
                    $dni[1],
                    $dni[2],
                    $dni[3],
                    $dni[4],
                    $etat,
                    $norma,
                    $nadg,
                    0,
                    0,
                    0,
                    0
                );     
                $tabTygodnieNauczyciel[] = $t;      
            }

        }


    // foreach ($tabPlanTygodnie as $tydzien) {
    //     echo "miesiac: " . $tydzien->mies . "<br>";
    //     echo "Etat: " . $tydzien->etat . "<br>";
    //     echo "PN: " . $tydzien->D1 . "<br>";
    //     echo "WT: " . $tydzien->D2 . "<br>";
    //     echo "SR: " . $tydzien->D3 . "<br>";
    //     echo "CZ: " . $tydzien->D4 . "<br>";
    //     echo "PT: " . $tydzien->D5 . "<br>";
    //     echo "norma: " . $tydzien->norma . "<br>";
    //     echo "nadgodziny: " . $tydzien->nadgodziny . "<br>";
    //     echo "Klasy4: " . $tydzien->klasy4 . "<br><br>";
    // }
    
    // foreach ($tabTygodnie as $tydzien) {
    //     echo "id: " . $tydzien->id . "<br>";
    //     echo "Data: " . $tydzien->data . "<br>";
    //     echo "Dzień 1: " . $tydzien->D1 . "<br>";
    //     echo "Dzień 2: " . $tydzien->D2 . "<br>";
    //     echo "Dzień 3: " . $tydzien->D3 . "<br>";
    //     echo "Dzień 4: " . $tydzien->D4 . "<br>";
    //     echo "Dzień 5: " . $tydzien->D5 . "<br>";
    //     echo "prevPlan: " . $tydzien->prevPlan . "<br>";
    //     echo "Ilość tygodni klasy 4: " . $tydzien->ileTygKl4 . "<br>";
    //     echo "<br>";
    // }
    
    // foreach ($tabTygodnieNauczyciel as $tydzien) {
    //     echo "id: " . $tydzien->id . "<br>";
    //     echo "D1: " . $tydzien->D1->wolne . "<br>";
    //     echo "D1 ind: " . $tydzien->D1->indywidualne. "<br>";
    //     echo "D2 ind: " . $tydzien->D2->indywidualne. "<br>";
    //     echo "D3 ind: " . $tydzien->D3->indywidualne. "<br>";
    //     echo "D4 ind: " . $tydzien->D4->indywidualne. "<br>";
    //     echo "norma: " . $tydzien->norma . "<br>";
    //     echo "nadgodziny: " . $tydzien->nadgodziny . "<br>";
    //     echo "Razem zrealizowane: " . $tydzien->razemZrealizowane . "<br>";
    //     echo "Razem dorazne: " . $tydzien->razemDorazne . "<br>";
    //     echo "Razem indywidualne: " . $tydzien->razemIndywidualne . "<br>";
    //     echo "Razem inne: " . $tydzien->razemInne . "<br><br>";
    // }

    // echo "Plan nadgodziny: " .$tabPlanTygodnie[0]->nadgodziny ."<br>";
    // echo "nadgodziny: ". $tabTygodnieNauczyciel[0]->nadgodziny;

    // $tabPlanTygodnie        -  tablica planów na okres 
    // $tabTygodnie            -  tablica tygodni i dni wolnych dyrektora
    // $tabTygodnieNauczyciel  -  tablica godzin wypracowanych przez nauczyciela 
}
