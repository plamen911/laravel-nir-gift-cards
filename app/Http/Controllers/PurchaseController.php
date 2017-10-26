<?php

namespace App\Http\Controllers;

use App\Helpers\SagePayHelper;
use App\Helpers\UtilityHelper;
use App\Http\Requests\PurchasePostRequest;
use App\Models\Country;
use App\Models\GiftCard;
use App\Services\PurchaseService;
use Illuminate\Support\Facades\Mail;

class PurchaseController extends Controller
{
    private $service;
    private $utilityHelper;

    /**
     * PurchaseController constructor.
     * @param PurchaseService $service
     * @param UtilityHelper $utilityHelper
     */
    public function __construct(PurchaseService $service, UtilityHelper $utilityHelper)
    {
        $this->service = $service;
        $this->utilityHelper = $utilityHelper;
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

        $prevUrl = url('/buy-gift-cards/' . $giftCard->id . '/address/' . ($giftCard->quantity - 1));
        $data = [
            'countriesArray' => Country::dropdown(),
            'creditCardTypesArray' => $this->utilityHelper->getCreditCardTypes(),
            'giftCard' => $giftCard,
            'prevUrl' => $prevUrl
        ];

        return view('gift-cards.purchase', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PurchasePostRequest $request
     * @param GiftCard $giftCard
     * @param SagePayHelper $sagePayHelper
     * @return \Illuminate\Http\Response
     */
    public function update(PurchasePostRequest $request, GiftCard $giftCard, SagePayHelper $sagePayHelper)
    {
        if ($giftCard->isPaid()) {
            return redirect('/');
        }

        try {
            $giftCard = $this->service->update($request, $giftCard->id, $sagePayHelper);

            Mail::send('emails.to-admin', compact('giftCard'), function ($message) use ($giftCard) {
                $message->from(env('ADMIN_EMAIL'), 'Nantucket Island Resorts')
                    ->to(env('ADMIN_EMAIL'))
                    ->subject('Receipt of online gift card purchase');
            });

            Mail::send('emails.to-buyer', compact('giftCard'), function ($message) use ($giftCard) {
                if(!empty($giftCard->email)){
                    $message->from(env('FRIENDLY_SENDER_EMAIL'), 'Nantucket Island Resorts')
                        ->to($giftCard->email)
                        ->subject('Receipt of online gift card purchase from Nantucket Island Resorts');
                }
            });

            if($giftCard->isECertificate()){
                foreach ($giftCard->addresses as $address) {
                    Mail::send('emails.to-recipient', compact('giftCard', 'address'), function ($message) use ($address) {
                        if(!empty($address->email)) {
                            $message->from(env('FRIENDLY_SENDER_EMAIL'), 'Nantucket Island Resorts')
                                ->to($address->email)
                                ->subject('Your Nantucket Island Resorts Gift Card');
                        }
                    });
                }
            }


            return redirect('buy-gift-cards/' . $giftCard->id . '/purchase-success');

        } catch (\Exception $ex) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors([$ex->getMessage()]);
        }
    }

    /**
     * @param GiftCard $giftCard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseSuccess(GiftCard $giftCard)
    {
        if (!$giftCard->isPaid()) {
            return redirect('/');
        }

        return view('gift-cards.purchase-success', [ 'giftCard' => $giftCard ]);
    }
}
