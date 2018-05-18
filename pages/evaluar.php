<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
<?php
if(isset($_POST['info'])){
	echo "<body onLoad=$('#myModal2').modal('show')>";
	echo "<body onLoad=$('#myModal').modal('hide')>";
	}
else if(isset($_POST['paciente'])){

	//Variables POST
	$nombre = mysqli_real_escape_string($link,$_POST['nombre']);
	$edad 	= mysqli_real_escape_string($link,$_POST['edad']);
	$sexo 	= mysqli_real_escape_string($link,$_POST['sexo']);
	$aa 	= mysqli_real_escape_string($link,$_POST['aa']);
	$np 	= mysqli_real_escape_string($link,$_POST['np']);
	$im 	= mysqli_real_escape_string($link,$_POST['im']);
	$dis 	= mysqli_real_escape_string($link,$_POST['dis']);
	$co 	= mysqli_real_escape_string($link,$_POST['co']);
	$pds 	= mysqli_real_escape_string($link,$_POST['pds']);
	$fecha	= date('Y-m-d H:i:s');

	//Clasificación

	if($np=='Discreto' AND $im=='Leve' AND $aa=='Discreto'){
		$Estado = "1 Grado";
	}

	if($np=='Evidente' AND $im=='Moderada' AND $aa=='Evidente' AND $dis=='Evidente'){
		$Estado = "2 Grado";
	}

	if($np=='Evidente' AND $im=='Severa' AND $aa=='Evidente' AND $dis=='Evidente' AND $co=='Alterada' AND $pds=='Aumentado'){
		$Estado = "3 Grado";
	}
	//Mysql sección
	$result     = 	mysqli_query($link,"SELECT * FROM pacientes ORDER BY id DESC");
  	$row        = 	mysqli_fetch_array($result);            
  	$id         =	($row["id"]+1);
	$query = mysqli_query($link,"INSERT INTO pacientes(id,nombre,edad,sexo,aa,np,im,dis,co,pds,fecha,estado) VALUES('$id','$nombre','$edad','$sexo','$aa','$np','$im','$dis','$co','$pds','$fecha','$Estado')");
	$my_error = mysqli_error($link);
    if(empty($my_error)){
            echo '<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-8 col-md-offset-2">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading" align="center">
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-cog"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						</span><div align="center"><h4><strong>Estado del paciente</strong></h4></div>
					</header>
					<div class="panel-body">
						<div class="adv-table">
						<div class="col-sm-12">
							<table class="display table table-bordered table-striped">
								<tr>
									<td>
										<strong>Nombre del paciente:</strong>&#160;</strong>
									</td>
									<td>
										<strong>'; echo $nombre; echo'	</strong>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Sexo:</strong>&#160;</strong>
									</td>
									<td>
										<strong>'; echo $sexo; echo'</strong>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Estado del paciente:</strong>&#160;</strong>
									</td>
									<td>
										<strong>'; echo $Estado; echo' de embriaguez</strong>
									</td>
								</tr>
							</table>
					</div>';

					echo'<div align="center"><a href="?page=evaluar"><button type="button" class="btn btn-success btn-lg">Evaluar otro paciente</button></a>';

    }else{
        echo $my_error;
    }

	}else{
		echo "<body onLoad=$('#myModal').modal('show')>";
	}
?>

<!-- Modal evaluar -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Evaluar nuevo paciente</h5>
        <button type="button" class="close" data-dismiss="modal2" data-toggle="modal2" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="modal-form" action="" method="post">
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Nombre *:</b></label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Edad *:</b></label>
                <input type="text" class="form-control" name="edad" required>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Sexo *:</b></label>
                	<select class="form-control" name="sexo">
                				<option>-- Seleccionar --</option>
        						<option>Masculino</option>
        						<option>Femenino</option>
        			</select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Aliento alcohólico *:</b></label>
                	<select class="form-control" name="aa">
                				<option>-- Seleccionar --</option>
        						<option>Negativo</option>
        						<option>Discreto</option>
        						<option>Evidente</option>
        			</select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Nistagmo Post-rotacional *:</b></label>
                	<select class="form-control" name="np">
                				<option>-- Seleccionar --</option>
        						<option>Negativo</option>
        						<option>Discreto</option>
        						<option>Evidente</option>
        			</select>             
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Incoordinación Motora *:</b></label>
                	<select class="form-control" name="im">
                				<option>-- Seleccionar --</option>
        						<option>Negativo</option>
        						<option>Leve</option>
        						<option>Moderada</option>
        						<option>Severa</option>
        			</select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Disartria *:</b></label>
                	<select class="form-control" name="dis">
                				<option>-- Seleccionar --</option>
        						<option>Negativa</option>
        						<option>Evidente</option>
        			</select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Convergencia Ocular *:</b></label>
                	<select class="form-control" name="co">
                				<option>-- Seleccionar --</option>
        						<option>Normal</option>
        						<option>Alterada</option>
        			</select>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label"><b>Polígono de sustentación *:</b></label>
                	<select class="form-control" name="pds">
                				<option>-- Seleccionar --</option>
        						<option>Normal</option>
        						<option>Aumentado</option>
        			</select>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" name="paciente" value="Sign up">Evaluar paciente</button>
         </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" >&times;</button>
          <h2 class="modal-title">Antes de hacer el test</h2>
        </div>
        <div class="modal-body">
          <h4><b>Nistagmus Post-rotacional</b></h4>
          <p class="text-justify">Hacer rotar al examinado sobre su propio eje, dando cinco vueltas en 10 segundos, para que al detenerse fije su mirada en un objeto colocado a 20 centímetros de su nariz. Observe y registre si el examinado presenta nistagmus horizontal que se clasifica y documenta en el reporte pericial como ausente, presente leve o presente evidente.</p>
          <br>
          <h4><b>Polígono de Sustentación</b></h4>
          <p class="text-justify">Evaluar el polígono de sustentación mediante pruebas específicas que permiten determinar la presencia de alteraciones de la sensibilidad propioceptiva, entre otras: Romberg: Solicitar al examinado que se ponga de pie, con los talones y las puntas de los pies juntos y los brazos a lo largo del cuerpo, y pedirle que cierre los ojos; otra forma de evaluarlo consiste en solicitarle que en esa posición levante y mantenga los miembros superiores extendidos hacia adelante.</p>
          <br>
          <h4><b>Incoordinación Motora</b></h4>
          <p class="text-justify">Pruebas de movimiento punto a punto, las cuales permiten determinar la presencia de dismetría (tenga en cuenta la dominancia hemisférica). Siempre demuéstrele al examinado como se hacen y asegúrese que entendió.
          Dedo-nariz: Solicite al examinado que con el dedo índice extendido se toque la nariz; luego que toque la punta del dedo índice del examinador colocado frente a él; pídale que repita ese movimiento varias veces. Luego indíquele que continúe haciéndolo, pero con los ojos cerrados. Normalmente la precisión en el movimiento persiste.</p>
          <br>
          <h4><b>Convergencia Ocular</b></h4>
          <p class="text-justify">Se pide al examinado que fije la mirada y siga un objeto que se le coloca al frente, aproximadamente a 20 cm de los ojos, el cual se le acerca lentamente hasta alcanzar la proximidad de la nariz. Normalmente debe haber convergencia.</p>
        </div>
        <div class="modal-footer">
         <form id="modal-form" action="" method="post">
          <button type="submit" class="btn btn-success btn-lg" name="info" value="Sign up">Empezar a evaluar paciente</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>