<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

include ("../db.php");
include ("../includes/header.php");
//include ("../includes/funciones.php");
//include_once ("funciones.js");
$vuelve= '/asistencia/Buscar/verop.php?id=';
?>

<?php echo 'nada1' ?>



<?php include ("../includes/footer.php") ?>