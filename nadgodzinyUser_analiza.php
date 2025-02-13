    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }        
        if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
            header('Location: index.php');
        }
        require "connect.php";        
    ?>    
       
 
<!-- Zapisane godziny -->
    <div class="container">        
        <?php
        // Odczyt ustalonych godzin z okresu rozliczeniowego 
        $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $user_id AND `rokSzk` = $rokSzk AND `miesiac`= '$miesiac'";
        $result = $conn->query($sql); 
        if ($result->num_rows == 0) {  
            //jeśli nie ma zapisu z aktualnego okresu to pobierz ostatni wpis
            $sql = "SELECT * FROM `godz_Nauczyciele_Godziny` WHERE `ID_Nauczyciela` = $user_id AND `rokSzk` = $rokSzk ORDER BY `ID` DESC LIMIT 1";             
            $result = $conn->query($sql);  
            if ($result->num_rows == 0)                                
                $setGodziny = FALSE;
            else
                $setGodziny = TRUE;
        } else
            $setGodziny = TRUE;                
            if ($setGodziny){
                $row = $result->fetch_assoc();
                $d1 = $row["PN"];
                $d2 = $row["WT"];
                $d3 = $row["SR"];
                $d4 = $row["CZ"];
                $d5 = $row["PT"];
                $kl4 = $row["kl4"];
                $etat = $row["etat"];  
            } 
        ?>     

        <div class="row">
            <!-- godziny Nauczyciela  -->
            <div class="col-sm-12 col-lg-7 ">                                                                    
                <div class="row">
                    <h4 class="w-100 m-0 p-2 text-white bg-primary">Godziny ustalone</h4>
                </div>
                
                <div class="row bg-light-gray p-3" >                        
                    <div class="col-2">
                        <label for="PN" class="form-label text-center">Ilość godz. <br />na etat</label>                
                        <input type="number" min="0" max="30" id="etat" name="etat" class="form-control bg-info" onchange="calculateSum()" value="<?php echo isset($etat) ? $etat : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="PN" class="form-label">PN</label>                
                        <input type="number" min="0" max="12" id="d1" name="PN" class="form-control day" onchange="calculateSum()" value="<?php echo isset($d1) ? $d1 : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="WT" class="form-label">WT</label>
                        <input type="number" min="0" max="12" id="d2" name="WT" class="form-control day" onchange="calculateSum()" value="<?php echo isset($d2) ? $d2 : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="SR" class="form-label">SR</label>
                        <input type="number" min="0" max="12" id="d3" name="SR" class="form-control day" onchange="calculateSum()" value="<?php echo isset($d3) ? $d3 : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="CZ" class="form-label">CZ</label>
                        <input type="number" min="0" max="12" id="d4" name="CZ" class="form-control day" onchange="calculateSum()" value="<?php echo isset($d4) ? $d4 : ''; ?>">
                    </div>
                    <div class="col">
                        <label for="PT" class="form-label">PT</label>
                        <input type="number" min="0" max="12" id="d5" name="PT" class="form-control day" onchange="calculateSum()" value="<?php echo isset($d5) ? $d5 : ''; ?>">
                    </div>
                    <div class="col-2">
                        <label for="kl4" class="form-label text-center">w tym <br />w klasach 4</label>
                        <input type="number" min="0" max="20" id="kl4" name="kl4" class="form-control  bg-info" onchange="calculateSum()" value="<?php echo isset($kl4) ? $kl4 : ''; ?>">
                    </div>

                </div>
                <div class="row p-4 text-white bg-gray" >
                    <div class="col-4">                            
                        <div class="text-end">Ilość godzin w tygodniu :</div>                                
                        <div class="text-end my-1">Ilość nadgodzin:</div>
                        <div class="text-end">Norma dzienna:</div>                                            
                    </div>
                    <div class="col-2">
                        <div class="text-center px-3 bg-warning bold text-grey " id="ileGodzin"></div>
                        <div class="text-center px-3 bg-warning bold text-grey my-1" id="setNadg"></div>
                        <div class="text-center px-3 bg-warning  bold text-grey" id="setNorma"></div>
                    </div>
                    <div class="col-6 text-end">                        
                        <button class="btn btn-primary " name="saveUserGodziny" type="submit" for="GodzinyUsera">Zapisz</button>                        
                    </div>
                </div>                
            </div>

            <!-- tabela podsumowująca okres  -->
            <div class="col-sm-12 col-lg-5 user_result">
                <div class="mb-2">
                        <h4 class="w-100 m-0 p-2 text-white bg-danger">Godziny - podsumowanie</h4>
                </div>  
                <table class="table table-striped-columns table_nadgodziny">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2" class="table-primary">Ilość godzin ponadwymiarowych</th>
                            <th scope="col" colspan="2" class="table-primary">Godziny Do odpracowania</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <tr>
                            <th>Ponadwymiarowe</th>
                            <td id="RazemPonad"></td>
                            <th>Ilość tygodni</th>
                            <td id="ileTygodniKl4"><?php echo isset($setTygodnieKl4) ? $setTygodnieKl4 : ''; ?></td>
                        </tr>
                        <tr>
                            <th>Zastępstwa</th>
                            <td id="RazemDorazne"></td>
                            <th >Wypracowane w tym okresie</th>
                            <td id="wypracowane4"></td>
                        </tr>
                        <tr>
                            <th>Indywidualne</th>
                            <td id="RazemIndyw"></td>
                            <th>Razem do wypracowania</th>
                            <td id="doWypracowania4"></td>
                        </tr>
                        <tr>
                            <th>Inne</th>
                            <td id="RazemInne"></td>                            
                            <th >Dotychczas wypracowane</th> 
                            <?php 
                                $razemWypracowane = 0;
                            ?>
                            <td id="RazemWypracowane4"><?php echo $razemWypracowane ?></td>                            
                        </tr>
                        <tr>
                            <th class="table-danger">Razem</th>
                            <td id="razemGodziny" class="bg-danger text-white"></td>
                            <th class="table-danger">Pozostało do wypracowania</th>
                            <td id="pozostalo4"></td>
                        </tr>
                    </tbody>

                </table>                                    
            </div>
        </div>
      
    </div>
    <!-- ------------------------------------------------------------------------------------------------- -->
    <!-- Okres rozliczeniowy  TABELA -->
    <div class="container" id="nadgodzinyTabela">
        <div class="row">        
            <div class="col-sm-12">                
                
                <?php
                    // Odczytanie tygodni rozliczeniowych z ustawień okresu
                    $sql = "SELECT * FROM `godz_TydzienRozliczeniowy`, RokSettings WHERE godz_TydzienRozliczeniowy.rokSzk=RokSettings.rokSzk AND godz_TydzienRozliczeniowy.miesiac=RokSettings.miesiacRozliczeniowy;";
                    $result = $conn->query($sql); 
                    if ($result->num_rows > 0) {  
                        $ileTyg = $result->num_rows ;
                        $_SESSION["ileTygodni"] = $ileTyg;
                        $week=1;                                                    
                        while($row = $result->fetch_assoc()) { 
                            $idTyg =  $row["ID"]; 
                                                 
                            // Odczytanie tygodni rozliczeniowych Nauczyciela  
                            $sql2 = "SELECT * FROM (`godz_Nauczyciele_Rozliczenie_Tydzien` INNER JOIN godz_TydzienRozliczeniowy ON godz_Nauczyciele_Rozliczenie_Tydzien.id_tydzien=godz_TydzienRozliczeniowy.ID) WHERE `id_nauczyciel`= $user_id  AND `id_tydzien`= $idTyg;";
                            $result2 = $conn->query($sql2); 
                            $row2 = $result2->fetch_assoc();                                                       
                            ?>                             
                            <!-- tabela na tydzień -->
                            <input type="hidden" id="<?php echo "idTydzien$week" ?>" name="<?php echo "idTydzien$week" ?>" value="<?php echo $idTyg ?>">
                            <h4 class="mt-5 pt-3 border-top tydzien">Tydzień <?php echo $week ?></h4>
                            <table class="tableTydzen w-100">
                                <thead>
                                    <tr> <!-- dni -->
                                        <th rowspan="3" class="label" style="vertical-align: bottom; padding-bottom:10px">Dzień wolny</th>
                                        <th class="bg-1">PN</th>
                                        <th class="bg-1">WT</th>
                                        <th class="bg-1">SR</th>
                                        <th class="bg-1">CZ</th>
                                        <th class="bg-1">PT</th>
                                        <th rowspan="3" class="bl fs-5">Razem</th>
                                    </tr>
                                    <tr class="bg-2">   <!-- daty -->
                                        <?php 
                                            $data = $row["DataPoczatkowa"];
                                            // echo "<td>". date('d-m-Y', strtotime($data)) ."</td>";
                                            for ($d = 1; $d <= 5; $d++) {
                                                $nextDay = date('d-m-Y', strtotime($data . ' + ' . $d . ' day'));
                                                echo "<td>" . $nextDay . "</td>";
                                            }
                                        ?>                            
                                        
                                    </tr>
                                    <tr><!-- wolne -->                           
                                        <?php 
                                            for ($d = 1; $d <= 5; $d++) {                                    
                                                // +3 bo w tablicy pierwsze dwa elementy to inne dane
                                                if ( $row["D".$d] == 1) {   ?>
                                                    <td><select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?>  disabled>  
                                                            <option value="wolne" selected >wolne</option> 
                                                        </select>
                                                    </td>
                                                    <!-- echo "<td ID='wolne$week-".$d>"' class='wolne'>wolne</td>";                                         -->
                                                <?php
                                                } else if ( isset($row2["D".$d."_wolne"]) && $row2["D".$d."_wolne"] != "") { ?>
                                                    <td>
                                                        <select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?> onChange="calculateSum()" >
                                                            <option value=""></option>
                                                            <option value="o"  <?php if ($userWeek[$week][$d]["wolne"] == "o") echo "selected" ?> >opieka</option>
                                                            <option value="l4" <?php if ($userWeek[$week][$d]["wolne"] == "l4") echo "selected" ?>>zwolnienie L4</option>
                                                            <option value="u"  <?php if ($userWeek[$week][$d]["wolne"] == "u") echo "selected" ?>>urlop</option>
                                                            <option value="i"  <?php if ($userWeek[$week][$d]["wolne"] == "i") echo "selected" ?>>inne</option>
                                                        </select>    
                                                    
                                                    </td>
                                                <?php
                                                } else { ?>
                                                    <td >
                                                        <select id=<?php echo "'wolne$week-$d' name='wolne$week-$d'"?> onChange="calculateSum()" >
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
                                    <tr class="bg-3">
                                        <th class="label">Planowe godziny</th>
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <th id="<?php echo "planowe$week-$i"; ?>" ><?php echo isset(${"d".$i}) ? ${"d".$i} : ''; ?></th>                        
                                        <?php } ?>
                                        <th class="suma" id="<?php echo "sumaPlanowe$week" ?>"> </th>
                                    </tr>
                                    <tr class="bg-3">
                                        <th class="label">Dzienna liczba godzin etatowych</th>
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <td id="<?php $nr=1; echo "norma$week-$i"; ?>" class="norma"></td>
                                        <?php } ?>
                                        <th class="suma" id="<?php echo "sumaNorma$week"; ?>"></th>
                                    </tr>
                                    <tr class="bg-2">
                                        <th class="label">Godziny zrealizowane</th>
                                        <?php 
                                        for ($i = 1; $i <= 5; $i++) { ?>
                                            <td id="<?php $nr=1; echo "realizacja$week-$i";?>"></td>
                                        <?php } ?>                                          
                                        <th class="border-bottom" id="sumaD">
                                            <input type="text" class="" name="<?php echo "razemRealizacja$week" ?>" id="<?php echo "razemRealizacja$week" ?>" readonly> 
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="label">Godziny doraźnych zastępstw</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdDorazne$week-$d";?>">
                                                <input type="number" min="0" max="9" size="3" id="<?php echo "dorazne$week-$d";?>" name="<?php echo "dorazne$week-$d";?>" 
                                                value="<?php echo isset($row2["D".$d."_dorazne"]) ? $row2["D".$d."_dorazne"] : 0 ;?>"                                     
                                                onChange="calculateSum()">
                                            <?php
                                            }    
                                            ?>                        
                                        <th class="bg-suma">
                                            <input type="text" class="suma" id="<?php echo "razemDorazne$week" ?>" name="<?php echo "razemDorazne$week" ?>" value="0" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="label">Nauczanie indywidualne</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdIndyw$week-$d";?>">
                                                <input type="number" min="0" max="9" size="3" id="<?php echo "indyw$week-$d";?>" name="<?php echo "indyw$week-$d";?>"  
                                                value="<?php echo isset($row2["D".$d."_indyw"]) ? $row2["D".$d."_indyw"] : 0 ;?>"                                     
                                                onChange="calculateSum()">
                                            <?php
                                            }    
                                            ?>                        
                                        <th class="bg-suma" >
                                            <input type="text" class="suma" name="<?php echo "razemIndyw$week" ?>" id="<?php echo "razemIndyw$week" ?>"  value="0" readonly>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="label">Inne</th>                                       
                                        <?php
                                            for ($d = 1; $d <= 5; $d++) {
                                                ?>
                                                <td id="<?php echo "tdInne$week-$d";?>">
                                                <input type="number" min="0" max="9" size="3" id="<?php echo "inne$week-$d";?>" name="<?php echo "inne$week-$d";?>" 
                                                value="<?php echo isset($row2["D".$d."_inne"]) ? $row2["D".$d."_inne"] : 0 ;?>"                                     
                                                onChange="calculateSum()"></td>
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
                            <?php
                            $week++;
                        }
                    }
                ?>
            </div>
        </div>      
    </div>


    <script>
    function calculateSum() {
        var etat = parseInt(document.getElementById("etat").value) || 0;            
        var kl4 = document.getElementById("kl4").value || 0;
        var ileTygOkres = document.getElementsByClassName("tydzien").length;         
        


        //wolne - blokowanie dnia
        for (var week = 1; week <= ileTygOkres; week++) {
            for (var i = 1; i <= 5; i++) {
                var element = document.getElementById("wolne"+week + "-" + i);
                if (element){                   
                    if (element.value !="") {               
                        element.classList.add("wolne");                    
                        document.getElementById("planowe" + week + "-" + i).classList.add("wolne");
                        document.getElementById("norma" + week + "-" + i).classList.add("wolne");                        
                        document.getElementById("realizacja" + week + "-" + i).classList.add("wolne");
                        document.getElementById("realizacja" + week + "-" + i).textContent = 0;                        

                        document.getElementById("tdDorazne" + week + "-" + i).classList.add("wolne");
                        document.getElementById("dorazne" + week + "-" + i).value = 0;
                        document.getElementById("dorazne" + week + "-" + i).disabled = true;

                        document.getElementById("tdIndyw" + week + "-" + i).classList.add("wolne");
                        document.getElementById("indyw" + week + "-" + i).value = 0;
                        document.getElementById("indyw" + week + "-" + i).disabled = true;

                        document.getElementById("tdInne" + week + "-" + i).classList.add("wolne");
                        document.getElementById("inne" + week + "-" + i).value = 0;
                        document.getElementById("inne" + week + "-" + i).disabled = true;

                    }else {
                        element.classList.remove("wolne");
                        document.getElementById("planowe" + week + "-" + i).classList.remove("wolne");
                        document.getElementById("norma" + week + "-" + i).classList.remove("wolne");  
                        document.getElementById("realizacja" + week + "-" + i).classList.remove("wolne");  
                        
                        document.getElementById("tdDorazne" + week + "-" + i).classList.remove("wolne");
                        document.getElementById("tdIndyw" + week + "-" + i).classList.remove("wolne");
                        document.getElementById("tdInne" + week + "-" + i).classList.remove("wolne");
                        document.getElementById("dorazne" + week + "-" + i).disabled = false;
                        document.getElementById("indyw" + week + "-" + i).disabled = false;
                        document.getElementById("inne" + week + "-" + i).disabled = false;
                    }
                }
            }
        }
                

        // -------------------------------------------------------------------------    
        // godziny planowe - tablea tydzień

        for (var week = 1; week <= ileTygOkres; week++) {
            for (var d = 1; d <= 5; d++) {
                document.getElementById("planowe" + week + "-" + d).textContent = document.getElementById("d" + d).value;                
            }
        }
       
        // -------------------------------------------------------------------------    
        // suma godzin planowanych na tydzień
        var inputFields = document.getElementsByClassName("day");
        var totalSum = 0;
        var ileDni = 0;
        for (var i = 0; i < inputFields.length; i++) {
            var g = parseInt(inputFields[i].value) || 0;            
            if (g > 0) ileDni++;
            totalSum += g;            
        }

        document.getElementById("ileGodzin").textContent = totalSum;
        
        for (var week = 1; week <= ileTygOkres; week++) {
            document.getElementById("sumaPlanowe" + week).textContent = parseInt(totalSum);   
        }
        

        var setNadg = 0;
        if (totalSum < etat)
            setNadg = 0;
        else
            setNadg = (totalSum - etat);

        document.getElementById("setNadg").textContent = setNadg;

        // -------------------------------------------------------------------------    
        // norma
        
        var norma =  etat / ileDni;         
        document.getElementById("setNorma").textContent = norma;        
        
        var normaClass = document.getElementsByClassName("norma");        
        for (var i = 0; i<normaClass.length; i++) {
            normaClass[i].textContent = norma;            
        }
        
        for (var week = 1; week <= ileTygOkres; week++) {
            document.getElementById("sumaNorma" + week).textContent = etat;   
        }

        // -------------------------------------------------------------------------
        // Godziny zrealizowane   
                
        for (var week = 1; week <= ileTygOkres; week++) {
            var sumaZreal = 0;
            var z = 0.0;
            for (var d = 1; d <= 5; d++) {
                var planowe = document.getElementById("planowe" + week + "-" + d).textContent; // godziny ustalone                             
                var realizacja = document.getElementById("realizacja" + week + "-" + d);    
               
                
                var elementClass = realizacja.className;
                if (elementClass == "wolne" || planowe==0){
                    // console.log("realizacja" + week + "-" + x);
                    z = 0;
                    realizacja.textContent = parseInt(0);
                }
                else{
                    z = parseFloat((planowe - norma).toFixed(1));
                    realizacja.textContent = parseFloat((planowe - norma).toFixed(1)); 
                    //do jednego miejsca po przecinku                    
                }
                sumaZreal += z;
            }

            var ileNadg = document.getElementById("ileTygodniKl4").textContent;
            if (sumaZreal < 0)
                sumaZreal = 0;
            else if (sumaZreal > setNadg)
                sumaZreal = setNadg;            
            // document.getElementById("razemRealizacja" + week).value = sumaZreal.toFixed(1);    
            document.getElementById("razemRealizacja" + week).value = Math.round(sumaZreal);    
            // document.getElementById("razemRealizacjaH" + week).setAttribute("value",  Math.round(sumaZreal));    
        }

        // -------------------------------------------------------------------------
        // Godziny doraźne
        
        for (var week = 1; week <= ileTygOkres; week++) {
            var sumaDorazne = 0;
            for (var d = 1; d <= 5; d++) {
                var dorazne = document.getElementById("dorazne" + week + "-" + d).value;
                console.log("Dorazne:"+dorazne);                
                sumaDorazne += parseInt(dorazne) || 0;                
            }
            document.getElementById("razemDorazne" + week).value = parseInt(sumaDorazne);
            
        }

        // -------------------------------------------------------------------------
        // Nauczanie indywidualne

        for (var week = 1; week <= ileTygOkres; week++) {
            var sumaIndyw = 0;            
            var z = 0;
            for (var x = 1; x <= 5; x++) {
                var indyw = document.getElementById("indyw"+week + "-" + x)  
                if (indyw && indyw.value){
                    sumaIndyw += parseInt(indyw.value) || 0;
                }
            }            
            document.getElementById("razemIndyw" + week).value = sumaIndyw;    
        }

        // -------------------------------------------------------------------------
        // Inne godziny
        
        for (var week = 1; week <= ileTygOkres; week++) {
            var sInne = 0;
            for (var x = 1; x <= 5; x++) {
                var inne = document.getElementById("inne" + week + "-" + x);
                if (inne && inne.value) {
                    sInne += parseInt(inne.value) || 0;
                }
            }
            document.getElementById("razemInne" + week).value = sInne;            
        }        

        // -------------------------------------------------------------------------    
        // Podsumowanie Tygodnia 
        
        for (var week = 1; week <= ileTygOkres; week++) {
            var s = 0;
            var s1 = parseFloat(document.getElementById("razemRealizacja" + week).value);
            var s2 = parseFloat(document.getElementById("razemDorazne" + week).value);
            var s3 = parseFloat(document.getElementById("razemIndyw" + week).value);
            var s4 = parseFloat(document.getElementById("razemInne" + week).value);

            s = parseFloat(s1+s2+s3+s4);
            // console.log(s + "t:" +week);
            document.getElementById("razemWeek" + week).textContent = Math.round(s); 
        }

        // ------------------------------------------------------------------- -
        // podsumowania oKRESU
        
        var sumaR = 0;
        var sumaD = 0;
        var sumaInd = 0;
        var sumaInne = 0;
        for (var week = 1; week <= ileTygOkres; week++) {
            var s = 0;
            sumaR += Math.round(document.getElementById("razemRealizacja" + week).value);            
            sumaD += parseInt(document.getElementById("razemDorazne" + week).value);
            sumaInd += parseInt(document.getElementById("razemIndyw" + week).value);
            sumaInne += parseInt(document.getElementById("razemInne" + week).value);
            console.log("podsumowanie:" + sumaD);
        }
        
        document.getElementById("RazemPonad").textContent = sumaR;
        document.getElementById("RazemDorazne").textContent = sumaD;
        document.getElementById("RazemIndyw").textContent = sumaInd;
        document.getElementById("RazemInne").textContent = sumaInne;
        document.getElementById("razemGodziny").textContent = sumaR +sumaD +sumaInd +sumaInne;
        
        // podsumowanie klasy 4
        var ileTyg = document.getElementById("ileTygodniKl4").textContent;
        var godzinyBezKlas4 = totalSum - kl4;
        if (godzinyBezKlas4 < 18) {
            document.getElementById("wypracowane4").textContent = document.getElementById("RazemPonad").textContent
            document.getElementById("doWypracowania4").textContent = ((18 - godzinyBezKlas4) * ileTyg);
            var g1 = document.getElementById("wypracowane4").textContent;
            var g2 = document.getElementById("RazemWypracowane4").textContent; 
            var g3 = document.getElementById("doWypracowania4").textContent; 
            
            document.getElementById("pozostalo4").textContent = g3 - g2 - g1;
           
            // console.log("ileTyg : " + ileTyg );
        }

    }    

    calculateSum();
   
</script>
   



