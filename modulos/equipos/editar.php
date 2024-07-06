<?php
include("../../bd.php");

if (isset($_GET['textID'])) {

    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM estaciones WHERE idestaciones=:id");

    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $numero = $registro["numero"];
    $torre = $registro["torrefolio"];
    $monitor = $registro["monitorfolio"];
    $teclado = $registro["tecladofolio"];
    $raton = $registro["ratonfolio"];
    $foto = $registro["foto"];

    $sentencia = $conexion->prepare("SELECT * FROM `articulos` WHERE tipo = 'Torre'");
    $sentencia->execute();
    $lista_torre = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = $conexion->prepare("SELECT * FROM `articulos` WHERE tipo = 'Monitor'");
    $sentencia->execute();
    $lista_monitor = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = $conexion->prepare("SELECT * FROM `articulos` WHERE tipo = 'Teclado'");
    $sentencia->execute();
    $lista_teclado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = $conexion->prepare("SELECT * FROM `articulos` WHERE tipo = 'Raton'");
    $sentencia->execute();
    $lista_raton = $sentencia->fetchAll(PDO::FETCH_ASSOC);

}
if ($_POST) {

    $textID = (isset($_POST["textID"]) ? $_POST["textID"] : "");
    $numero = (isset($_POST["estasig"]) ? $_POST["estasig"] : "");
    $torre = (isset($_POST["torreasig"]) ? $_POST["torreasig"] : "");
    $monitor = (isset($_POST["monitorasig"]) ? $_POST["monitorasig"] : "");
    $teclado = (isset($_POST["tecladoasig"]) ? $_POST["tecladoasig"] : "");
    $raton = (isset($_POST["ratonasig"]) ? $_POST["ratonasig"] : "");

    if (empty($numero) || empty($torre) || empty($monitor) || empty($teclado) || empty($raton) || empty($foto)) {
        $mensaje = "Todos los campos son obligatorios";
      }else{
        $sentencia = $conexion->prepare("UPDATE estaciones SET numero=:estasig,torrefolio=:torreasig,
    monitorfolio=:monitorasig,tecladofolio=:tecladoasig,ratonfolio=:ratonasig
    WHERE idestaciones=:id");

    $sentencia->bindParam(":id", $textID);
    $sentencia->bindParam(":estasig", $numero);
    $sentencia->bindParam(":torreasig", $torre);
    $sentencia->bindParam(":monitorasig", $monitor);
    $sentencia->bindParam(":tecladoasig", $teclado);
    $sentencia->bindParam(":ratonasig", $raton);

    $sentencia->execute();

    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

    $fecha_foto = new DateTime();

    $nombreArchivo = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo);

        $sentencia = $conexion->prepare("SELECT foto FROM estaciones WHERE idestaciones=:id");
        $sentencia->bindParam(":id", $textID);
        $sentencia->execute();
        $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($registroFoto["foto"]) && $registroFoto["foto"] != "") {
            if (file_exists("./" . $registroFoto["foto"])) {
                unlink("./" . $registroFoto["foto"]);
            }

        }

        $sentencia = $conexion->prepare("UPDATE estaciones SET foto=:foto WHERE idestaciones=:id");
        $sentencia->bindParam(":id", $textID);
        $sentencia->bindParam(":foto", $nombreArchivo);
        $sentencia->execute();
    }
    $mensaje="Registro actualizado";
    header("Location:index.php?mensaje=".$mensaje);
      }
}


?>
<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">
        Datos de la estacion
    </div>

    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
        <?php if (!empty($mensaje)) { ?>
  <div id="mensaje" class="alert alert-danger" role="alert">
    <strong><?php echo $mensaje ?></strong>
  </div>
<?php } ?>
            <div class="mb-3 w-50">
                <label for="textID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $textID; ?>" class="form-control" readonly name="textID" id="textID"
                    aria-describedby="helpId" placeholder="ID">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Estacion asignada</label>
                <input type="number" value="<?php echo ($numero) ?>" class="form-control w-50" name="estasig" id="estasig"
                    aria-describedby="helpId" placeholder="Numero de estacion">
            </div>
            <div class="mb-3 w-50">
                <label for="" class="form-label">Torre asignada:</label>
                <select class="form-select form-select-sm" name="torreasig" id="torreasig">
                    <?php foreach ($lista_torre as $registro) { ?>
                        <option <?php echo ($torre == $registro['idarticulos']) ? "selected" : ""; ?>
                            value="<?php echo $registro['idarticulos']; ?>">
                            <?php echo $registro['folio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Monitor asignado:</label>
                <select class="form-select form-select-sm" name="monitorasig" id="monitorasig">
                    <?php foreach ($lista_monitor as $registro) { ?>
                        <option <?php echo ($monitor == $registro['idarticulos']) ? "selected" : ""; ?>
                            value="<?php echo $registro['idarticulos']; ?>">
                            <?php echo $registro['folio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Teclado asignado:</label>
                <select class="form-select form-select-sm" name="tecladoasig" id="tecladoasig">
                    <?php foreach ($lista_teclado as $registro) { ?>
                        <option <?php echo ($teclado == $registro['idarticulos']) ? "selected" : ""; ?>
                            value="<?php echo $registro['idarticulos']; ?>">
                            <?php echo $registro['folio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Raton asignado:</label>
                <select class="form-select form-select-sm" name="ratonasig" id="ratonasig">
                    <?php foreach ($lista_raton as $registro) { ?>
                        <option <?php echo ($raton == $registro['idarticulos']) ? "selected" : ""; ?>
                            value="<?php echo $registro['idarticulos']; ?>">
                            <?php echo $registro['folio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
    <label for="foto" class="form-label">Foto de la estación:</label>
    <input type="file" class="form-control w-50" name="foto" id="foto" aria-describedby="helpId" accept=".png, .jpg"
        placeholder="Foto">
</div>
<div class="mb-3">
        <label for="" class="form-label">Foto actual:</label>
        <img class="form-control w-25" src="<?php echo $foto; ?>" class="img-fluid rounded" alt="" />
      </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>

    <div class="card-footer text-muted"></div>
</div>
<?php include("../../templates/footer.php"); ?>