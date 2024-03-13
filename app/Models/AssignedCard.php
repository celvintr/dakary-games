<?php

namespace App\Models;

use App\Classes\Helpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssignedCard extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_from' => 'datetime',
        'date_to'   => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'date_from_formatted',
        'date_to_formatted',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $year = substr($model->date_from, 0, 4);

            $max = DB::table('assigned_cards')->where('code', 'LIKE', $year . '-%')->max('code');
            $max = intval(substr($max, 5)) + 1;
            $model->code = $year . '-' . str_pad($max, 4, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Cliente asociado.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Detalles.
     */
    public function details()
    {
        return $this->hasMany(AssignedCardDetail::class);
    }

    /**
     * Detalles (activadas).
     */
    public function details_changed()
    {
        return $this->hasMany(AssignedCardDetail::class)->where('status', 'changed');
    }

    /**
     * Detalles (pendientes).
     */
    public function details_pending()
    {
        return $this->hasMany(AssignedCardDetail::class)->where('status', 'pending');
    }

    /**
     * Detalles (cancelados).
     */
    public function details_canceled()
    {
        return $this->hasMany(AssignedCardDetail::class)->where('status', 'canceled');
    }

    /**
     * Detalles (reasignados).
     */
    public function details_reassigned()
    {
        return $this->hasMany(AssignedCardDetail::class)->where('reassigned', true);
    }

    /**
     * Filtrar registros abiertos.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Filtrar registros cerrados.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Fecha desde formateada
     *
     * @return string
     */
    public function getDateFromFormattedAttribute()
    {
        return $this->date_from->format('d/m/Y');
    }

    /**
     * Fecha hasta formateada
     *
     * @return string
     */
    public function getDateToFormattedAttribute()
    {
        return $this->date_to->format('d/m/Y');
    }

    /**
     * Fecha hasta formateada
     *
     * @return string
     */
    public function getDaysExpirationAttribute()
    {
        $dt      = Carbon::now();
        $future  = $this->date_to;

        if ($dt->format('Y-m-d') > $future->format('Y-m-d'))
            return 0;

        return $dt->diffInDays($future);
    }

    /**
     * Fecha hasta formateada
     *
     * @return string
     */
    public function getDetailsSummaryAttribute()
    {
        $qty_changed = $this->details->where('status', 'changed')->count();
        $qty_total   = $this->details->count();
        $qty_pending = $qty_total - $qty_changed;

        $amount_changed = $this->details->where('status', 'changed')->sum('price');
        $amount_pending = $this->details->where('status', 'pending')->sum('price');

        $comission_changed = $this->details->where('status', 'changed')->sum('comission');
        $comission_pending = $this->details->where('status', 'pending')->sum('comission');

        $amount_total   = $amount_changed - $comission_changed;

        return [
            'qty_total'   => $qty_total,
            'qty_changed' => $qty_changed,
            'qty_pending' => $qty_pending,

            'amount_total'   => $amount_total,
            'amount_changed' => $amount_changed,
            'amount_pending' => $amount_pending,

            'comission_changed' => $comission_changed,
            'comission_pending' => $comission_pending,

            'amount_total_formatted'   => Helpers::formatFormDecimal($amount_total),
            'amount_changed_formatted' => Helpers::formatFormDecimal($amount_changed),
            'amount_pending_formatted' => Helpers::formatFormDecimal($amount_pending),

            'comission_changed_formatted' => Helpers::formatFormDecimal($comission_changed),
            'comission_pending_formatted' => Helpers::formatFormDecimal($comission_pending),
        ];
    }
}
