<?php
require_once('../config/conexion.php');
require_once('../fpdf.php');

$cnn = Conexion::conectar();

if (!$cnn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_POST['idGenerarInforme'];

//echo "<br>" . $id;
// Asignamos variables a todos los datos del empleado
$sql = "SELECT e.*, d.NombreDepartamento FROM empleado e join departamento d on e.DepartamentoId = d.Id WHERE e.Id = '$id'";
$resultado = mysqli_query($cnn, $sql);
while ($fila = $resultado->fetch_array()) {
    $nombre = $fila['Nombre'];
    $apellidos = $fila['Apellidos'];
    $telefono = $fila['Teléfono'];
    $horasContrato = $fila['HorasContrato'];
    $email = $fila['Email'];
    $contrasena = $fila['Contraseña'];
    $administra = $fila['Administra'];
    $departamentoId = $fila['DepartamentoId'];
    $nombreDepartamento =$fila['NombreDepartamento'];
}
mysqli_free_result($resultado);

$fechaInicio = $_POST['fechaInicio'] . " " . date("00:00:00");
$fechaFin = $_POST['fechaFin'] . " " . date("00:00:00");



// Obtenemos todas las filas de turnos iniciados de un empleado concreto dentro de las fechas indicadas para contar
// los días trabajados totales en el periodo y metemos en una variable los días trabajados en el período seleccionado
$sql = "SELECT COUNT(DISTINCT CAST(HoraInicioTurno AS DATE)) FROM turno where HoraInicioTurno is not null AND
 EmpleadoId ='$id' AND HoraInicioTurno >= '$fechaInicio' AND HoraFinTurno <= DATE_ADD('$fechaFin', INTERVAL 1 DAY)";

$resultado = mysqli_query($cnn, $sql);

while ($fila = $resultado->fetch_array()) {
    $diasTrabajadosPeriodoSeleccionado = $fila['0'];
}
mysqli_free_result($resultado);

// Tiempo total de turnos

$sql= "SELECT SUM(TIMESTAMPDIFF(SECOND,`HoraInicioTurno`,`HoraFinTurno`))/3600 from turno where HoraInicioTurno is not null AND
EmpleadoId ='$id' AND HoraInicioTurno >= '$fechaInicio' AND HoraFinTurno <= DATE_ADD('$fechaFin', INTERVAL 1 DAY)";
$resultado = mysqli_query($cnn, $sql);
while ($fila = $resultado->fetch_array()) {
    $horasTotalesDentroDelTurno = $fila['0'];
}
mysqli_free_result($resultado);


// Calculos
// Tiempo total descansado
$sql ="SELECT SUM(TIMESTAMPDIFF(SECOND,`HoraInicioDescanso`,`HoraFinDescanso`))/3600 from descanso INNER JOIN turno on descanso.TurnoId = Turno.Id where HoraInicioTurno is not null AND
EmpleadoId =$id AND HoraInicioTurno >= '$fechaInicio' AND HoraFinTurno <= DATE_ADD('$fechaFin', INTERVAL 1 DAY)";
$resultado = mysqli_query($cnn, $sql);
while ($fila = $resultado->fetch_array()) {
    $horasTotalesDentroDescanso = $fila['0'];
}

// Cálculo del tiempo descansado en un turno (calcula la diferencia de tiempo entre ambas celdas)
$sql = "SELECT TIMESTAMPDIFF(SECOND,`HoraInicioDescanso`,`HoraFinDescanso`) from descanso WHERE `TurnoId` = ";
 
// Variables necesarias para operaciones y operaciones
$horasDebioTrabajarPeriodoSeleccionado = $horasContrato * $diasTrabajadosPeriodoSeleccionado;
$horasEfectivasTrabajadas = $horasTotalesDentroDelTurno - $horasTotalesDentroDescanso;
$balance = ($horasEfectivasTrabajadas - $horasDebioTrabajarPeriodoSeleccionado)*60;
$fechaInicioFormateada = date("d-m-Y", strtotime($fechaInicio));
$fechaFinFormateada = date("d-m-Y", strtotime($fechaFin));
$minutosEfectivosTrabajados = $horasEfectivasTrabajadas*60;

if ($balance >= 0) {
    $rojo=0;
    $verde=255;
    $azul=0; 
}
else {
    $rojo=255;
    $verde=0;
    $azul=0; 
}

function convertToHoursMins($time, $format = '%02d:%02d') {

    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
//echo convertToHoursMins(250, '%02d hours %02d minutes');


$txt = "El/la empleado/a " . $nombre . " " . $apellidos . ", con Id " . $id . ", que actualmente pertenece al departamento de " . $nombreDepartamento . 
", ha trabajado entre el " . $fechaInicioFormateada . " y el " . $fechaFinFormateada . ", un total de "  . $diasTrabajadosPeriodoSeleccionado . 
" días. En dicho periódo, según las horas diarias estipuladas en su contrato (".$horasContrato."), debería de haber trabajado un total de " . $horasDebioTrabajarPeriodoSeleccionado .
 " horas. El saldo de horas con la empresa a día de hoy es de: " . convertToHoursMins($balance, '%02d horas y %02d minutos') . "." . "\n\nTabla resumen:";

$headerTabla;

$pdf = new FPDF();
$pdf->AddPage();
//$pdf->Image('../views/logo2.png');
$pdf->SetFont('Arial', 'B', 16);
// Logo
// Arial bold 15
$pdf->SetFont('Arial','B',15);
// Movernos a la derecha
$pdf->Cell(40);
// Título
$pdf->Cell(110,10,utf8_decode('INFORME BALANCE HORAS TRABAJADAS'),0,0,'C');
$pdf->Ln(35);
// Salto de línea

$pdf->Image('../web/img/logo2.png',172,2,35);

// Arial bold 15
$pdf->SetFont('Arial','B',15);
// Calculamos ancho y posición del título.
$w = $pdf->GetStringWidth($nombre)+65;
$pdf->SetX((210-$w)/2);
// Colores de los bordes, fondo y texto
$pdf->SetDrawColor(0,80,180);
$pdf->SetFillColor(230,230,0);
// Ancho del borde (1 mm)
$pdf->SetLineWidth(1);
// Título
$pdf->Cell($w,9,'DEPARTAMENTO DE RRHH',1,1,'C',true);
// Salto de línea
$pdf->Ln(10);

$pdf->MultiCell(190, 10,utf8_decode($txt));
$pdf->Ln(10);
$pdf->SetFillColor(190);
$pdf->Cell(90, 10, 'ID', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode($id), 1, 0, 'c', 0);
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Empleado/a', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode($nombre . " " . $apellidos. '' ), 1, 0, 'c', 0);
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Horas diarias de contrato', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode($horasContrato), 1, 0, 'c', );
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Periodo del informe', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode($fechaInicioFormateada . " / " . $fechaFinFormateada), 1, 0, 'c', 0);
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Horas asignadas a periodo', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode($horasDebioTrabajarPeriodoSeleccionado), 1, 0, 'c', );
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Horas efectivas trabajadas', 1, 0, 'c', 1);
$pdf->Cell(90, 10, utf8_decode(convertToHoursMins($minutosEfectivosTrabajados, '%02d horas y %02d minutos')), 1, 0, 'c', 0);
$pdf->Ln(10);
$pdf->Cell(90, 10, 'Balance final en horas', 1, 0, 'c', 1);
$pdf->SetFillColor($rojo, $verde, $azul);
$pdf->Cell(90, 10, utf8_decode(convertToHoursMins($balance, '%02d horas y %02d minutos')), 1, 0, 'c', 1);

$pdf->Output("I",utf8_decode( "Infome horario " . $nombre . " " . $apellidos . " del " . $fechaFinFormateada  . " al " . $fechaFinFormateada  . ".pdf" ));
?>