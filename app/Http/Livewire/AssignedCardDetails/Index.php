<?php

namespace App\Http\Livewire\AssignedCardDetails;

use App\Models\AssignedCardDetail;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $card_code;

    public $assigned_card_detail;

    public $error;

    public function render()
    {
        return view('livewire.assigned-card-details.index');
    }

    public function change()
    {
        #Validar
        $this->validate([
            'assigned_card_detail.file' => 'image|max:5120',
        ], [], [
            'assigned_card_detail.file' => 'soporte',
        ]);

        #Actualizar
        $model = AssignedCardDetail::find($this->assigned_card_detail['id']);
        $model->file     = $this->assigned_card_detail['file']->store('cards', 'public');
        $model->comments = $this->assigned_card_detail['comments'];
        $model->status   = 'changed';
        $model->save();

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Producto activado / canjeado exitosamente',
            'route'   => route('assigned-card-details.index'),
        ]);
    }

    /**
     * Consultar codigo de la tarjeta
     */
    public function search()
    {
        $this->error = "";

        $assigned_card_detail = AssignedCardDetail::where('code', $this->card_code)->first();
        if (!empty($assigned_card_detail->id)) {
            if ($assigned_card_detail->assigned->status == 'closed' && $assigned_card_detail->status == 'pending') {
                $this->error = "Producto pendiente de reasignación.";
            }
            else {
                $card     = $assigned_card_detail->card;
                $assigned = $assigned_card_detail->assigned;

                $this->assigned_card_detail = $assigned_card_detail->toArray();
                $this->assigned_card_detail['file'] = null;
                $this->assigned_card_detail['file_url'] = $assigned_card_detail->file_url;
                $this->assigned_card_detail['updated_at'] = $assigned_card_detail->updated_at->format('d/m/Y h:ia');
                $this->assigned_card_detail['card'] = $card->toArray();
                $this->assigned_card_detail['card']['price_formatted'] = $card->price_formatted;
                $this->assigned_card_detail['assigned'] = $assigned->toArray();
                $this->assigned_card_detail['assigned']['dealer'] = $assigned->dealer->toArray();
            }
        } else {
            $this->error = "Producto no encontrado.";
        }
    }
}
