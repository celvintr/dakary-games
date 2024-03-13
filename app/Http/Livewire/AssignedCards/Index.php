<?php

namespace App\Http\Livewire\AssignedCards;

use App\Models\AssignedCard;
use App\Models\AssignedCardDetail;
use Illuminate\Database\Eloquent\Builder;
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

        $query = AssignedCard::query();

        #filtros
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('comments', 'LIKE', '%' . $params['search'] . '%');

                $q->orWhereHas('dealer', function (Builder $q2) use ($params) {
                    $q2->where('code', 'LIKE', '%' . $params['search'] . '%');
                    $q2->orWhere('name', 'LIKE', '%' . $params['search'] . '%');
                    $q2->orWhere('phone', 'LIKE', '%' . $params['search'] . '%');
                });
            });
        }
        if ($params['status'] !== '') {
            $query->where('status', $params['status']);
        }

        $items = $query->orderBy('code', 'DESC')->paginate(10);

        return view('livewire.assigned-cards.index', compact('items'));
    }

    /**
     * Eliminar registro
     *
     * @param int $id Id. del registro a a eliminar
     */
    public function destroy($id)
    {
        #Eliminar
        $model_detail = AssignedCardDetail::find($id);
        $model_detail->delete();

        #Eliminar
        $model = AssignedCard::find($id);
        $model->delete();

        #Alert
        $this->dispatchBrowserEvent('toast', [
            'type'    => 'success',
            'message' => 'Contrato eliminado.',
        ]);
    }
}
