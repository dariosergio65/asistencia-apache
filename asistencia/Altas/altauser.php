<?php
session_start();
if (!isset($_SESSION['ingresado'])){
    header("location: /asistencia/index.php");
    die();
}

include("../db.php");
include("../includes/funciones.php");

// Procesar el formulario si se envió
if (isset($_POST['cargauser'])) {
    $miuser    = $_POST['user'];
    $minombre  = $_POST['nombre'];
    $micat     = $_POST['cat'];
    $misector  = $_POST['sec'];
    $miclave   = encriptar($_POST['clave']);

    // Validar que no exista el usuario
    $check = "SELECT User FROM usuarios WHERE User = '$miuser'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "El nombre de usuario ya existe";
        $_SESSION['message_type'] = "danger";
        header("location: altauser.php");
        die();
    }

    // Insertar nuevo usuario
    $query = "INSERT INTO usuarios (User, Nombre, id_categoria, id_sector, Clave) 
              VALUES ('$miuser', '$minombre', $micat, $misector, '$miclave')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['message'] = "Registro cargado con éxito";
        $_SESSION['message_type'] = "success";

        // Determinar adónde volver según flag
        if (isset($_GET['flag'])) {
            if ($_GET['flag'] == 0) {
                header("location: /asistencia/abmb/usuarios.php");
            } elseif ($_GET['flag'] == 1) {
                header("location: /asistencia/Altas/altaservicio.php");
            } else {
                header("location: altauser.php");
            }
        } else {
            header("location: altauser.php");
        }
        die();
    } else {
        die("Algo falló y no se pudo CARGAR el registro.");
    }
}

// ⬇️ Recién acá incluimos el header (después de TODA la lógica PHP)
include("../includes/headermenu.php");
?>

<!-- Mostrar mensajes de sesión -->
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

<!-- Formulario de alta de usuario -->
<div class="container p-1">
    <div class="row">
        <div class="col-md-7">
            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
                <table class="table table-bordered">
                    <thead class="thead-cel" style="text-align:center">
                        <tr>
                            <th>USUARIO NUEVO:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>User <input type="text" name="user" style="width: 100%" placeholder="Usuario nuevo" required></td>
                        </tr>
                        <tr>
                            <td>Nombre: <input type="text" name="nombre" style="width: 50%" placeholder="Nombre real" required></td>
                        </tr>
                        <tr>
                            <td>Categoría: 
                                <select name="cat" style="width: 50%" required>
                                    <option value="">Seleccione:</option>
                                    <?php
                                    $querycat = "SELECT * FROM categorias";
                                    $resultcat = mysqli_query($conn, $querycat);
                                    while ($valores = mysqli_fetch_array($resultcat)) {
                                        echo '<option value="' . $valores['id'] . '">' . $valores['nombre'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sector: 
                                <select name="sec" style="width: 50%" required>
                                    <option value="">Seleccione:</option>
                                    <?php
                                    $querysec = "SELECT * FROM sectores";
                                    $resultsec = mysqli_query($conn, $querysec);
                                    while ($sec = mysqli_fetch_array($resultsec)) {
                                        echo '<option value="' . $sec['id'] . '">' . $sec['Sector'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Clave: <input type="password" name="clave" style="width: 50%" placeholder="Clave" required></td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-success" name="cargauser">
                                    CARGAR USUARIO
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include("../includes/footermenu.php"); ?>