<?php
session_start();
if (!isset($_SESSION['ingresado'])) {
    header("location: /asistencia/index.php");
    die();
}

$usuario = $_SESSION['ingresado'];
$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';
include($rutadb);

$vuelve = '/asistencia/abmb/usuarios.php';

// ============================================
// 1. PROCESAR ACTUALIZACIÓN SI VIENE DEL FORM
// ============================================
if (isset($_POST['update'])) {
    $minombre = $_POST['nombre'];
    $micat    = $_POST['cat'];
    $misector = $_POST['sec'];
    $miclave  = $_POST['clave'];
    $miuser   = $_POST['user'];

    $query = "UPDATE usuarios SET 
                Nombre = '$minombre', 
                id_categoria = $micat, 
                id_sector = $misector, 
                Clave = '$miclave' 
              WHERE User = '$miuser'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Algo falló y no se pudo modificar el registro.");
    }

    $_SESSION['message'] = "Registro de Usuarios actualizado con éxito";
    $_SESSION['message_type'] = "success";
    header("location: " . $vuelve);
    die();
}

// ============================================
// 2. OBTENER DATOS DEL USUARIO A MODIFICAR
// ============================================
if (isset($_GET['id'])) {
    $miuser = $_GET['id'];
    $query = "SELECT * FROM usuarios WHERE User = '$miuser'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $minombre = $row['Nombre'];
        $micat    = $row['id_categoria'];
        $misector = $row['id_sector'];
        $miclave  = $row['Clave'];
    } else {
        die("Usuario no encontrado.");
    }
} else {
    die("ID de usuario no especificado.");
}

// ============================================
// 3. INCLUIR HEADER (DESPUÉS DE TODA LA LÓGICA)
// ============================================
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/headermenu.php';
include($rutaheader);
?>

<!-- Mensajes de sesión -->
<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php 
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
} 
?>

<!-- Formulario de modificación -->
<div class="container p-4">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">
                <form action="<?= $_SERVER['PHP_SELF'] . '?id=' . $miuser ?>" method="POST">

                    <div class="form-group">
                        <input type="text" name="falsouser" style="background-color:yellow;" disabled value="<?= $miuser ?>">  
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="user" value="<?= $miuser ?>">  
                    </div>

                    <div class="form-group">
                        Nombre: 
                        <input type="text" name="nombre" value="<?= $minombre ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        Categoría: 
                        <select name="cat" style="width: 50%" required>
                            <option value="">Seleccione:</option>
                            <?php
                            $querycat = "SELECT * FROM categorias";
                            $resultcat = mysqli_query($conn, $querycat);
                            while ($valores = mysqli_fetch_array($resultcat)) {
                                $selected = ($micat == $valores['id']) ? 'selected' : '';
                                echo '<option value="' . $valores['id'] . '" ' . $selected . '>' . $valores['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        Sector: 
                        <select name="sec" style="width: 50%" required>
                            <option value="">Seleccione:</option>
                            <?php
                            $querysec = "SELECT * FROM sectores";
                            $resultsec = mysqli_query($conn, $querysec);
                            while ($sec = mysqli_fetch_array($resultsec)) {
                                $selected = ($misector == $sec['id']) ? 'selected' : '';
                                echo '<option value="' . $sec['id'] . '" ' . $selected . '>' . $sec['Sector'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        Clave: 
                        <input type="password" name="clave" value="<?= $miclave ?>" class="form-control" required>
                    </div>

                    <button class="btn btn-success" name="update">MODIFICAR</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/footermenu.php';
include($rutafooter);
?>