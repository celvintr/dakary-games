<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $params = [
        'search' => '',
    ];

    public function updatingParams()
    {
        $this->resetPage();
    }

    public function render()
    {
        $params = $this->params;

        $query = User::query();

        #filtros
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('name', 'LIKE', '%' . $params['search'] . '%');
                $q->orWhere('email', 'LIKE', '%' . $params['search'] . '%');
            });
        }

        $items = $query->paginate(10);

        return view('livewire.users.index', compact('items'));
    }

    /**
     * Eliminar registro
     *
     * @param int $id Id. del registro a a eliminar
     */
    public function destroy($id)
    {
        #Eliminar
        $model = User::find($id);
        $model->delete();

        #Alert
        $this->dispatchBrowserEvent('toast', [
            'type'    => 'success',
            'message' => 'Registro eliminado.',
        ]);
    }
}
