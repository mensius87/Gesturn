<?php
require_once('session.php');
require_once('no_es_administrador.php');
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/sl-1.3.3/datatables.min.css" />
  <link rel="stylesheet" href="../style/style.css">
</head>

<body>

  <?php
  require_once('nav.php');
  ?>

  <div class="container">
    <div class="row">
      <div class="col-md-12 login-form">
        <div class="row">
          <div class="m-3">
            <!-- Trigger nuevo empleado -->
            <button class="btn btn-success btn-lg" tabindex="-1" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#modalNuevoEmpleado">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
              </svg>&nbsp&nbspAñadir empleado
            </button>
            <!-- -->
          </div>
          <div class="col-md-12 login-from-row">
            <h1 id="encabezadoTabla">Listado de empleados</h1><br><br>
            <table class="table mb-4" id="tablaEmpleados" class="display" style="width:100%">
              <thead>
                <tr">
                  <th></th>
                  <th colspan="8">
                  </th>
                  </tr>
                  <tr class="table-warning">
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Detalle</th>
                    <th scope="col">Informe</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Borrar</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Button trigger modal generar informe está en actions_datos_empleado -->

    <!-- Modal crear informe empleado -->
    <div class="modal fade" id="modalFormularioInforme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header btn-dark">
            <h5 class="modal-title" id="staticBackdropLabel">Solicitud de informe de horas trabajadas</h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x-square-fill" data-bs-dismiss="modal" viewBox="0 0 16 16">
              <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
            </svg>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <form class="row g-3" id="obtenerInfome" action='../../Controller/Generar_informe.php' method="post">

                  <div class="col-md-12 text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="140" height="140" fill="currentColor" class="bi bi-calendar-week m-4" viewBox="0 0 16 16">
                      <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                  </div>
                  <div class="col-md-6 p-4">
                    <label for="nombre">Fecha de inicio&nbsp</label>
                    <input type="number" class="form-control" name="idGenerarInforme" id="idGenerarInforme" hidden>
                    <input type="date" class="form-control" name="fechaInicio" id="fechaInicio">
                  </div>
                  <div class="col-md-6 p-4">
                    <label for="apellidos">Fecha de fin&nbsp</label>
                    <input type="date" class="form-control" name="fechaFin" id="fechaFin">
                  </div>
                  <div class="col md-12">
                    <button class="btn btn-block btn-success" id="informeEmpleado" type="submit" name="informeEmpleado">Solicitar informe</button>
                    <button class="btn btn-block btn-danger" data-bs-dismiss="modal" type="button">Cancelar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal nuevo empleado (el trigger está en el borón de arriba del todo) -->
    <div class="modal fade" id="modalNuevoEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header btn-success">
            <h5 class="modal-title" id="staticBackdropLabel">Crear nuevo empleado</h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x-square-fill" data-bs-dismiss="modal" viewBox="0 0 16 16">
              <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
            </svg>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <form class="row g-3" id="anadirEmpleado" name="anadirEmpleado">
                  <div class="col-md-12 text-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="green" class="bi bi-person-plus" viewBox="0 0 16 16">
                      <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                      <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                    </svg>
                  </div>
                  <div class="col-md-12 text-center mb-4">
                    <label>¿Tendrá rol de administrador?&nbsp&nbsp</label>
                    <label for="administra">&nbsp&nbsp&nbsp&nbspSí</label>
                    <input type="radio" name="administra" id="siAdministrador" value="1">
                    <label for="noAdministra">&nbsp&nbsp&nbsp&nbspNo</label>
                    <input type="radio" name="administra" id="noAdministrador" value="0">
                  </div>

                  <div class="col-md-6 mb-3 ">
                    <label for="">Nombre&nbsp</label>
                    <input type="" class="form-control" name="nombre" id="nombre" placeholder="">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="">Apellidos&nbsp</label>
                    <input type="" class="form-control" name="apellidos" id="apellidos" placeholder="">
                  </div>
                  <div class="col-md-5">
                    <label for="">Teléfono&nbsp</label>
                    <input type="" class="form-control" name="telefono" id="telefono" placeholder="">
                  </div>
                  <div class="col-md-3">
                    <label for="">Departamento&nbsp</label><br>
                    <label for=""><select name="departamentoId" id="departamentoId">
                        <option value="">Seleccionar</option>
                        <option value="1">RRHH</option>
                        <option value="2">Finanzas</option>
                        <option value="3">Marketing</option>
                        <option value="4">Otros</option>
                        <option value="5">Desarrollo</option>
                      </select>&nbsp</label><br>
                  </div>
                  <div class="col-md-4">
                    <label for="">Horas de contrato&nbsp</label>
                    <input type="" class="form-control" name="horasContrato" id="horasContrato" placeholder="">
                  </div>
                  <div class="col-md-12 ">
                    <label for="">Email&nbsp</label>
                    <input type="" class="form-control" name="email" id="email" placeholder="">
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="">Contraseña&nbsp</label>
                    <input type="" class="form-control" name="contrasena" id="contrasena" placeholder="">
                  </div>
                  <div class="col md-12">
                </form>
                <button class="btn btn-block btn-success" data-bs-dismiss="" id="anadir" name="anadir">Dar de alta</button>
                <button class="btn btn-block btn-danger" data-bs-dismiss="modal" type="button">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Button trigger modal ver detalle de empleado está en actions_datos_empleado-->

  <!-- Modal detalle de empleado -->
  <div class="modal fade modal-xl" id="modalVerEmpleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="table">
      <div class="modal-content">
        <div class="modal-header btn-primary">
          <h5 class="modal-title" id="staticBackdropLabel">Ver detalle empleado</h5>

          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x-square-fill" data-bs-dismiss="modal" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
          </svg>
        </div>

        <div class="modal-body" id="bodyModalVerEmpleado">
          <div class="col-md-12 text-center my-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="blue" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </div>

          <div id="tablaDetalleEmpleado" class="d-flex flex-row container justify-content-center alig-items-center my-5">
            <div class="row">
              <ul class="list-group list-group-horizontal" id="encabezadoVerEmpleado">
                <li class="list-group-item encabezado">ID</li>
                <li class="list-group-item encabezado">Nombre</li>
                <li class="list-group-item encabezado">Apellidos</li>
                <li class="list-group-item encabezado">Teléfono</li>
                <li class="list-group-item encabezado">Email</li>
                <li class="list-group-item encabezado">Departamento</li>
                <li class="list-group-item encabezado">Horas</li>
                <li class="list-group-item encabezado">Administra</li>
              </ul>
              <ul ul class="list-group list-group-horizontal" id="bodyVerEmpleado">

              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="col md-12">
            <button class="btn btn-block btn-success" data-bs-dismiss="modal" id="confirmarVerEmpleado" name="confirmarVerEmpleado">Volver</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Button trigger modal editar empleado está en el action_datos_empleado-->


  <!-- Modal editar empleado -->
  <div class="modal fade" id="modalModificarEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-warning">
          <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Modificación datos empleado</h5>
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="white" class="bi bi-x-square-fill" data-bs-dismiss="modal" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
          </svg>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-12 text-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="orange" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                </svg>
              </div>
              <form class="row g-3 ">
                <div class="col-12 text-center" id="editAdministra">

                </div>
                <div class="col-3 mb-3">
                  <label for="Id">ID&nbsp</label>
                  <input type="number" class="form-control" name="editId" id="editId" readonly="readonly" value="">
                </div>
                <div class="col-4 mb-3">
                  <label for="editNombre">Nombre&nbsp</label>
                  <input type="text" class="form-control" name="editNombre" id="editNombre" value="">
                </div>
                <div class="col-5 mb-3">
                  <label for="editApellidos">Apellidos&nbsp</label>
                  <input type="text" class="form-control" name="editApellidos" id="editApellidos" value="">
                </div>
                <div class="col-4">
                  <label for="editTelefono">Teléfono&nbsp</label>
                  <input type="text" class="form-control" name="editTelefono" id="editTelefono" value="">
                </div>
                <div class="col-4">
                  <label for="">Departamento&nbsp</label><br>
                  <label for="editDepartamentoId">
                    <select name="editDepartamentoId" id="editDepartamentoId" class="form-control">


                    </select></label><br><br>
                </div>
                <div class="col-4">
                  <label for="editHorasContrato">Horas contrato&nbsp</label>
                  <input type="text" class="form-control" name="editHorasContrato" id="editHorasContrato" value="">
                </div>
                <div class="col-12 mb-2">
                  <label for="">Email&nbsp</label>
                  <input type="mail" class="form-control" name="editEmail" id="editEmail" value="">
                </div>
                <div class="col-12 mb-3">
                  <label for="">Confirma o cambia contraseña&nbsp</label>
                  <input type="pass" class="form-control" name="editContrasena" id="editContrasena" value="" required>
                </div>
              </form>
              <div class="col md-12">
                <button class="btn btn-block btn-success" data-bs-dismiss="modal" id="modificar" name="modificar">Modificar</button>
                <button class="btn btn-block btn-danger" data-bs-dismiss="modal" type="button">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Button trigger modal eliminar empleado (se dispara desde action_datos_empleados) 
  <button type="button" class='botonBorrar btn btn-danger btn-sm' data-bs-toggle="modal" data-bs-target="#modalBorrarEmpleado">
  <i class="bi bi-trash"></i>
  </button>-->

  <!-- Modal eliminar empleado -->
  <div class="modal fade" id="modalBorrarEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-danger">
          <h5 class="modal-title" id="staticBackdropLabel">Eliminar empleado</h5>
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x-square-fill" data-bs-dismiss="modal" viewBox="0 0 16 16">
            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
          </svg>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <form class="row g-3">
                <div class="col-md-12 text-center my-5 ">
                  <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                  </svg>
                </div>
                <div class="col-md-12 text-center mb-5">
                  <form id="borrar"><br>
                    <p id="msgConfirmarEliminar"></p>
                </div>
              </form>
            </div>
            <div class="col md-12">
              <button class="btn btn-block btn-success" data-bs-dismiss="modal" id="confirmarEliminacion" name="confirmarEliminacion">Eliminar</button>
              <button class="btn btn-block btn-danger" data-bs-dismiss="modal" type="button">Cancelar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="../js/validacion_formularios.js"></script>
<script src="../js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/b-html5-2.0.1/b-print-2.0.1/sl-1.3.3/datatables.min.js"></script>
<!-- Problemas al añadir empleado  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
  var mitabla;
  $(document).ready(function() {
    mitabla = $('#tablaEmpleados').DataTable({
      responsive: true,
      "iDisplayLength": 10,
      dom: 'lBfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf'
      ],
      ajax: '../../Controller/Controlador_Principal.php?action=datosEmpleados',

      columns: [{
          'data': 'ID'
        },
        {
          'data': 'Nombre'
        },
        {
          'data': 'Apellidos'
        },
        {
          'data': 'Departamento'
        },
        {
          'defaultContent': "<td><button type='button' class='botonVer btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalVerEmpleado'><i class='bi bi-search'></i></button></td>"
        },
        {
          'defaultContent': "<td><button type='button' class='botonGenerarInforme btn btn-dark btn-sm' data-bs-toggle='modal' data-bs-target='#modalFormularioInforme'><i class='bi bi-file-earmark-break-fill'></i></button></td>"
        },
        {
          'defaultContent': "<td><button type='button' class='botonEditarEmpleado btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalModificarEmpleado'><i class='bi bi-pencil-square'></i></button></td>"
        },
        {
          'defaultContent': "<td><button type='button' class='botonBorrar btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalBorrarEmpleado'><i class='bi bi-trash'></i></button></td>"
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
      mitabla.ajax.reload(null, false); // user paging is not reset on reload
    }, 1000);
  });
</script>