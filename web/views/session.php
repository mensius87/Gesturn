<?php
session_start();
if (!isset($_SESSION['Id'])) {
   header("Location: ../../index.php");
   exit();
}
// si algo falla borrar siguiente línea y sus retoques
$IdSesion;
$IdSesion = $_SESSION['Id'];

require_once('../../config/conexion.php');
$cnn = Conexion::conectar();
if (!$cnn) {
   die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM empleado WHERE Id='$IdSesion'";
$resultado = mysqli_query($cnn, $sql);
while ($fila = $resultado->fetch_array()) {
   $nombreSesion = $fila['Nombre'];
   $apellidosSesion = $fila['Apellidos'];
   $administraSesion = $fila['Administra'];
   $emailSesion = $fila['Email'];
}

unset($_SESSION['Administra']);

$mensajeRol = "";
$mensajeAdministrador = "Usuario: " . $emailSesion . " [Admin]";
$mensajeEmpleado = "Usuario : " . $emailSesion . " [Empleado/a]";

if ($administraSesion == 1) {
   $mensajeRol = $mensajeAdministrador;
} else {
   $mensajeRol = $mensajeEmpleado;
}

mysqli_close($cnn);
