<?php
include("../../bd.php");


$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');


$sentencia = $conexion->prepare("SELECT * FROM `reservas` ORDER BY `fecha` DESC");
$sentencia->execute();
$lista_reservas = $sentencia->fetchAll(PDO::FETCH_ASSOC);


if (empty($lista_reservas)) {

    $disponibilidad_img = '<img width="180" src="talvez.jpg" class="img-fluid rounded" alt="No hay reservas" />';
} else {

    $disponibilidad = false;
    foreach ($lista_reservas as $reserva) {
        if ($fecha_actual == $reserva['fecha'] && $hora_actual >= $reserva['inicio'] && $hora_actual <= $reserva['fin']) {
            $disponibilidad = true;
            break;
        }
    }

   
    if ($disponibilidad) {
        $disponibilidad_img = '<img width="180" src="no.jpg" class="img-fluid rounded" alt="" />';
    } else {
        $disponibilidad_img = '<img width="180" src="si.jpg" class="img-fluid rounded" alt="" />';
    }
}


$sentencia = $conexion->prepare("SELECT *,
(SELECT nombre FROM maestros WHERE maestros.idmaestros=reservas.nombremaestro) as nombre
 FROM `reservas` ");
$sentencia->execute();
$lista_tbl_articulos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../../templates/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                <div class="p-2">Reservas</div>
                <div class="p-2">
                    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Reservar área</a>
                </div>
        </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table" id="tabla_id">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre del profesor</th>
                                    <th scope="col">Materia</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora de inicio</th>
                                    <th scope="col">Hora de fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista_tbl_articulos as $registro) { ?>
                                    <tr>
                                        <td scope="row">
                                            <?php echo $registro['nombre']; ?>
                                        </td>
                                        <td>
                                            <?php echo $registro['materia']; ?>
                                        </td>
                                        <td>
                                            <?php echo $registro['fecha']; ?>
                                        </td>
                                        <td>
                                            <?php echo $registro['inicio']; ?>
                                        </td>
                                        <td>
                                            <?php echo $registro['fin']; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        <label for="" class="form-label">Disponibilidad:</label>
            <?php echo $disponibilidad_img; ?>
        </div>
    </div>
</div>


<?php include("../../templates/footer.php"); ?>