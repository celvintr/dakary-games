<?php

namespace App\Models;

use App\Classes\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'price_formatted',
        'comission_formatted',
    ];

    /**
     * Filtrar registros activos.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Filtrar registros inactivos.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
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
