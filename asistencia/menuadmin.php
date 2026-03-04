<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: index.php");
    die();
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/funciones.php';
include ($rutaf);
$rutaindex = '/asistencia/index.php';
$usuario=$_SESSION['ingresado']; 

// Detectar si estás en local o producción
$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost:8080', 'localhost:8081', '127.0.0.1:8080']);

if ($isLocal) {
    $base_url = 'http://localhost:8081';
} else {
    $base_url = 'https://dario.free.nf';
}


$usuarios = $base_url . '/asistencia/abmb/usuarios.php';
$accesos = $base_url . '/asistencia/Consultas/accesos.php';

//$pantalla = 'menuadmin0';//ojo al cambiar nombre del archivo php
//$usuarios= 'https://dario.free.nf/asistencia/abmb/usuarios.php';
//$accesos= 'https://dario.free.nf/asistencia/Consultas/accesos.php';

//include ("includes/headermenu.php");


?>
<?php
if (isset($_POST['abmusers'])){
    header ("location: abmb/usuarios.php");
    //echo '<meta http-equiv="refresh" content="0;url=' . $usuarios . '" />';
}elseif (isset($_POST['accesos'])){
    header ("location: Consultas/accesos.php");
    //echo '<meta http-equiv="refresh" content="0;url=' . $accesos . '" />';
}

include ("includes/headermenu.php");
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center"> 
                        <tr>
                            <th>AMB</th>
                            <th>PRINCIPALES</th>
                            <th>CONSULTAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-success" name="abmusers" >
                                    ABM USUARIOS
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-secondary" name="nada">
                                    Disponible
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                        <button class="btn btn-success" name="accesos">
                                        ACCESOS
                                        </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-secondary" name="nada">
                                    Disponible
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-secondary" name="nada">
                                    Disponible
                                    </button>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group">
                                    <button class="btn btn-secondary" name="nada">
                                        Disponible
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php
include ("includes/footermenu.php");
?>