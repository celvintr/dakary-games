<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Form extends Component
{
    public $data = [
        'id'       => '',
        'name'     => '',
        'email'    => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public $form = [
        'title'  => 'Nuevo registro',
        'label'  => 'Guardar',
        'action' => 'store',
        'newPassword' => true,
    ];

    public function mount($id = null)
    {
        if ($id) {
            #Data
            $data = User::find($id);
            $this->data = $data->toArray();

            #Info
            $this->form = [
                'title'  => 'Actualizar registro',
                'label'  => 'Actualizar',
                'action' => 'update',
                'newPassword' => false,
            ];
        }
    }

    public function render()
    {
        return view('livewire.users.form');
    }

    /**
     * Crear registro
     */
    public function store()
    {
        #Validar
        $this->validate([
            'data.name'     => 'required',
            'data.email'    => 'required|unique:users,email',
            'data.password' => 'required|confirmed',
        ], [], [
            'data.name'     => 'nombre',
            'data.email'    => 'email',
            'data.password' => 'contraseña',
        ]);

        #Crear
        $model = new User();
        $model->name     = $this->data['name'];
        $model->email    = $this->data['email'];
        $model->password = Hash::make($this->data['password']);
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Registro creado exitosamente',
            'route'   => route('users.index'),
        ]);
    }

    /**
     * Actualizar registro
     */
    public function update()
    {
        #Validar
        $this->validate([
            'data.name'     => 'required',
            'data.password' => 'required|confirmed',
        ], [], [
            'data.name'     => 'nombre',
            'data.password' => 'contraseña',
        ]);

        #Actualizar
        $model = User::find($this->data['id']);
        $model->name = $this->data['name'];
        if ($this->form['newPassword']) {
            $model->password = Hash::make($this->data['password']);
        }
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Registro actualizado exitosamente',
            'route'   => route('users.index'),
        ]);
    }
}
