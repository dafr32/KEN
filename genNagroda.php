<?php
session_start();
if ( !isset($_SESSION['correct']) || $_SESSION['correct']=="false"){
    header('Location: index.php');
}

$id = $_GET["id"];
require "connect.php";
$rok = $_SESSION['rok'];
$semestr = $_SESSION['semestr'];

$sql = "SELECT * FROM nagrody_wpisy WHERE id_ucznia = $id AND rok = $rok";
// echo $sql;
$result = $conn->query($sql);                  
if ($result->num_rows > 0) 
{ 

} else
{
    ?>
    <!-- brak nagrody  -->
    <div class="row">
        <div class="col-sm-3 text-center">
            <h4 class="bg-dark text-center text-info">Nagroda</h4>
            <h5>DLA</h5>
            <h1><?php echo $_GET["dla"] ?> </h1>
            <h5>ZA</h5>

        </div>
    </div>
<?php
}
?>

