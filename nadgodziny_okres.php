<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
        header('Location: index.php');
    }
    require "connect.php";
    $rokSzk = $_SESSION['rokSzk']; 
    $semestr = $_SESSION['semestr'];
    $miesiac =  $_SESSION['miesiac'];
    
    $_SESSION['content-admin'] = "admin_Nadgodziny.php";    
    $_SESSION['content-nadgodziny'] = "nadgodziny_okres.php";    

?>
<div class="wow fadeIn">
    <div class="">
        <form action="save.php" method="POST" class="d-flex align-items-center justify-content-center my-5 mx-auto" >    
            <label for="miesiac">Wybierz miesiąc rozliczeniowy:</label>
            <select name="miesiac" id="miesiac" class="form-select ms-3" style="width: 200px; font-weight: bold;">               
                <option value="sierpień" <?php echo ($miesiac=="sierpień") ? "selected":"" ?>>Sierpień</option>
                <option value="wrzesień" <?php echo ($miesiac=="wrzesień") ? "selected":"" ?>>Wrzesień</option>
                <option value="październik" <?php echo ($miesiac=="październik") ? "selected":"" ?>>Październik</option>
                <option value="listopad" <?php echo ($miesiac=="listopad") ? "selected":"" ?>>Listopad</option>
                <option value="grudzień" <?php echo ($miesiac=="grudzień") ? "selected":"" ?>>Grudzień</option>
                <option value="styczeń" <?php echo ($miesiac=="styczeń") ? "selected":"" ?>>Styczeń</option>
                <option value="luty" <?php echo ($miesiac=="luty") ? "selected":"" ?>>Luty</option>
                <option value="marzec" <?php echo ($miesiac=="marzec") ? "selected":"" ?>>Marzec</option>
                <option value="kwiecień" <?php echo ($miesiac=="kwiecień") ? "selected":"" ?>>Kwiecień</option>
                <option value="maj" <?php echo ($miesiac=="maj") ? "selected":"" ?>>Maj</option>
                <option value="czerwiec" <?php echo ($miesiac=="czerwiec") ? "selected":"" ?>>Czerwiec</option>
                <option value="lipiec" <?php echo ($miesiac=="lipiec") ? "selected":"" ?>>Lipiec</option>
            </select>
            <button type="submit" name="submitMiesiac" class="btn btn-warning ms-3 px-5">Zmień</button>
        </form>        
    </div> 


    <?php

    $sql="SELECT * FROM `godz_TydzienRozliczeniowy` WHERE `rokSzk`= $rokSzk AND `miesiac` = '$miesiac'";
    // echo $sql;    
    $result = $conn->query($sql); 

    if ($result->num_rows > 0) {  ?> 
        <!-- jeśli jest zapis tygodni z tego okresu                    -->
        <form action="save.php" method="POST" style="max-width:800px; margin:auto">        
            <table class="table table-primary table-striped w-100" id="tableOkres">
                <thead>
                    <tr>
                        <td colspan="2" class="bg-none"></td>
                        <th colspan="5" class="text-center bg-2"> Dni wolne</th>
                    </tr>
                    <tr class="py-3">                <!-- Data początkowa tygodnia -->
                        <th class="bg-1">lp</th>    
                        <th class="bg-1">Tydzień</th>
                        <th class="bg-1">PN</th>
                        <th class="bg-1">WT</th>
                        <th class="bg-1">SR</th>
                        <th class="bg-1">CZ</th>
                        <th class="bg-1">PT</th>   
                        <th class="bg-1">Poprzedni plan</th>                                            
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $week = 0;
                    while($row = $result->fetch_assoc()) {  
                        $week++;
                        $data = $row["DataPoczatkowa"];
                        $id = $row["ID"];
                        $prevPlan = ($row["prevPlan"] == 1) ? 1 : 0;
                        ?>                                
                        <tr class=""> 
                            <td>
                                <?php echo $week ?> 
                                <input type="text" name="<?php echo "W$week-ID" ?>" value="<?php echo $id ?>" hidden> </td>
                            <td>                                    
                                <input type="date" class="form-control" name="<?php echo "W$week-Data"?>" value="<?php echo $data ?>">
                            </td> 
                            <?php 
                            for ($day=1;$day<=5;$day++){ 
                                $w = $row["D".$day]; ?>
                                <td class="">
                                    <input class="form-check-input" type="checkbox" name="<?php echo "W$week-D$day" ?>" <?php echo ($w == 1 ? "checked" : "") ?>>
                                </td>                     
                                <?php
                            }                            
                            ?>        
                            <td class="">
                                <input class="form-check-input" type="checkbox" name="<?php echo "W$week-prev" ?>" <?php echo ($prevPlan == 1 ? "checked" : "") ?>>
                            </td>                     
                        </tr>                                                 
                    <?php
                    }
                    // usupełnienie pustych tygodni do 6
                    for ($nr = $week+1; $nr <= 5; $nr++) { ?>
                        <input type="text" name="<?php echo "W$nr-ID" ?>" value="null" hidden>
                        <tr class=""> 
                            <td><?php echo $nr ?> <input type="text" name="<?php echo "W$nr-ID" ?>" value="null" hidden> </td>
                            <td>
                                <input type="date" class="form-control" name="<?php echo "W$nr-Data"?>" value="">
                            </td> 
                            <?php 
                            for ($day=1;$day<=5;$day++){ ?>
                                <td class="">
                                    <input class="form-check-input" type="checkbox" name="<?php echo "W$nr-D$day" ?>">
                                </td>                     
                                <?php
                            }
                            ?> 
                            <td class="">
                                <input class="form-check-input" type="checkbox" name="<?php echo "W$week-prev" ?>" >
                            </td>         
                        </tr> 
                    <?php
                    } ?>
                </tbody>
            </table>
        
            <div class="mt-5">
                <button class="btn btn-primary btn-block" name="setOkres" type="submit">Zapisz zmiany</button>                                    
            </div>             
        </form>  
                

    <?php                                        
    } else { 
        // jeśli brak zapisów 
        ?>
        <h2 class="my-5 text-red">Dodaj nowy okres rozliczeniowy</h2>
        <form action="save.php" method="POST" style="max-width:800px; margin:auto">            
            <table class="table table-primary table-striped w-100" id="tableOkres">
                <thead>
                    <tr>
                        <td colspan="2" class="bg-none"></td>
                        <th colspan="5" class="text-center bg-2"> Dni wolne</th>
                    </tr>
                    <tr>                <!-- Data początkowa tygodnia -->                                    
                        <th class="bg-1">lp</th>    
                        <th class="bg-1" style="width: 100px">Tydzień</th>
                        <th class="bg-1">PN</th>
                        <th class="bg-1">WT</th>
                        <th class="bg-1">SR</th>
                        <th class="bg-1">CZ</th>
                        <th class="bg-1">PT</th>    
                        <th class="bg-1">Poprzedni plan</th>                
                    </tr>
                </thead>
                <tbody> 
                    <?php
                    for ($nr = 1; $nr <= 6; $nr++) { ?>
                        <tr class=""> 
                            <td><?php echo $nr ?> <input type="text" name="<?php echo "W$nr-ID" ?>" value="null" hidden> </td>
                            <td>
                                <input type="date" class="form-control" name="<?php echo "W$nr-Data"?>" >
                            </td> 
                            <?php 
                            for ($day = 1;$day <= 5;$day++){ ?>
                                <td class="">
                                    <input class="form-check-input" type="checkbox" name="<?php echo "W$nr-D$day"?>" >
                                </td>                     
                                <?php
                            }
                            ?>
                            <td class="">
                                <input class="form-check-input" type="checkbox" name="<?php echo "W$nr-prev" ?>" >
                            </td>           
                        </tr> 
                    <?php
                    } ?>
                </tbody>
            </table>
            <div class="mt-5">  <!-- miesiąc -->                                        
                <button class="btn btn-primary btn-block" name="setOkres" type="submit">Zapisz zmiany</button>                                                                 
            </div>
        
        </form>  
                    
    <?php
    } ?>
    </div>
</div>
 