<?php

session_start();
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/funciones.php';
include ($rutaf);

$menuadmin= 'https://lagoelectromecanica.com/asistencia/menuadmin.php';
$posicion= 'https://lagoelectromecanica.com/asistencia/Altas/posicion.php';
$login= 'https://lagoelectromecanica.com/asistencia/login.php';

if($_POST['opcion'] < 1){
    $_SESSION['mensaje'] = "Debe ingresar una opcion.";
    $_SESSION['tipo_mensaje'] = "danger";
    header("location: login.php");
    die();
}else{
    $opc=$_POST['opcion'];
    if ($opc==1){$opcion='Entrada';}
    if ($opc==2){$opcion='Salida';}
    if ($opc==3){$opcion='Posicion';}
}

$cuenta=0;
if(isset($_POST['usuario'])){
    $miuser=htmlentities(addslashes($_POST['usuario']));
    $miclave=htmlentities(addslashes($_POST['clave']));
}else{
    die("Algo raro pasó :(");
}

try{
    $base= new PDO("mysql:host=localhost; dbname=lagoelec_asis", "lagoelec_admin", "phVAiGuvwbHs");
    //$base= new PDO("mysql:host=localhost; dbname=c1600506_asistencia", "c1600506", "pegi45soVA");
    $base->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET utf8");
    $sql="SELECT * FROM usuarios WHERE User= :miuser";
    $resultado=$base->prepare($sql);

    $resultado->bindValue(":miuser", $miuser); 

    $resultado->execute();

    while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
        if(password_verify($miclave, $registro['Clave'])){
            $categoria=$registro['id_categoria'];
            $cuenta++;
        }
    }
    ?>

<?php
    
    $filas=$cuenta;
    if($filas != 0){
        $_SESSION['ingresado']=$_POST['usuario'];
        //useracceso($_SESSION['ingresado'],$opcion);
        //useracceso('prueba','ingreso');
        //header("location: autenticado.php");
        if($categoria==1){// admin 
            //header("location: menuadmin.php");
            //header("location: /asistencia/menuadmin.php");
            echo '<meta http-equiv="refresh" content="0;url=' . $menuadmin . '" />';
            die();
        }else{ // categorias personal e invitado
            //die('llegamos');
            //echo 'registro realizado!'
            useracceso($_SESSION['ingresado'],$opcion);
            //header("location: /asistencia/Altas/posicion.php");
            echo '<meta http-equiv="refresh" content="0;url=' . $posicion . '" />';
            die();
        }
        die();
        
    }
    else{
        $_SESSION['mensaje'] = "Debe ingresar un usuario y contraseña válidos.";
        $_SESSION['tipo_mensaje'] = "danger";
        //header("location: login.php");
        echo '<meta http-equiv="refresh" content="0;url=' . $login . '" />';
        die();
    }
}
catch(Exception $e){
    die("Error Servicios: " . $e->getMessage());
}

$resultado->closeCursor();

?>

<?php
//include ("footer.php")
?>