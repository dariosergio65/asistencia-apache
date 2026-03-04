<?php
session_start();
if (!isset($_SESSION['ingresado'])) {
    header("location: /asistencia/index.php");
    die();
}
$usuario = $_SESSION['ingresado'];

include $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';

// Verificar si el usuario logueado es admin (categoría 1)
$query = "SELECT id_categoria FROM usuarios WHERE User = '$usuario'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if ($row['id_categoria'] != 1) {
    die("No tenés permisos para borrar usuarios.");
}

// ============================================
// 1. PROCESAR EL BORRADO
// ============================================
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM usuarios WHERE User = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("No se pudo borrar el registro");
    }

    $_SESSION['message'] = 'Registro borrado';
    $_SESSION['message_type'] = 'danger';

    header("location: /asistencia/abmb/usuarios.php");
    die();
}

// ============================================
// 2. INCLUIR HEADER (DESPUÉS DE LA LÓGICA)
// ============================================
include $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/headermenu.php';
?>

<!-- Mostrar mensajes de sesión (si los hay) -->
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

<!-- Acá podrías poner un mensaje si querés, o dejar vacío -->
<div class="container">
    <p>Procesando...</p>
</div>

<?php 
// ============================================
// 3. INCLUIR FOOTER (RUTA CORREGIDA)
// ============================================
include $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/footermenu.php';
?>