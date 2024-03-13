<?php

namespace App\Http\Controllers;

use App\Classes\Helpers;
use App\Exports\SalesDatesExport;
use App\Exports\SalesDealersExport;
use App\Exports\SalesCardsExport;
use App\Models\AssignedCardDetail;
use App\Models\Card;
use App\Models\Dealer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Database\Eloquent\Builder;
use PDF;

class ReportController extends Controller
{
    /**
     * Reporte de ventas por fecha.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_dates()
    {
        $date_from = Carbon::now()->firstOfMonth()->format('d/m/Y');
        $date_to   = Carbon::now()->format('d/m/Y');

        return view('reports.sales.dates.index', [
            'date_from' => $date_from,
            'date_to'   => $date_to,
        ]);
    }

    /**
     * Reporte de ventas por fecha (filtrar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sales_dates_export(Request $request)
    {
        $params = [
            'date_from'     => Helpers::formatDate($request->date_from),
            'date_to'       => Helpers::formatDate($request->date_to),
            'status_detail' => $request->status_detail,
            'status_parent' => $request->status_parent,
        ];

        if ($request->export == 'pdf') return $this->sales_dates_pdf($params);
        else return $this->sales_dates_xls($params);
    }

    /**
     * Reporte de ventas por fecha (pdf).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_dates_pdf($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'params'  => [
                'date_from'     => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'       => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        view()->share('data', $data);
        $pdf = PDF::loadView('reports.sales.dates.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('reporte-de-ventas-por-fecha.pdf');
    }

    /**
     * Reporte de ventas por fecha (xls).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_dates_xls($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'params'  => [
                'date_from'     => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'       => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        return Excel::download(new SalesDatesExport($data), 'reporte-de-ventas-por-fecha.xlsx');
    }

    /**
     * Reporte de ventas por cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_dealers()
    {
        $date_from = Carbon::now()->firstOfMonth()->format('d/m/Y');
        $date_to   = Carbon::now()->format('d/m/Y');

        return view('reports.sales.dealers.index', [
            'date_from' => $date_from,
            'date_to'   => $date_to,
        ]);
    }

    /**
     * Reporte de ventas por cliente (filtrar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sales_dealers_export(Request $request)
    {
        $params = [
            'date_from'     => Helpers::formatDate($request->date_from),
            'date_to'       => Helpers::formatDate($request->date_to),
            'dealer_id'     => $request->dealer_id,
            'status_detail' => $request->status_detail,
            'status_parent' => $request->status_parent,
        ];

        if ($request->export == 'pdf') return $this->sales_dealers_pdf($params);
        else return $this->sales_dealers_xls($params);
    }

    /**
     * Reporte de ventas por cliente (pdf).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_dealers_pdf($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        $query->whereHas('assigned', function (Builder $q) use ($params) {
            $q->where('dealer_id', $params['dealer_id']);
        });
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'dealer'  => Dealer::find($params['dealer_id']),
            'params'  => [
                'date_from' => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'   => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        view()->share('data', $data);
        $pdf = PDF::loadView('reports.sales.dealers.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('reporte-de-ventas-por-cliente.pdf');
    }

    /**
     * Reporte de ventas por cliente (xls).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_dealers_xls($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        $query->whereHas('assigned', function (Builder $q) use ($params) {
            $q->where('dealer_id', $params['dealer_id']);
        });
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'dealer'  => Dealer::find($params['dealer_id']),
            'params'  => [
                'date_from' => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'   => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        return Excel::download(new SalesDealersExport($data), 'reporte-de-ventas-por-cliente.xlsx');
    }

    /**
     * Reporte de ventas por producto.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_cards()
    {
        $date_from = Carbon::now()->firstOfMonth()->format('d/m/Y');
        $date_to   = Carbon::now()->format('d/m/Y');

        return view('reports.sales.cards.index', [
            'date_from' => $date_from,
            'date_to'   => $date_to,
            'cards'     => Card::all(),
        ]);
    }

    /**
     * Reporte de ventas por producto (filtrar).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sales_cards_export(Request $request)
    {
        $params = [
            'date_from' => Helpers::formatDate($request->date_from),
            'date_to'   => Helpers::formatDate($request->date_to),
            'card_id'   => $request->card_id,
            'status_detail' => $request->status_detail,
            'status_parent' => $request->status_parent,
        ];

        if ($request->export == 'pdf') return $this->sales_cards_pdf($params);
        else return $this->sales_cards_xls($params);
    }

    /**
     * Reporte de ventas por producto (pdf).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_cards_pdf($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        $query->where('card_id', $params['card_id']);
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'card'    => Card::find($params['card_id']),
            'params'  => [
                'date_from' => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'   => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        view()->share('data', $data);
        $pdf = PDF::loadView('reports.sales.cards.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('reporte-de-ventas-por-producto.pdf');
    }

    /**
     * Reporte de ventas por producto (xls).
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    protected function sales_cards_xls($params)
    {
        $query = AssignedCardDetail::query();
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') >= ?", [$params['date_from']]);
        $query->whereRaw("DATE_FORMAT(updated_at, '%Y-%m-%d') <= ?", [$params['date_to']]);
        $query->where('card_id', $params['card_id']);
        if ($params['status_detail']) {
            $query->where('status', $params['status_detail']);
        }
        if ($params['status_parent']) {
            $query->whereHas('assigned', function (Builder $q) use ($params) {
                $q->where('status', $params['status_parent']);
            });
        }
        $details = $query->orderBy('updated_at', 'ASC')->get();

        $data = [
            'details' => $details,
            'card'    => Card::find($params['card_id']),
            'params'  => [
                'date_from' => Carbon::createFromFormat('Y-m-d', $params['date_from'])->format('d/m/Y'),
                'date_to'   => Carbon::createFromFormat('Y-m-d', $params['date_to'])->format('d/m/Y'),
                'status_detail' => $params['status_detail'],
                'status_parent' => $params['status_parent'],
            ],
        ];

        return Excel::download(new SalesCardsExport($data), 'reporte-de-ventas-por-producto.xlsx');
    }
}
