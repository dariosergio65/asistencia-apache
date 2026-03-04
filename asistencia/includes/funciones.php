<?php

function encriptar($miclave){

    //include_once ("../db.php");

    $miclave=htmlentities(addslashes($miclave));
    $encriptada =  password_hash($miclave, PASSWORD_DEFAULT);

    return $encriptada;
}


function clavevalida($clave,&$error_clave){
    if(strlen($clave) < 6){
       $error_clave = "La clave debe tener al menos 6 caracteres";
       return false;
    }
    /* 
    if(strlen($clave) > 16){
       $error_clave = "La clave no puede tener más de 16 caracteres";
       return false;
    }
    if (!preg_match('`[a-z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra minúscula";
       return false;
    }
    if (!preg_match('`[A-Z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra mayúscula";
       return false;
    }
    if (!preg_match('`[0-9]`',$clave)){
       $error_clave = "La clave debe tener al menos un caracter numérico";
       return false;
    }
    */
    $error_clave = "";
    return true;
 }

 function claveanterior($usu,$clave){//verifica la clave anterior en los cambios de clave
     
    $clave=htmlentities(addslashes($clave)); //para evitar inyección
    
    try{
        $base= new PDO("mysql:host=localhost:3306; dbname=task", "root", "");
        $base->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET utf8");
        $sql="SELECT * FROM usuarios WHERE User= :miuser";
        $resultado=$base->prepare($sql);
    
        $resultado->bindValue(":miuser", $usu); 
    
        $resultado->execute();
    
        while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
            if(password_verify($clave, $registro['Clave'])){
                return true;
            }else{
                return false;
            }
        }
    
    }
    catch(Exception $e){
        die("Error Servicios: " . $e->getMessage());
    }
    
    $resultado->closeCursor();
    
 }


function useracceso($nombreusuario, $accion = 'ingreso', $lati = null, $long = null, $exac = null) {
    $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';
    include($rutadb);

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechahora = date("Y-m-d H:i:s");
    $ipuser = $_SERVER['REMOTE_ADDR'];
    $requesturi = $_SERVER['REQUEST_URI'];

    // Obtener ID del usuario
    $queryu = "SELECT User FROM usuarios WHERE User = '$nombreusuario'";
    $resultu = mysqli_query($conn, $queryu);
    $rowest = mysqli_fetch_array($resultu);
    $miuser = $rowest['User'];

    mysqli_query($conn, "SET time_zone = '-03:00'");

    if ($lati !== null && $long !== null) {
        // Ya tenemos coordenadas → ACTUALIZAR el último registro pendiente
        $sqlupdate = "UPDATE accesos 
                      SET latitud = '$lati', longitud = '$long', exactitud = '$exac', flag = 1 
                      WHERE idusuario = '$miuser' AND flag = 0 
                      ORDER BY id DESC LIMIT 1";
        mysqli_query($conn, $sqlupdate);
    } else {
        // Sin coordenadas → INSERT con flag = 0 y valores vacíos en lat/lon
        $sqlinsert = "INSERT INTO accesos 
                      (fechahora, idusuario, accion, ip, requesturi, latitud, longitud, flag) 
                      VALUES 
                      ('$fechahora', '$miuser', '$accion', '$ipuser', '$requesturi', '', '', 0)";
        mysqli_query($conn, $sqlinsert);
    }

    mysqli_free_result($resultu);
    mysqli_close($conn);
}// fin de la funcion

function comprobar($miusuario,$pantalla){ 

    $rutadb = $_SERVER['DOCUMENT_ROOT'] . '/Servicios/db.php';
    include ($rutadb);

    $query = "SELECT permitido FROM permisos WHERE id_usuario='$miusuario' AND id_pantalla='$pantalla' ";
    $result_tasks = mysqli_query($conn,$query);

    $en="enabled";
    $dis="disabled";
    
    if (!$result_tasks){
        //echo 'disabled';
        return $dis;
        die("me fui");
    }else{
        $row=mysqli_fetch_array($result_tasks);

        if($row['permitido']){
            //echo "enabled";
            return $en;
        }else{
            //echo "disabled";
            return $dis;
        }
    }
}



?>