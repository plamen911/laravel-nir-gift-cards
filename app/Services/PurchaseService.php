<?php

namespace App\Services;

use App\Helpers\SagePayHelper;
use App\Http\Requests\PurchasePostRequest;
use App\Models\Address;
use App\Models\GiftCard;

/**
 * Class PurchaseService
 * @package App\Services
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class PurchaseService
{
    private $service;

    /**
     * PurchaseService constructor.
     * @param PaymentGatewayService $service
     */
    public function __construct(PaymentGatewayService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PurchasePostRequest $request
     * @param $id
     * @param SagePayHelper $sagePayHelper
     * @return GiftCard
     * @throws \Exception
     */
    public function update(PurchasePostRequest $request, $id, SagePayHelper $sagePayHelper)
    {
        $giftCard = GiftCard::find($id);
        if (!$giftCard) {
            throw new \RuntimeException('Invalid Gift Card ID!');
        }

        $credentials = $this->service->credentials();
        $TEST_CREDIT_CARD = $credentials[4]->value;

        $giftCard->name = $request->name;
        $giftCard->cctype = $request->cctype;
        $giftCard->ccnumber = substr($request->ccnumber, -4);
        $giftCard->ccexp_month = $request->ccexp_month;
        $giftCard->ccexp_year = $request->ccexp_year;
        $giftCard->email = $request->email;
        $giftCard->phone = $request->phone;
        $giftCard->address = $request->address;
        $giftCard->address2 = $request->address2;
        $giftCard->city = $request->city;
        $giftCard->state = $request->state;
        $giftCard->zip = $request->zip;
        $giftCard->country = $request->country;
        $giftCard->save();

        if ($TEST_CREDIT_CARD === $request->ccnumber) {
            // save dummy payment data
            $giftCard->status = 'Approved';
            $giftCard->reference = 'E8IHG1VbP0';
            $giftCard->message = 'APPROVED 682682 - test';
            $giftCard->code = '682682';
            $giftCard->cvv_result = 'P';
            $giftCard->avs_result = '';
            $giftCard->risk_code = '00';
            $giftCard->network_id = '10';
            $giftCard->is_purchase_card = '';
            $giftCard->order_number = 'NIR' . sprintf('%08s', $giftCard->id);
            $giftCard->save();

            $this->setPoolNumbers($giftCard);

        } else {
            // process payment
            try {
                $params = [
                    'total' => $giftCard->total,
                    'shipping' => $giftCard->shipping,
                    'orderId' => $giftCard->id, 
                    'ccnumber' => $request->ccnumber,
                    'expiration' => sprintf('%02d', (int)$request->ccexp_month) . substr($request->ccexp_year, -2),
                    'cvv' => $request->cvv,
                    'email' => $giftCard->email,
                    'name' => $giftCard->name,
                    'address1' => $giftCard->address,
                    'city' => $giftCard->city,
                    'state' => $giftCard->state,
                    'zip' => $giftCard->zip,
                    'country' => $giftCard->country
                ];

                $response = $sagePayHelper->processTransaction($params);
                if (!isset($response->status) || (string)$response->status !== 'Approved') {
                    if (isset($response->code) && isset($response->detail)) {
                        throw new \Exception('Error processing payment: ' . $response->detail . ' (' . $response->code . ')');
                    } else {
                        throw new \Exception(print_r($response, 1));
                    }
                }

                $giftCard->status = (string)$response->status;
                $giftCard->reference = (string)$response->reference;
                $giftCard->message = (string)$response->message;
                $giftCard->code = (string)$response->code;
                $giftCard->cvv_result = (string)$response->cvvResult;
                $giftCard->avs_result = (string)$response->avsResult;
                $giftCard->risk_code = (string)$response->riskCode;
                $giftCard->network_id = (string)$response->networkId;
                $giftCard->is_purchase_card = (string)$response->isPurchaseCard;
                $giftCard->order_number = (string)$response->orderNumber;
                $giftCard->save();

                $this->setPoolNumbers($giftCard);

            } catch (\Exception $ex) {
                throw $ex;
            }
        }

        return $giftCard;
    }

    private function setPoolNumbers(GiftCard $giftCard)
    {
        /**
         * @var Address $address
         */
        foreach ($giftCard->addresses()->get() as $address) {
            $address->pool_number = $address->getPoolNumber();
            $address->save();
        }
    }
}