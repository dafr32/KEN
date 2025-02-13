<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require "connect.php";
    $_SESSION['content-admin'] = "efekt_Tabele.php";
    $rokSzk = $_SESSION['rokSzk'];
    $semestr = $_SESSION['semestr'];
    $belfer = $_SESSION['belfer'];
    $belfer_id = $_SESSION['belfer_id'];                
?>


<style>
    .headerTable {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #e1b71dd1;
        padding: 20px;
        margin-bottom: 10px;
    }
    .program h3 {
        color: #000;
        text-transform: uppercase;
        font-size: 1.3rem;
    }
    .firstCol {
     background: #eeeeee1f;
    }
        
        
    .formSubject {
        display: grid;
        grid-template-columns: 2fr 2fr 2fr 3fr 1fr;
        gap: 10px;         
    }

    .formSubject label {
        font-size: 0.9rem;
        font-weight: 400;
        font-style: italic;
        padding-bottom: 10px;
        display:block;
    }
        
    .formField {
        background-color: #3498db;
        color: #fff;
        padding: 20px;
        text-align: center;        
    }

    .formField input::placeholder {
        color:#ddd;
    }
    .form-check {
        text-align:center;
    }

    .form-check .form-check-input {
        float: unset;
    }

    .formSave {
        background: unset;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .tableSubject span {
        font-style: italic;
        color: #555555a8;
    }


</style>
<div class="container pt-4 program">
    <h2 class="text-center">OŚWIADCZENIE</h2>
    <h4 class="text-center mb-5"> o realizacji podstawy programowej i programu nauczania <br />
        w roku szkolnym </h4>
    <?php
    // ILE PRZEDMIOTÓW                
    $sql = "SELECT * FROM `prog_PrzedmiotyN` WHERE id_Nauczyciela = $belfer_id AND rokSzk = $rokSzk AND semestr = $semestr";
    $result = $conn->query($sql);         
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                                    
            $result2 = $conn->query("SELECT * FROM `Przedmioty` WHERE ID = ".$row['id_Przedmiotu']);
            $rowP = $result2->fetch_assoc();
            $idP = $rowP['ID'];
            $przedm = $rowP['przedmiot'];
            echo "<div class='headerTable'> 
                    <h3 > $przedm </h3> 
                    <div> <button class='btn btn-sm btn-danger' id='delete$idP' onclick='deleteS($idP)'>Usuń</button></div>
                    </div>";
            ?>
            <div class="">
                <div class="firstCol">
                    <table id="<?php echo "table" ?>" class="table table-striped table-bordered mt-4">
                        <thead>
                            <tr class="text-center">
                                <th class="col">lp</th>
                                <th class="col">Klasa<br>(klasa - grupa)</th>
                                <th class="col">liczba godzin zrealizowanych</th>
                                <th class="col">Podstawę programową zrealizowałem(am) zgodnie z przyjętym planem pracy dydaktycznej</th>
                                <th class="col">Do realizacji w nastepnym roku szkolnym/semestrze pozostało (podać dział lub niezrealizowaną partię materiału)</th>
                                <th>Usuń</th>
                            </tr>
                        </thead>                    
                        <tbody  id="tableBody">  
                            <?php                                                  
                                $sql = "SELECT * FROM prog_Realizacja WHERE rokSzk = $rokSzk AND semestr = $semestr AND przedmiot = $idP AND id_nauczyciela = $belfer_id ORDER BY klasa";
                                $result2 = $conn->query($sql);   
                                $i = 1;                                             
                                while($row2 = $result2->fetch_assoc()){ 
                                    $idClass = $row2['id']; ?>                                
                                    <tr>
                                        <td><?php echo $i ?></td>                                
                                        <td class="text-center"><?php echo $row2['klasa'] ?></td>                                
                                        <td class="text-center"><?php echo $row2['godz'] ?></td>                                                                
                                        <?php $check = ($row2['zrealizowany'] == 1) ? "tak" : "nie"; ?>
                                        <td class="text-center" style="width: 250px"> <?php echo $check ?></td>                                                                
                                        <td class="text-center"><?php echo $row2['uzasadnienie'] ?></td>
                                        <?php echo "<td class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:20px;' onclick='deleteClass($idClass)'></i></td>"; ?>
                                    </tr>
                                    <?php
                                    $i++; 
                                }
                            ?>
                        </tbody>
                    </table>  
                </div>
                <div class="formularz">
                    <p><strong>Dodaj klasę/grupę:</strong></p>                            
                    <form action="save.php" method="POST" id="<?php echo "form$idP" ?>" class="formSubject">                         
                        <div class="formField">
                            <input type="text" name="przedmiot" value="<?php echo "$idP" ?>" hidden>
                            <label for="klasa<?php echo "$idP" ?>">Klasa/grupa: </label>
                            <input class="form-control" type="text" width="10" name="klasa" placeholder="np. 1A gr1 ...." required>                            
                        </div>
                        <div class="formField">
                            <label for="godz<?php echo "$idP" ?>">Liczba godzin zrealizowanych: </label>
                            <input class="form-control mx-auto" style="max-width:100px" type="number" name="godz" placeholder="" required>
                        </div>
                        <div class="formField form-check">
                            <label class="form-check-label">Podstawa zrealizowana: </label>
                            <input class="form-check-input mx-auto" type="checkbox" onclick="check(<?php echo $idP ?>)" name="zrealizowany" id="<?php echo "check$idP" ?>">
                        </div>
                        <div class="formField">
                            <label class="form-check-label" >Do realizacji w następnym roku szkolnym/semestrze<br><span>podać dział lub niezrealizowaną partię materiału</span>: </label>
                            <textarea class="form-control" placeholder="..." name="uzasadnienie" id="<?php echo "uzasadnienie$idP" ?>" required ></textarea>
                        </div>
                        <div class="formField formSave">
                            <input type="submit" class="btn btn-primary btn-save mx-auto" value="Dodaj" name="progDodajKlase" for="<?php echo "form$idP" ?>" >
                        </div>                        
                    </form>
                </div>
                <hr>
            </div>
        <?php 
        }
    }
    ?>        
</div>
    <script>        
        function deleteS(id) {
            const table = 'prog_PrzedmiotyN';
            if (confirm("Czy napewno chcesz usunąć przedmiot?")) {
                window.location.href = `delete-record.php?table=${table}&id=${id}`;
            }else {
                alert("OK");
            }
        }
        function deleteClass(id) {
            const table = 'prog_Realizacja';
            if (confirm("Czy napewno chcesz usunąć przedmiot?")) {
                window.location.href = `delete-record.php?table=${table}&id=${id}`;
            }else {
                alert("OK");
            }
        }
        
        function check(id) {
            var checkbox = document.getElementById("check" + id);
            var textarea = document.getElementById("uzasadnienie" + id);

            if (checkbox.checked) {
                textarea.removeAttribute("required");
                textarea.disabled = true; // Wyłącz pole textarea
            } else {
                textarea.setAttribute("required", "required");
                textarea.disabled = false; // Włącz pole textarea
            }
        }

    </script>

</div>



