<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
    die();
}
$usuario=$_SESSION['ingresado'];

$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/funciones.php';
include ($rutaf);

//$vuelta='/asistencia/Altas/final.php';
$final='https://lagoelectromecanica.com/asistencia/Altas/final.php';

$bandera=true;

        if (isset($_SESSION['mensaje'])) { ?>

        <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php } unset($_SESSION['mensaje']); 


if (isset($_GET["lat"]) && isset($_GET["lon"])) {
    $bandera=false;
    $lat = $_GET["lat"]; //latitud
    $lon = $_GET["lon"]; //longitud
    $exa = $_GET["exa"]; //exactitud
    useracceso($usuario,'vacio',$lat,$lon,$exa);
        //echo $usuario;
        $_SESSION['message'] = "Registro cargado con exito";
        $_SESSION['message_type'] = "success";
        //header("location: " . $vuelta);
        echo '<meta http-equiv="refresh" content="0;url=' . $final . '" />';
        die('fin');

} elseif($bandera) {?>
    
    <div id='ubicacion'></div>
    
    <script type="text/javascript">
        //comienza javascript para obtener localización
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(mostrarUbicacion);
        } else {alert("¡Error! Este navegador no soporta la Geolocalización.");}
        function mostrarUbicacion(position) {
            var latitud = position.coords.latitude;
            var longitud = position.coords.longitude;
            var exactitud = position.coords.accuracy;	
            var div = document.getElementById("ubicacion");
            //div.innerHTML = "<br>Latitud: " + latitud + "<br>Longitud: " + longitud + "<br>Exactitud: " + exactitud;
            
            window.location.href = window.location.href + "?lat=" + latitud + "&lon=" + longitud + "&exa=" + exactitud;}	
            
        function refrescarUbicacion() {	
            navigator.geolocation.watchPosition(mostrarUbicacion);}	
        //fin javascript
    </script>

<?php } ?>

<?php
//include ("footer.php")
?>