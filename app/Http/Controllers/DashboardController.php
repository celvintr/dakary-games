<?php

namespace App\Http\Controllers;

use App\Models\AssignedCard;
use App\Models\AssignedCardDetail;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $months_short = [];

    public function __construct()
    {
        $this->months_short = [
            1  => 'Ene',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Abr',
            5  => 'May',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Ago',
            9  => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #clientes
        $dealers = Dealer::active()->count();

        #tarjetas activas
        $assigned_card_details = AssignedCardDetail::pending()
            ->whereHas('assigned', function($query) {
                $query->where('status', 'open');
            })
            ->count();

        #asignaciones abiertas
        $assigned_cards_opened = AssignedCard::open()->get();

        #asignaciones pendientes por cerrar
        $assigned_card_expired = $assigned_cards_opened->filter(function($model) {
            return $model->days_expiration == 0;
        });

        #INFO CARDS
        $cards = [
            'dealers'               => $dealers,
            'assigned_card_details' => $assigned_card_details,
            'assigned_cards'        => $assigned_cards_opened->count(),
            'assigned_card_expired' => $assigned_card_expired->count(),
        ];

        #ventas por clientes
        $dealers_sales = DB::select(
            "SELECT
                SUM(acd.price) AS amount,
                SUM(acd.comission) AS comission,
                COUNT(acd.card_id) AS qty,
                ac.dealer_id,
                d.code AS dealer_code,
                d.name AS dealer_name
            FROM assigned_card_details acd
            INNER JOIN assigned_cards ac ON (ac.id = acd.assigned_card_id)
            INNER JOIN dealers d ON (d.id = ac.dealer_id)
            WHERE
                acd.status = ?
                AND YEAR(acd.updated_at) = ?
            GROUP BY ac.dealer_id
            ORDER BY amount DESC",
            ['changed', now()->format('Y')]
        );

        #ventas por productos
        $cards_sales = DB::select(
            "SELECT
                SUM(acd.price) AS amount,
                SUM(acd.comission) AS comission,
                COUNT(ac.dealer_id) AS qty,
                acd.card_id,
                d.name AS card_name
            FROM assigned_card_details acd
            INNER JOIN assigned_cards ac ON (ac.id = acd.assigned_card_id)
            INNER JOIN cards d ON (d.id = acd.card_id)
            WHERE
                acd.status = ?
                AND YEAR(acd.updated_at) = ?
            GROUP BY acd.card_id
            ORDER BY amount DESC",
            ['changed', now()->format('Y')]
        );

        #INFO TABLES
        $tables = [
            'dealers_sales' => $dealers_sales,
            'cards_sales'   => $cards_sales,
        ];

        #ventas por periodo
        $month_sales = DB::select(
            "SELECT
                SUM(acd.price) AS amount,
                SUM(acd.comission) AS comission,
                MONTH(acd.updated_at) AS sales_month
            FROM assigned_card_details acd
            INNER JOIN assigned_cards ac ON (ac.id = acd.assigned_card_id)
            INNER JOIN cards d ON (d.id = acd.card_id)
            WHERE
                acd.status = ?
                AND YEAR(acd.updated_at) = ?
            GROUP BY sales_month
            ORDER BY sales_month ASC",
            ['changed', now()->format('Y')]
        );

        $chart_sales = [] ;
        $month_sales_amount = [];
        $month_sales_comission = [];
        $month_sales_categories = [];
        foreach ($month_sales as $sale) {
            $month_sales_amount[] = $sale->amount;
            $month_sales_comission[] = $sale->comission;
            $month_sales_categories[] = $this->months_short[$sale->sales_month];
        }

        // CHART 1
        $chart_sales = [
            'amount'     => $month_sales_amount,
            'comission'  => $month_sales_comission,
            'categories' => $month_sales_categories,
        ];

        return view('dashboard', [
            'cards'       => $cards,
            'tables'      => $tables,
            'chart_sales' => $chart_sales,
        ]);
    }
}
