<?php

namespace App\Services;

use App\Http\Requests\GiftCardPostRequest;
use App\Models\Address;
use App\Models\GiftCard;

class GiftCardService
{
    /**
     * @param GiftCardPostRequest $request
     * @return GiftCard
     */
    public function store(GiftCardPostRequest $request)
    {
        if ($request->amount === 'Custom Amount') {
            $request->amount = $request->customAmount;
        }

        $amount = (float)$request->amount;
        $quantity = (int)$request->quantity;
        $total = $amount * $quantity;

        $giftCard = GiftCard::create([
            'amount' => $amount,
            'quantity' => $quantity,
            'total' => $total,
            'sendto' => $request->sendto,
            'delivery_id' => $request->delivery_id
        ]);

        $this->initAddresses($giftCard);

        return $giftCard;
    }

    /**
     * @param GiftCardPostRequest $request
     * @param $id
     * @return GiftCard
     */
    public function update(GiftCardPostRequest $request, $id)
    {
        $giftCard = GiftCard::find($id);
        if (!$giftCard) {
            throw new \RuntimeException('Invalid Gift Card ID!');
        }

        if ($request->amount === 'Custom Amount') {
            $request->amount = $request->customAmount;
        }

        $amount = (float)$request->amount;
        $quantity = (int)$request->quantity;
        $total = ($amount * $quantity) + $giftCard->shipping;

        $giftCard->amount = $amount;
        $giftCard->quantity = $quantity;
        $giftCard->total = $total;
        $giftCard->sendto = $request->sendto;
        $giftCard->delivery_id = (int)$request->delivery_id;
        $giftCard->save();

        $this->initAddresses($giftCard);

        if ($giftCard->isECertificate()) {
            $giftCard->removeShippingInfo();
        }

        return $giftCard;
    }

    /**
     * @param GiftCard $giftCard
     */
    private function initAddresses(GiftCard $giftCard)
    {
        $addressCount = Address::where('card_id', $giftCard->id)->count();
        if ($giftCard->quantity > $addressCount) {
            for ($i = $addressCount; $i < $giftCard->quantity; $i++) {
                $address = new Address();
                $address->card_id = $giftCard->id;
                $address->save();
            }
        } elseif ($giftCard->quantity < $addressCount) {
            $addresses = Address::where('card_id', $giftCard->id)->orderBy('id', 'asc')->get();
            for ($i = $giftCard->quantity; $i < count($addresses); $i++) {
                $addresses[$i]->delete();
            }
        }
    }
}