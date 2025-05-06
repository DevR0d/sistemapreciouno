<div class="container">
    <!-- Formulario de crear/editar -->
    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="mb-4">
        <div class="row">
            <div class="col-md-3 mb-2">
                <input wire:model="name" type="text" class="form-control" placeholder="Nombre">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-2">
                <input wire:model="email" type="email" class="form-control" placeholder="Email">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-2">
                <input wire:model="password" type="password" class="form-control" placeholder="Contraseña">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-3 mb-2">
                <select wire:model="role" class="form-control">
                    <option value="prevencionista">Prevencionista</option>
                    <option value="admin">Administrador</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-success">
                {{ $isEditing ? 'Actualizar Usuario' : 'Crear Usuario' }}
            </button>
            @if($isEditing)
                <button type="button" class="btn btn-secondary" wire:click="resetForm">Cancelar</button>
            @endif
        </div>
    </form>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th class="text-center align-middle">#</th>
                <th class="text-center align-middle">Nombre</th>
                <th class="text-center align-middle">Email</th>
                <th class="text-center align-middle">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td class="text-center align-middle">{{ $usuario->id }}</td>
                    <td class="text-center align-middle">{{ $usuario->name }}</td>
                    <td class="text-center align-middle">{{ $usuario->email }}</td>
                    <td class="text-center align-middle">
                        <button wire:click="edit({{ $usuario->id }})" class="btn btn-warning btn-sm">Editar</button>
                        <button wire:click="delete({{ $usuario->id }})" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                    </td>
                </tr>
            @endforeach

{{--            @forelse($data as $usuarios)--}}
{{--                <tr>--}}
{{--                    <td><strong>{{ $usuarios['id'] }}</strong></td>--}}
{{--                    <td><strong>{{ $usuarios['name'] }}</strong></td>--}}
{{--                    <td><strong>{{ $usuarios['email'] }}</strong></td>--}}
{{--                    <td>--}}
{{--                        <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Editar</a>--}}
{{--                        <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Eliminar</a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @empty--}}
        </tbody>
    </table>
</div>
