<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Obtener los clientes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dealers(Request $request)
    {
        $search = $request->q;

        $query = Dealer::query();
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('code', 'LIKE', '%' . $search . '%');
                $q->orWhere('name', 'LIKE', '%' . $search . '%');
                $q->orWhere('phone', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $query->get();

        return response()->json([
            'items' => $items,
        ]);
    }
}
