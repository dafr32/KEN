<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - MENU
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }      
    require "connect.php"; 
    $_SESSION['content-admin'] = "admin_Egzaminy.php";
    if(!isset($_SESSION['egzaminy-content'])) $_SESSION['egzaminy-content'] = "admin_Egzaminy_Komisje.php";
    if(!isset($_SESSION['egzaminy-rok'])) $_SESSION['egzaminy-rok'] = 2025;
    $idMenu = isset($_SESSION['idMenu']) ? $_SESSION['idMenu'] : '';
?>
<style>
    .nav-link {cursor: pointer;}
    .btn-toggle {
        transition: all 03.s ease;
    }
    .btn-toggle::before {
        width: 1.25em;
        line-height: 0;        
        transition: transform .35s ease;
        transform-origin: .5em 50%;
        color: #fff;        
    }
    .btn-toggle::before {
        content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%28255,255,255,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");               
    }
    .btn-toggle[aria-expanded="true"]::before {
        transform: rotate(90deg);
    }
    .btn-toggle-nav .nav-link {padding-left: 35px}
 
    #MenuEgzaminy > .nav-link {
        cursor: pointer;
        padding-left: 5px;
        color: #3dd73d;
    }
    #MenuEgzaminy .raporty .nav-link {
        padding-left: 10px;
    }

</style>
<div class="container-fluid" style="max-width: 1600px">
    <div class="row">
        <div class="col-sm-12 col-xxl-2 mt-3 ">
            <div class="bg-dark">
                <nav class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark">
                    <ul id="MenuEgzaminy" class="nav nav-pills flex-column mb-auto">
                        <li class="nav-link" id="Terminy">Terminy egzaminów</li>                    
                        <li class="nav-link" id="Komisje">Komisje egzaminacyjne</li>
                        <li class="nav-item" ><hr></li>                       
                        <li class="nav-item raporty" style="    color: #0d6efd; text-transform: uppercase;">Raporty
                            <ul class="btn-toggle-nav list-unstyled pb-1">                                
                                <li class="nav-link" id="Raport_Nauczyciele" >Nauczyciele - przydziały</li>
                                <li class="nav-link" id="Raport_Nauczyciele_Przydzialy" >Nauczyciele - komisje</li>
                                <li class="nav-link" id="Raport_Komisje" >Komisje</li>
                                <li class="nav-link" id="Raport_Sale" >Sale - wykazy</li>
                                <li class="nav-link" id="Raport_Students" >Lista zdających</li>
                            </ul>
                        </li>
                        <li class="nav-item" ><hr></li>                       
                        <li class="nav-item" style="color: red; text-transform: uppercase;">Raporty </li>                       
                            <ul id="lata" class="btn-toggle-nav list-unstyled pb-1">                 
                                <li class="nav-link" data-id="2024" >2024</li>
                                <li class="nav-link" data-id="2025" >2025</li>
                            </ul>
                        </li>
                    </ul>
                </nav>                 
            </div>
            <h3 class="mt-3">Import uczniów</h3>
            <p class="small">Kod zdającego;Nazwisko;Imiona;Pesel lub nr dokumentu;Rodzaj deklaracji;Typ arkusza;Egzamin;Sposoby dostosowania;Nr sali</p>
            <form action="savelist.php" method="POST" enctype="multipart/form-data">
                <label for="csvFile">Select CSV File:</label>
                <input type="hidden" name="rok" id="rok-input" value="<?php echo ($_SESSION['egzaminy-rok'] ?? '') ?>">
                <input type="file" name="csvFile" id="csvFile" accept=".csv" required>                
                <div class="text-right ">
                    <button type="submit" name="import_Users_Egzaminy" id="importButton" class="btn btn-primary my-4 px-5">Import</button>                    
                </div>
            </form>
        </div>
        <div class="col-10">
            <div id="egzaminy_content" data-id-menu="<?php echo $idRok ?>">
                <?php include $_SESSION['egzaminy-content'] ?>
            </div>
        </div>
    </div>
</div>

<script>
    function activeMenuEgzaminy(id){        
        var parentDOM = document.getElementById("MenuEgzaminy");
        var menus = parentDOM.querySelectorAll('.nav-link');
        
        menus.forEach(function(item) {
            item.classList.remove('active');
        });        
        var activeMenuItem = document.getElementById(id);    
        if (activeMenuItem) {
            activeMenuItem.classList.add('active');
        }
    }

    $(document).ready(function() {  

        $("#MenuEgzaminy li").on("click", function() {
            var id_menu = $(this).attr("id");            
            if (id_menu) {                        
                $("#egzaminy_content").attr("data-id-menu", id_menu);
                activeMenuEgzaminy(id_menu);                
                $.ajax({
                    url: "admin_Egzaminy_" + id_menu + ".php",
                    type: "GET",             
                    success: function(response) {
                        $("#egzaminy_content").html(response); 
                    },
                    error: function(xhr, status, error) {
                        console.error("Błąd ładowania egzaminów:", error);
                    }
                });
            } else {
                console.error("Brak id_menu!");
            }
        });

       
        $("#lata > li").on("click", function() {
            const rok = $(this).attr("data-id"); 
            window.location.href = "/ken_admin.php?rok="+rok;                       
            
        });


        // Import uczniów
        const importButton = document.getElementById("importButton");
        const rokInput = document.getElementById("rok-input");
        const importForm = document.getElementById('importForm'); // Get form
       
        // Add event listener to the import button
        importButton.addEventListener('click', function(event) {
            // event.preventDefault(); // Remove this line
             let rok = prompt("Wpisz rok:");

            if (rok !== null && rok >= 2024) {                
                // If the user entered a year and clicked OK, update the year
                rokInput.value = rok;   
                 // importForm.submit(); - We are not submiting form here      
            } else {
                // User clicked Cancel or entered an invalid year
                 event.preventDefault();// Prevent the default form submission
                 alert("Musisz wpisać rok >= 2024");
            }
        });
       
       $("#lata > li").on("click", function() {
            const rok = $(this).attr("data-id"); 
            window.location.href = "/ken_admin.php?rok="+rok;                          
        });




    });




</script>