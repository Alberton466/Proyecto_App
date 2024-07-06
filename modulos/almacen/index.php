<?php
include("../../bd.php");

if (isset($_GET['textID'])) {
    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";

    $sentencia = $conexion->prepare("SELECT foto FROM articulos WHERE idarticulos=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registroFoto["foto"]) && $registroFoto["foto"] != "") {
        if (file_exists("./" . $registroFoto["foto"])) {
            unlink("./" . $registroFoto["foto"]);
        }

    }

    $sentencia = $conexion->prepare("DELETE FROM articulos WHERE idarticulos=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);

}

$sentencia = $conexion->prepare("SELECT * FROM articulos");
$sentencia->execute();
$lista_tbl_articulos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">
        <div class="container">
        <div class="d-flex justify-content-between align-items-center">
                <div class="p-2">Inventario</div>
                <div class="p-2">
                    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar articulo</a>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Numero asignado</th>
                        <th scope="col">Folio</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_articulos as $registro) { ?>


                        <tr class="">
                            <td scope="row">
                                <?php echo $registro['tipo']; ?>
                            </td>
                            <td>
                                <?php echo $registro['numasig']; ?>
                            </td>
                            <td>
                                <?php echo $registro['folio']; ?>
                            </td>
                            <td>
                                <img width="180" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                            </td>
                            <td>
                                <a class="btn btn-primary" href="editar.php?textID=<?php echo $registro['idarticulos']; ?>"
                                    role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['idarticulos']; ?>);"
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