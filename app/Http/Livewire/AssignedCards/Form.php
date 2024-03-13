<?php

namespace App\Http\Livewire\AssignedCards;

use App\Classes\Helpers;
use App\Models\AssignedCard;
use App\Models\AssignedCardDetail;
use App\Models\Card;
use App\Models\Dealer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Form extends Component
{
    protected $listeners = ['selectDealer'];

    public $data = [
        'id'        => '',
        'dealer_id' => '',
        'date_from' => '',
        'date_to'   => '',
        'comments'  => '',
        'status'    => '',
        'details'   => [],
    ];

    public $items = [];

    public $form = [
        'title'  => 'Nuevo contrato',
        'label'  => 'Guardar',
        'action' => 'store',
    ];

    public $dealer;

    public $cards;

    public $pending_cards = [], $reassigned_cards = [];

    public function mount($id = null)
    {
        $this->cards = Card::active()->get()->toArray();

        if ($id) {
            #Data
            $data = AssignedCard::findOrFail($id);
            if ($data->status == 'closed') abort(404);
            #
            $this->data = $data->toArray();
            $this->data['date_from'] = $data->date_from_formatted;
            $this->data['date_to'] = $data->date_to_formatted;
            $this->data['date_from_formatted'] = $data->date_from_formatted;
            $this->data['date_to_formatted'] = $data->date_to_formatted;
            #
            $this->selectDealer($this->data['dealer_id']);
            #
            $items = [];
            foreach($data->details as $detail) {
                if ($detail->reassigned) {
                    $this->pending_cards[] = [
                        'id'        => $detail->id,
                        'card_id'   => $detail->card_id,
                        'card_name' => $detail->card->name,
                        'code'      => $detail->code,
                    ];
                    $this->reassigned_cards[] = $detail->code;
                } else {
                    $items[$detail->card_id]['card_id']   = $detail->card_id;
                    $items[$detail->card_id]['price']     = $detail->price;
                    $items[$detail->card_id]['comission'] = $detail->comission;
                    if (empty($items[$detail->card_id]['qty'])) $items[$detail->card_id]['qty'] = 1;
                    else ++$items[$detail->card_id]['qty'];
                }
            }
            $this->items = array_values($items);

            #Info
            $this->form = [
                'title'  => 'Actualizar contrato',
                'label'  => 'Actualizar',
                'action' => 'update',
            ];
        }
    }

    public function render()
    {
        return view('livewire.assigned-cards.form');
    }

    /**
     * Crear registro
     */
    public function store()
    {
        #Validar
        $this->validate([
            'data.dealer_id'  => 'required',
            'data.date_from'  => 'required|date_format:d/m/Y',
            'data.date_to'    => 'required|date_format:d/m/Y',
            'items.*.card_id' => 'required',
            'items.*.qty'     => 'required|numeric|min:1',
        ], [], [
            'data.dealer_id'  => 'cliente',
            'data.date_from'  => 'fecha desde',
            'data.date_to'    => 'fecha hasta',
            'items.*.card_id' => 'tarjeta',
            'items.*.qty'     => 'cantidad',
        ]);

        #Crear
        $assigned_card = new AssignedCard();
        $assigned_card->dealer_id = $this->data['dealer_id'];
        $assigned_card->date_from = Helpers::formatDate($this->data['date_from']);
        $assigned_card->date_to   = Helpers::formatDate($this->data['date_to']);
        $assigned_card->comments  = $this->data['comments'];
        $assigned_card->save();
        #
        $nulls = AssignedCardDetail::whereNull('dealer_code')->get();
        foreach ($nulls as $null) {
            $ac = AssignedCard::find($null->assigned_card_id);
            $d = Dealer::find($ac->dealer_id);
            #
            $acd = AssignedCardDetail::find($null->id);
            $acd->dealer_code = $d->code;
            $acd->save();
        }
        #Detalles
        foreach($this->items as $item) {
            for ($i=1; $i <= $item['qty']; $i++) {
                $card = Card::find($item['card_id']);
                $dealer = Dealer::find($this->data['dealer_id']);
                #
                $assigned_card_detail = new AssignedCardDetail();
                $assigned_card_detail->assigned_card_id = $assigned_card->id;
                $assigned_card_detail->card_id          = $item['card_id'];
                $assigned_card_detail->price            = $card->price;
                $assigned_card_detail->comission        = $card->comission;
                $assigned_card_detail->dealer_code      = $dealer->code;
                $assigned_card_detail->save();
            }
        }
        #Reasignadas
        foreach($this->reassigned_cards as $code) {
            if ($code) {
                $acd  = AssignedCardDetail::where('code', $code)->where('status', 'pending')->first();
                #pendiente
                $old_acd = AssignedCardDetail::find($acd->id);
                $old_acd->code   = $acd->code . '-' . $assigned_card->id;
                $old_acd->status = 'canceled';
                $old_acd->save();
                #
                $dealer = Dealer::find($this->data['dealer_id']);
                #nueva
                $assigned_card_detail = new AssignedCardDetail();
                $assigned_card_detail->assigned_card_id = $assigned_card->id;
                $assigned_card_detail->card_id          = $acd->card_id;
                $assigned_card_detail->code             = $acd->code;
                $assigned_card_detail->price            = $acd->price;
                $assigned_card_detail->comission        = $acd->comission;
                $assigned_card_detail->reassigned       = true;
                $assigned_card_detail->dealer_code      = $dealer->code;
                $assigned_card_detail->save();
            }
        }

        #Alert
        $this->dispatchBrowserEvent('cards_assigned', [
            'message' => 'Contrato generado exitosamente',
            'route'   => route('assigned-cards.index'),
            'pdf'     => route('assigned-cards.pdf', $assigned_card->id),
        ]);
    }

    /**
     * Actualizar registro
     */
    public function update()
    {
        #Validar
        $this->validate([
            'data.date_from'  => 'required|date_format:d/m/Y',
            'data.date_to'    => 'required|date_format:d/m/Y',
            'items.*.card_id' => 'required',
            'items.*.qty'     => 'required|numeric|min:1',
        ], [], [
            'data.date_from'  => 'fecha desde',
            'data.date_to'    => 'fecha hasta',
            'items.*.card_id' => 'tarjeta',
            'items.*.qty'     => 'cantidad',
        ]);

        #Actualizar
        $assigned_card = AssignedCard::find($this->data['id']);
        $assigned_card->date_from = Helpers::formatDate($this->data['date_from']);
        $assigned_card->date_to   = Helpers::formatDate($this->data['date_to']);
        $assigned_card->comments  = $this->data['comments'];
        $assigned_card->save();
        #
        $nulls = AssignedCardDetail::whereNull('dealer_code')->get();
        foreach ($nulls as $null) {
            $ac = AssignedCard::find($null->assigned_card_id);
            $d = Dealer::find($ac->dealer_id);
            #
            $acd = AssignedCardDetail::find($null->id);
            $acd->dealer_code = $d->code;
            $acd->save();
        }
        #Details
        AssignedCardDetail::where('assigned_card_id', $this->data['id'])->where('reassigned', false)->delete();
        foreach($this->items as $item) {
            for ($i=1; $i <= $item['qty']; $i++) {
                $card = Card::find($item['card_id']);
                $dealer = Dealer::find($assigned_card->dealer_id);
                #
                $assigned_card_detail = new AssignedCardDetail();
                $assigned_card_detail->assigned_card_id = $this->data['id'];
                $assigned_card_detail->card_id          = $item['card_id'];
                $assigned_card_detail->price            = $card->price;
                $assigned_card_detail->comission        = $card->comission;
                $assigned_card_detail->dealer_code      = $dealer->code;
                $assigned_card_detail->save();
            }
        }
        #Reasignadas
        AssignedCardDetail::where('assigned_card_id', $this->data['id'])->where('reassigned', true)->delete();
        foreach($this->pending_cards as $key => $pending) {
            $old_code = $pending['code'] . '-' . $assigned_card->id;
            $old_acd  = AssignedCardDetail::where('code', $old_code)->where('status', 'canceled')->first();
            if (!empty($old_acd->id)) {
                $old_acd->code   = $pending['code'];
                $old_acd->status = 'pending';
                $old_acd->save();
            }

            $code = $this->reassigned_cards[$key];
            if ($code) {
                $acd  = AssignedCardDetail::where('code', $code)->where('status', 'pending')->first();
                #pendiente
                $old_acd = AssignedCardDetail::find($acd->id);
                $old_acd->code   = $acd->code . '-' . $assigned_card->id;
                $old_acd->status = 'canceled';
                $old_acd->save();
                #
                $dealer = Dealer::find($this->data['dealer_id']);
                #nueva
                $assigned_card_detail = new AssignedCardDetail();
                $assigned_card_detail->assigned_card_id = $assigned_card->id;
                $assigned_card_detail->card_id          = $acd->card_id;
                $assigned_card_detail->code             = $acd->code;
                $assigned_card_detail->price            = $acd->price;
                $assigned_card_detail->comission        = $acd->comission;
                $assigned_card_detail->reassigned       = true;
                $assigned_card_detail->dealer_code      = $dealer->code;
                $assigned_card_detail->save();
            }
        }

        #Alert
        $this->dispatchBrowserEvent('submitted', [
            'message' => 'Contrato actualizado exitosamente',
            'route'   => route('assigned-cards.index'),
        ]);
    }

    /**
     * Seleccionar cliente
     *
     * @param int $id Id. del cliente
     */
    public function selectDealer($id)
    {
        $dealer = Dealer::find($id);
        $this->dealer = $dealer->toArray();
        $this->data['dealer_id'] = $id;

        $this->pending_cards = [];
        $this->reassigned_cards = [];

        #Reasignadas
        $assigned_cards = AssignedCard::where('dealer_id', $id)->closed()->get();
        foreach ($assigned_cards as $assigned_card) {
            if ($assigned_card->details_pending->count()) {
                foreach ($assigned_card->details_pending as $dp) {
                    $this->pending_cards[] = [
                        'id'        => $dp->id,
                        'card_id'   => $dp->card_id,
                        'card_name' => $dp->card->name,
                        'code'      => $dp->code,
                    ];
                    $this->reassigned_cards[] = null;
                }
            }
        }
    }

    /**
     * Agregar tarjeta
     */
    public function addItem()
    {
        $this->items[] = [
            'card_id'   => '',
            'qty'       => 0,
            'price'     => 0,
            'comission' => 0,
        ];
    }

    /**
     * Remover tarjeta
     */
    public function removeItem($key)
    {
        $items = $this->items;
        unset($items[$key]);
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = $item;
        }
    }
}
