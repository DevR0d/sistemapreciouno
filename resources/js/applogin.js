import $ from 'jquery';
import Swal from "sweetalert2";

// Verificar si jQuery está disponible
if (typeof $ === 'undefined') {
    throw new Error('jQuery no está cargado. Verifica tus imports.');
}

$(document).ready(function () {
    $("#formulariologin").submit(function (e) {
    e.preventDefault();

    const $form = $(this);
    const loadingBar = $("#loadingBar");
    const loadingProgress = $("#loadingProgress");
    const $btnLogin = $("#btnlogin");
    const $spinner = $btnLogin.find(".loading-spinner");
    const $btnText = $btnLogin.find(".btn-text");

    // Mostrar barra y spinner
    loadingBar.show();
    loadingProgress.css("width", "0").addClass("loading");
    $spinner.removeClass("d-none");
    $btnText.addClass("d-none");
    $btnLogin.prop("disabled", true);
    $form.find(":input").prop("disabled", true);

    const datos = {
        email: $("#username").val(),
        password: $("#password").val(),
        _token: $('input[name="_token"]').val()
    };

    setTimeout(() => loadingProgress.css("width", "50%"), 300);

    $.ajax({
        url: "/iniciarsesion",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            loadingProgress.css("width", "100%");
            setTimeout(() => {
                loadingBar.fadeOut();
                $form.find(":input").prop("disabled", false);
                $btnLogin.prop("disabled", false);
                $spinner.addClass("d-none");
                $btnText.removeClass("d-none");

                if (response.idrol === null) {
                    $form[0].reset();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Acceso denegado',
                        text: response.message || 'Credenciales inválidas',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    const rutas = {
                        1: '/dashboard',
                        2: '/guiasremision',
                        3: '/dashboard' // o '/superadmin'
                    };
                    $form[0].reset();
                    window.location.replace(rutas[response.idrol] || '/');
                }
            }, 500);
        },
        error: function (error) {
            loadingBar.fadeOut();
            $form.find(":input").prop("disabled", false);
            $btnLogin.prop("disabled", false);
            $spinner.addClass("d-none");
            $btnText.removeClass("d-none");
            $form[0].reset();
            Swal.fire({
                icon: 'error',
                title: 'Error de inicio de sesión',
                text: error.responseJSON?.message || 'Credenciales incorrectas o error en el servidor',
                confirmButtonColor: '#c8102e'
            });
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


