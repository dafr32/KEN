<?php
   // *********************************************************************
    // Dyrektor - Egzaminy 
    // - Raport Lista Zdających
    // *********************************************************************

    if (session_status() === PHP_SESSION_NONE) { session_start(); }  
    include "head.php";
    require "connect.php"; 

    $rok = $_SESSION['egzaminy-rok'];
    $_SESSION['egzaminy-content'] = "admin_Egzaminy_Raport_Students.php";
?>

<style>
    .table>:not(caption)>*>* {
        padding: 2px 5px; 
    }
    .table tr:hover {
        cursor: pointer;
    }
    /* Modal Styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 800px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<h2 class="text-center my-1">Lista zdających - <?php echo $_SESSION['egzaminy-rok'] ?></h2>
<div class="mt-2" style="max-width:800px; margin-left:auto; margin-right:auto">
    <?php
    $sql = "SELECT `Kod zdającego` as kod, `Nazwisko`,  `Imiona`, `Rok` 
            FROM `egzaminy__Uczniowie` 
            WHERE Rok = $rok GROUP BY kod";
    
    // echo $sql;
    $result = $conn->query($sql);        
    if ($result->num_rows > 0) { ?>
        <table class="table">
        <thead>
            <tr>
                <th>lp</th>
                <th>Kod</th>
                <th>Nazwisko</th>
                <th>Imiona</th>            
                <th>Rok</th>            
            </tr>
        </thead>
        <tbody>
        <?php
            $lp=1;
            while($row = $result->fetch_assoc()) {  
                echo "<tr id=".$row['kod']." data-kod='".$row['kod']."' data-rok='".$row['Rok']."'>";
                echo "<td>$lp</td>";
                echo "<td>". $row['kod'] . "</td>";
                echo "<td>". $row['Nazwisko'] . "</td>";
                echo "<td>". $row['Imiona'] . "</td>";
                echo "<td>". $row['Rok'] . "</td>";
                echo "</tr>";                   
                $lp+=1;                        
            }
        ?>
        </tbody>
        </table>
    <?php
    } ?>
</div>



<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>



<script>
    const el = document.querySelector('table');
    if (el) { // Check if the table exists
        const rows = el.querySelectorAll('tbody tr'); // Select rows only from tbody
        const modal = document.getElementById("myModal");
        const modalContent = document.getElementById("modal-body");
        const span = document.getElementsByClassName("close")[0];

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const kod = this.dataset.kod;
                const rok = this.dataset.rok;
                modal.style.display = "block";

                // AJAX request to get data
                fetch('admin_Egzaminy_get_student_details.php?kod=' + kod +'&rok=' + rok)
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
            });
        });

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
</script>
