@extends('intranet/layout')
@section('title', 'Agregar Guía de Remisión')

@section('content')
    <div class="container-fluid py-2" style="overflow-y: auto; max-height: 90vh;">
        <h5 class="modal-title mb-2 fw-bold text-primary" id="idmodalguiasremision">
            <i class="fas fa-file-import me-1"></i>Agregar Guía de Remisión
        </h5>
        <form id="idformaddguiasremision" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" id="idguia" name="idguia" value="">

            <div class="row g-3">
                <!-- Columna 1: Datos Principales -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-primary">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0 fw-semibold"><i class="fas fa-file-alt me-2"></i>Datos Principales</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <label for="idtxtcodigoguia" class="form-label small fw-bold">N° Guía</label>
                                <input type="text" class="form-control form-control-sm" id="idtxtcodigoguia"
                                    name="codigoguia" required>
                                <div class="invalid-feedback">Ingrese el numero de la guia </div>
                            </div>
                            <div class="mb-3">
                                <label for="idtxtnumerotrasladotim" class="form-label small fw-bold">N° TIM</label>
                                <input type="text" class="form-control form-control-sm" id="idtxtnumerotrasladotim"
                                    name="numerotrasladotim" required>
                                <div class="invalid-feedback">Ingrese el número de TIM</div>
                            </div>
                            <div class="mb-0">
                                <label for="idtxtrazonsocialguia" class="form-label small fw-bold">Razón Social</label>
                                <input type="text" class="form-control form-control-sm" id="idtxtrazonsocialguia"
                                    name="razonsocialguia" required>
                                <div class="invalid-feedback">Ingrese la razón social</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Columna 2: Detalles del Traslado -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-success">
                        <div class="card-header bg-success text-white py-2">
                            <h6 class="mb-0 fw-semibold"><i class="fas fa-truck me-2"></i>Detalles del Traslado</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <label for="idselcetmotivotraslado" class="form-label small fw-bold">Motivo</label>
                                <select class="form-select form-select-sm" id="idselcetmotivotraslado" name="motivotraslado"
                                    required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Venta">Venta</option>
                                    <option value="Traslado entre almacenes">Traslado entre almacenes</option>
                                    <option value="Exportación">Exportación</option>
                                    <option value="Importación">Importación</option>
                                </select>
                                <div class="invalid-feedback">Seleccione un motivo de traslado</div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label for="idtxtpesobrutototal" class="form-label small fw-bold">Peso (kg)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm"
                                        id="idtxtpesobrutototal" name="pesobrutototal" required>
                                    <div class="invalid-feedback">Ingrese el peso bruto total</div>
                                </div>
                                <div class="col-6">
                                    <label for="idtxtvolumenproducto" class="form-label small fw-bold">Volumen (m³)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm"
                                        id="idtxtvolumenproducto" name="volumenproducto" required>
                                    <div class="invalid-feedback">Ingrese el volumen total</div>
                                </div>
                            </div>
                            <div>
                                <label for="idselectnumerobultopallet" class="form-label small fw-bold">N°
                                    Bultos/Pallets</label>
                                <input type="number" class="form-control form-control-sm" id="idselectnumerobultopallet"
                                    name="numerobultopallet" required>
                                <div class="invalid-feedback">Ingrese el número de bultos o pallets</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna 3: Personal -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-info">
                        <div class="card-header bg-info text-white py-2">
                            <h6 class="mb-0 fw-semibold"><i class="fas fa-users me-2"></i>Datos del conductor</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <label for="idselecttransportista" class="form-label small fw-bold">Transportista</label>
                                <select class="form-select form-select-sm" id="idselecttransportista" name="idtransportista"
                                    required>
                                    <option value="">Seleccionar...</option>
                                    @forelse($transportes as $transporte)
                                        <option value="{{ $transporte->idtransportista }}">
                                            {{ $transporte->nombre_razonsocial }}</option>
                                    @empty
                                        <option value="" disabled>No hay conductores</option>
                                    @endforelse
                                </select>
                                <div class="invalid-feedback">Seleccione un conductor</div>
                            </div>
                            <div class="mb-3">
                                <label for="idselectidconductor" class="form-label small fw-bold">Conductor</label>
                                {{--                                <select class="form-select form-select-sm" id="idselectidconductor" name="idconductor" required> --}}
                                {{--                                    <option value="">Seleccionar...</option> --}}
                                {{--                                    @forelse($conductores as $conductor) --}}
                                {{--                                        <option value="{{ $conductor->idconductor }}">{{ $conductor->nombre }}</option> --}}
                                {{--                                    @empty --}}
                                {{--                                        <option value="" disabled>No hay conductores</option> --}}
                                {{--                                    @endforelse --}}
                                {{--                                </select> --}}
                                <select class="form-select form-select-sm" id="idselectidconductor" name="idconductor"
                                    required>
                                    <option value="">Seleccionar...</option>
                                    {{-- Opcional: cargar todos o dejar vacío --}}
                                    {{-- @foreach ($conductores as $conductor)
                                        <option value="{{ $conductor->idconductor }}">{{ $conductor->nombre }}</option>
                                    @endforeach --}}
                                </select>

                            </div>
                            <div>
                                <label for="idtxtobservaciones" class="form-label small fw-bold">Observaciones</label>
                                <input type="text" class="form-control form-control-sm" id="idtxtobservaciones"
                                    name="observaciones">
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Segunda fila: Empresa receptora (ahora ocupa toda la fila) -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm border-warning">
                                <div class="card-header bg-warning text-dark py-2">
                                    <h6 class="mb-0 fw-semibold"><i class="fas fa-building me-2"></i>Empresa Receptora</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="idselectidtipoempresa" class="form-label small fw-bold">Empresa que recibirá</label>
                                            <select class="form-select form-select-sm" id="idselectidtipoempresa" name="idtipoempresa" required>
                                                <option value="">Seleccionar...</option>
                                                @foreach($tipoempresa as $empresa)
                                                    <option value="{{ $empresa->idtipoempresa }}">{{ $empresa->razonsocial }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Seleccione una empresa receptora</div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label for="idtxtdireccionempresa" class="form-label small fw-bold">Dirección</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtdireccionempresa" name="direccionempresa" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label for="idtxtprovinciaempresa" class="form-label small fw-bold">Provincia</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtprovinciaempresa" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label for="idtxtdepartamentoempresa" class="form-label small fw-bold">Departamento</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtdepartamentoempresa" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label for="idtxtrucempresa" class="form-label small fw-bold">RUC</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtrucempresa" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mt-3">
                                        <div class="col-md-3">
                                            <label for="idtxtubigeoempresa" class="form-label small fw-bold">Ubigeo</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtubigeoempresa" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label for="idtxtcodigoestablecimiento" class="form-label small fw-bold">Código Establecimiento</label>
                                            <input type="text" class="form-control form-control-sm" id="idtxtcodigoestablecimiento" readonly>
                                            <div class="invalid-feedback">Seleccione la empresa y se autocompletara este campo</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>

            <!-- Sección de Productos -->
            <br>
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary bg-opacity-10 py-2 border-0">
                    <h6 class="mb-0 text-secondary fw-bold"><i class="fas fa-boxes me-2"></i>Agrega los Productos al
                        Carrito</h6>
                </div>

                <div class="card-body p-3">
                    <!-- Formulario para agregar productos -->
                    <!-- Agregar Producto por Nombre -->
                    <div class="row g-2 mb-3 align-items-end">
                        <!-- Nombre del Producto (select) -->
                        <div class="col-md-4">
                            <label for="idselectnombreproducto" class="form-label small fw-bold">Nombre del
                                Producto</label>
                            <select class="form-select form-select-sm" id="idselectnombreproducto" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->idproducto }}"
                                        data-codigo="{{ $producto->codigoproducto }}">
                                        {{ $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Código del Producto (autocompletado) -->
                        <div class="col-md-3">
                            <label for="idtxtcodigoproducto" class="form-label small fw-bold">Código</label>
                            <input type="text" class="form-control form-control-sm" id="idtxtcodigoproducto" placeholder=" Seleccione un producto y vera el codigo aqui " readonly>
                            <input type="hidden" id="idproductocarritogiaremision">
                        </div>

                        <!-- Cantidad -->
                        <div class="col-md-2">
                            <label for="idtxtcantidadproducto" class="form-label small fw-bold">Cantidad</label>
                            <input type="number" class="form-control form-control-sm" id="idtxtcantidadproducto"
                                required>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-2">
                            <label for="idselectestadoproducto" class="form-label small fw-bold">Estado</label>
                            <select class="form-select form-select-sm" id="idselectestadoproducto" required>
                                <option value="Bueno">Bueno</option>
                                {{--  <option value="Regular">Regular</option>  --}}
                                {{--  <option value="Dañado">Dañado</option>  --}}
                            </select>
                        </div>

                        <!-- Botón Agregar -->
                        <div class="col-md-1">
                            <button type="button" class="btn btn-primary btn-sm h-100" id="idbtnagregarproducto"
                                title="Agregar producto">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tabla de productos agregados -->
                    <div class="border rounded overflow-y-auto" style="max-height:500px ;overflow-y: auto; border: 1px solid red;">
                        <table class="table table-sm table-bordered table-hover " id="tablaProductos">
                            <thead class="table-light">
                                <tr>
                                    <th width="15%">Código</th>
                                    <th width="40%">Producto</th>
                                    <th width="15%">Cantidad</th>
                                    <th width="20%">Estado</th>
                                    <th width="10%">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los productos se agregarán aquí dinámicamente -->
                                {{--  @for ($i = 0; $i < 20; $i++)
                                    <tr>
                                        <td>123456</td>
                                        <td>Producto largo con nombre</td>
                                        <td>10</td>
                                        <td>Bueno</td>
                                        <td><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endfor  --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('vistaguiasderemision') }}" class="btn btn-outline-danger btn-sm px-3">
                    <i class="fas fa-times-circle me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success btn-sm px-3">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('idselectidtipoempresa').addEventListener('change', function() {
        const empresaId = this.value;

        if (!empresaId) {
            limpiarCamposEmpresa();
            return;
        }

        fetch(`/empresa/${empresaId}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('idtxtdireccionempresa').value = data.direccion || '';
                    document.getElementById('idtxtprovinciaempresa').value = data.provincia || '';
                    document.getElementById('idtxtdepartamentoempresa').value = data.departamento || '';
                    document.getElementById('idtxtrucempresa').value = data.ruc || '';
                    document.getElementById('idtxtubigeoempresa').value = data.ubigeo || '';
                    document.getElementById('idtxtcodigoestablecimiento').value = data.codigoestablecimiento || '';
                } else {
                    limpiarCamposEmpresa();
                }
            })
            .catch(err => {
                console.error('Error al obtener datos de la empresa:', err);
                limpiarCamposEmpresa();
            });
    });

    function limpiarCamposEmpresa() {
        document.getElementById('idtxtdireccionempresa').value = '';
        document.getElementById('idtxtprovinciaempresa').value = '';
        document.getElementById('idtxtdepartamentoempresa').value = '';
        document.getElementById('idtxtrucempresa').value = '';
        document.getElementById('idtxtubigeoempresa').value = '';
        document.getElementById('idtxtcodigoestablecimiento').value = '';
    }
});

</script>
@endpush