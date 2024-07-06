<?php
session_start();
if($_POST){
  include("./bd.php");

  $sentencia = $conexion->prepare("SELECT *,count(*) as n_usuarios
   FROM maestros 
   WHERE correo=:usuario 
   AND contrasenia=:contrasenia ");

   $usuario=$_POST["usuario"];
   $contrasenia=$_POST["contrasenia"];

   $sentencia->bindParam(":usuario", $usuario);
   $sentencia->bindParam(":contrasenia", $contrasenia);

$sentencia->execute();

$registro = $sentencia->fetch(PDO::FETCH_LAZY);

if($registro["n_usuarios"] > 0){

  $_SESSION['usuario'] = $registro["nombre"];
  $_SESSION['logueado'] = true;

  header("Location:index.php");

}else{
  $mensaje = "El usuario o contraseña es incorrectos";
}

}


?>

<?php include("templates/headerl.php");?>
<!doctype html>
<html lang="en">

<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
  <header>
    <!-- place navbar here -->
  </header>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

/* Reseting */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #ecf0f3;
}

.wrapper {
    max-width: 350px;
    min-height: 500px;
    margin: 80px auto;
    padding: 40px 30px 30px 30px;
    background-color: #ecf0f3;
    border-radius: 15px;
    box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
}

.logo {
    width: 80px;
    margin: auto;
}

.logo img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    box-shadow: 0px 0px 3px #5f5f5f,
        0px 0px 0px 5px #ecf0f3,
        8px 8px 15px #a7aaa7,
        -8px -8px 15px #fff;
}

.wrapper .name {
    font-weight: 600;
    font-size: 1.4rem;
    letter-spacing: 1.3px;
    padding-left: 10px;
    color: #555;
}

.wrapper .form-field input {
    width: 100%;
    display: block;
    border: none;
    outline: none;
    background: none;
    font-size: 1.2rem;
    color: #666;
    padding: 10px 15px 10px 10px;
    /* border: 1px solid red; */
}

.wrapper .form-field {
    padding-left: 10px;
    margin-bottom: 20px;
    border-radius: 20px;
    box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
}

.wrapper .form-field .fas {
    color: #555;
}

.wrapper .btn {
    box-shadow: none;
    width: 100%;
    height: 40px;
    background-color: #03A9F4;
    color: #fff;
    border-radius: 25px;
    box-shadow: 3px 3px 3px #b1b1b1,
        -3px -3px 3px #fff;
    letter-spacing: 1.3px;
}

.wrapper .btn:hover {
    background-color: #039BE5;
}

.wrapper a {
    text-decoration: none;
    font-size: 0.8rem;
    color: #03A9F4;
}

.wrapper a:hover {
    color: #039BE5;
}

@media(max-width: 380px) {
    .wrapper {
        margin: 30px 20px;
        padding: 40px 15px 15px 15px;
    }
}
  </style>
  <main>

<div class="wrapper">
        <div class="logo">
            <img src="/app/libs/img/icono.ico" alt="">
        </div>
        <div class="text-center mt-4 name">
            UAGro
        </div>
        <form action="" method="post" class="p-3 mt-3">
        <?php if(isset($mensaje)){?>
            <div class="alert alert-danger" role="alert">
              <strong><?php echo $mensaje?></strong>
            </div>
            <?php }?>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text"
                      class="form-control" name="usuario" id="usuario" placeholder="Escriba su correo electronico">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password"
                      class="form-control" name="contrasenia" id="contrasenia" aria-describedby="helpId" placeholder="Escriba su contraseña">
            </div>
            <button type="submit" class="btn mt-3">Entrar al sistema</button>
        </form>
    </div>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>

<?php include("templates/footer.php");?>