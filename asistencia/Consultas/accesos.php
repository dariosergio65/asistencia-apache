<?php
session_start();
if (!isset($_SESSION['ingresado'])){
	header("location: ../index.php");
	die();
}

$rutadb = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/db.php';
include ($rutadb);

// esto es para que me haga un excel
//  ACA va el EXPORT, antes de TODO
if (isset($_POST['toExcel'])) {

    $miagen   = '%' . $_POST['agen'] . '%';
    $Fechaini = $_POST['fechaini'] . ' 00:00:00';
    $Fechafin = $_POST['fechafin'] . ' 23:59:59';

    $query = "
        SELECT 
            a.fechahora as Fecha,
            u.User as Usuario,
            u.Nombre as Nombre,
            a.accion as Accion,
            a.ip as IP
        FROM accesos a
        INNER JOIN usuarios u ON a.idusuario=u.User
        WHERE u.Nombre LIKE '$miagen'
        AND a.fechahora >= '$Fechaini'
        AND a.fechahora < '$Fechafin'
        ORDER BY a.fechahora DESC
    ";
    require $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/excel-export.php';
    exportarExcelConNegritas($conn, $query, 'reporte');
}//fin del excel

$rutaf = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/funciones.php';
include ($rutaf);
//$rutaexcel = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/excel-export.php';
$rutaexcel = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/exp-csv-final.php'; //funciona para cvs
include ($rutaexcel);
$rutaindex = '/asistencia/index.php';
$usuario=$_SESSION['ingresado']; 


$rutaheader = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/headermenu.php';
include ($rutaheader); 
$esta = $_SERVER['PHP_SELF'];
?>

<script>
function popup(w,h,url)
{ 
window.open(url,"popup","width="+w+",height="+h+",left=20,top=20"); 
}
</script> 

<div class="col-md-12 container p-2">
	<div class="row">
		<div class="col-md-11">
			<form action="<?php echo $esta ?>" method="POST">
							
				<table class="table table-bordered">
					<thead class="thead-cel" style="text-align:center">
						<tr>
							<th style="width: 30%" >Nombre de Empleado:</th>
							<th style="width: 20%" >Fecha desde:</th>
							<th style="width: 20%" >Fecha hasta:</th>
							<th style="width: 30%" >Acciones</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>
									<input text="est" name="agen" style="width: 100%" placeholder="Nombre a buscar">
								</td>
								<td>
									<input type="date" name="fechaini" value="<?= date('Y-m-d') ?>" style="display:block; margin:0 auto;" >
								</td>
								<td>
									<input type="date" name="fechafin" value="<?= date('Y-m-d') ?>" style="display:block; margin:0 auto;">
								</td>
								<td><input type="submit" name="Busca" value="Buscar" class="btn btn-secondary">
								
								<input type="submit" name="toExcel" value="Excel" class="btn btn-success">
								</td>								
							</tr>		
					</tbody>
				</table>

			</form>
		</div>
	</div>

	<?php if (isset($_SESSION['message'])) { ?>

		<div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
			<?= $_SESSION['message'] ?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

	<?php } unset($_SESSION['message']); ?>	


	<div class="row">

		<div class="col-md-12">
			<table class="table table-sm table-bordered table-hover">
				<thead class="thead-dario" style="text-align:center">
					<tr>
						<th style="width: 10%">Fecha</th>
						<th style="width: 10%">Usuario</th>
						<th style="width: 10%">Nombre</th>
						<th style="width: 10%">Acción</th>
						<th style="width: 10%">Latitud</th>
						<th style="width: 10%">Longitud</th>
						<th style="width: 10%">Exactitud</th>
						<th style="width: 10%">Mapa</th>
						<th style="width: 10%">Ip</th>
						<th style="width: 10%">Uri</th>
					<tr>
				</thead>
				<tbody>
					<?php
						if (isset($_POST['Busca'])){
							$miagen= '%' . $_POST['agen'] . '%';
							$Fechaini= $_POST['fechaini'] . ' 00:00:00';
							$Fechafin= $_POST['fechafin'] . ' 23:59:59';
							$query = "SELECT a.fechahora as fecha, u.User as useru, u.Nombre as nombreu, a.accion as acciona, a.latitud as alat, a.longitud as alon, a.exactitud as aexa, a.ip as ipa, a.requesturi as reqa FROM accesos a
							INNER JOIN usuarios u ON a.idusuario=u.User
							WHERE u.Nombre like '$miagen'
							AND a.fechahora >= '$Fechaini' AND a.fechahora < '$Fechafin'
							ORDER BY a.fechahora desc
							";
						}
						// esto es para que me haga un excel
						/*
						elseif (isset($_POST['toExcel'])){
							$miagen= '%' . $_POST['agen'] . '%';
							$Fechaini= $_POST['fechaini'] . ' 00:00:00';
							$Fechafin= $_POST['fechafin'] . ' 23:59:59';
							$query = "SELECT a.fechahora as Fecha, u.User as Usuario, u.Nombre as Nombre, a.accion as Accion, a.ip as IP FROM accesos a
							INNER JOIN usuarios u ON a.idusuario=u.User
							WHERE u.Nombre like '$miagen'
							AND a.fechahora >= '$Fechaini' AND a.fechahora < '$Fechafin'
							ORDER BY a.fechahora desc
							";
							exportarCSV_FINAL($conn, $query, $nombre_base = 'reporte');
							//exportarExcelConNegritas($conn, $query, $nombre_base = 'reporte');
						}
						*/
						//fin del excel
						else{
							$query = "SELECT a.fechahora as fecha, u.User as useru, u.Nombre as nombreu, a.accion as acciona, a.latitud as alat, a.longitud as alon, a.exactitud as aexa, a.ip as ipa, a.requesturi as reqa FROM accesos a
							INNER JOIN usuarios u ON a.idusuario=u.User
							ORDER BY a.fechahora desc
							";
						}

						unset($_POST['Busca']);
						$result_tasks = mysqli_query($conn,$query);

						if (!$result_tasks){
							$query = "SELECT * FROM accesos";
							$result_tasks = mysqli_query($conn,$query);
							echo 'ALGO SALIO MAL';
						}

						while ($row=mysqli_fetch_array($result_tasks)) { 
							$coord= $row['alat'] . ',' .  $row['alon'] ;
					?>
							<tr>
								<td><?php echo $row['fecha']; ?></td>
								<td><?php echo $row['useru'] ?></td>
								<td><?php echo $row['nombreu']; ?></td>
								<td><?php echo $row['acciona'] ?></td>

								<td><?php echo $row['alat'] ?></td>
								<td><?php echo $row['alon'] ?></td>
								<td><?php echo $row['aexa'] ?></td>
								<td> 
									<a href="javascript:popup('1100','600','https://www.google.es/maps/place/<?php echo $coord; ?>')">Ver Mapa</a> 
								</td>

								<td><?php echo $row['ipa']; ?></td>
								<td><?php echo $row['reqa'] ?></td>
							</tr>		
					<?php }
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php 
$rutafooter = $_SERVER['DOCUMENT_ROOT'] . '/asistencia/includes/footermenu.php';
include ($rutafooter); 
?>


