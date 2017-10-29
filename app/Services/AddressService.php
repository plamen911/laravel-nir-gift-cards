<?php

namespace App\Services;

use App\Http\Requests\AddressPostRequest;
use App\Models\Address;
use App\Models\GiftCard;
use App\Models\ShippingMethod;

class AddressService
{
    /**
     * @param AddressPostRequest $request
     * @param int $id
     * @return Address
     */
    public function update(AddressPostRequest $request, $id)
    {
        $address = Address::find($id);
        if (!$address) {
            throw new \RuntimeException('Invalid Gift Card address ID!');
        }
        $giftCard = GiftCard::find($address->card_id);
        if (!$giftCard) {
            throw new \RuntimeException('Invalid Gift Card ID!');
        }

        $address->recipient = $request->recipient;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->address2 = $request->address2;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;
        $address->country = $request->country;
        $address->message = $request->message;
        $address->save();

        if ($giftCard->isECertificate()) {
            $giftCard->removeShippingInfo();
        } else {
            $shippingMethod = ShippingMethod::find($request->shipping_id);
            if ($shippingMethod) {
                $address->shipping_id = $shippingMethod->id;
                $address->shipping = $shippingMethod->amount;
                $address->save();

                $giftCard = GiftCard::find($address->card_id);
                $shipping = $giftCard->addresses->sum('shipping');

                $giftCard->shipping_id = $shippingMethod->id;
                $giftCard->shipping = $shipping;
                $giftCard->total = ($giftCard->amount * $giftCard->quantity) + $giftCard->shipping;
                $giftCard->save();
            }
        }

        return $address;
    }
}