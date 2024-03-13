<?php
namespace App\Classes;

use Carbon\Carbon;

class Helpers
{
    /**
     * Formatear fecha para la BD
     *
     * @param string $string Fecha formateado
     * @return string
     */
    public static function formatDate($string)
    {
        if (empty($string)) return null;

        $date = Carbon::createFromFormat('d/m/Y', $string)->format('Y-m-d');

        return $date;
    }
    /**
     * Formatear fecha para la BD
     *
     * @param string $string Fecha formateado
     * @return string
     */
    public static function formatFormDateTime($string)
    {
        if (empty($string)) return null;

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $string)->format('d/m/Y h:ia');

        return $date;
    }

    /**
     * Formatear numero para la BD
     *
     * @param string $string Monto formateado
     * @return float
     */
    public static function formatDecimal($string)
    {
        if (empty($string)) return 0;

        $number = str_replace(',', '', $string);

        return floatval($number);
    }

    /**
     * Formatear numero para los formularios
     *
     * @param float $number Monto a formatear
     * @return string
     */
    public static function formatFormDecimal($number)
    {
        if (empty($number)) return "0.00";

        return number_format($number, 2, '.', ',');
    }
}
