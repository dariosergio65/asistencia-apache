<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: ../index.php");
	die();
}
$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/funciones.php';
include ($rutaf);
$rutaindex = '/asistencia/index.php';
$usuario=$_SESSION['ingresado']; 

//$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';
$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/headermenu.php';
//include ($rutadb);
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];


if (isset($_POST['volver'])) {
		$vuelta = '/asistencia/login.php';
		//header("location: " . $vuelta);
		echo '<meta http-equiv="refresh" content="0;url=' . $vuelta . '" />';
}

if (isset($_SESSION['mensaje'])) { ?>

	<div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
		<?= $_SESSION['mensaje'] ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<?php } unset($_SESSION['mensaje']); 


?>

<form action=<?php echo $esta ; ?> method="POST">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">
			<h2></h2>
		</div>

		<table class="table table-bordered">
			<tr>
				<td>
						<div class="form-group" style="text-align:center">
						<h3> FICHADA REGISTRADA </h3>
						</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group" style="text-align:center">
					<input type="submit" class="btn btn-primary" name="volver" value="Salir">
					</div>
				</td>
			</tr>
        </table>

		<!-- <div class="panel-footer">
			<br>
			 <button class="btn btn-primary">Ingresar</button> -->
			<!-- <input type="submit" class="btn btn-primary" name="volver" value="Volver"> 
		</div> -->
	</div>
</form>


<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/footermenu.php';
include ($rutafooter); 
?>


