import $ from 'jquery';
import Swal from "sweetalert2";

document.addEventListener('livewire:init', () => {
    // Configurar listener para cuando se actualice la lista
    Livewire.on('listaActualizada', () => {
        console.log('Lista de usuarios actualizada en el frontend');
        // Aquí puedes forzar la actualización de los data-attributes si es necesario
    });
});

// Verificar si jQuery está disponible
if (typeof $ === 'undefined') {
    throw new Error('jQuery no está cargado. Verifica tus imports.');
}

$(document).ready(function () {
    // Asumiendo que el formulario de usuarios tiene el ID 'idformusuario'
    $("#idformusuario").submit(function (e) {
        e.preventDefault();

        // Desactivar el botón de envío para evitar múltiples envíos
        const $form = $(this);
        $form.find(":input").prop("disabled", true);

        // Obtener los datos del formulario
        const datos = {
            id: $("#idusuario").val(), // ID del usuario (si estamos editando)
            name: $("#idtxtnombre").val(),
            email: $("#idtxtemail").val(),
            password: $("#idtxtpassword").val(), // Contraseña
            idrol: $("#idselectrol").val(),
            _token: $('input[name="_token"]').val() // Token CSRF
        };

        // Enviar los datos al servidor (AJAX)
        $.ajax({
            url: "/verificarusuario", // Asegúrate de que esta ruta esté correctamente definida en Laravel
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (!response.success) {
                    console.log('Estructura de respuesta inválida');
                    // Puedes lanzar un error o notificar al usuario
                }

                // Emitir evento Livewire para refrescar la lista de usuarios
                Livewire.dispatch("listarusuariosDesdeJS");

                // Mostrar un mensaje de éxito usando SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // Resetear y cerrar el modal
                $("#idformusuario")[0].reset();
                $form.find(":input").prop("disabled", false);
                bootstrap.Modal.getInstance($('#idmodalUsuarios')[0]).hide();

            },
            error: function (xhr) {

                // Mostrar un mensaje de error si la solicitud falla
                console.error('Error solicitud falla:', xhr.responseJSON);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al registrar usuario',
                    text: xhr.responseJSON.message || 'Hubo un problema al registrar el usuario. Intenta nuevamente.',
                    showConfirmButton: true
                });
            }
        });
    });

    // Aquí puedes agregar más eventos o lógica según sea necesario
    $('#btnnuevousuario').on('click', function () {
        // Limpiar inputs
        $("#id").val('');
        $("#idformusuario")[0].reset();

        // Cambiar el título del modal
        $('#idlabeltitlemodalUsuarios').text('Nuevo Usuario');
        $('#idformusuario : input').prop('disabled', false);

        // Mostrar el modal
        const modalElement = document.getElementById('idmodalUsuarios'); // Asegúrate de que tu modal tenga este ID
        const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modalInstance.show();
    });

    //Delegacion de eventos para manejar el clic en los botones de editar y eliminar
    $(document).on('click', '.btneditarusuario', function (e) {
        e.preventDefault();

        // Obtener datos del TR actual (no del botón)
        const $tr = $(this).closest('tr');
        const id = $tr.find('td:eq(0)').text().trim();
        const name = $tr.find('td:eq(1)').text().trim();
        const email = $tr.find('td:eq(2)').text().trim();
        const password = $tr.find('td:eq(3)').text().trim();
        const idrol = $tr.find('td:eq(4)').text().trim();

        //Llenar el formulario con los datos del usuario
        $("#idusuario").val(id);
        $("#idtxtnombre").val(name);
        $("#idtxtemail").val(email);
        $("#idtxtpassword").val(password);
        $("#idselectrol").val(idrol);
        $('#idlabeltitlemodalUsuarios').text('Editar Usuario');

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('idmodalUsuarios'));
        modal.show();
    });

    $(document).on('click', '.btneliminarusuario', async function (e) {
        e.preventDefault();

        const $tr = $(this).closest('tr');
        const id = $tr.find('td:eq(0)').text().trim();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!csrfToken) {
            console.log('Token CSRF no encontrado');
            return;
        }

        const pregunta = await window.SweetAlertpreguntarSI_NO('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.');
        if (!pregunta) return;

        // Enviar solicitud AJAX para eliminar el usuario
        try {
            const response = await $.ajax({
                url: `/estadousuario`, // Asegúrate de que esta ruta esté correctamente definida en Laravel
                type: "POST",
                data: {
                    idusuario: id,
                    _token: csrfToken
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                dataType: 'json'
            });

            if (!response.success) {
                Livewire.dispatch("listarusuariosDesdeJS");
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario eliminado',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                throw new Error(response.message || 'Error en la operación');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.responseJSON?.message || 'No se pudo completar la eliminación'
            });
        }
    });
});
