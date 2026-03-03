<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');

if (!session_status()){ session_start(); }

//para saber si estoy en local o en InfinityFree

$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost:8080', 'localhost:8081', '127.0.0.1:8080']);

if ($isLocal) {
    // MODO DOCKER (LOCAL)
    $host = 'db';
    $user = 'lagoelec_dario';
    $pass = 'Tq63dsAm6No8';
} else {
    // MODO INFINITYFREE (PRODUCCIÓN)
    $host = 'sql123.infinityfree.com';  // Reemplaza con tu host real
    $user = 'if0_12345678';             // Reemplaza con tu usuario
    $pass = 'password_produccion';      // Reemplaza con tu contraseña
}

$db   = 'lagoelec_asis';  // Nombre de la BD (puede cambiar en producción)


// 1. Configuración de la base de datos

//$db_host="db";
//$db_nombre="lagoelec_asis";
//$db_usuario="lagoelec_dario";
//$db_contra="Tq63dsAm6No8";

// 2. Conectar

$conn = mysqli_connect($host,$user,$pass,$db);


mysqli_set_charset($conn, "utf8"); //par las eñes

mysqli_query($conn, "SET time_zone = '-03:00'"); //importante!!!

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