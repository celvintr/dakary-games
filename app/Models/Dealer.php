<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class Dealer extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'maps' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $max = DB::table('dealers')->max('id');
            $max = intval($max) + 1;
            $model->code = 'D' . $max;
        });
    }

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
     * Obtener la url de la imagen del documento
     *
     * @return string
     */
    public function getDocumentImageUrlAttribute()
    {
        return asset('storage/' . $this->document_image);
    }

    /**
     * Obtener la url de la imagen del negocio
     *
     * @return string
     */
    public function getBusinessImageUrlAttribute()
    {
        return asset('storage/' . $this->business_image);
    }

    /**
     * Obtener la url del mapa de google desde la direccion
     *
     * @return string
     */
    public function getGoogleMapUrlAttribute()
    {
        if (!empty($this->maps))
            return "https://www.google.com/maps/search/?api=1&query=".$this->maps['geometry']['location']['lat']."%2C".$this->maps['geometry']['location']['lng']."&query_place_id=".$this->maps['place_id'];
        else return null;
    }

    /**
     * Obtener la url del whatsapp desde el telefono
     *
     * @return string
     */
    public function getWhatsappUrlAttribute()
    {
        if (!empty($this->phone)) {
            $phone = $this->phone;
            $phone = str_replace(' ', '', $phone);
            $phone = str_replace('-', '', $phone);
            $phone = str_replace('(', '', $phone);
            $phone = str_replace(')', '', $phone);

            return "https://wa.me/".$phone;
        }
        else return null;
    }
}
