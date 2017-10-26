<?php

namespace App\Http\Controllers;

use App\Helpers\UtilityHelper;
use App\Http\Requests\GiftCardPostRequest;
use App\Models\DeliveryType;
use App\Models\GiftCard;
use App\Services\GiftCardService;

/**
 * Class GiftCardController
 * @package App\Http\Controllers
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class GiftCardController extends Controller
{
    private $service;
    private $helper;

    /**
     * GiftCardController constructor.
     * @param GiftCardService $service
     * @param UtilityHelper $helper
     */
    public function __construct(GiftCardService $service, UtilityHelper $helper)
    {
        $this->service = $service;
        $this->helper = $helper;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $giftCard = new \stdClass();
        $giftCard->amount = 0;
        $giftCard->customAmount = null;
        $giftCard->quantity = 1;
        $giftCard->sendto = 'me';
        $giftCard->delivery_id = '1';

        $data = [
            'amountsArray' => $this->helper->getGiftCardAmounts(),
            'deliveryTypes' => DeliveryType::orderBy('position')->get(),
            'id' => 0,
            'giftCard' => $giftCard
        ];

        return view('gift-cards.gift-card', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GiftCardPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GiftCardPostRequest $request)
    {
        $giftCard = $this->service->store($request);

        return redirect('buy-gift-cards/' . $giftCard->id . '/address/0');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GiftCard $giftCard
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCard $giftCard)
    {
        if ($giftCard->isPaid()) {
            return redirect('/');
        }

        $amountsArray = $this->helper->getGiftCardAmounts();
        $giftCard->customAmount = (!in_array((float)$giftCard->amount, array_keys($amountsArray))) ? $giftCard->amount : null;
        if ($giftCard->customAmount) {
            $giftCard->amount = 'Custom Amount';
        }

        $data = [
            'amountsArray' => $amountsArray,
            'deliveryTypes' => DeliveryType::orderBy('position')->get(),
            'id' => $giftCard->id,
            'giftCard' => $giftCard
        ];

        return view('gift-cards.gift-card', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GiftCardPostRequest $request
     * @param GiftCard $giftCard
     * @return \Illuminate\Http\Response
     */
    public function update(GiftCardPostRequest $request, GiftCard $giftCard)
    {
        if ($giftCard->isPaid()) {
            return redirect('/');
        }
        
        $giftCard = $this->service->update($request, $giftCard->id);

        return redirect('buy-gift-cards/' . $giftCard->id . '/address/0');
    }
}
