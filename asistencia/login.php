<?php include ("db.php"); ?>
<?php include ("includes/header.php"); ?>

<?php 
		if (true){//!session_status()
			session_start();
		}	

	if (isset($_SESSION['mensaje'])) { ?>

	<div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
		<?= $_SESSION['mensaje'] ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<?php } unset($_SESSION['mensaje']); ?>

<div class="container p-6 col-4">
<form action="compruebalogin.php" method="POST">
	<div class="panel panel-primary">
		<div class="panel-heading text-center">
			<h2></h2>
		</div>

		

		<div class="panel-body">
			<h4>Usuario:</h4>
			<input type="text" class="form-control" name="usuario">
			<br>
			<h4>Contraseña:</h4>
			<input type="password" class="form-control" name="clave">
			<br>
			<div class="form-group" style="text-align:left;color:blue" > <h5>Opciones:
				<select name="opcion">
					<option value="0">Seleccione:</option>
					<?php
					$queryop="SELECT * FROM opciones";
					$rop=mysqli_query($conn,$queryop);
					while ($valores = mysqli_fetch_array($rop)) {
						echo '<option value="' . $valores['id'] . '">' . $valores['Opcion'] . '</option>';
					}
					?>
				</select>
				</h5> 
			</div>
		</div>
		<div class="panel-footer">
			<br>
			<!-- <button class="btn btn-primary">Ingresar</button> -->
			<input type="submit" class="btn btn-primary" name="intento" value="Aceptar">
		</div>
	</div>
</form>
</div>


<?php include ("includes/footer.php"); ?>


