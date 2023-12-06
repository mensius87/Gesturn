<?php
require_once('AdminController.php');
require_once('EmpleadoController.php');

if (isset($_GET['action'])){
    $action = $_GET['action'];
}
else{
    $action = $_POST['action'];
}

switch ($action) {
    case 'login':
        $objControllerlogin = new AdminController;
        $objControllerlogin->login($_POST['email'], $_POST['password']);
        break;
    case 'datosEmpleados':
        $objControllerDatosEmpleados = new AdminController;
        $objControllerDatosEmpleados->datosEmpleados();
        break;
    case 'anadirEmpleado':
        $objController = new AdminController;
        $objController->anadirEmpleado($_POST['administra'], $_POST['nombre'], $_POST['apellidos'], $_POST['telefono'], $_POST['departamentoId'], $_POST['horasContrato'], $_POST['email'], $_POST['contrasena']);
        break;
    case 'mostrarDatosEmpleado':
        $objController = new AdminController;
        $objController->mostrarDatosEmpleado($_GET['id']);
        break;
    case 'recogerDatos':
        $objController = new AdminController;
        $objController->recogerDatos($_GET['id']);
        break;
    case 'actualizarEmpleado':
        $objController = new AdminController;
        $objController->actualizarEmpleado($_GET['id'], $_GET['administra'], $_GET['nombre'], $_GET['apellidos'], $_GET['telefono'], $_GET['departamentoId'], $_GET['horasContrato'], $_GET['email'], $_GET['contrasena']);
        break;
    case 'borrarEmpleado':
        $objController = new AdminController;
        $objController->borrarEmpleado($_GET['id']);
        break;
    case 'iniciarTurno':
        $objController = new EmpleadoController;
        $objController->iniciarTurno($_POST['sesionId']);
        break;
    case 'iniciarDescanso':
        $objController = new EmpleadoController;
        $objController->iniciarDescanso($_POST['sesionId']);
        break;
    case 'finalizarDescanso':
        $objController = new EmpleadoController;
        $objController->finalizarDescanso($_POST['sesionId']);
        break;
    case 'finalizarTurno':
        $objController = new EmpleadoController;
        $objController->finalizarTurno($_POST['sesionId']);
        break;
    case 'historialEmpleado':
        $objController = new EmpleadoController;
        $objController->historialEmpleado($_GET['sesionId']);
        break;
}

?>