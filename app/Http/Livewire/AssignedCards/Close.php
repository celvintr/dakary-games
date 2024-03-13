<?php

namespace App\Http\Livewire\AssignedCards;

use App\Models\AssignedCard;
use App\Models\AssignedCardDetail;
use Livewire\Component;

class Close extends Component
{
    public $assigned = [];
    public $items    = [];
    public $modal    = [
        'code'       => '',
        'file'       => '',
        'comments'   => '',
        'updated_at' => '',
    ];

    public function mount($id)
    {
        #Data
        $assigned = AssignedCard::find($id);
        $this->assigned = $assigned->toArray();
        $this->assigned['date_from_formatted']      = $assigned->date_from_formatted;
        $this->assigned['date_to_formatted']        = $assigned->date_to_formatted;
        $this->assigned['dealer']                   = $assigned->dealer->toArray();
        $this->assigned['dealer']['google_map_url'] = $assigned->dealer->google_map_url;
        $this->assigned['dealer']['whatsapp_url']   = $assigned->dealer->whatsapp_url;
        $this->assigned['details']                  = $assigned->details->toArray();
        #
        $items = [];
        foreach($assigned->details as $detail) {
            $items[$detail->card_id]['card_id']   = $detail->card_id;
            $items[$detail->card_id]['name']      = $detail->card->name;
            $items[$detail->card_id]['price']     = $detail->card->price;
            $items[$detail->card_id]['comission'] = $detail->card->comission;
            if (empty($items[$detail->card_id]['qty'])) $items[$detail->card_id]['qty'] = 1;
            else ++$items[$detail->card_id]['qty'];
        }
        $this->items = array_values($items);
        #
        $total_changed = 0;
        $total_comission = 0;
        $total_qty = 0;
        $details = collect($this->assigned['details']);
        foreach ($this->items as $key => $item) {
            $cards = $details->where('assigned_card_id', $id)
                ->where('card_id', $item['card_id'])
                ->all();

            $changed = $details->where('assigned_card_id', $id)
                ->where('card_id', $item['card_id'])
                ->where('status', 'changed')
                ->count();

            $this->items[$key]['cards']   = $cards;
            $this->items[$key]['changed'] = $changed;
            $this->items[$key]['amount_changed'] = $changed * $this->items[$key]['price'];
            $this->items[$key]['amount_comission'] = $changed * $this->items[$key]['comission'];

            $total_changed += $this->items[$key]['amount_changed'];
            $total_comission += $this->items[$key]['amount_comission'];
            $total_qty += $changed;
        }
        $this->assigned['total_qty'] = $total_qty;
        $this->assigned['total_changed'] = $total_changed;
        $this->assigned['total_comission'] = $total_comission;
    }

    public function render()
    {
        return view('livewire.assigned-cards.close');
    }

    public function close()
    {
        #Actualizar
        $assigned_card = AssignedCard::find($this->assigned['id']);
        $assigned_card->status = 'closed';
        $assigned_card->save();

        #Alert
        $this->dispatchBrowserEvent('cards_closed', [
            'message' => 'Contrato cerrado exitosamente.',
            'route'   => route('assigned-cards.index'),
            'pdf'     => route('assigned-cards.pdf-closed', $this->assigned['id']),
        ]);
    }
}
