<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gift_cards';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'quantity', 'total', 'sendto', 'delivery_id'];

    /**
     * Get the addresses for the gift card.
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'card_id')->orderBy('id');
    }

    /**
     * Get the shipping method that owns the gift card.
     */
    public function shippingMethod()
    {
        return $this->belongsTo('App\Models\ShippingMethod', 'shipping_id', 'id');
    }

    /**
     * Get the shipping method that owns the gift card.
     */
    public function deliveryTypes()
    {
        return $this->belongsTo('App\Models\DeliveryType', 'delivery_id');
    }

    public function numberPool()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param int $index
     * @return Address|null
     */
    public function getAddressIdByIndex($index)
    {
        return $this->addresses()->offset($index)->limit(1)->first();
    }

    /**
     * @return bool
     */
    public function isECertificate()
    {
        return (int)$this->delivery_id === 2;
    }

    // If delivery type is an e-certificate, remove shipping info
    public function removeShippingInfo()
    {
        $this->shipping_id = 0;
        $this->shipping = 0;
        $this->total = ($this->amount * $this->quantity) + $this->shipping;
        $this->save();

        foreach ($this->addresses() as $address) {
            $address->address = '';
            $address->address2 = '';
            $address->city = '';
            $address->state = '';
            $address->zip = '';
            $address->country = '';
            $address->shipping_id = 0;
            $address->shipping = 0;
            $address->save();
        }
    }

//    public function getSendTo()
//    {
//        if ('someone' === $this->sendto) {
//            return 'Someone Else';
//        }
//        return ucwords($this->sendto);
//    }

    public function getSendtoNameAttribute()
    {
        if ('someone' === $this->sendto) {
            return 'Someone Else';
        }
        return ucwords($this->sendto);
    }

    public function isPaid()
    {
        return !empty($this->status) && $this->status === 'Approved';
    }
}
