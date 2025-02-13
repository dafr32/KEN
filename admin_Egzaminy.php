<?php
    // *********************************************************************
    // Dyrektor - Egzaminy 
    // - MENU
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }      
    require "connect.php"; 
    $_SESSION['content-admin'] = "admin_Egzaminy.php";
    $_SESSION['egzaminy-content'] = "admin_Egzaminy_Komisje.php";
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
                        <li class="nav-item raporty" style="    color: #0d6efd; text-transform: uppercase;">Raporty </li>                       
                            <ul class="btn-toggle-nav list-unstyled pb-1">                                
                                <li class="nav-link" id="Raport_Nauczyciele" >Nauczyciele - przydziały</li>
                                <li class="nav-link" id="Raport_Nauczyciele_Przydzialy" >Nauczyciele - komisje</li>
                                <li class="nav-link" id="Raport_Komisje" >Komisje</li>
                                <li class="nav-link" id="Raport_Sale" >Sale - wykazy</li>
                            </ul>
                                                    
                        </li>
                    </ul>
                </nav> 
            </div>
        </div>
        <div class="col-10">
            <div id="egzaminy_content">
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
        console.log(id_menu);
        activeMenuEgzaminy(id_menu);
        $.ajax({
          url: "admin_Egzaminy_"+id_menu+".php",
            type: "GET", // Typ żądania            
            success: function(response) {
                $("#egzaminy_content").html(response); 
            }
        });
      });           

    });
</script>