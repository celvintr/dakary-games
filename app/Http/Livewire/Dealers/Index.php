<?php

namespace App\Http\Livewire\Dealers;

use App\Models\Dealer;
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

        $query = Dealer::query();

        #filtros
        if (!empty($params['search'])) {
            $query->where(function($q) use ($params) {
                $q->where('code', 'LIKE', '%' . $params['search'] . '%');
                $q->orWhere('name', 'LIKE', '%' . $params['search'] . '%');
                $q->orWhere('phone', 'LIKE', '%' . $params['search'] . '%');
                $q->orWhere('address', 'LIKE', '%' . $params['search'] . '%');
            });
        }
        if ($params['status'] !== '') {
            $query->where('status', $params['status']);
        }

        $items = $query->paginate(10);

        return view('livewire.dealers.index', compact('items'));
    }
}
