<?php
include("../../bd.php");
if ($_POST) {

  $nombre = (isset($_POST["nombre"]) ? $_POST["nombre"] : "");
  $correo = (isset($_POST["correo"]) ? $_POST["correo"] : "");
  $contrasenia = (isset($_POST["contrasenia"]) ? $_POST["contrasenia"] : "");

  if (empty($nombre) || empty($correo) || empty($contrasenia)) {
    $mensaje = "Todos los campos son obligatorios";
  }else{
    $sentencia = $conexion->prepare("INSERT INTO maestros(idmaestros,nombre,correo,contrasenia)
  VALUES (null,:nombre,:correo,:contrasenia)");

  $sentencia->bindParam(":nombre", $nombre);
  $sentencia->bindParam(":correo", $correo);
  $sentencia->bindParam(":contrasenia", $contrasenia);
  $sentencia->execute();

  $mensaje="Registro agregado";
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
    <div class="mb-3">
    <label for="" class="form-label">Nombre del maestro:</label>
    <input class="form-control w-50" type="text" name="nombre" id="nombre" placeholder="Nombre del maestro" oninput="validarNombre(this)">
</div>
      <div class="mb-3">
        <label for="" class="form-label">Correo:</label>
        <input class="form-control w-50" type="text" name="correo" id="correo" placeholder="Correo">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Contraseña:</label>
        <input class="form-control w-50" type="text" name="contrasenia" id="contrasenia" placeholder="Contraseña">
      </div>

      <button type="submit" class="btn btn-success">Agregar maestro</button>
      <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

  </div>

  <div class="card-footer text-muted"></div>
</div>
<script>
    function validarNombre(input) {
        const nombreRegExp = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]+$/;
        if (!nombreRegExp.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ.\s]/g, ''); // Se elimina cualquier caracter no permitido.
        }
    }
</script>

<?php include("../../templates/footer.php"); ?>