<?php
include("../../bd.php");

if (isset($_GET['textID'])) {

  $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";
  $sentencia = $conexion->prepare("SELECT * FROM articulos WHERE idarticulos=:id");

  $sentencia->bindParam(":id", $textID);
  $sentencia->execute();
  $registro = $sentencia->fetch(PDO::FETCH_LAZY);

  $tipo = $registro["tipo"];
  $numasig = $registro["numasig"];
  $folio = $registro["folio"];
  $foto = $registro["foto"];


}
if ($_POST) {

  $textID = (isset($_POST["textID"]) ? $_POST["textID"] : "");
  $tipo = (isset($_POST["tipo"]) ? $_POST["tipo"] : "");
  $numero = (isset($_POST["numero"]) ? $_POST["numero"] : "");
  $folio = (isset($_POST["folio"]) ? $_POST["folio"] : "");

  if (empty($tipo) || empty($numero) || empty($folio) || empty($foto)) {
    $mensaje = "Todos los campos son obligatorios";
  }else{
    $sentencia = $conexion->prepare("UPDATE articulos SET tipo=:tipo,numasig=:numero,folio=:folio WHERE idarticulos=:id");

  $sentencia->bindParam(":id", $textID);
  $sentencia->bindParam(":tipo", $tipo);
  $sentencia->bindParam(":numero", $numero);
  $sentencia->bindParam(":folio", $folio);
  $sentencia->execute();

  $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");


  $fecha_foto = new DateTime();

  $nombreArchivo = ($foto != '') ? $fecha_foto->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
  $tmp_foto = $_FILES["foto"]['tmp_name'];
  if ($tmp_foto != '') {
    move_uploaded_file($tmp_foto, "./" . $nombreArchivo);

    $sentencia = $conexion->prepare("SELECT foto FROM articulos WHERE idarticulos=:id");
    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registroFoto = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registroFoto["foto"]) && $registroFoto["foto"] != "") {
      if (file_exists("./" . $registroFoto["foto"])) {
        unlink("./" . $registroFoto["foto"]);
      }

    }

    $sentencia = $conexion->prepare("UPDATE articulos SET foto=:foto WHERE idarticulos=:id");
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
    Datos del articulo
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
      <div class="mb-3 w-50">
        <label for="" class="form-label">Tipo:</label>
        <select class="form-select form-select-sm" name="tipo" id="tipo" onchange="actualizarCampo()">
          <option value="<?php echo $tipo; ?>">
            <?php echo $tipo; ?>
          </option>
          <option value="Torre">Torre</option>
          <option value="Monitor">Monitor</option>
          <option value="Teclado">Teclado</option>
          <option value="Raton">Raton</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Numero asignado</label>
        <input class="form-control w-50" value="<?php echo $numasig; ?>" type="number" name="numero" id="numero"
          oninput="actualizarCampo()">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Folio</label>
        <input class="form-control w-50" value="<?php echo $folio; ?>" type="text" name="folio" id="folio" readonly>
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Foto:</label>
        <input type="file" class="form-control w-50" value="<?php echo $foto; ?>" name="foto" id="foto"
          aria-describedby="helpId" placeholder="Foto">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Foto actual:</label>
        <img class="form-control w-25" src="<?php echo $foto; ?>" class="img-fluid rounded" alt="" />
      </div>

      <button type="submit" class="btn btn-success">Actualizar</button>
      <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

    <script>
      function actualizarCampo() {
        var selectValue = document.getElementById("tipo").value;
        var inputValue = document.getElementById("numero").value;

        var resultado = "";

        if (selectValue === "Torre") {
          resultado = "T0" + inputValue;
        } else if (selectValue === "Monitor") {
          resultado = "M0" + inputValue;
        } else if (selectValue === "Teclado") {
          resultado = "TE0" + inputValue;
        } else if (selectValue === "Raton") {
          resultado = "R0" + inputValue;
        }
        else {
          resultado = "No se cumple ninguna condición específica.";
        }

        document.getElementById("folio").value = resultado;
      }
    </script>

  </div>

  <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/footer.php"); ?>