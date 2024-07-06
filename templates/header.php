<?php
session_start();

$url_base = "http://localhost/app/";
if(!isset($_SESSION['usuario'])){
  header("Location:".$url_base."login.php");
}

?>
<!doctype html>
<html lang="en">

<head>
  <title>UAGro</title>
  <link rel="icon" href="/app/libs/img/icono.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/app/libs/img/icono.ico" type="image/x-icon">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <header
    style="background-image: url('/app/libs/img/fondo.jpg'); background-repeat: no-repeat;background-size: cover;background-position: center;">
    <br />
    <div style="text-align: center;">
      <img style=" display: block; margin: auto;" width="320" src="/app/libs/img/logo2.jpg" />
    </div>
    <br />

  </header>
  <nav class="navbar navbar-expand navbar-light"
    style="background-image: url('/app/libs/img/header.png'); background-repeat: no-repeat; background-size: cover; background-position: center; height: 50px; text-align: center;padding: 6px 10px; ">
    <ul class="nav navbar-nav mx-auto">
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link active" href="/app/" aria-current="page"> UAGro<span
            class="visually-hidden">(current)</span></a>
      </li>
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link" href="<?php echo $url_base; ?>modulos/almacen/">Inventario</a>
      </li>
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link" href="<?php echo $url_base; ?>modulos/equipos/">Estaciones</a>
      </li>
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link" href="<?php echo $url_base; ?>modulos/reservar/">Reservar</a>
      </li>
      <?php if($_SESSION['usuario'] == 'admin'){?>
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link" href="<?php echo $url_base; ?>modulos/maestros/">Maestros</a>
      </li>
      <?php }?>
      <li class="nav-item"
        style="background: #E9E9E4; border: none; border-radius: 50px; padding: 6px 10px; margin: 0 5px;">
        <a class="nav-link" href="<?php echo $url_base; ?>cerrar.php">Cerrar sesion</a>
      </li>
    </ul>
  </nav>

  <main class="container">
  <?php if (isset($_GET['mensaje'])) {?>
<script>
    Swal.fire({icon:"success", title:"<?php echo $_GET['mensaje']?>"});
</script>
<?php } ?>
    <br />
