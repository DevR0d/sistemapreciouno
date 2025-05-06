<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th class="text-center align-middle">#</th>
            <th class="text-center align-middle">Nombre</th>
            <th class="text-center align-middle">SKU</th>
            <th class="text-center align-middle">Estado</th>
            <th class="text-center align-middle">Fecha de registro</th>
            <th class="text-center align-middle">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $productos)
            <tr>
                <td class="text-center align-middle"><strong>{{ $productos['idproducto'] }}</strong></td>
                <td class="text-center align-middle"><strong>{{ $productos['nombre'] }}</strong></td>
                <td class="text-center align-middle"><strong>{{ $productos['sku'] }}</strong></td>
                <td class="text-center align-middle"><strong>{{ $productos['estado'] }}</strong></td>
                <td class="text-center align-middle"><strong>{{ $productos['fecharegistro'] }}</strong></td>
                <td class="text-center align-middle">
                    <button wire:click="edit({{ $productos['idproducto'] }})" class="btn btn-warning btn-sm">Editar</button>
                    <button wire:click="delete({{ $productos['idproducto'] }})" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    No hay productos registrados.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
