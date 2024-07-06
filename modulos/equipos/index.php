<?php
include("../../bd.php");

if (isset($_GET['textID'])) {
    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";

    $sentencia = $conexion->prepare("SELECT foto FROM estaciones WHERE idestaciones=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registroFoto["foto"]) && $registroFoto["foto"] != "") {
        if (file_exists("./" . $registroFoto["foto"])) {
            unlink("./" . $registroFoto["foto"]);
        }

    }

    $sentencia = $conexion->prepare("DELETE FROM estaciones WHERE idestaciones=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);

}

$sentencia = $conexion->prepare("SELECT *,
(SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.torrefolio) as torre,
(SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.monitorfolio) as monitor,
(SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.tecladofolio) as teclado,
(SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.ratonfolio) as raton
 FROM `estaciones`");
$sentencia->execute();
$lista_tbl_estaciones = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">
        <div class="container">
        <div class="d-flex justify-content-between align-items-center">
                <div class="p-2">Estaciones</div>
                <div class="p-2">
                    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar estacion</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Numero de la estacion</th>
                        <th scope="col">Torre</th>
                        <th scope="col">Monitor</th>
                        <th scope="col">Teclado</th>
                        <th scope="col">Raton</th>
                        <th scope="col">Fotografia</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_estaciones as $registro) { ?>
                        <tr class="">
                            <td scope="row">
                                <?php echo $registro['numero']; ?>
                            </td>
                            <td>
                                <?php echo $registro['torre']; ?>
                            </td>
                            <td>
                                <?php echo $registro['monitor']; ?>
                            </td>
                            <td>
                                <?php echo $registro['teclado']; ?>
                            </td>
                            <td>
                                <?php echo $registro['raton']; ?>
                            </td>
                            <td>
                                <img width="180" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                            </td>
                            <td>
                            <a class="btn btn-primary" href="reporte.php?textID=<?php echo $registro['idestaciones']; ?>"
                                    role="button">Reporte</a>
                                <a class="btn btn-primary" href="editar.php?textID=<?php echo $registro['idestaciones']; ?>"
                                    role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['idestaciones']; ?>);"
                                    role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php include("../../templates/footer.php"); ?>