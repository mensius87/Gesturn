$(document).ready(function () {

    function mostrarHoraActual() {

        var d = new Date();
        horas = d.getHours();
        minutos = d.getMinutes();
        if (horas < 10) horas = '0' + horas;
        if (minutos < 10) minutos = '0' + minutos;
        return horas + ':' + minutos;
    }

    console.log(mostrarHoraActual());

    // Si se pulsa botonInicioTurno, los otros aparecen y este desaparece
    $("#botonInicioTurno").click(function () {
        var sesionId = $('#idSesion').val();
        console.log(sesionId)

        $.ajax({
            type: 'POST',
            url: '../../Controller/Controlador_Principal.php',
            data: {
                action: 'iniciarTurno',
                sesionId: sesionId
            },
            success: function (response) {
                //console.log(response);
                if (response == 1) {
                    toastr.success('Has iniciado el turno');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "");
                    $("#botonFinTurno").css("display", "");
                    $('#historialEmpleado').append(
                        '<li class="list-group-item"><span class="letraHistorial" id="styleInicioTurno">Turno iniciado [' + mostrarHoraActual() + ']</span></li>'
                    );
                } else {
                    toastr.error('Error al iniciar el turno');
                    $("#botonInicioTurno").css("display", "");
                    $("#botonInicioDescanso").css("display", "none");
                    $("#botonFinTurno").css("display", "none");
                }
            }
        })
    });

    // Si se pulsa botonInicioDescanso, desaparece junto con botonFinTurno (el de inicio ya no estaba)
    // y aparece otro para finalizar el descanso
    $("#botonInicioDescanso").click(function () {
        var sesionId = $('#idSesion').val();

        $.ajax({
            type: 'POST',
            url: '../../Controller/Controlador_Principal.php',
            data: {
                action: 'iniciarDescanso',
                sesionId: sesionId
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    toastr.success('Has iniciado un descanso');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "none");
                    $("#botonFinDescanso").css("display", "");
                    $("#botonFinTurno").css("display", "none");
                    $('#historialEmpleado').append(
                        '<li class="list-group-item"><span class="letraHistorial" id="styleInicioDescanso">Descanso iniciado [' + mostrarHoraActual() + ']</span></li>'
                    );
                } else {
                    toastr.error('Error al iniciar descanso');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "");
                    $("#botonFinDescanso").css("display", "none");
                    $("#botonFinTurno").css("display", "");
                }
            }
        })
    });

    $("#botonFinDescanso").click(function () {
        var sesionId = $('#idSesion').val();

        $.ajax({
            type: 'POST',
            url: '../../Controller/Controlador_Principal.php',
            data: {
                action: 'finalizarDescanso',
                sesionId: sesionId
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    toastr.success('Has vuelto al turno tras un descanso');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "");
                    $("#botonFinDescanso").css("display", "none");
                    $("#botonFinTurno").css("display", "");
                    $('#historialEmpleado').append(
                        '<li class="list-group-item""><span class="letraHistorial" id="styleFinDescanso">Descanso finalizado [' + mostrarHoraActual() + ']</span></li>'
                    );
                } else {
                    toastr.error('Error al finalizar el descanso');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "none");
                    $("#botonFinDescanso").css("display", "");
                    $("#botonFinTurno").css("display", "none");

                }
            }
        })
    });

    // Si se pulsa botonFinTurno, los desaparece junto con botonInicioDescanso y aparece botonInicioTurno
    $("#botonFinTurno").click(function () {
        var sesionId = $('#idSesion').val();

        $.ajax({
            type: 'POST',
            url: '../../Controller/Controlador_Principal.php',
            data: {
                action: 'finalizarTurno',
                sesionId: sesionId
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    toastr.success('Has finalizado tu turno');
                    $("#botonInicioTurno").css("display", "");
                    $("#botonInicioDescanso").css("display", "none");
                    $("#botonFinDescanso").css("display", "none");
                    $("#botonFinTurno").css("display", "none");
                    $('#historialEmpleado').append(
                        '<li class="list-group-item"><span class="letraHistorial" id="styleFinTurno">Turno finalizado [' + mostrarHoraActual() + ']</span></li>'
                    );
                } else {
                    toastr.error('Error al finalizar el turno');
                    $("#botonInicioTurno").css("display", "none");
                    $("#botonInicioDescanso").css("display", "");
                    $("#botonFinDescanso").css("display", "none");
                    $("#botonFinTurno").css("display", "");
                }
            }
        })
    });
});