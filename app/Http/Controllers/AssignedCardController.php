<?php

namespace App\Http\Controllers;

use App\Models\AssignedCard;
use App\Models\AssignedCardDetail;
use PDF;

class AssignedCardController extends Controller
{
    /**
     * Generar PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $assigned_card = AssignedCard::findOrFail($id);
        #
        $items = [];
        $items_pending = [];
        foreach($assigned_card->details as $detail) {
            if ($detail->reassigned) {
                $items_pending[$detail->card_id]['card_id'] = $detail->card_id;
                $items_pending[$detail->card_id]['name']    = $detail->card->name;
                $items_pending[$detail->card_id]['cards'][] = $detail->code;
            }
            else {
                $items[$detail->card_id]['card_id'] = $detail->card_id;
                $items[$detail->card_id]['name']    = $detail->card->name;
                if (empty($items[$detail->card_id]['qty'])) $items[$detail->card_id]['qty'] = 1;
                else ++$items[$detail->card_id]['qty'];
            }
        }
        $items = array_values($items);
        $items_pending = array_values($items_pending);
        foreach ($items as $key => $item) {
            $min = AssignedCardDetail::where('assigned_card_id', $id)
                ->where('card_id', $item['card_id'])
                ->where('reassigned', false)
                ->min('code');

            $max = AssignedCardDetail::where('assigned_card_id', $id)
                ->where('card_id', $item['card_id'])
                ->where('reassigned', false)
                ->max('code');

            $items[$key]['min'] = $min;
            $items[$key]['max'] = $max;
        }

        $data = [
            'assigned_card' => $assigned_card,
            'items'         => $items,
            'items_pending' => $items_pending,
        ];

        view()->share('data', $data);
        $pdf = PDF::loadView('pdf.assigned-cards', $data);
        return $pdf->stream('contrato.pdf');
    }

    /**
     * Generar PDF Cierre.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf_closed($id)
    {
        $assigned_card = AssignedCard::findOrFail($id);

        $data = [
            'assigned_card' => $assigned_card,
        ];

        view()->share('data', $data);
        $pdf = PDF::loadView('pdf.assigned-cards-closed', $data);
        return $pdf->stream('cierre.pdf');
    }
}
