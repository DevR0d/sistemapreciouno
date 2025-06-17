<?php

namespace App\Livewire\Usuarios;

use App\Models\User;  // Usaremos el modelo de usuarios de Laravel
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestionusuario extends Component
{
    use WithPagination;

    public $search = '';        // Filtro de búsqueda
    public $perPage = 10;       // Número de registros por página
    public $sortField = 'id';   // Campo por el cual se ordena
    public $sortDirection = 'asc'; // Dirección del orden (asc/desc)

    protected $paginationTheme = 'bootstrap'; // Usar el tema de Bootstrap para la paginación

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
    ];

    // Método para actualizar la lista cuando se cambia el filtro
    #[On('listarusuariosDesdeJS')]
    public function refreshList()
    {
        $this->resetPage(); // Resetear la paginación
    }

    // Método para limpiar el filtro de búsqueda
    public function updatingSearch()
    {
        $this->resetPage(); // Resetear la paginación cuando cambia la búsqueda
    }

    // Método para actualizar la cantidad de elementos por página
    public function updatingPerPage()
    {
        $this->resetPage(); // Resetear la paginación cuando cambia la cantidad de registros por página
    }

    // Método para ordenar por una columna
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    // Metodo para obtener usuarios con filtrado y paginación
    public function render()
    {
        $usuarios = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Contadores
        $totalUsuarios = User::count();
        $totalAdmins = User::where('idrol', 1)->count();
        $totalPrevencionistas = User::where('idrol', 2)->count();

        return view('livewire.usuarios.gestionusuario', [
            'data' => $usuarios,   // Paginación de usuarios
            'totalUsuarios' => $totalUsuarios,
            'totalAdmins' => $totalAdmins,
            'totalPrevencionistas' => $totalPrevencionistas,
        ]);
    }
}
