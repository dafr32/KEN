<!-- 
    ****************************************************************
    Includowana zawartość w pliku nadgodziny_User_tydzien.php dla Nauczyciela
    ---------------------------------------------
    - Formularz
    ****************************************************************
 -->
<?php
    if (session_status() === PHP_SESSION_NONE) { session_start(); }        
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){ header('Location: index.php'); }
    require "connect.php";   
    $setTygodnieKl4 = $_SESSION['ileTygKl4'];      
?>    

<form action="save.php" method="POST" id="TeacherNadgodziny-ID<?php echo $teacher_id ?>" class="elementAccordion">   
    <input type="hidden" id="TeacherID" name="TeacherID" value="<?php echo $teacher_id ?>">                            
    
    <!-- -------------------------------------------------------- -->
    <!-- Tabela ustawień gozin w tygodniu -->
    <!-- -------------------------------------------------------- -->
    <div class="container-fluid py-3" id="godzinyHeader">        
        <?php
        // Odczyt ustalonych godzin z okresu rozliczeniowego 
        $query = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = ? AND `rokSzk` = ? AND `miesiac`= ?";        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $teacher_id, $rokSzk, $miesiac);
        $stmt->execute();
        $resUstalone = $stmt->get_result();     
        if ($resUstalone->num_rows == 0) {  
            //jeśli nie ma zapisu z aktualnego okresu to pobierz ostatni wpis
            $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $teacher_id AND `rokSzk` = $rokSzk ORDER BY `ID` DESC LIMIT 1";                         
            $resUstalone = $conn->query($sql);  
            if ($resUstalone->num_rows == 0)                                
                $setGodziny = FALSE;
            else
                $setGodziny = TRUE;
        } else
            $setGodziny = TRUE;                        
            if ($setGodziny){
                $rowT1 = $resUstalone->fetch_assoc();                
                $d1 = $rowT1["PN"];
                $d2 = $rowT1["WT"];
                $d3 = $rowT1["SR"];
                $d4 = $rowT1["CZ"];
                $d5 = $rowT1["PT"];
                $kl4 = $rowT1["kl4"];
                $etat = $rowT1["etat"];  
            } 
        ?>     
        <!-- plan lekcji Nauczyciela  -->
        <div class="container">
            <div class="row">                
                <div class="col-sm-12 col-lg-6">                                                                    
                    <h4 class="w-100">Plan lekcji </h4>
                    <div class="d-flex">
                        <div class="grid-container2 bg-light-gray me-2 w-50 ">
                            <div class="grid-item1">Ilość godz. na etat</div>
                            <div class="grid-item2"><input type="number" min="0" max="30" id="etat" name="etat" class="form-control text-red" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($etat) ? $etat : 18; ?>" required></div>
                            <div class="grid-item1 text-center">PN</div>
                            <div class="grid-item2"><input type="number" min="0" max="12" id="d1" name="PN" class="form-control day" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($d1) ? $d1 : 0; ?>"> </div>
                            <div class="grid-item1 text-center">WT</div>
                            <div class="grid-item2"><input type="number" min="0" max="12" id="d2" name="WT" class="form-control day" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($d2) ? $d2 : 0; ?>"></div>
                            <div class="grid-item1 text-center">SR</div>
                            <div class="grid-item2"><input type="number" min="0" max="12" id="d3" name="SR" class="form-control day" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($d3) ? $d3 : 0; ?>"></div>
                            <div class="grid-item1 text-center">CZ</div>
                            <div class="grid-item2"><input type="number" min="0" max="12" id="d4" name="CZ" class="form-control day" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($d4) ? $d4 : 0; ?>"></div>
                            <div class="grid-item1 text-center">PT</div>
                            <div class="grid-item2"><input type="number" min="0" max="12" id="d5" name="PT" class="form-control day" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($d5) ? $d5 : 0; ?>"></div>
                            <div class="grid-item1">w tym w klasach 4</div>
                            <div class="grid-item2"><input type="number" min="0" max="20" id="kl4" name="kl4" class="form-control text-red" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($kl4) ? $kl4 : 0; ?>"></div>
                        </div>

                        <div class="d-flex flex-column">
                            <div class="grid-container2" >                                                     
                                <div class="grid-item text-end">Ilość godzin w tygodniu :</div> 
                                <div class="grid-item text-center bg-warning bold px-4 mb-2" id="ileGodzin"></div>
                                <div class="grid-item text-end">Ilość nadgodzin:</div>
                                <div class="grid-item text-center bg-warning bold mb-2" id="setNadg"></div>
                                <div class="grid-item text-end">Norma dzienna:</div>    
                                <div class="grid-item text-center bg-warning bold" id="setNorma"></div>                                       
                            </div>
                            <div class="mt-5 text-end">                        
                                <button class="btn btn-primary" name="saveUserGodziny" type="submit" for="GodzinyUsera">Zapisz plan</button>                        
                            </div>
                        </div>                
                    </div>
                </div>
                    
                <!-- tabela podsumowująca okres  -->
                <div class="col-sm-12 col-lg-3 user_result">
                    <div class="bg-lightgray  h-100">
                        <h4 class="w-100">Godziny nadliczbowe</h4>                
                        <div class="grid-container2 mx-3 mt-4">
                            <div class="grid-item1 text-end">Ponadwymiarowe</div>
                            <div class="grid-item3 text-center bg-3 bold " id="RazemPonad"></div>
                            <div class="grid-item1 text-end">Zastępstwa</div>
                            <div class="grid-item3 text-center bg-3 bold " id="RazemDorazne"></div>
                            <div class="grid-item1 text-end">Indywidualne</div>
                            <div class="grid-item3 text-center bg-3 bold " id="RazemIndyw"></div>                    
                            <div class="grid-item1 text-end">Inne</div>
                            <div class="grid-item3 text-center bg-3 bold " id="RazemInne"></div>   
                            <div class="grid-item1 text-end table-danger">Razem</div>
                            <div class="grid-item3 text-center bold bg-danger text-white" id="razemGodziny"></div>   
                            <div class="grid-item1 text-end table-danger">Do wypłaty</div>
                            <div class="grid-item3 text-center bold bg-danger text-white" id="wyplata"></div>
                        </div>
                    </div>
                </div>
                

                <!-- tabela podsumowująca klasy 4  -->                   
                <div class="col-sm-12 col-lg-3 user_result <?php if ($kl4 == 0) echo "hide" ?>">
                    <div class="bg-lightgray h-100">
                        <h4 class="w-100">Do wypracowania - klasy 4</h4>                
                        <div class="grid-container2 mx-3 mt-4">
                            <div class="grid-item1 text-end">Ilość tygodni</div>
                            <div class="grid-item3 text-center bg-3 bold px-3" id="ileTygodniKl4"><?php echo isset($setTygodnieKl4) ? $setTygodnieKl4 : 0; ?></div>
                            <div class="grid-item1 text-end">Razem do wypracowania</div>
                            <div class="grid-item3 text-center bg-3 bold" id="doWypracowania4">0</div>                            
                            
                            <div class="grid-item1 text-end">Dotychczas wypracowane</div> 
                            <div class="grid-item3 text-center bg-3 bold " id="RazemWypracowane4">
                                <?php  
                                // -------------------------------------- 
                                // odczyt dotychczas odpracowanych  
                                $s = "SELECT SUM(`odpracowane`) as suma FROM `godz_Nauczyciele_klasy4` 
                                    INNER JOIN `Miesiace` ON `godz_Nauczyciele_klasy4`.`miesiac` = `Miesiace`.`miesiac` 
                                    WHERE `godz_Nauczyciele_klasy4`.`id_Nauczyciela` = $teacher_id AND `godz_Nauczyciele_klasy4`.`rokSzk` = $rokSzk 
                                    AND `Miesiace`.`nr` < (SELECT `nr` FROM `Miesiace` WHERE `miesiac` = '$miesiac');";
                             
                                $res3 = $conn->query($s); 
                                if ($res3->num_rows > 0) $ro = $res3->fetch_assoc();       
                                echo isset($ro["suma"]) ? $ro["suma"] : 0;                                
                                ?>    
                            </div>                            
                            <div class="grid-item1 text-end">Wypracowane w tym okresie</div>
                            <div class="grid-item3 text-center bg-3 bold" id="wypracowane4">
                                <?php 
                                $s = "SELECT * FROM `godz_Nauczyciele_klasy4` WHERE `rokSzk`=$rokSzk AND `miesiac`='$miesiac' AND `id_Nauczyciela`= $teacher_id;";
                                $res3 = $conn->query($s); 
                                if ($res3->num_rows > 0)  $ro = $res3->fetch_assoc();                                    
                                echo isset($ro["odpracowane"]) ? $ro["odpracowane"] : 0;                                 
                                ?>
                            </div>
                            <div class="grid-item1 text-end table-danger">Pozostało do wypracowania</div>
                            <div class="grid-item3 text-center bg-danger bold text-white" id="pozostalo4">0</div>
                        </div>
                    </div>
                </div>  
              
            </div>
        </div>
    </div>

    <!-- -------------------------------------------------------- -->
    <!-- Okres rozliczeniowy TABELE - TYGODNIE -->
    <!-- -------------------------------------------------------- -->
    <div class="container py-4" id="nadgodzinyTabela">
        <div class="row">        
            <div class="col-sm-12 col-xl-9">                                
                <?php
                    // Odczytanie tygodni rozliczeniowych z ustawień okresu
                    // Formularz generuje dla każdego tygodnia osobną tabelę
                    $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";                                        
                    $resTygodnie = $conn->query($sql); 
                    if ($resTygodnie->num_rows > 0) {  
                        $ileTyg = $resTygodnie->num_rows ;
                        $_SESSION["ileTygodni"] = $ileTyg;
                        $week=1;                                                    
                        while($rowTygodnie = $resTygodnie->fetch_assoc()) { 
                            $idTyg =  $rowTygodnie["ID"];                      
                            //-----------------------------------------------------
                            // Odczyt kolejnego tygodnia 
                            //-----------------------------------------------------                             
                            $query = "SELECT * FROM (`godz_Nauczyciele_Rozliczenie_Tydzien` INNER JOIN godz_TydzienRozliczeniowy ON godz_Nauczyciele_Rozliczenie_Tydzien.id_tydzien=godz_TydzienRozliczeniowy.ID) WHERE `id_nauczyciel`= ?  AND `id_tydzien`= ?;";                            
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("ii", $teacher_id, $idTyg);
                            $stmt->execute();
                            $resTeacher = $stmt->get_result();
                            if ($resTeacher->num_rows > 0) {
                                $rowTeacher = $resTeacher->fetch_assoc();
                            }
                            ?>
                            <!-- ukryte pole i idRekordu tygodnia - jeśli istnieje -->
                            <input type="hidden" id="<?php echo "idTydzien$week" ?>" name="<?php echo "idTydzien$week" ?>" value="<?php echo $idTyg ?>">                            
                            <table class="tableTydzen w-100">
                                <thead>
                                    <!-- wiersz nagłówkowy - Dni tygodnia -----  -->
                                    <tr class="bg-1"> 
                                        <th rowspan="3" class="label p-1" style="vertical-align: bottom; padding:0 10px 10px 10px">
                                            <h4 class="tydzien text-center">Tydzień <?php echo $week ?></h4>
                                            Dzień wolny
                                        </th>
                                        <th class="bg-1">PN</th>
                                        <th class="bg-1">WT</th>
                                        <th class="bg-1">SR</th>
                                        <th class="bg-1">CZ</th>
                                        <th class="bg-1">PT</th>
                                        <th rowspan="3" class="bl fs-5">Razem</th>
                                    </tr>
                                    <!-- wiersz nagłówkowy - Daty -------------- -->  
                                    <tr class="bg-2">   
                                        <?php 
                                            $data = $rowTygodnie["DataPoczatkowa"];                                            
                                            echo "<td>". date('d-m-Y', strtotime($data)) ."</td>";
                                            for ($d = 1; $d < 5; $d++) {
                                                $nextDay = date('d-m-Y', strtotime($data . ' + ' . $d . ' day'));
                                                echo "<td>" . $nextDay . "</td>";
                                            }
                                        ?>                            
                                        
                                    </tr>
                                    <!-- Dni wolne  ----------------------------  -->
                                    <tr>                           
                                        <?php 
                                            for ($d = 1; $d <= 5; $d++) {    
                                                // jeśli admin zaznaczył że dzień wolny                                                                                 
                                                if ( $rowTygodnie["D".$d] == 1) {   ?>
                                                    <td><select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?>  disabled>  
                                                            <option value="wolne" selected >wolne</option> 
                                                        </select>
                                                    </td>                                                    
                                                <?php
                                                 // jeśli Nauczyciel zaznaczył że dzień wolny  
                                                } else if ( isset($rowTeacher["D".$d."_wolne"]) && $rowTeacher["D".$d."_wolne"] != "") { ?>
                                                    <td>
                                                        <select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?> onChange="calculateSum(<?php echo $teacher_id ?>)" >
                                                            <option value=""></option>
                                                            <option value="o"  <?php if ($rowTeacher["D".$d."_wolne"] == "o") echo "selected" ?> >opieka</option>
                                                            <option value="l4" <?php if ($rowTeacher["D".$d."_wolne"] == "l4") echo "selected" ?>>zwolnienie L4</option>
                                                            <option value="u"  <?php if ($rowTeacher["D".$d."_wolne"] == "u") echo "selected" ?>>urlop</option>
                                                            <option value="i"  <?php if ($rowTeacher["D".$d."_wolne"] == "i") echo "selected" ?>>inne</option>
                                                        </select>    
                                                    
                                                    </td>
                                                <?php
                                                } else { ?>
                                                    <td >
                                                        <select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?> onChange="calculateSum(<?php echo $teacher_id ?>)" >
                                                            <option value="" selected></option>
                                                            <option value="o">opieka</option>
                                                            <option value="l4">zwolnienie L4</option>
                                                            <option value="u">urlop</option>
                                                            <option value="i">inne</option>
                                                        </select>
                                                    </td>
                                                <?php
                                                }                                   
                                            }
                                        ?>                                                                                                                                                                                                           
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ----------------------------------------------------
                                            Wypracowane godziny
                                    ----------------------------------------------------- -->
                                    <tr class="bg-3">
                                        <th class="label">Wypracowane godziny</th>
                                        <?php 
                                        // Odczytanie zapisanych w bazie godzin dla danego tygodnia 
                                        for ($i = 1; $i <= 5; $i++) { 
                                            $wypr = 0;
                                            echo "w:" . $rowTeacher["D".$i."_wypracowane"];
                                            if (isset($rowTeacher["D".$i."_wypracowane"])) {
                                                $wypr = $rowTeacher["D".$i."_wypracowane"];
                                            } else if (isset(${"d".$i})) {
                                                $wypr = ${"d".$i}; 
                                            }
                                            
                                            ?>
                                            <th>                                                                                                
                                                <input type="number" min="0" max="12" size="3" name="<?php echo "planowe$week-$i"; ?>" id="<?php echo "planowe$week-$i"; ?>" value="<?php echo $wypr; ?>" onChange="calculateSum(<?php echo $teacher_id ?>)">
                                            </th>                        
                                        <?php 
                                        } ?>
                                        <th class="suma" id="<?php echo "sumaPlanowe$week" ?>"> </th>
                                    </tr>
                                    <!-- ----------------------------------------------------
                                            Dzienna liczba godzin etatowych 
                                    ----------------------------------------------------- -->
                                    <tr class="bg-3">
                                        <th class="label">Dzienna liczba godzin etatowych</th>
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <td id="<?php $nr=1; echo "norma$week-$i"; ?>" class="norma"></td>
                                        <?php } ?>
                                        <th class="suma" id="<?php echo "sumaNorma$week"; ?>"></th>
                                    </tr>
                                    <!-- ----------------------------------------------------
                                            Godziny zrealizowane 
                                    ----------------------------------------------------- -->
                                    <tr class="bg-2">
                                        <th class="label">Godziny zrealizowane</th>
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <td id="<?php $nr=1; echo "realizacja$week-$i";?>"></td>
                                        <?php } ?>                                          
                                        <th class="border-bottom" id="sumaD">

                                            <input type="text" size="7" name="<?php echo "razemRealizacja$week" ?>" id="<?php echo "razemRealizacja$week" ?>" readonly> 
                                        </th>
                                    </tr>
                                    <!-- ----------------------------------------------------
                                            Godziny doraźnych zastępstw
                                    ----------------------------------------------------- -->
                                    <tr>
                                        <th class="label">Godziny doraźnych zastępstw</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdDorazne$week-$d";?>">
                                                <input type="number" min="0" max="12" size="3" id="<?php echo "dorazne$week-$d";?>" name="<?php echo "dorazne$week-$d";?>" 
                                                value="<?php echo isset($rowTeacher["D".$d."_dorazne"]) ? $rowTeacher["D".$d."_dorazne"] : 0 ;?>"                                     
                                                onChange="calculateSum(<?php echo $teacher_id ?>)">
                                            <?php
                                            }    
                                            ?>                        
                                        <th class="bg-suma">
                                            <input type="text" class="suma" id="<?php echo "razemDorazne$week" ?>" name="<?php echo "razemDorazne$week" ?>" value="0" readonly>
                                        </th>
                                    </tr>
                                    <!-- ----------------------------------------------------
                                            Nauczanie indywidualne
                                    ----------------------------------------------------- -->
                                    <tr>
                                        <th class="label">Nauczanie indywidualne</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdIndyw$week-$d";?>">
                                                <input type="number" min="0" max="12" size="3" id="<?php echo "indyw$week-$d";?>" name="<?php echo "indyw$week-$d";?>"  
                                                value="<?php echo isset($rowTeacher["D".$d."_indyw"]) ? $rowTeacher["D".$d."_indyw"] : 0 ;?>"                                     
                                                onChange="calculateSum(<?php echo $teacher_id ?>)">
                                            <?php
                                            }    
                                            ?>                        
                                        <th class="bg-suma" >
                                            <input type="text" class="suma" name="<?php echo "razemIndyw$week" ?>" id="<?php echo "razemIndyw$week" ?>"  value="0" readonly>
                                        </th>
                                    </tr>
                                    <!-- ----------------------------------------------------
                                            INNE
                                    ----------------------------------------------------- -->
                                    <tr>
                                        <th class="label">Inne</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdInne$week-$d";?>">
                                                <input type="number" min="0" max="12" size="3" id="<?php echo "inne$week-$d";?>" name="<?php echo "inne$week-$d";?>" 
                                                value="<?php echo isset($rowTeacher["D".$d."_inne"]) ? $rowTeacher["D".$d."_inne"] : 0 ;?>"                                     
                                                onChange="calculateSum(<?php echo $teacher_id ?>)"></td>
                                            <?php
                                            }    
                                            ?>                        
                                        <th class="bg-suma" >
                                            <input type="text" class="suma" name="<?php echo "razemInne$week" ?>" id="<?php echo "razemInne$week" ?>" value="0" readonly>
                                        </th>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end px-3 ">Razem</th>
                                        <th id="<?php echo "razemWeek$week" ?>" class="bg-4" ></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="my-3 border-bottom"></div>
                            <?php
                            $week++;
                        }
                    }
                ?>
            </div>
            <div class="col-sm-12 col-xl-3 text-end">
                <button class="btn btn-primary btn-lg mt-5 px-5" name="submitOkres" type="submit">Zapisz</button>            
            </div>  
        </div>      
    </div>
</form>




