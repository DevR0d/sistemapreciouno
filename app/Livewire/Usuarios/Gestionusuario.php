<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gestionusuario extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $totalusuarios;
    public $totaladmins;
    public $totalprevencionistas;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public array $usuarios = [];

    #[On('listarusuariosDesdeJS')]
    public function listar(): void
    {
        $resultado = (new User())->mostrarusuarios(['paginado' => false]);
        $this->usuarios = $resultado['data'] ?? [];
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->totalusuarios = DB::table('users')
            ->whereRaw("LOWER(estado) != 'eliminado'")
            ->count();

        $this->totaladmins = DB::table('users')
            ->whereRaw("LOWER(estado) != 'eliminado'")
            ->where('idrol', 1)
            ->count();

        $this->totalprevencionistas = DB::table('users')
            ->whereRaw("LOWER(estado) != 'eliminado'")
            ->where('idrol', 2)
            ->count();

        $this->listar();
    }

    public function refreshList()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

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

    public function render()
    {
        $usuarios = User::whereRaw("LOWER(estado) != 'eliminado'")
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.usuarios.gestionusuario', [
            'data' => $usuarios,
            'totalUsuarios' => $this->totalusuarios,
            'totalAdmins' => $this->totaladmins,
            'totalPrevencionistas' => $this->totalprevencionistas,
        ]);
    }
}
