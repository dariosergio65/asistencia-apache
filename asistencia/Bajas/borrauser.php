<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
}
$usuario=$_SESSION['ingresado'];

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/headermenu.php';
include ($rutadb);
include ($rutaheader); 
//$regreso = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/abmb/usuarios.php';
?>

<?php

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $query="DELETE FROM usuarios where User = '$id' ";
    //$query="UPDATE agentes SET activo=0 where dni = $id";
    $result=mysqli_query($conn,$query);

    if(!$result){
        die("No se pudo borrar el registro");
    }

    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    header("location: /asistencia/abmb/usuarios.php");

}
?>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/includes/footermenu.php';
include ($rutafooter); 
?>