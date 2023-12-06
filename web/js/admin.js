$(document).ready(function () {
    console.log('JQuery is working');

    $('tbody').addClass('table-success');

    // AÑADIR EMPLEADO \\ 
    $('#anadir').click(function () {

        administra = $('input:radio[name=administra]:checked').val();
        nombre = $('#nombre').val();
        apellidos = $('#apellidos').val();
        telefono = $('#telefono').val();
        departamentoId = $('#departamentoId').find(":selected").val();
        horasContrato = $('#horasContrato').val();
        email = $('#email').val();
        contrasena = $('#contrasena').val();

        $("#anadirEmpleado").validate({
            errorClass: "errorValidacion",
            validClass: "correctoValidacion",

            rules: {
                administra: {
                    required: true
                },
                nombre: {
                    required: true
                },
                apellidos: {
                    required: true
                },
                telefono: {
                    required: true,
                    digits: true
                },
                horasContrato: {
                    required: true,
                    digits: true
                },
                departamentoId: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                contrasena: {
                    required: true
                },
            },

            messages: {
                administra: {
                    required: "¿Administrará?"
                },
                nombre: {
                    required: "Rellena el nombre"
                },
                apellidos: {
                    required: "Rellena los apellidos"
                },
                telefono: {
                    required: "Rellena el teléfono",
                    digits: "Introduce solo números"
                },
                horasContrato: {
                    required: "Indica las horas",
                    digits: "Introduce solo números"
                },
                departamentoId: {
                    required: "Indica departamento"
                },
                email: {
                    required: "Email no puede estar vacío",
                    email: "Formato de email incorrecto"
                },
                contrasena: {
                    required: "Contraseña no puede estar vacía"
                },
            },
            submitHandler: function (form, event) {
                
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../../Controller/Controlador_Principal.php",
                    data: {
                        action: 'anadirEmpleado',
                        administra: administra,
                        nombre: nombre,
                        apellidos: apellidos,
                        telefono: telefono,
                        departamentoId: departamentoId,
                        horasContrato: horasContrato,
                        email: email,
                        contrasena: contrasena
                    },
                    success: function (response) {

                        if (response == 1) {
                            toastr.success('Empleado añadido correctamente');
                            $('#modalNuevoEmpleado').modal('hide');
                            mitabla.ajax.reload();
                            $('#anadirEmpleado')[0].reset();
                        } else {
                            toastr.error('Error al añadir empleado');
                        }
                    },
                });
            }
            
        });

    });

    // VER DETALLE DE EMPLEADO \\ Al hacer clic, se selecciona por Id de fila de la tabla y se dirige al action de ver empleado con el Id seleccionado
    $(document).on('click', '.botonVer', function () {
        var idEmpleadoFila = this.parentElement.parentElement.firstChild.innerHTML;

        $.post("../../Controller/Controlador_Principal.php?action=mostrarDatosEmpleado&id=" + idEmpleadoFila, function (response) {
            $('#bodyVerEmpleado').html(response);
        });
    });

    // INFORME \\ Al hacer clic, se selecciona por Id de fila de la tabla y se dirige al action de informe empleado con el Id seleccionado
    $(document).on('click', '.botonGenerarInforme', function () {
        var id = this.parentElement.parentElement.firstChild.innerHTML; //seleccionamos de su lista de elementos el que se llama empleadoId y lo guardamos en id
        console.log(id);

        $('#idGenerarInforme').val(id);
    });

    // EDITAR EMPLEADO \\ Al hacer clic, se selecciona por Id de fila de la tabla y se dirige al action de editar empleado con el Id seleccionado
    $(document).on('click', '.botonEditarEmpleado', function () {
        var idEmpleadoFila = this.parentElement.parentElement.firstChild.innerHTML; //seleccionamos de su lista de elementos el que se llama empleadoId y lo guardamos en idEmpleadoFila

        $.post('../../Controller/Controlador_Principal.php?action=recogerDatos&id=' + idEmpleadoFila, function (response) {
            const editEmpleado = JSON.parse(response);

            $('#editId').val(editEmpleado.editId);
            $('#editNombre').val(editEmpleado.editNombre);
            $('#editApellidos').val(editEmpleado.editApellidos);
            $('#editTelefono').val(editEmpleado.editTelefono);
            $('#editDepartamentoId').val(editEmpleado.editDepartamentoId);
            $('#editHorasContrato').val(editEmpleado.editHorasContrato);
            $('#editEmail').val(editEmpleado.editEmail);

            if ($('#editContrasena').val() != null) {
                $('#editContrasena').val("");
            }
            $('#editContrasena').val();

            //$('input:radio[name=administra]:checked').val(editEmpleado.editAdministra);

            if (editEmpleado.editAdministra == 1) {
                $('#editAdministra').html(
                    '<label>¿Tendrá rol de administrador?&nbsp&nbsp</label>\
                        <label for="administra">&nbsp&nbsp&nbsp&nbspSí</label>\
                        <input type="radio"  name="editAdministra" id="administra" value="1" checked>\
                        <label for="noAdministra">&nbsp&nbsp&nbsp&nbspNo</label>\
                        <input type="radio"  name="editAdministra" id="noAdministra" value="0">\
                        <br><br>'
                );
            }
            else {
                $('#editAdministra').html(
                    '<label>¿Tendrá rol de administrador?&nbsp&nbsp</label>\
                        <label for="administra">&nbsp&nbsp&nbsp&nbspSí</label>\
                        <input type="radio"  name="editAdministra" id="administra" value="1">\
                        <label for="noAdministra">&nbsp&nbsp&nbsp&nbspNo</label>\
                        <input type="radio"  name="editAdministra" id="noAdministra" value="0" checked >\
                        <br><br>'
                );
            }

            switch (editEmpleado.editDepartamentoId) {
                case '1':
                    editEmpleado.editDepartamentoId =
                        '<option selected value="1">RRHH</option>\
                            <option value="2">Finanzas</option>\
                            <option value="3">Marketing</option>\
                            <option value="4">Otros</option>\
                            <option value="5">Desarrollo</option>';
                    break;
                case '2':
                    editEmpleado.editDepartamentoId =
                        '<option value="1">RRHH</option\
                            <option value="2">Finanzas</option>\
                            <option value="3">Marketing</option>\
                            <option value="4">Otros</option>\
                            <option value="5">Desarrollo</option>';
                    break;
                case '3':
                    editEmpleado.editDepartamentoId =
                        '<option value="1">RRHH</option>\
                            <option value="2">Finanzas</option>\
                            <option selected value="3">Marketing</option>\
                            <option value="4">Otros</option>\
                            <option value="5">Desarrollo</option>';
                    break;
                case '4':
                    editEmpleado.editDepartamentoId =
                        '<option value="1">RRHH</option>\
                            <option value="2">Finanzas</option>\
                            <option value="3">Marketing</option>\
                            <option selected value="4">Otros</option>\
                            <option value="5">Desarrollo</option>';
                    break;
                case '5':
                    editEmpleado.editDepartamentoId =
                        '<option value="1">RRHH</option>\
                            <option value="2">Finanzas</option>\
                            <option value="3">Marketing</option>\
                            <option value="4">Otros</option>\
                            <option selected value="5">Desarrollo</option>';
                    break;
            }
            $('#editDepartamentoId').html(editEmpleado.editDepartamentoId);
        });
    });

    $(document).on('click', '#modificar', function () {
        var id = $('#editId').val();
        var administra = $('input:radio[name=editAdministra]:checked').val();
        var nombre = $('#editNombre').val();
        var apellidos = $('#editApellidos').val();
        var telefono = $('#editTelefono').val();
        var departamentoId = $('#editDepartamentoId').find(":selected").val();
        var horasContrato = $('#editHorasContrato').val();
        var email = $('#editEmail').val();
        var contrasena = $('#editContrasena').val();

        $.post("../../Controller/Controlador_Principal.php?action=actualizarEmpleado&id=" + id + "&administra=" + administra + "&nombre=" + nombre + "&apellidos=" + apellidos + "&telefono=" + telefono + "&departamentoId=" + departamentoId + "&horasContrato=" + horasContrato + "&email=" + email + "&contrasena=" + contrasena, function (response) {
            if (response == 1) {
                toastr.success('Empleado actualizado correctamente');
            } else {
                toastr.error('Error al actualizar empleado');
            }
            console.log(response);
        });
    });

    // BORRAR EMPLEADO \\ Al hacer clic, se selecciona por Id de fila de la tabla y se dirige al action de borrar empleado con el Id seleccionado
    $(document).on('click', '.botonBorrar', function () {
        var idEmpleadoFila = this.parentElement.parentElement.firstChild.innerHTML; //seleccionamos de su lista de elementos el que se llama empleadoId y lo guardamos en idEmpleadoFila

        var msgConfirmarEliminar = '¿Seguro que deseas elimiar el empleado con Id ' + idEmpleadoFila + '?';
        console.log(msgConfirmarEliminar);

        $('#msgConfirmarEliminar').text(msgConfirmarEliminar);

        $("#confirmarEliminacion").click(function () {

            $.post("../../Controller/Controlador_Principal.php?action=borrarEmpleado&id=" + idEmpleadoFila, function (response) {
                if (response == 1) {
                    
                    toastr.success('Empleado eliminado correctamente');
                    $('#modalBorrarEmpleado').modal('hide');

                } else {
                    toastr.error('Error al eliminar empleado');
                }
            });
        });
    });
})



