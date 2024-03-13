<?php

namespace App\Http\Livewire\Cards;

use App\Models\Card;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $params = [
        'search' => '',
        'status' => '',
    ];

    public function updatingParams()
    {
        $this->resetPage();
    }

    public function render()
    {
        $params = $this->params;

        $query = Card::query();

        #filtros
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('code', 'LIKE', '%' . $params['search'] . '%');
                $q->orWhere('name', 'LIKE', '%' . $params['search'] . '%');
            });
        }
        if ($params['status'] !== '') {
            $query->where('status', $params['status']);
        }

        $items = $query->paginate(10);

        return view('livewire.cards.index', compact('items'));
    }

    /**
     * Eliminar registro
     *
     * @param int $id Id. del registro a a eliminar
     */
    public function destroy($id)
    {
        #Eliminar
        $model = Card::find($id);
        $model->delete();

        #Alert
        $this->dispatchBrowserEvent('toast', [
            'type'    => 'success',
            'message' => 'Producto eliminado.',
        ]);
    }
}
