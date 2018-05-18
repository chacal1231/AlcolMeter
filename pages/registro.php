<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
<?php
$QueryTabla = mysqli_query($link,"SELECT * FROM pacientes ORDER BY id DESC");
$RowTabla 	= mysqli_fetch_array($QueryTabla);
?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Registro de pacientes
            </header>
            <section class="panel">
                        <div class="panel-body">
                            <hr/>
                            <div class="table-responsive">
                                <table  class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Edad</th>
                                            <th>Sexo</th>
                                            <th>Fecha de valoración</th>
                                            <th>Grado de embriaguez</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach( $QueryTabla as $RowTabla => $field ) : ?> <!-- Mulai loop -->
                                        <tr class="text-besar">
                                            <td><?php echo $field['nombre']; ?></td>
                                            <td><?php echo $field['edad']; ?></td>
                                            <td><?php echo $field['sexo']; ?></td>
                                            <td><?php echo $field['fecha']; ?></td>
                                            <td><?php echo $field['estado']; ?></td>                                               
                                        </tr>
                                        <?php endforeach; ?> <!-- Selesai loop -->                                  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
        </div>
    </section>
</div>