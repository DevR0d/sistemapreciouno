import $ from 'jquery';
import Swal from "sweetalert2";

// Verificar si jQuery está disponible
if (typeof $ === 'undefined') {
    throw new Error('jQuery no está cargado. Verifica tus imports.');
}

$(document).ready(function () {
    $("#formulariologin").submit(function (e) {
        e.preventDefault();

        // Desactivar inputs y botón
        // $("#idformvechiculo :input").prop("disabled", true);

        const $form = $(this);
        $form.find(":input").prop("disabled", true);

        const datos = {
            email: $("#username").val(),
            password: $("#password").val(),
            _token: $('input[name="_token"]').val()
        };

        // Enviar datos al servidor (AJAX)
        $.ajax({
            url: "/iniciarsesion", // Ruta en Laravel
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $form.find(":input").prop("disabled", false);
                if (response.idrol === null) {
                    Swal.fire({
                        icon: 'warning',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // throw new Error();
                } else if (response.idrol === 1) {
                    $form[0].reset();
                    window.location.replace('/dashboard');
                } else if (response.idrol === 2) {
                    $form[0].reset();
                    window.location.replace('/guiasremision');
                } else if (response.idrol === 3) {
                    $form[0].reset();
                    window.location.replace('/dashboard'); // o la ruta que uses para el superadmin
                }


                // Actualizar Livewire
                // Livewire.dispatch("listarvehiculoDesdeJS");

                // Swal.fire({
                //     icon: 'success',
                //     title: response.message,
                //     timer: 1500,
                //     showConfirmButton: false
                // });

                // Resetear y cerrar modal

                // bootstrap.Modal.getInstance($('#idmodalvehiculo')[0]).hide();

            },
            error: function (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.responseJSON?.message || 'No se pudo completar la eliminación'
                });
                // alert("Error: " + xhr.responseJSON.message);
            }
        });
    });

    $(document).on('click', '#btncerrarsesion', async function (e) {
        e.preventDefault();

        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Verificación adicional
        if (!csrfToken) {
            console.log('Token CSRF no encontrado');
            return;
        }

        const pregunta = await window.SweetAlertpreguntarSI_NO("¿Estás seguro de cerrar sesión?");

        if (!pregunta) return;

        try {
            const response = await $.ajax({
                url: "/logout",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                dataType: 'json'
            });

            if (response.success) {
                window.location.replace('/login');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.responseJSON?.message || 'No se pudo completar el cerrar sesión'
            });
        }
    });
});


