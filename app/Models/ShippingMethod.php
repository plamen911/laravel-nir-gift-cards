<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping_methods';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the gift cards for the shipping method
     */
    public function giftCards()
    {
        return $this->hasMany('App\Models\GiftCard')->orderBy('id');
    }

    // Get all Active status records in lists type
    public static function dropdown()
    {
//        $data = [];
//        $methods = ShippingMethod::all();
//        foreach ($methods as $method) {
//            $data[$method->id] = $method->name . ' - $' . number_format($method->amount, 2);
//        }
//        return $data;

        return self::orderBy('position')->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name . ' - $' . number_format($item->amount, 2)];
            })->pluck('name', 'id');
    }
}
