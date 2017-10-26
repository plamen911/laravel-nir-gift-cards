<?php

namespace App\Http\Controllers;

use App\Helpers\UtilityHelper;
use App\Http\Requests\AddressPostRequest;
use App\Models\Country;
use App\Models\GiftCard;
use App\Models\ShippingMethod;
use App\Services\AddressService;

class AddressController extends Controller
{
    private $service;
    private $helper;

    /**
     * AddressController constructor.
     * @param AddressService $service
     * @param UtilityHelper $helper
     */
    public function __construct(AddressService $service, UtilityHelper $helper)
    {
        $this->service = $service;
        $this->helper = $helper;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GiftCard $giftCard
     * @param  int $index
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCard $giftCard, $index)
    {
        if ($giftCard->isPaid()) {
            return redirect('/');
        }

        $address = $giftCard->getAddressIdByIndex($index);
        if (!$address) {
            return abort(404, 'Gift card address not found.');
        }

        if ($index - 1 >= 0) {
            $prevUrl = url('/buy-gift-cards/' . $giftCard->id . '/address/' . ($index - 1));
        } else {
            $prevUrl = url('/buy-gift-cards/' . $giftCard->id);
        }

        $data = [
            'countriesArray' => Country::dropdown(),
            'shippingMethodsArray' => ShippingMethod::dropdown(),
            'index' => $index,
            'giftCard' => $giftCard,
            'address' => $address,
            'prevUrl' => $prevUrl
        ];

        return view('gift-cards.address', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressPostRequest $request
     * @param GiftCard $giftCard
     * @param  int $index
     * @return \Illuminate\Http\Response
     */
    public function update(AddressPostRequest $request, GiftCard $giftCard, $index)
    {
        if ($giftCard->isPaid()) {
            return redirect('/');
        }
        
        $address = $giftCard->getAddressIdByIndex($index);
        if (!$address) {
            return abort(404, 'Gift card address not found.');
        }

        $this->service->update($request, $address->id);

        if ($index + 1 < $giftCard->quantity) {
            return redirect('buy-gift-cards/' . $giftCard->id . '/address/' . ($index + 1));
        } else {
            return redirect('buy-gift-cards/' . $giftCard->id . '/purchase');
        }
    }
}
