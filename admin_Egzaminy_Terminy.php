<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Terminy Egzaminów
    // *********************************************************************
    if (session_status() === PHP_SESSION_NONE) {session_start(); }  
    require "connect.php"; 


    $_SESSION['content-admin'] = "admin_Egzaminy.php";
    $_SESSION['egzaminy-content'] = "admin_Egzaminy_Terminy.php";
    $rok = $_SESSION['egzaminy-rok'];
    if(isset($_GET['del_id'])){
        $sql = "DELETE FROM `egzaminy__Terminy` WHERE id=? AND rok=$rok";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_GET["del_id"]);
        $stmt->execute();
        if($stmt === false) {
            echo "Prepared statement creation failed: " . $conn->error;
            exit;
        }
    }

?>

<style>
    table th, table td {vertical-align: middle; text-align:center; padding: 4px 8px !important}
    table .form-control { padding: 5px; }   
    table .form-select {text-align:center}
    #egzaminyTable thead th { background: #0d6efd; color: #fff}
</style>

<div class="container p-3">    
    <div class="row">
        <div class="col-sm-12 col-xxl-9 pe-2">  
            <h2 class="mb-3">Terminy egzaminów - <?php echo $_SESSION['egzaminy-rok'] ?></h2> 
            <form action="save.php" method="POST">                     
                <div style="max-height: calc(100vh - 300px); overflow:auto">                
                    <table id="egzaminyTable" class="table table-striped" >
                        <thead class="bg-dark">
                            <tr>
                                <th class="" style="width: 5%">ID</th>
                                <th class="" style="width: 45%">Przedmiot</th>
                                <th class="" style="width: 20%">Data</th>
                                <th class="" style="width: 20%">Godzina</th>  
                                <th class="" style="width: 10%">Usuń</th>                  
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            $sql = "SELECT * FROM egzaminy__Terminy WHERE Year(data) = ".  $_SESSION['egzaminy-rok'] ." ORDER BY data, godz ";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $_SESSION['ilePrzedmiotowEgzamin'] = $result->num_rows;
                                $i = 1;
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) { 
                                    $godz = $row['godz'];   
                                    $id = $row["id"] ;                     
                                    $przedm = $row['przedmiot'];
                                    ?>
                                    <tr>
                                        <th> <input type="hidden" name="id<?php echo $i ?>" value="<?php echo $row["id"] ?>"> <?php echo $i; ?></th>
                                        <td> <input type="text" name="przedmiot<?php echo $i ?>" class="form-control text-left" id="przedmiot"  value="<?php echo $row['przedmiot'] ?>" require></td>
                                        <td> <input type="date" name="data<?php echo $i ?>" class="form-control" id="data" value="<?php echo $row['data'] ?>" require></td>                            
                                        <td>
                                            <select name="godz<?php echo $i ?>" id="godz<?php echo $i ?>" class="form-select" require>               
                                                <option value="1" <?php echo ($godz==null) ? "selected":"" ?>></option>    
                                                <option value="1" <?php echo ($godz==1) ? "selected":"" ?>>9:00</option>
                                                <option value="2" <?php echo ($godz==2) ? "selected":"" ?>>14:00</option>
                                            </select>
                                        </td>                                    
                                        <?php echo "<th class='text-center text-grey'><i class='bi bi-trash3-fill' style='cursor:pointer; font-size:20px;' onclick='delPrzedmiot( $id , \"$przedm\")'></i></th>"; ?>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } 
                            ?>
                        </tbody>
                    </table>                
                </div>
                <div class="text-end mt-2">
                    <button class="btn btn-primary" name="updateEgzaminy" type="submit">Zapisz </button>
                </div>            
            </form>
        </div>
        <div class="col-sm-12 col-xxl-3 p-4 bg-light ">
            <!-- Formularz dodawania nowego przedmiotu i terminu -->
            <h3 class="mb-3">Dodaj nowy przedmiot i termin</h3>
            <form id="DodajEgzamin" action="save.php" method="POST">
                <div class="mb-3">
                    <label for="przedmiot" class="form-label">Przedmiot:</label>
                    <input type="text" class="form-control" id="przedmiot" name="przedmiot" require>
                </div>
                <div class="d-flex">
                    <div class="mb-3">
                        <label for="data" class="form-label">Data:</label>
                        <input type="date" class="form-control" id="data" name="data" require>
                    </div>
                    <div class="mb-3">
                        <label for="godzina" class="form-label">Godzina:</label>
                        <select name="godz" id="godz" class="form-select ms-3" style="width: 100px; font-weight: bold;" require>               
                            <option value="1" >9:00</option>
                            <option value="2" >14:00</option>
                        </select>
                    </div>
                    
                </div>
                <input type="hidden" name="rok" value="<?php echo ($_SESSION['egzaminy-rok'] ?? '') ?>">
                <div class="text-end">
                    <button type="submit" name="DodajEgzamin" class="btn btn-primary">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addPrzedmiot(id, nazwa) { 
        $.ajax({
                url: `admin_Egzaminy_Terminy.php?del_id=${id}`,
                type: "GET", // Typ żądania            
                success: function(response) {
                    $("#egzaminy_content").html(response); 
                }
            });
    }
    function delPrzedmiot(id, nazwa) { 
        const result = confirm("Czy chcesz skasować przedmiot "+nazwa+" ?");        
        if (result === true) {
            $.ajax({
                url: `admin_Egzaminy_Terminy.php?del_id=${id}`,
                type: "GET", // Typ żądania            
                success: function(response) {
                    $("#egzaminy_content").html(response); 
                }
            }); 
        // window.location.href = `admin_Egzaminy_Terminy.php?del_id=${id}`;
        } else {
            console.log("User clicked Cancel");
        }                       
    }
</script>