import $ from 'jquery';
import Swal from "sweetalert2";

const fechaActual = new Date();
const fechaLocal = fechaActual.getFullYear() + "-" +
    ("0" + (fechaActual.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fechaActual.getDate()).slice(-2);
const horaLocal = ("0" + fechaActual.getHours()).slice(-2) + ":" +
    ("0" + fechaActual.getMinutes()).slice(-2) + ":" +
    ("0" + fechaActual.getSeconds()).slice(-2);

let productos = [];
let contadorId = 0;

if (typeof $ === 'undefined') {
    throw new Error('jQuery no está cargado. Verifica tus imports.');
}

$(document).ready(function () {
    $('#idformaddguiasremision').on('keypress', function (e) {
        if (e.which === 13 && !$(e.target).is('textarea, [type="submit"]')) {
            e.preventDefault();
        }
    });

    // Validación de campos al escribir
    $('#idformaddguiasremision').on('input change', 'input, select', function () {
        const $campo = $(this);
        const valor = $campo.val()?.trim();

        if (valor) {
            $campo.removeClass('is-invalid').addClass('is-valid');
        } else {
            $campo.removeClass('is-valid').addClass('is-invalid');
        }
    });

    // Auto completar campos al seleccionar producto por nombre
    $('#idselectnombreproducto').on('change', function () {
        const selected = $(this).find('option:selected');
        const codigo = selected.data('codigo') || '';
        const idproducto = selected.val();
        const nombre = selected.text();

        $('#idtxtcodigoproducto').val(codigo);
        $('#idproductocarritogiaremision').val(idproducto);
        $('#idtxtnombreproducto').val(nombre); // <-- ESTA LÍNEA ES CLAVE
    });

    $('#idbtnagregarproducto').click(agregarProductoAlCarrito);

    $('#tablaProductos').on('click', '.btn-eliminar', function (e) {
        eliminarProducto($(this).closest('tr').data('id'));
    });

    $("#idformaddguiasremision").submit(async function (e) {
        e.preventDefault();

        if (!validarFormulario()) return;

        const datos = {
            idguia: $("#idguia").val(),
            codigoguia: $("#idtxtcodigoguia").val(),
            fechaemision: fechaLocal,
            horaemision: horaLocal,
            razonsocialguia: $("#idtxtrazonsocialguia").val(),
            numerotrasladotim: $("#idtxtnumerotrasladotim").val(),
            motivotraslado: $("#idselcetmotivotraslado").val(),
            pesobrutototal: $("#idtxtpesobrutototal").val(),
            volumenproducto: $("#idtxtvolumenproducto").val(),
            numerobultopallet: $("#idselectnumerobultopallet").val(),
            observaciones: $("#idtxtobservaciones").val(),
            idconductor: $("#idselectidconductor").val(),
            idtipoempresa: $("#idselectidtipoempresa").val(),
            idtransportista: $("#idselectrasnporte").val(),
            productos: productos,
            _token: $('input[name="_token"]').val()
        };

        const confirm = await Swal.fire({
            title: "¿Estás seguro de registrar esta guía?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "Cancelar"
        });

        if (!confirm.isConfirmed) return;

        $.ajax({
            url: "/registrarguiaremision",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                window.location.replace('/guiasremision');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON.message || 'Ocurrió un error al guardar'
                });
            }
        });
    });

    //Listener para el cambio del selector de empresa y haga la petición para traer conductores filtrados
    $('#idselecttransportista').on('change', function () {
        const idtransportista = $(this).val();
        if (!idtransportista) {
            $('#idselectidconductor').html('<option value="">Seleccionar...</option>');
            return;
        }

        $.ajax({
            url: '/conductores-por-empresa/' + idtransportista,
            type: 'GET',
            success: function (data) {
                let opciones = '<option value="">Seleccionar...</option>';
                if (data.length > 0) {
                    data.forEach(function (conductor) {
                        opciones += `<option value="${conductor.idconductor}">${conductor.nombre}</option>`;
                    });
                } else {
                    opciones += '<option value="" disabled>No hay conductores disponibles</option>';
                }
                $('#idselectidconductor').html(opciones);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la lista de conductores'
                });
            }
        });
    });
    // Botón Eliminar guía desde tabla
    $(document).on('click', '.btn-eliminarguia', async function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!csrfToken || !id) {
            console.log('ID o token CSRF faltante');
            return;
        }

        const pregunta = await window.SweetAlertpreguntarSI_NO("¿Estás seguro de eliminar?");

        if (!pregunta) return;

        try {
            const response = await $.ajax({
                url: "/estadoguia/{id}",
                type: "POST",
                data: {
                    idguia: id,
                    _token: csrfToken
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                dataType: 'json'
            });

            if (response.success) {
                Livewire.dispatch("listarGuiasRemisionDesdeJS");
                Swal.fire({
                    icon: 'success',
                    title: response.message,
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

    // Botón Editar guía desde tabla
    $(document).on('click', '.btn-editarguia', function(e) {
        e.preventDefault();

        const idguia = $(this).data('id');
        const codigo = $(this).data('codigo');

        if (!idguia) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo obtener el ID de la guía'
            });
            return;
        }

        // Redirigir a la página de edición con el ID de la guía
        window.location.href = `/crearguiaremision?idguia=${idguia}`;
    });
});

function agregarProductoAlCarrito() {
    const idproducto = $('#idproductocarritogiaremision').val().trim();
    const codigo = $('#idtxtcodigoproducto').val().trim();
    const nombre = $('#idselectnombreproducto option:selected').text().trim();
    const cantidad = parseInt($('#idtxtcantidadproducto').val());
    const estado = $('#idselectestadoproducto').val();

    if (!idproducto || !codigo || !nombre) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Debe seleccionar un producto válido con nombre y código .',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    if (isNaN(cantidad) || cantidad <= 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Cantidad inválida',
            text: 'La cantidad debe ser un número mayor a 0',
            confirmButtonText: 'Corregir'
        });
        $('#idtxtcantidadproducto').focus();
        return;
    }

    const productoExistente = productos.find(p =>
        p.idproducto === idproducto && p.estado === estado
    );

    if (productoExistente) {
        Swal.fire({
            icon: 'info',
            title: 'Producto duplicado',
            text: 'Este producto con el mismo estado ya fue agregado.',
        });
        return;
    }

    productos.push({
        id: contadorId++,
        idproducto,
        codigo,
        nombre,
        cantidad,
        estado
    });

    actualizarTablaProductos();

    $('#idselectnombreproducto').val('');
    $('#idtxtcodigoproducto').val('').focus();
    $('#idtxtcantidadproducto').val('');
    $('#idproductocarritogiaremision').val('');
    $('#idselectestadoproducto').val('Bueno');
}
//Eliminar producto de la tabla
function actualizarTablaProductos() {
    const tbody = $('#tablaProductos tbody').empty();

    productos.forEach(producto => {
        tbody.append(`
            <tr data-id="${producto.id}">
                <td>${producto.codigo}</td>
                <td>${producto.nombre}</td>
                <td>${producto.cantidad}</td>
                <td>${producto.estado}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger btn-eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
    });
}

function eliminarProducto(id) {
    productos = productos.filter(p => p.id !== id);
    actualizarTablaProductos();
}

function limpiarValidaciones() {
    $('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
}

(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Obtener todos los formularios a validar
        var forms = document.getElementsByClassName('needs-validation');
        // Validación al enviar
        Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function validarFormulario() {
    let valido = true;
    let camposIncompletos = false;

    // Validar campos requeridos
    const camposRequeridos = [
        '#idtxtcodigoguia',
        '#idtxtnumerotrasladotim',
        '#idtxtrazonsocialguia',
        '#idselcetmotivotraslado',
        '#idtxtpesobrutototal',
        '#idtxtvolumenproducto',
        '#idselectnumerobultopallet',
        '#idselectidtipoempresa',
        '#idselectidconductor',
    ];

    // $(camposRequeridos.join(',')).removeClass('is-invalid');

    camposRequeridos.forEach(selector => {
        const $campo = $(selector);
        const valor = $campo.val()?.trim();

        if (!valor) {
            $campo.addClass('is-invalid').removeClass('is-valid');
            if (valido) $campo.focus();
            valido = false;
            camposIncompletos = true;
        } else {
            $campo.removeClass('is-invalid').addClass('is-valid');
        }
    });

    if (camposIncompletos) {
        Swal.fire({
            icon: 'error',
            title: 'Campos requeridos',
            text: 'Complete todos los campos requeridos',
            confirmButtonText: 'Entendido'
        });
        return false;
    }

    if (productos.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Productos requeridos',
            text: 'Agregue al menos un producto',
            confirmButtonText: 'Entendido'
        });
        return false;
    }

    return true;

}
