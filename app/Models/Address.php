<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the gift card that owns the address.
     */
    public function giftCard()
    {
        return $this->belongsTo('App\Models\GiftCard', 'card_id', 'id');
    }

    /**
     * Get the shipping method that owns the address.
     */
    public function shippingMethod()
    {
        return $this->belongsTo('App\Models\ShippingMethod', 'shipping_id', 'id');
    }

    public function getPoolNumber()
    {
        $poolNumber = 1068620000001;
        // $endPoolNumber = 1068620000001;

        $maxId = self::leftJoin('gift_cards', function ($join) {
                $join->on('addresses.card_id', '=', 'gift_cards.id');
            })
            ->where('gift_cards.status', 'Approved')
            ->whereNotNull('addresses.pool_number')
            ->max('addresses.id');
        if ($maxId) {
            $address = self::find($maxId);
            $poolNumber = (int)$address->pool_number;
            $poolNumber++;
        }

        return $poolNumber;
    }
}
