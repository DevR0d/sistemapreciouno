import $ from 'jquery';
import Swal from "sweetalert2";

const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);

// Verificar si jQuery está disponible
if (typeof $ === 'undefined') {
    throw new Error('jQuery no está cargado. Verifica tus imports.');
}

$(document).ready(function() {
    $("#idformproducto").submit(function(e) {
        e.preventDefault();

        // Cerrar el modal
        const modalElement = document.getElementById('idmodalProductos'); // Asegúrate que tu modal tenga este ID
        const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modalInstance.hide();

        const datos = {
            nombre: $("#idtxtnombre").val(),
            sku: $("#idtxtsku").val(),
            estado: $("#idselectestado").val(),
            fecharegistro: fechaLocal,
            _token: $('input[name="_token"]').val() // Token CSRF
        };

        console.log(JSON.stringify(datos));

        // Enviar datos al servidor (AJAX)
        $.ajax({
            url: "/registrarproducto", // Ruta en Laravel
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (!response.result) {
                    console.log('Estructura de respuesta inválida');
                    // throw new Error();
                }

                Livewire.dispatch("listarproductoDesdeJS");

                // Mensaje de éxito (opcional)
                Swal.fire({
                    icon: 'success',
                    title: 'Producto registrado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Limpiar el formulario (opcional)
                $("#idformproducto")[0].reset();
            },
            error: function(error) {
                // alert("Error: " + xhr.responseJSON.message);
            }
        });
    });
});
