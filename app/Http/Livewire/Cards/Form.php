<?php

namespace App\Http\Livewire\Cards;

use App\Classes\Helpers;
use App\Models\Card;
use Livewire\Component;

class Form extends Component
{
    public $data = [
        'id'        => '',
        'name'      => '',
        'price'     => 0,
        'diamonds'  => 0,
        'bonus'     => 0,
        'comission' => 0,
        'status'    => '',
        'price_formatted'     => '',
        'comission_formatted' => '',
    ];

    public $form = [
        'title'   => 'Nuevo producto',
        'label'   => 'Guardar',
        'action'  => 'store',
    ];

    public function mount($id = null)
    {
        if ($id) {
            #Data
            $data = Card::find($id);
            $this->data = $data->toArray();
            $this->data['price']     = $data->price_formatted;
            $this->data['comission'] = $data->comission_formatted;

            #Info
            $this->form = [
                'title'  => 'Actualizar producto',
                'label'  => 'Actualizar',
                'action' => 'update',
            ];
        }
    }

    public function render()
    {
        return view('livewire.cards.form');
    }

    /**
     * Crear registro
     */
    public function store()
    {
        #Validar
        $this->validate([
            'data.name'      => 'required',
            'data.price'     => 'required',
            'data.comission' => 'required',
        ], [], [
            'data.name'      => 'nombre',
            'data.price'     => 'precio',
            'data.comission' => 'comisión',
        ]);

        #Crear
        $model = new Card();
        $model->name      = $this->data['name'];
        $model->price     = Helpers::formatDecimal($this->data['price']);
        $model->comission = Helpers::formatDecimal($this->data['comission']);
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Producto creado exitosamente',
            'route'   => route('cards.index'),
        ]);
    }

    /**
     * Actualizar registro
     */
    public function update()
    {
        #Validar
        $this->validate([
            'data.name'      => 'required',
            'data.price'     => 'required',
            'data.comission' => 'required',
        ], [], [
            'data.name'      => 'nombre',
            'data.price'     => 'precio',
            'data.comission' => 'comisión',
        ]);

        #Actualizar
        $model = Card::find($this->data['id']);
        $model->name      = $this->data['name'];
        $model->price     = Helpers::formatDecimal($this->data['price']);
        $model->comission = Helpers::formatDecimal($this->data['comission']);
        $model->status    = $this->data['status'];
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Producto actualizado exitosamente',
            'route'   => route('cards.index'),
        ]);
    }
}
