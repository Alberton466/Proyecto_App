<?php
include("../../bd.php");

if ($_POST) {
  $maestro = (isset($_POST["nommaestro"]) ? $_POST["nommaestro"] : "");
  $materia = (isset($_POST["materia"]) ? $_POST["materia"] : "");
  $fecha = (isset($_POST["fechadereserva"]) ? $_POST["fechadereserva"] : "");
  $inicio = (isset($_POST["horainicio"]) ? $_POST["horainicio"] : "");
  $fin = (isset($_POST["horafin"]) ? $_POST["horafin"] : "");

  if (empty($maestro) || empty($materia) || empty($fecha) || empty($inicio) || empty($fin)) {
    $mensaje = "Todos los campos son obligatorios";
  }else{
    $sentencia = $conexion->prepare("INSERT INTO reservas(idreservas,nombremaestro,materia,fecha,inicio,fin)
  VALUES (null,:nommaestro,:materia,:fechadereserva,:horainicio,:horafin)");

  $sentencia->bindParam(":nommaestro", $maestro);
  $sentencia->bindParam(":materia", $materia);
  $sentencia->bindParam(":fechadereserva", $fecha);
  $sentencia->bindParam(":horainicio", $inicio);
  $sentencia->bindParam(":horafin", $fin);
  $sentencia->execute();

  $mensaje="Registro agregado";
  header("Location:index.php?mensaje=".$mensaje);
  }

  
}
$sentencia = $conexion->prepare("SELECT * FROM `maestros`");
$sentencia->execute();
$maestros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$hora_actual = date('H:i');


?>
<?php include("../../templates/header.php"); ?>

<div class="card">
  <div class="card-header">
    Datos de la reserva
  </div>

  <div class="card-body">
    <form action="" method="post">
    <?php if (!empty($mensaje)) { ?>
  <div id="mensaje" class="alert alert-danger" role="alert">
    <strong><?php echo $mensaje ?></strong>
  </div>
<?php } ?>

    <div class="mb-3 w-50">
                <label for="" class="form-label">Nombre del maestro:</label>
                <select class="form-select form-select-sm" name="nommaestro" id="nommaestro">
                <option value="">Elige uno</option>
                    <?php foreach ($maestros as $registro) { ?>
                        <option value="<?php echo $registro['idmaestros']; ?>"><?php echo $registro['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

      <div class="mb-3 w-50">
        <label for="" class="form-label">Materia</label>
        <input type="text" class="form-control" name="materia" id="materia" aria-describedby="helpId"
          placeholder="Nombre de la materia">
      </div>

      <div class="mb-3 w-50">
  <label for="fechadereserva" class="form-label">Fecha de reserva</label>
  <input type="date" class="form-control" name="fechadereserva" id="fechadereserva" aria-describedby="helpId"
    placeholder="Fecha de reserva" min="<?php echo date('Y-m-d'); ?>">
</div>

      <div class="mb-3 w-50">
        <label for="horainicio" class="form-label">Hora de inicio</label>
        <input type="time" class="form-control" name="horainicio" id="horainicio" aria-describedby="helpId"
          placeholder="Hora de inicio" min="<?php echo $hora_actual; ?>">
      </div>

      <div class="mb-3 w-50">
        <label for="horafin" class="form-label">Hora de fin</label>
        <input type="time" class="form-control" name="horafin" id="horafin" aria-describedby="helpId"
          placeholder="Hora de fin">
      </div>


      <button type="submit" class="btn btn-success">Agregar reserva</button>
      <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>
  </div>

  <div class="card-footer text-muted"></div>
</div>


<?php include("../../templates/footer.php"); ?>