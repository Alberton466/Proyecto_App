<?php
include("../../bd.php");

if (isset($_GET['textID'])) {

    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM maestros WHERE idmaestros=:id");

    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    $nombre = $registro["nombre"];
    $correo = $registro["correo"];
    $contrasenia = $registro["contrasenia"];

}
if ($_POST) {
    
  $textID = (isset($_POST["textID"]) ? $_POST["textID"] : "");
  $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
  $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");
  $contrasenia = (isset($_POST["contrasenia"]) ? $_POST["contrasenia"] : "");

  if (empty($nombre) || empty($correo) || empty($contrasenia)) {
    $mensaje = "Todos los campos son obligatorios";
  }else{
    $sentencia = $conexion->prepare("UPDATE maestros SET nombre=:nombre,correo=:correo,
    contrasenia=:contrasenia
    WHERE idmaestros=:id");

  $sentencia->bindParam(":id", $textID);
  $sentencia->bindParam(":nombre", $nombre);
  $sentencia->bindParam(":correo", $correo);
  $sentencia->bindParam(":contrasenia", $contrasenia);
  $sentencia->execute();

  $mensaje="Registro actualizado";
  header("Location:index.php?mensaje=".$mensaje);
  }

}

?>
<?php include("../../templates/header.php"); ?>

<div class="card">
  <div class="card-header">
    Datos del maestro
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
        <label for="" class="form-label">Nombre del maestro:</label>
        <input class="form-control w-50" type="text" name="nombre" id="nombre" value="<?php echo ($nombre) ?>" placeholder="Nombre del maestro">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Correo:</label>
        <input class="form-control w-50" type="text" name="correo" id="correo" value="<?php echo ($correo) ?>" placeholder="Correo">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Contraseña:</label>
        <input class="form-control w-50" type="text" name="contrasenia" id="contrasenia" value="<?php echo ($contrasenia) ?>" placeholder="Contraseña">
      </div>

      <button type="submit" class="btn btn-success">Actualizar</button>
      <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

  </div>

  <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>