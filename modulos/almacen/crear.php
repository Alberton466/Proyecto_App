<?php
include("../../bd.php");
if ($_POST) {

  $tipo = (isset($_POST["tipo"]) ? $_POST["tipo"] : "");
  $numero = (isset($_POST["numero"]) ? $_POST["numero"] : "");
  $folio = (isset($_POST["folio"]) ? $_POST["folio"] : "");

  $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");

  if (empty($tipo) || empty($numero) || empty($folio) || empty($foto)) {
    $mensaje = "Todos los campos son obligatorios";
  }else{
    $sentencia = $conexion->prepare("INSERT INTO articulos(idarticulos,tipo,numasig,folio,foto)
  VALUES (null,:tipo,:numero,:folio,:foto)");

  $sentencia->bindParam(":tipo", $tipo);
  $sentencia->bindParam(":numero", $numero);
  $sentencia->bindParam(":folio", $folio);

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
        <label for="" class="form-label">Tipo:</label>
        <select class="form-select form-select-sm" name="tipo" id="tipo" onchange="actualizarCampo()">
          <option value="">Elige uno</option>
          <option value="Torre">Torre</option>
          <option value="Monitor">Monitor</option>
          <option value="Teclado">Teclado</option>
          <option value="Raton">Raton</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Numero asignado</label>
        <input class="form-control w-50" type="number" name="numero" id="numero" oninput="actualizarCampo()">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Folio</label>
        <input class="form-control w-50" type="text" name="folio" id="folio" readonly>
      </div>

      <div class="mb-3">
    <label for="foto" class="form-label">Foto:</label>
    <input type="file" class="form-control w-50" name="foto" id="foto" aria-describedby="helpId" accept=".png, .jpg"
        placeholder="Foto">
</div>


      <button type="submit" class="btn btn-success">Agregar articulo</button>
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