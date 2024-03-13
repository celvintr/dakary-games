<?php

return [

    'status' => [
        'active'   => 'Activo',
        'inactive' => 'Inactivo',
    ],
    'status-class' => [
        'active'   => 'success',
        'inactive' => 'danger',
    ],

    'status-assigned' => [
        'open'   => 'Abierto',
        'closed' => 'Cerrado',
    ],
    'status-assigned-class' => [
        'open'   => 'success',
        'closed' => 'danger',
    ],

    'status-assigned-detail' => [
        'pending'   => 'Pendiente',
        'changed'   => 'Cambiado',
        'canceled'  => 'Cambiado',
    ],
    'status-assigned-detail-class' => [
        'pending'   => 'danger',
        'changed'   => 'success',
        'canceled'  => 'danger',
    ],

    'google_map_api' => env('GOOGLE_MAP_API'),
    'google_map_lat' => env('GOOGLE_MAP_LAT'),
    'google_map_lng' => env('GOOGLE_MAP_LNG'),

];
