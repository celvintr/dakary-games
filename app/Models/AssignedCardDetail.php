<?php

namespace App\Models;

use App\Classes\Helpers;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AssignedCardDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reassigned' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'price_formatted',
        'comission_formatted',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (!$model->reassigned) {
                $assigned_card = DB::table('assigned_cards')->where('id', $model->assigned_card_id)->first();
                $dealer = DB::table('dealers')->where('id', $assigned_card->dealer_id)->first();

                $max = DB::table('assigned_card_details')
                    ->where('dealer_code', $dealer->code)
                    ->where('status', '<>', 'canceled')
                    ->max('code');
                $max = intval(substr($max, strlen($dealer->code))) + 1;
                $model->code = $dealer->code . str_pad($max, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Cliente asociado.
     */
    public function assigned()
    {
        return $this->belongsTo(AssignedCard::class, 'assigned_card_id');
    }

    /**
     * Tarjeta asociado.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Filtrar registros pendientes.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Filtrar registros cambiados.
     */
    public function scopeChanged($query)
    {
        return $query->where('status', 'changed');
    }

    /**
     * Filtrar registros cancelados.
     */
    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    /**
     * Filtrar registros reasignados.
     */
    public function scopeReassigned($query)
    {
        return $query->where('reassigned', true);
    }

    /**
     * Obtener la url de la imagen del soporte
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file);
    }

    /**
     * Precio formateado
     *
     * @return string
     */
    public function getPriceFormattedAttribute()
    {
        return Helpers::formatFormDecimal($this->price);
    }

    /**
     * Comision formateada
     *
     * @return string
     */
    public function getComissionFormattedAttribute()
    {
        return Helpers::formatFormDecimal($this->comission);
    }
}
