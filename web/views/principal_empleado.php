<?php
require_once('session.php');
require_once('no_es_empleado.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Control Horario de empleados</title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/af-2.3.7/r-2.2.9/datatables.min.css" />
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>
  <?php
  require_once('nav.php');
  ?>

  <input type="hidden" name="idSesion" id="idSesion" value="<?php echo $_SESSION['Id'] ?>">

  <div class="container">
    <div class="row align-items-start">
      <div class="col">
      </div>
      <div class="col">
        <div class="container text-center">
          <div class="row text-center">
            <div class="row">
              <div class="col-md-12 login-from-row login-form">
                <h2>Gestiona tu turno</h2>
                <h4>_______________</h4>
                <a id="botonInicioTurno" href="#" name="sesion" class="btn btn-info btn-lg btn-block my-3">Iniciar turno</a>
                <a id="botonInicioDescanso" style="display: none;" href="#" class="btn btn-primary btn-lg btn-block my-3">Parar a descansar</a>
                <a id="botonFinDescanso" style="display: none;" href="#" class="btn btn-warning btn-lg btn-block my-3">Volver al trabajo</a>
                <a id="botonFinTurno" style="display: none;" href="#" class="btn btn-danger btn-lg btn-block my-3">Finalizar turno</a>
                <table class="table mb-4" id="tablaHistorial" class="display" style="width:100%">
                  <thead>
                    <tr">
                      <th></th>
                      <th colspan="2">
                      </th>
                      </tr>
                      <tr class="table-warning">
                        <th scope="col">Evento</th>
                        <th scope="col">Hora</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/af-2.3.7/r-2.2.9/datatables.min.js"></script>
  <script src="../js/empleado.js"></script>

  <script>
    $(document).ready(function() {
      var mitablaHistorial = $('#tablaHistorial').DataTable({
        aaSorting: [
          [1, 'asc']
        ],
        searching: false,
        paging: false,
        info: false,
        responsive: true,
        "iDisplayLength": 10,
        ajax: '../../Controller/Controlador_Principal.php?action=historialEmpleado&sesionId=<?php echo $_SESSION['Id'] ?>',
        columns: [{
            'data': 'Evento'
          },
          {
            'data': 'Hora'
          }
        ],
        "language": {
          "lengthMenu": "Mostrar _MENU_ resultados por página&nbsp&nbsp&nbsp&nbsp&nbsp",
          "zeroRecords": "Ningún resultado encontrado",
          "info": "Mostrando pagina _PAGE_ de _PAGES_",
          "infoEmpty": "No hay resgistros disponibles",
          "infoFiltered": "(filtrado de un total de _MAX_ registros)",
          "search": "Buscar:",
          "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
          },
        }
      });
      setInterval(function() {
        mitablaHistorial.ajax.reload(null, false); // user paging is not reset on reload
      }, 1000);
    });
  </script>
</body>

</html>