<?php 
include("../../bd.php");
session_start();

if (isset($_GET['textID'])) {

    $textID = (isset($_GET['textID'])) ? $_GET['textID'] : "";
    $sentencia = $conexion->prepare("SELECT *,
    (SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.torrefolio) as torre,
    (SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.monitorfolio) as monitor,
    (SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.tecladofolio) as teclado,
    (SELECT folio FROM articulos WHERE articulos.idarticulos=estaciones.ratonfolio) as raton FROM estaciones WHERE idestaciones=:id");

    $sentencia->bindParam(":id", $textID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);


    $numero = $registro["numero"];
    $torre = $registro["torre"];
    $monitor = $registro["monitor"];
    $teclado = $registro["teclado"];
    $raton = $registro["raton"];

}
$meses = array(
  1 => 'enero',
  2 => 'febrero',
  3 => 'marzo',
  4 => 'abril',
  5 => 'mayo',
  6 => 'junio',
  7 => 'julio',
  8 => 'agosto',
  9 => 'septiembre',
  10 => 'octubre',
  11 => 'noviembre',
  12 => 'diciembre'
);

date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('d-m-Y');
$numero_mes = date('n', strtotime($fecha_actual));
$mes_actual = $meses[$numero_mes];
$dia_actual = date('d', strtotime($fecha_actual));
$anio_actual = date('Y', strtotime($fecha_actual));

$imageData = base64_encode(file_get_contents('../../libs/img/formato.png'));
$imageSrc = 'data:image/png;base64,' . $imageData;

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de equipo</title>
</head>
<body style="background-image: url('<?php echo $imageSrc; ?>'); background-size: cover;">

    <br /><br /><br /><br /><br /><br /><br /><br /><br /> <br />
    <div style="text-align: right; font-size: 22px;">Iguala, Guerrero, <?php echo($dia_actual);?> de <?php echo($mes_actual);?> <?php echo($anio_actual);?> </div>
    <div style="text-align: right; font-size: 22px; font-weight: bold;" >Asunto: Reporte de estacion No. <?php echo($numero);?></div>
    <div style="font-size: 20px; font-weight: bold;" >ING. DAVID PERALTA DIAZ</div>
    <div style="font-size: 20px; font-weight: bold;" >ENCARGADO DEL AREA DE COMPUTO</div>
    <div style="font-size: 20px; font-weight: bold;" >PRESENTE</div>
    <br /><br /><br />
    <div style="font-size: 20px;">Por medio de la presente hace constar que la estacion No. <?php echo($numero);?>, con el folio de torre <?php echo($torre);?>
    , con el folio de monitor <?php echo($monitor);?>, con el folio de teclado <?php echo($teclado);?>, con el folio de raton <?php echo($raton);?> 
    , ha sido reportado de una avería en alguno de sus componentes por lo cual se debe de hacer un correcto checado de la estacion de inmediato.</div>
    <br /><br /><br /><br /><br />
    <h1 style="text-align: center; font-size: 25px; ">Atentamente:</h1>
    <br /><br /><br />
    <h1 style="text-align: center; font-size: 25px; ">___________________________</h1>
    <h1 style="text-align: center; font-size: 20px; "><?php echo $_SESSION['usuario'];?></h1>
</body>
</html>

<?php
$HTML=ob_get_clean();

require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnable"=>true));
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));


?>


