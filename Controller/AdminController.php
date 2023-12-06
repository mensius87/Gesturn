<?php
require_once('../config/conexion.php');

class AdminController
{
   function login($email, $password)
   {
      session_start();

      if (!empty($_POST)) {
         $cnn = Conexion::conectar();

         if (!$cnn) {
            die("Connection failed: " . mysqli_connect_error());
         }

         $password = md5($password);

         $query = mysqli_query($cnn, "SELECT Id, Contraseña, Administra, Email from EMPLEADO where Email = '" . $email . "' 
                                    AND Contraseña = '" . $password . "'");

         $resultado = mysqli_num_rows($query);

         if ($resultado == 1) {
            $resultado = $query->fetch_array();
            if ($resultado['Administra'] == 1) {
               session_start();
               $_SESSION["Id"] = $resultado['Id'];
               $_SESSION["Administra"] = $resultado['Administra'];
               $_SESSION['Administrador'] = $_SESSION["Administra"];
               unset($_SESSION['Administra']);
               header("Location: ../web/views/principal_admin.php");
               exit();
            } else if ($resultado['Administra'] == 0) {
               session_start();
               $_SESSION["Id"] = $resultado['Id'];
               $_SESSION["Administra"] = $resultado['Administra'];
               $_SESSION['Administrador'] = $_SESSION["Administra"];
               unset($_SESSION['Administra']);
               header("Location: ../web/views/principal_empleado.php");
               exit();
            }
            session_start();
            $_SESSION["Email"] = $resultado['Email'];
         } else {
            echo "Usuario o contraseña erróneos";
         }

         mysqli_close($cnn);
      }
   }
   function datosEmpleados()
   {
      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT e.*, d.NombreDepartamento FROM empleado e join departamento d on e.DepartamentoId = d.Id";

      $json = array();

      $resultado = mysqli_query($cnn, $sql);
      while ($fila = mysqli_fetch_array($resultado)) {
         $json['data'][] = array(
            'ID' => $fila['Id'],
            'Nombre' => $fila['Nombre'],
            'Apellidos' => $fila['Apellidos'],
            'Departamento' => $fila['NombreDepartamento']
         );
      }

      $jsonString = json_encode($json);

      echo $jsonString;
   }

   function anadirEmpleado($administra, $nombre, $apellidos, $telefono, $departamentoId, $horasContrato, $email, $contrasena)
   {

      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }

      $contrasenaCifrada = md5($contrasena);

      $sql = "INSERT INTO EMPLEADO(Nombre, Apellidos, Teléfono, horasContrato,
        Administra, Contraseña, DepartamentoId, Email)
        VALUES ('$nombre', '$apellidos',
        '$telefono', '$horasContrato',
        '$administra', '$contrasenaCifrada', '$departamentoId', '$email')";

      if (mysqli_query($cnn, $sql)) {
         if (mysqli_affected_rows($cnn)) {
            echo 1;
         } else {
            echo 0;
         }
      } else {
         echo "Error: " . $sql . "<br>" . mysqli_error($cnn);
      }
      mysqli_close($cnn);
   }

   function mostrarDatosEmpleado($id)
   {
      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT e.*, d.NombreDepartamento FROM empleado e join departamento d on e.DepartamentoId = d.Id WHERE e.Id = '$id'";

      $resultado = mysqli_query($cnn, $sql);
      while ($fila = $resultado->fetch_array()) {

         if ($fila['Administra'] == 1) {
            $fila['Administra'] = "Sí";
         } else {
            $fila['Administra'] = "No";
         }

         echo
         '<li class="list-group-item datos"> ' . $fila["Id"] . '</li>
          <li class="list-group-item datos"> ' . $fila["Nombre"] . '</li>
          <li class="list-group-item datos"> ' . $fila["Apellidos"] . '</li>
          <li class="list-group-item datos"> ' . $fila["Teléfono"] . '</li>
          <li class="list-group-item datos"> ' . $fila["Email"] . '</li>
          <li class="list-group-item datos"> ' . $fila["NombreDepartamento"] . '</li>
          <li class="list-group-item datos"> ' . $fila["HorasContrato"] . '</li>
          <li class="list-group-item datos"> ' . $fila["Administra"] . '</li>';
      }

      mysqli_close($cnn);
   }

   function recogerDatos($id)
   {
      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT e.*, d.NombreDepartamento FROM empleado e join departamento d on e.DepartamentoId = d.Id WHERE e.Id = '$id'";

      $json = array();

      $resultado = mysqli_query($cnn, $sql);
      while ($fila = mysqli_fetch_array($resultado)) {

         $json[] = array(
            'editId' => $fila['Id'],
            'editNombre' => $fila['Nombre'],
            'editApellidos' => $fila['Apellidos'],
            'editTelefono' => $fila['Teléfono'],
            'editHorasContrato' => $fila['HorasContrato'],
            'editEmail' => $fila['Email'],
            'editContrasena' => $fila['Contraseña'],
            'editAdministra' => $fila['Administra'],
            'editDepartamentoId' => $fila['DepartamentoId']
         );
      }

      $jsonString = json_encode($json[0]);
      echo $jsonString;

      mysqli_close($cnn);
   }

   function actualizarEmpleado($id, $administra, $nombre, $apellidos, $telefono, $departamentoId, $horasContrato, $email, $contrasena)
   {
      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }
      $contranaCifrada = md5($contrasena);

      $sql = "UPDATE empleado SET Nombre='$nombre', Apellidos='$apellidos',
        Teléfono='$telefono', Email='$email', HorasContrato='$horasContrato',
        Administra='$administra', Contraseña='$contranaCifrada',
        DepartamentoId='$departamentoId' WHERE Id = '$id'";

      if (mysqli_query($cnn, $sql)) {
         if (mysqli_affected_rows($cnn)) {
            echo 1;
         } else {
            echo 0;
         }
      } else {
         echo 'error';
      }
      mysqli_close($cnn);
   }

   function borrarEmpleado($id)
   {

      $cnn = Conexion::conectar();

      if (!$cnn) {
         die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "DELETE FROM empleado WHERE Id='$id'";

      if (mysqli_query($cnn, $sql)) {
         if (mysqli_affected_rows($cnn)) {
            echo 1;
         } else {
            echo 0;
         }
      } else {

         die();
      }

      mysqli_close($cnn);
   }
}
