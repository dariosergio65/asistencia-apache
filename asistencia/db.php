<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
if (!session_status()){ session_start(); }
//session_start();
//session_destroy();
//echo "cargada";

// 1. Configuración de la base de datos

$db_host="localhost";
$db_nombre="lagoelec_asis";
$db_usuario="lagoelec_admin";
$db_contra="phVAiGuvwbHs";

// 2. Conectar

$conn = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

mysqli_set_charset($conn, "utf8"); //par las eñes
mysqli_query($conn, "SET time_zone = '-03:00'");
//configura mysqul para que me de la hora de Argentina

// 3. Verificar conexión y ejecutar consultas sacarlo en produccion
/*
if ($conn) {
    echo "✅ Conexión exitosa a la base de datos<br>";
    
    // Ejemplo de consulta
    $query = "SELECT NOW() as fecha_actual";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "Fecha del servidor: " . $row['fecha_actual'] . "<br>";
        mysqli_free_result($result);
    }
} else {
    echo "❌ No se pudo conectar a la base de datos<br>";
}
*/
?>