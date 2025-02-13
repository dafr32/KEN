<!-- 
    ****************************************************************
    Includowana zawartość w pliku nadgodziny_User_tydzien.php dla Nauczyciela
    ---------------------------------------------
    - Formularz
    ****************************************************************
 -->
 
<?php           
    if (session_status() === PHP_SESSION_NONE) { session_start(); }        
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false") { header('Location: index.php'); }       

    readData($teacher_id);   

	$etat = $tabPlanTygodnie[0]->etat ?? 0;
	$d1 = $tabPlanTygodnie[0]->D1 ?? 0;
	$d2 = $tabPlanTygodnie[0]->D2 ?? 0;
	$d3 = $tabPlanTygodnie[0]->D3 ?? 0;
	$d4 = $tabPlanTygodnie[0]->D4 ?? 0;
	$d5 = $tabPlanTygodnie[0]->D5 ?? 0;
	$normaG = $tabPlanTygodnie[0]->norma ?? 0;
	$kl4 = $tabPlanTygodnie[0]->klasy4 ?? 0;

    $setTygodnieKl4 = $tabTygodnie[0]->ileTygKl4; 
    $ileTygOkres = count($tabTygodnie);    
    $_SESSION["ileTygodni"] = $setTygodnieKl4;

    $PlanNew = json_encode($tabPlanTygodnie[0]);
    if ($tabTygodnie[0]->prevPlan == 1){
        $PlanOld = json_encode($tabPlanTygodnie[1]);
    } else {
        $PlanOld = json_encode($tabPlanTygodnie[0]);
    }
?>    
 <script>        
        var PlanNew = <?php echo $PlanNew; ?>;
        var PlanOld = <?php echo $PlanOld; ?>;
        var zmianaPlanu = false;              
        var ileTygOkres = <?php echo count($tabTygodnie); ?>;        
</script>  

<form action="save.php" method="POST" id="TeacherNadgodziny-ID<?php echo $teacher_id ?>" class="elementAccordion" data-ileTygOkres = "<?php echo count($tabTygodnie); ?> ">   
    <input type="hidden" id="TeacherID" name="TeacherID" value="<?php echo $teacher_id ?>">                            
    
    <!-- -------------------------------------------------------- -->
    <!-- Tabela ustawień godzin w tygodniu -->
    <!-- -------------------------------------------------------- -->
    <div class="container-fluid py-3" id="godzinyHeader">               
        <!-- plan lekcji Nauczyciela  -->
        <div class="container">
            <div class="row">                
                <div class="col-sm-12 col-lg-6">                                                                    
                    <h4 class="w-100">Plan lekcji </h4>
                    <div class="d-flex">
                        <div class="grid-container2 bg-light-gray me-2 w-50 ">
                            <div class="grid-item1">Ilość godz. na etat</div>
                            <div class="grid-item2"><input type="number" min="0" max="30" id="etatPlan" name="etat" class="form-control text-red" onchange="calculateSum(<?php echo $teacher_id ?>)" value="<?php echo isset($etat) ? $etat : 18; ?>" required></div>
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
                                <div class="grid-item text-center bg-warning bold" id="setNorma"><?php echo $normaG ?></div>                                       
                            </div>
                            <div class="mt-5 text-end">                        
                                <button class="btn btn-primary" name="saveUserGodziny" type="submit" for="GodzinyUsera">Zmień plan</button>                        
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

    <!-- ----------------------------------------------------------------  -->
    <!-- ogłoszenie o zmianie planu  -->
    <!-- ----------------------------------------------------------------  -->

    <div id="ogloszenie" class="py-2 text-center hidden">
        <h1 class=""> UWAGA !!!</h1>    
    </div>

    <!-- -------------------------------------------------------- -->
    <!-- Okres rozliczeniowy TABELE - TYGODNIE -->
    <!-- -------------------------------------------------------- -->
    <div class="container py-4" id="nadgodzinyTabela">
        <div class="row">        
            <div class="col-sm-12 col-xl-10">                                
                <?php
                    // Odczytanie tygodni rozliczeniowych z ustawień okresu
                    // Formularz generuje dla każdego tygodnia osobną tabelę
                    $week = 1;
                    foreach($tabTygodnie as $tydzien){                         
                        //-----------------------------------------------------
                        // Odczyt kolejnego tygodnia 
                        //-----------------------------------------------------                             
                        $idTyg =  $tydzien->id;                                             
                        $rowTeacher = $tabTygodnieNauczyciel[$week-1];
                        $prevPlan = false;
                        $nextPlan = false;
                        $nadgodziny = $tabPlanTygodnie[0]->nadgodziny;
                        if ($tydzien->prevPlan == 1){
                            $nadgodziny = $tabPlanTygodnie[1]->nadgodziny;
                            if( $week == 1 ) {
                                $prevPlan = true;
                                $nextPlan = true;
                                echo "<script>var zmianaPlanu = true; </script>";
                            }                   
                            echo "<strong>Poprzedni Plan</strong>";
                        }    
                        if ($tydzien->prevPlan == 0 && $nextPlan) {
                            echo "<strong>Nowy Plan</strong>";
                        }
                            
                        ?>
                        <!-- ukryte pole i idRekordu tygodnia - jeśli istnieje -->
                        <input type="hidden" id="<?php echo "idTydzien$week" ?>" name="<?php echo "idTydzien$week" ?>" value="<?php echo $idTyg ?>">                            
                        <input type="hidden" id="<?php echo "etat-$week" ?>" name="<?php echo "etat-$week" ?>" value="<?php echo $rowTeacher->etat ?>">                            
                        <input type="hidden" class="norma" id="<?php echo "norma-$week"; ?>" name="<?php echo "norma-$week"; ?>" value="<?php echo $rowTeacher->norma ?>">
                        <input type="hidden" id="<?php echo "nadgodziny$week" ?>" name="<?php echo "nadgodziny-$week" ?>" value="<?php echo $rowTeacher->nadgodziny ?>">                            
                        
                        <table id="<?php echo "table-$week" ?>" class="tabelaTydzen w-100" data-nadg="<?php echo $nadgodziny; ?>" data-plan="<?php echo ($tydzien->prevPlan == 1) ? "old": "new"; ?>">
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
                                        $data =  $tydzien->data;                                            
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
                                            if ( $tydzien->{"D".$d} == 1) {   ?>
                                                <td><select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?>  disabled>  
                                                        <option value="wolne" selected >wolne</option> 
                                                    </select>
                                                </td>                                                    
                                            <?php
                                                // jeśli Nauczyciel zaznaczył że dzień wolny  
                                            } else if ( $rowTeacher->{"D".$d}->wolne != "") { ?>
                                                <td>
                                                    <select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?> onChange="calculateSum(<?php echo $teacher_id ?>)" >
                                                        <option value=""></option>
                                                        <option value="o"  <?php if ($rowTeacher->{"D".$d}->wolne == "o") echo "selected" ?> >opieka</option>
                                                        <option value="l4" <?php if ($rowTeacher->{"D".$d}->wolne == "l4") echo "selected" ?>>zwolnienie L4</option>
                                                        <option value="u"  <?php if ($rowTeacher->{"D".$d}->wolne == "u") echo "selected" ?>>urlop</option>
                                                        <option value="i"  <?php if ($rowTeacher->{"D".$d}->wolne == "i") echo "selected" ?>>inne</option>
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
                                <!-- Planowe - Wypracowane godziny  ----------------------------------------------------- -->
                                <tr class="bg-3">
                                    <th class="label">Wypracowane godziny</th>
                                    <?php 
                                    // Odczytanie zapisanych w bazie godzin dla danego tygodnia 
                                    for ($i = 1; $i <= 5; $i++) { 

                                        $wypr = $rowTeacher->{"D".$i}->wypracowane;                                       
                                        if ($tydzien->prevPlan == 1) {
                                            $plan = $tabPlanTygodnie[1]->{"D".$i};
                                        } else {
                                            $plan = $tabPlanTygodnie[0]->{"D".$i};
                                        }
                                        
                                        ?>
                                        <th>                                                                                                
                                            <input type="number" min="0" max="12" size="3" name="<?php echo "planowe$week-$i"; ?>" id="<?php echo "planowe$week-$i"; ?>" value="<?php echo $wypr; ?>" class="<?php echo ($tydzien->prevPlan == 1) ? "zmiana": ""; ?>" onChange="calculateSum(<?php echo $teacher_id ?>)">
                                        </th>                        
                                    <?php 
                                    } ?>
                                    <th class="suma" id="<?php echo "sumaPlanowe$week" ?>"> </th>
                                </tr>
                                <!-- ----------------------------------------------------
                                        Dzienna norma
                                ----------------------------------------------------- -->
                                <tr class="bg-3">
                                    <th class="label">Dzienna norma godzin etatowych</th>
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) { 
                                        
                                        if ($tydzien->prevPlan == 1) {
                                            $plan = $tabPlanTygodnie[1]->{"D".$i};
                                            $norma = $tabPlanTygodnie[1]->norma;
                                        } else {
                                            $plan = $tabPlanTygodnie[0]->{"D".$i};
                                            $norma = $tabPlanTygodnie[0]->norma;
                                        }
                                        if ($plan == 0) $norma = 0; ?> 

                                        <td id="<?php echo "norma$week-$i"; ?>" name="<?php echo "norma$week-$i"; ?>" class="norma"><?php echo $norma ?></td>
                                    <?php } ?>
                                    <th class="suma" id="<?php echo "sumaNorma$week"; ?>"></th>
                                </tr>
                                <!-- ----------------------------------------------------
                                        Godziny zrealizowane - planowe
                                ----------------------------------------------------- -->
                                <tr class="bg-2">
                                    <th class="label">Godziny zrealizowane</th>
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) { ?>
                                        <td id="<?php $nr=1; echo "realizacja$week-$i";?>"></td>
                                    <?php } ?>                                          
                                    <th class="border-bottom d-flex justify-content-center" id="sumaD">
                                        <div id="<?php echo "razemRealizacjaFloat$week" ?>" class="small me-1"></div>
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
                                            value="<?php echo isset($rowTeacher->{"D".$d}->dorazne) ? $rowTeacher->{"D".$d}->dorazne : 0 ;?>"                                     
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
                                            value="<?php echo isset($rowTeacher->{"D".$d}->indywidualne) ? $rowTeacher->{"D".$d}->indywidualne : 0 ;?>"                                     
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
                                            value="<?php echo isset($rowTeacher->{"D".$d}->inne) ? $rowTeacher->{"D".$d}->inne : 0 ;?>"                                     
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
                    
                ?>
            </div>
            <div class="col-sm-12 col-xl-2 text-end">
                <button class="btn btn-primary btn-lg mt-5 px-5" name="submitOkres" type="submit">Zapisz</button>            
            </div>  
        </div>      
    </div>
</form>

<script>
    window.onload = function() {         
        const godz_tydzien = document.querySelector("#ileGodzin").textContent;
        const tabeleRozliczen = document.querySelector("#nadgodzinyTabela");  
        const ogloszenie = document.querySelector("#ogloszenie");
        let ogloszenie_tekst = document.createElement("h3");
        // console.log("godz:",godz_tydzien);

        if (godz_tydzien > 0 ) {              
            calculateSum(<?php echo $teacher_id ?>); 
            if (zmianaPlanu) {       
                gloszenie_tekst.innerHTML = "W tym miesiącu rozliczeniowym nastąpiła zmiana planu. <br> Proszę sprawdzić i ewentualnie zaktualizować plan lekcji"
                ogloszenie.appendChild(ogloszenie_tekst);
                ogloszenie.classList.remove("hidden");  
            } else {            
                ogloszenie.classList.add("hidden");
            }
        } else {            
            tabeleRozliczen.style.display = "none";                        
            ogloszenie_tekst.innerHTML = "Proszę wypełnić najpierw tabelę godzin wg planu lekcji";
            ogloszenie.appendChild(ogloszenie_tekst);
            ogloszenie.classList.remove("hidden");  
            console.log(ogloszenie.classList);          
        }

        
    };





</script>


