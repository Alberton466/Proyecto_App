<?php
include("../../bd.php");

if (isset($_GET['textID'])) {
    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";
    
    $sentencia = $conexion->prepare("DELETE FROM maestros WHERE idmaestros=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("Location:index.php?mensaje=".$mensaje);

}

$sentencia = $conexion->prepare("SELECT * FROM maestros");
$sentencia->execute();
$lista_maestros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>

<div class="container">
            <div class="card">
                <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                <div class="p-2">Maestros</div>
                <div class="p-2">
                    <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Añadir maestro</a>
                </div>
            </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table" id="tabla_id">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre del maestro</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Contraseña</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lista_maestros as $registro) { ?>
                        <tr class="">
                            <td scope="row">
                                <?php echo $registro['nombre']; ?>
                            </td>
                            <td>
                                <?php echo $registro['correo']; ?>
                            </td>
                            <td>
                                <?php echo $registro['contrasenia']; ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="editar.php?textID=<?php echo $registro['idmaestros']; ?>"
                                    role="button">Editar</a>
                                <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['idmaestros']; ?>);"
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