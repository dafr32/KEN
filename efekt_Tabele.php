<?php   
    if (session_status() === PHP_SESSION_NONE) {session_start(); }
    require "connect.php";
    $_SESSION['content-admin'] = "efekt_Tabele.php";



    if (isset($_POST["submitUpdate"])) {
        // Aktualizacja rekordu po przesłaniu formularza
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $newEl = isset($_POST["element"]) ? $_POST["element"] : null;
        $table = isset($_POST['table']) ? $_POST['table'] : null;        
       
        // echo "tabela:".$table."<br>";
        // echo "element:".$newEl."<br>";
        $updateSql = "UPDATE $table SET `element`='$newEl' WHERE `id`=$id";        
        $conn->query($updateSql);

    }elseif (isset($_POST["submitDelete"])) {
        // Aktualizacja rekordu po przesłaniu formularza
        $id = isset($_POST["id"]) ? $_POST["id"] : null;
        $newEl = isset($_POST["element"]) ? $_POST["element"] : null;
        $table = isset($_POST['table']) ? $_POST['table'] : null;        
       
        echo "tabela:".$table."<br>";
        echo "element:".$newEl."<br>";
        $updateSql = "DELETE FROM $table WHERE `id`=$id";        
        $conn->query($updateSql);
    }



?>    
<style>
    table {
        border:1px solid #222;
    }
</style>

<!-- EFEKTY  -->
<div class="container">
    <h1 class="my-5 text-red border-bottom">EFEKTY</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php
            // Zapytanie SQL
            $sql = "SELECT `id`, `element` FROM `efektywnosc__ListaEfekty`";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<table class='table table-striped'>";
                echo "<tr class='bg-info'><th>ID</th><th>Efekt w postaci</th><th>Akcje</th></tr>";
                $i=1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td id='efekty" . $row["id"] . "' class='text-left editable' data-id='" . $row["id"] . "' data-element='" . $row["element"] . "' data-table='efektywnosc__ListaEfekty' contenteditable='true'>" . $row["element"] . "</td>";
                    echo '<td class="" style="width:150px">
                            <button class="btn btn-light btn-sm" onclick="saveChanges(\'efekty' . $row["id"] . '\') >Zapisz</button>
                            <button class="btn btn-light btn-sm ms-1" onclick="deleteElement(\'efekty' . $row["id"] . '\')">Usuń</button>
                          </td>';
                    echo "</tr>";
                    $i++;
                }
            
                echo "</table>";
            } else {
                echo "Brak wyników";
            }
            ?>
        </div>
        <div class="col-sm-12 col-md-6">
            <h2>Dodaj Efekt</h2>
            
            <form action="efekt_Pedagog.php" method="post" class="text-left">
                <label for="element">Efekt:</label>
                <input class="text-left form-control" type="text" id="element" name="element" placeholder="dodaj nowy element..." required>        
                <div class="text-right">
                    <input type="submit" name="dodajEfekt" class="text-left btn btn-primary w-50 mt-3" style="width: 150px" placeholder="dodaj nowy element..." value="Dodaj">
                </div>
                <!-- Przycisk do wysłania formularza -->
            </form>
        </div>
    </div>
</div>


<!-- Formy  -->
<div class="container">
    <h1 class="my-5 text-red border-bottom">Formy</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php
            // Zapytanie SQL
            $sql = "SELECT `id`, `element` FROM `efektywnosc__ListaFormy`";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<table class='table table-striped'>";
                echo "<tr  class='bg-info'><th>ID</th><th>Formy pracy</th><th>Akcje</th></tr>";
                $i=1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td id='formy" . $row["id"] . "' class='text-left editable' data-id='" . $row["id"] . "' data-element='" . $row["element"] . "' data-table='efektywnosc__ListaFormy' contenteditable='true'>" . $row["element"] . "</td>";
                    echo '<td class="" style="width:150px">
                            <button class="btn btn-light btn-sm" onclick="saveChanges(\'formy' . $row["id"] . '\')">Zapisz</button>
                            <button class="btn btn-light btn-sm ms-1" onclick="deleteElement(\'formy' . $row["id"] . '\')">Usuń</button>
                        </td>';
                    echo "</tr>";
                    $i++;
                }
            
                echo "</table>";
            } else {
                echo "Brak wyników";
            }
            ?>
        </div>
        <div class="col-sm-12 col-md-6">
            <h2>Dodaj Formę pracy</h2>
            
            <form action="efekt_Pedagog.php" method="post" class="text-left">
                <label for="element">Forma:</label>
                <input class="text-left form-control" type="text" id="element" name="element" placeholder="dodaj nowy element..." required>        
                <div class="text-right">
                    <input type="submit" name="dodajForme" class="btn btn-primary w-50 mt-3" style="width: 150px" value="Dodaj">
                </div>
                <!-- Przycisk do wysłania formularza -->
            </form>
        </div>
    </div>
</div>


<div class="container">
    <h1 class="my-5 text-red border-bottom">Wnioski</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <?php
            // Zapytanie SQL
            $sql = "SELECT `id`, `element` FROM `efektywnosc__ListaWnioski`";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo "<table class='table table-striped'>";
                echo "<tr class='bg-info'><th>ID</th><th>Wnioski do pracy</th><th>Akcje</th></tr>";
                $i=1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $i . "</td>";
                    echo "<td id='wnioski" . $row["id"] . "' class='text-left editable' data-id='" . $row["id"] . "' data-element='" . $row["element"] . "' data-table='efektywnosc__ListaWnioski' contenteditable='true'>" . $row["element"] . "</td>";
                    echo '<td style="width:150px">
                            <button class="btn btn-light btn-sm" onclick="saveChanges(\'wnioski' . $row["id"] . '\')">Zapisz</button>
                            <button class="btn btn-light btn-sm ms-1" onclick="deleteElement(\'wnioski' . $row["id"] . '\')">Usuń</button>
                            </td>';
                    echo "</tr>";
                    $i++;
                }
            
                echo "</table>";
            } else {
                echo "Brak wyników";
            }
            ?>
        </div>
        <div class="col-sm-12 col-md-6">
            <h2>Dodaj Wniosek do pracy</h2>
            
            <form action="efekt_Pedagog.php" method="post" class="text-left">
                <label for="element">Wniosek:</label>
                <input class="text-left form-control" type="text" id="element" name="element" placeholder="dodaj nowy element..." required>        
                <div class="text-right">
                    <input type="submit" name="dodajWniosek" class="btn btn-primary mt-3" style="width: 150px" value="Dodaj">
                </div>                
            </form>
        </div>
    </div>
</div>


<script>

    function deleteElement(id) {
        var confirmDelete = confirm('Czy na pewno chcesz usunąć ten rekord?');
        if (confirmDelete) {
            var editableCell = document.querySelector('#' + id);
            var newElement = editableCell.innerText.trim();
            
            // Utwórz formularz
            var form = document.createElement('form');
            form.method = 'post';
            form.style.display = 'none';
            document.body.appendChild(form);

            // Utwórz pola input i dodaj je do formularza
            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = editableCell.getAttribute('data-id');
            form.appendChild(inputId);

            var inputTable = document.createElement('input');
            inputTable.type = 'hidden';
            inputTable.name = 'table';
            inputTable.value = editableCell.getAttribute('data-table'); // Pobierz wartość z data-table
            form.appendChild(inputTable);

                // Dodaj pole do oznaczenia, że przesyłasz za pomocą submitUpdate
            var inputSubmitUpdate = document.createElement('input');
                inputSubmitUpdate.type = 'hidden';
                inputSubmitUpdate.name = 'submitDelete';
                inputSubmitUpdate.value = 'submitDelete';
                form.appendChild(inputSubmitUpdate);
            
            form.submit();
        }
    }

    function saveChanges(id) {
        console.log("saveChanges called with ID: " + id);
        var editableCell = document.querySelector('#' + id);
        var newElement = editableCell.innerText.trim();
        
        // Utwórz formularz
        var form = document.createElement('form');
        form.method = 'post';
        form.style.display = 'none';
        document.body.appendChild(form);

        // Utwórz pola input i dodaj je do formularza
        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = editableCell.getAttribute('data-id');
        form.appendChild(inputId);

        var inputElement = document.createElement('input');
        inputElement.type = 'hidden';
        inputElement.name = 'element';
        inputElement.value = newElement;
        form.appendChild(inputElement);

        var inputTable = document.createElement('input');
        inputTable.type = 'hidden';
        inputTable.name = 'table';
        inputTable.value = editableCell.getAttribute('data-table'); // Pobierz wartość z data-table
        form.appendChild(inputTable);

        // Dodaj pole do oznaczenia, że przesyłasz za pomocą submitUpdate
        var inputSubmitUpdate = document.createElement('input');
            inputSubmitUpdate.type = 'hidden';
            inputSubmitUpdate.name = 'submitUpdate';
            inputSubmitUpdate.value = 'submitUpdate';
            form.appendChild(inputSubmitUpdate);
        
        form.submit();
    }


</script>
