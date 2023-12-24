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

         $stmt = $cnn->prepare("SELECT Id, Contraseña, Administra, Email FROM EMPLEADO WHERE Email = ?");
         $stmt->bind_param("s", $email);
         $stmt->execute();
         $resultado = $stmt->get_result();

         if ($resultado->num_rows == 1) {
            $fila = $resultado->fetch_assoc();
            if (password_verify($password, $fila['Contraseña'])) {
               if ($fila['Administra'] == 1) {
                  $_SESSION["Id"] = $fila['Id'];
                  $_SESSION["Administra"] = $fila['Administra'];
                  $_SESSION['Administrador'] = $_SESSION["Administra"];
                  unset($_SESSION['Administra']);
                  header("Location: ../web/views/principal_admin.php");
                  exit();
               } else if ($fila['Administra'] == 0) {
                  $_SESSION["Id"] = $fila['Id'];
                  $_SESSION["Administra"] = $fila['Administra'];
                  $_SESSION['Administrador'] = $_SESSION["Administra"];
                  unset($_SESSION['Administra']);
                  header("Location: ../web/views/principal_empleado.php");
                  exit();
               }
               $_SESSION["Email"] = $fila['Email'];
            } else {
               echo "Usuario o contraseña erróneos";
            }
         } else {
            echo "Usuario o contraseña erróneos";
         }

         $stmt->close();
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

      $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);

      $stmt = $cnn->prepare("INSERT INTO EMPLEADO(Nombre, Apellidos, Teléfono, horasContrato, Administra, Contraseña, DepartamentoId, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssiisss", $nombre, $apellidos, $telefono, $horasContrato, $administra, $contrasenaCifrada, $departamentoId, $email);

      if ($stmt->execute()) {
         if ($stmt->affected_rows > 0) {
            echo 1;
         } else {
            echo 0;
         }
      } else {
         echo "Error: " . $stmt->error;
      }
      $stmt->close();
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
      $contrasenaCifrada = password_hash($contrasena, PASSWORD_DEFAULT);

      $sql = "UPDATE empleado SET Nombre='$nombre', Apellidos='$apellidos',
        Teléfono='$telefono', Email='$email', HorasContrato='$horasContrato',
        Administra='$administra', Contraseña='$contrasenaCifrada',
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

      $stmt = $cnn->prepare("DELETE FROM empleado WHERE Id = ?");
      $stmt->bind_param("i", $id);

      if ($stmt->execute()) {
         if ($stmt->affected_rows > 0) {
            echo 1;
         } else {
            echo 0;
         }
      } else {
         echo "Error: " . $stmt->error;
      }

      $stmt->close();
      mysqli_close($cnn);
   }
}
