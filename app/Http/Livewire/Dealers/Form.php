<?php

namespace App\Http\Livewire\Dealers;

use App\Models\Dealer;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $data = [
        'id'             => '',
        'code'           => '',
        'document'       => '',
        'name'           => '',
        'phone'          => '',
        'company'        => '',
        'address'        => '',
        'maps'           => '',
        'status'         => '',
        'document_image' => '',
        'business_image' => '',
        'document_image_url' => '',
        'business_image_url' => '',
    ];

    public $form = [
        'title'   => 'Nuevo cliente',
        'label'   => 'Guardar',
        'action'  => 'store',
        'errAddr' => null,
    ];

    public function mount($id = null)
    {
        if ($id) {
            #Data
            $data = Dealer::find($id);
            $this->data = $data->toArray();
            $this->data['document_image'] = null;
            $this->data['business_image'] = null;
            $this->data['document_image_url'] = $data->document_image_url;
            $this->data['business_image_url'] = $data->business_image_url;

            #Info
            $this->form = [
                'title'   => 'Actualizar cliente',
                'label'   => 'Actualizar',
                'action'  => 'update',
                'errAddr' => null,
            ];
        }
    }

    public function render()
    {
        return view('livewire.dealers.form');
    }

    /**
     * Crear registro
     */
    public function store()
    {
        #Validar
        $this->validate([
            'data.document'       => 'required|unique:dealers,document',
            'data.name'           => 'required',
            'data.phone'          => 'required',
            'data.company'        => 'required',
            'data.address'        => 'required',
            'data.maps'           => 'required',
            'data.document_image' => 'image|max:5120',
            'data.business_image' => 'image|max:5120',
        ], [
            'data.maps.required'  => 'Debe seleccionar una dirección válida en el mapa',
        ], [
            'data.document'       => 'nro. de documento',
            'data.name'           => 'nombre',
            'data.phone'          => 'teléfono',
            'data.company'        => 'nombre del negocio',
            'data.address'        => 'dirección',
            'data.maps'           => 'mapa',
            'data.document_image' => 'imagen del documento',
            'data.business_image' => 'imagen del negocio',
        ]);

        #Crear
        $model = new Dealer();
        $model->document = $this->data['document'];
        $model->name     = $this->data['name'];
        $model->phone    = $this->data['phone'];
        $model->company  = $this->data['company'];
        $model->address  = $this->data['address'];
        $model->maps     = $this->data['maps'];
        if (!empty($this->data['document_image'])) {
            $model->document_image = $this->data['document_image']->store('photos', 'public');
        }
        if (!empty($this->data['business_image'])) {
            $model->business_image = $this->data['business_image']->store('photos', 'public');
        }
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Cliente creado exitosamente',
            'route'   => route('dealers.index'),
        ]);
    }

    /**
     * Actualizar registro
     */
    public function update()
    {
        #Validar
        $this->validate([
            'data.document'       => 'required|unique:dealers,document,'.$this->data['id'],
            'data.name'           => 'required',
            'data.phone'          => 'required',
            'data.company'        => 'required',
            'data.address'        => 'required',
            'data.document_image' => ($this->data['document_image'] ? 'image|max:5120' : ''),
            'data.business_image' => ($this->data['business_image'] ? 'image|max:5120' : ''),
        ], [], [
            'data.document'       => 'nro. de documento',
            'data.name'           => 'nombre',
            'data.phone'          => 'teléfono',
            'data.company'        => 'nombre del negocio',
            'data.address'        => 'dirección',
            'data.document_image' => 'imagen del documento',
            'data.business_image' => 'imagen del negocio',
        ]);

        #Actualizar
        $model = Dealer::find($this->data['id']);
        $model->document = $this->data['document'];
        $model->name     = $this->data['name'];
        $model->phone    = $this->data['phone'];
        $model->company  = $this->data['company'];
        $model->address  = $this->data['address'];
        $model->maps     = $this->data['maps'];
        if (!empty($this->data['document_image'])) {
            $model->document_image = $this->data['document_image']->store('photos', 'public');
        }
        if (!empty($this->data['business_image'])) {
            $model->business_image = $this->data['business_image']->store('photos', 'public');
        }
        $model->status = $this->data['status'];
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Cliente actualizado exitosamente',
            'route'   => route('dealers.index'),
        ]);
    }
}
