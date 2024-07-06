<?php
include("../../bd.php");
if ($_POST) {

    $numero = (isset($_POST["estasig"]) ? $_POST["estasig"] : "");
    $torre = (isset($_POST["torreasig"]) ? $_POST["torreasig"] : "");
    $monitor = (isset($_POST["monitorasig"]) ? $_POST["monitorasig"] : "");
    $teclado = (isset($_POST["tecladoasig"]) ? $_POST["tecladoasig"] : "");
    $raton = (isset($_POST["ratonasig"]) ? $_POST["ratonasig"] : "");

    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

    if (empty($numero) || empty($torre) || empty($monitor) || empty($teclado) || empty($raton) || empty($foto)) {
        $mensaje = "Todos los campos son obligatorios";
      }else{
        $sentencia = $conexion->prepare("INSERT INTO estaciones(idestaciones,numero,torrefolio,monitorfolio,tecladofolio,ratonfolio,foto)
  VALUES (null,:estasig,:torreasig,:monitorasig,:tecladoasig,:ratonasig,:foto)");

    $sentencia->bindParam(":estasig", $numero);
    $sentencia->bindParam(":torreasig", $torre);
    $sentencia->bindParam(":monitorasig", $monitor);
    $sentencia->bindParam(":tecladoasig", $teclado);
    $sentencia->bindParam(":ratonasig", $raton);

    $fecha_foto = new DateTime();
    $nombreArchivo = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo);
    }

    $sentencia->bindParam(":foto", $nombreArchivo);
    $sentencia->execute();

    $mensaje="Registro agregado";
    header("Location:index.php?mensaje=".$mensaje);
      }
    
}

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
            <div class="mb-3">
                <label for="" class="form-label">Estacion asignada</label>
                <input type="number" class="form-control w-50" name="estasig" id="estasig" aria-describedby="helpId"
                    placeholder="Numero de estacion">
            </div>
            <div class="mb-3 w-50">
                <label for="" class="form-label">Torre asignada:</label>
                <select class="form-select form-select-sm" name="torreasig" id="torreasig">
                <option value="">Elige uno</option>
                    <?php foreach ($lista_torre as $registro) { ?>
                        <option value="<?php echo $registro['idarticulos']; ?>"><?php echo $registro['folio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Monitor asignado:</label>
                <select class="form-select form-select-sm" name="monitorasig" id="monitorasig">
                <option value="">Elige uno</option>
                    <?php foreach ($lista_monitor as $registro) { ?>
                        <option value="<?php echo $registro['idarticulos']; ?>"><?php echo $registro['folio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Teclado asignado:</label>
                <select class="form-select form-select-sm" name="tecladoasig" id="tecladoasig">
                <option value="">Elige uno</option>
                    <?php foreach ($lista_teclado as $registro) { ?>
                        <option value="<?php echo $registro['idarticulos']; ?>"><?php echo $registro['folio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3 w-50">
                <label for="" class="form-label">Raton asignado:</label>
                <select class="form-select form-select-sm" name="ratonasig" id="ratonasig">
                <option value="">Elige uno</option>
                    <?php foreach ($lista_raton as $registro) { ?>
                        <option value="<?php echo $registro['idarticulos']; ?>"><?php echo $registro['folio']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
    <label for="foto" class="form-label">Foto de la estación:</label>
    <input type="file" class="form-control w-50" name="foto" id="foto" aria-describedby="helpId" accept=".png, .jpg"
        placeholder="Foto">
</div>

            <button type="submit" class="btn btn-success">Agregar estacion</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>
    </div>

    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>