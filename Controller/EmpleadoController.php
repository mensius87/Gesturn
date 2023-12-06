<?php
require_once('../config/conexion.php');

class EmpleadoController
{
    function iniciarTurno($empleadoId)
    {
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: ../index.php");
            exit();
        }

        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $horaInicioTurno = date("Y-m-d H:i:s");

        $sql = "INSERT INTO turno (HoraInicioTurno, EmpleadoId) VALUES ('$horaInicioTurno','$empleadoId')";

        if (mysqli_query($cnn, $sql)) {
            if (mysqli_affected_rows($cnn)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 'Error en la conexión a la BBDD';
            die();
        }
        mysqli_close($cnn);
    }

    function iniciarDescanso($empleadoId)
    {
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: ../index.php");
            exit();
        }

        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $empleadoId;
        $horaInicioDescanso = date("Y-m-d H:i:s");
        //$caputuraDiaSql = date("Y-m-d");

        $sql = "SELECT Id FROM turno WHERE EmpleadoId = '$empleadoId' ORDER BY Id DESC LIMIT 0, 1";
        $resultado = mysqli_query($cnn, $sql);
        while ($fila = $resultado->fetch_array()) {
            $turnoId = $fila['Id'];
        }

        $sql = "INSERT INTO descanso (HoraInicioDescanso, TurnoId) VALUES ('$horaInicioDescanso','$turnoId')";

        if (mysqli_query($cnn, $sql)) {
            if (mysqli_affected_rows($cnn)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo "error al realizar la operación en la BBDD";
            die();
        }

        mysqli_close($cnn);
    }

    function finalizarDescanso($empleadoId)
    {
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: ../index.php");
            exit();
        }

        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $empleadoId;
        $horaFinDescanso = date("Y-m-d H:i:s");

        $sql = "SELECT d.Id, t.EmpleadoId FROM descanso d JOIN turno t on d.TurnoId = t.Id WHERE t.EmpleadoId = '$empleadoId'ORDER BY id DESC LIMIT 0, 1";

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $IdDescansoIniciado = $fila['Id'];
        }
        mysqli_free_result($resultado);

        $sql = "UPDATE descanso SET HoraFinDescanso='$horaFinDescanso' WHERE Id = $IdDescansoIniciado";

        if (mysqli_query($cnn, $sql)) {
            if (mysqli_affected_rows($cnn)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo "Error al realizar la operación en la BBDD";
            die();
        }
        mysqli_close($cnn);
    }

    function finalizarTurno($empleadoId)
    {
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: ../index.php");
            exit();
        }
        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $empleadoId;
        $horaFinTurno = date("Y-m-d H:i:s");

        /* Hay que seleccionar la fila que se creó al inicio de turno y modificar para poner la hora
        de fin de turno que estará en null
        */

        $sql = "SELECT Id FROM turno WHERE EmpleadoId = '$empleadoId' ORDER BY id DESC LIMIT 0, 1";

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $IdTurnoIniciado = $fila['Id'];
        }
        mysqli_free_result($resultado);

        $sql = "UPDATE turno SET HoraFinTurno='$horaFinTurno' WHERE Id = $IdTurnoIniciado";

        if (mysqli_query($cnn, $sql)) {
            if (mysqli_affected_rows($cnn)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 'Error en BBDD';
            die();
        }

        mysqli_close($cnn);
    }

    function historialEmpleado($empleadoId)
    {
        session_start();
        if (!isset($_SESSION['Id'])) {
            header("Location: ../index.php");
            exit();
        }
        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $diaActualInicio = date("Y-m-d") . " " . date("00:00:01");
        $diaActualFin = date("Y-m-d") . " " . date("23:59:59");

        $sql = "SELECT HoraInicioTurno FROM turno WHERE EmpleadoId = $empleadoId AND HoraInicioTurno >= '$diaActualInicio' AND HoraInicioTurno <= '$diaActualFin'";

        $json = array();

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $json['data'][] = array(
                'Evento' => 'Inicio Turno',
                'Hora' => date("H:i:s", strtotime($fila['HoraInicioTurno']))
            );
        }
        mysqli_close($cnn);


        // Consulta para capturar los inicioDescanso del día actual
        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT d.HoraInicioDescanso FROM descanso d JOIN turno t on d.TurnoId = t.Id WHERE EmpleadoId = $empleadoId AND HoraInicioDescanso >= '$diaActualInicio' AND HoraInicioDescanso <= '$diaActualFin'";

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $json['data'][] = array(
                'Evento' => 'Inicio Descanso',
                'Hora' => date("H:i:s", strtotime($fila['HoraInicioDescanso']))
            );
        }
        mysqli_close($cnn);


        // Consulta para capturar los finDescanso del día actual
        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT d.HoraFinDescanso FROM descanso d JOIN turno t on d.TurnoId = t.Id WHERE EmpleadoId = $empleadoId AND HoraFinDescanso >= '$diaActualInicio' AND HoraFinDescanso <= '$diaActualFin'";

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $json['data'][] = array(
                'Evento' => 'Fin Descanso',
                'Hora' => date("H:i:s", strtotime($fila['HoraFinDescanso']))
            );
        }
        mysqli_close($cnn);

        $cnn = Conexion::conectar();

        if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT HoraFinTurno FROM turno WHERE EmpleadoId = $empleadoId AND HoraFinTurno >= '$diaActualInicio' AND HoraFinTurno <= '$diaActualFin'";

        $resultado = mysqli_query($cnn, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $json['data'][] = array(
                'Evento' => 'Fin Turno',
                'Hora' => date("H:i:s", strtotime($fila['HoraFinTurno']))
            );
        }
        mysqli_close($cnn);

        $jsonString = json_encode($json);

        echo $jsonString;
    }
}

?>