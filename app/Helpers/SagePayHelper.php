<?php

namespace App\Helpers;

use App\Services\PaymentGatewayService;

/**
 * Class SagePayHelper
 * @package App\Helpers
 * @author Plamen Markov <plamen@lynxlake.org>
 * @description Based on: https://github.com/SagePayments/Direct-API/blob/master/php/shared.php
 */
class SagePayHelper
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
     * @param array $params
     * @return mixed
     * @description https://developer.sagepayments.com/bankcard/apis
     */
    public function processTransaction(array $params)
    {
        $credentials = $this->service->credentials();

        // you (or your client's) merchant credentials.
        // grab a test account from us for development!
        $MERCHANT_ID = $credentials[0]->value;
        $MERCHANT_KEY = $credentials[1]->value;

        // your application's credentials
        $DEVELOPER_ID = $credentials[2]->value;
        $DEVELOPER_KEY = $credentials[3]->value;

        // data validation
        $fields = ['total', 'shipping', 'orderId', 'ccnumber', 'expiration', 'cvv', 'email', 'name', 'address1', 'city', 'state', 'zip'];
        foreach ($fields as $field) {
            if (empty($params[$field])) {
                throw new \InvalidArgumentException('The `' . $field . '` field is missing.');
            }
        }

        // the nonce can be any unique identifier -- guids and timestamps work well
        $nonce = uniqid();

        // a standard unix timestamp. a request must be received within 60s
        // of its timestamp header.
        $timestamp = (string)time();

        // setting up the request data itself
        $verb = "POST";
        $url = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale";
        $requestData = [
            // complete reference material is available on the dev portal: https://developer.sagepayments.com/apis
            "eCommerce" => [
                "amounts" => [
                    "tax" => 0,
                    "total" => (float)$params['total'],
                    "shipping" => (float)$params['shipping'],
                ],
                "orderNumber" => 'NIR' . sprintf('%08s', $params['orderId']),
                "cardData" => [
                    "number" => $params['ccnumber'],
                    "expiration" => $params['expiration'],
                    "cvv" => $params['cvv']
                ],
                "customer" => [
                    "email" => $params['email']
                ],
                "billing" => [
                    "name" => $params['name'],
                    "address" => $params['address1'],
                    "city" => $params['city'],
                    "state" => $params['state'],
                    "postalCode" => $params['zip'],
                    "country" => (isset($params['country'])) ? $params['country'] : 'US',
                ],
                "level2" => [
                    "customerNumber" => $params['orderId']
                ]
            ]
        ];
        // convert to json for transport
        $payload = json_encode($requestData);
        // the request is authorized via an HMAC header that we generate by
        // concatenating certain info, and then hashing it using our client key
        $toBeHashed = $verb . $url . $payload . $MERCHANT_ID . $nonce . $timestamp;
        $hmac = $this->getHmac($toBeHashed, $DEVELOPER_KEY);
        // ok, let's make the request! cURL is always an option, of course,
        // but I find that file_get_contents is a bit more intuitive.
        $config = [
            "http" => [
                "header" => [
                    "clientId: " . $DEVELOPER_ID,
                    "merchantId: " . $MERCHANT_ID,
                    "merchantKey: " . $MERCHANT_KEY,
                    "nonce: " . $nonce,
                    "timestamp: " . $timestamp,
                    "authorization: " . $hmac,
                    "content-type: application/json",
                ],
                "method" => $verb,
                "content" => $payload,
                "ignore_errors" => true // exposes response body on 4XX errors
            ]
        ];
        $context = stream_context_create($config);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result);

        if (isset($response->code) && isset($code->detail)) {
            throw new \RuntimeException($response->detail . ' (' . $response->code . ').');
        }

        return $response;
    }

    private function getHmac($toBeHashed, $privateKey)
    {
        $hmac = hash_hmac(
            "sha512", // use the SHA-512 algorithm...
            $toBeHashed, // ... to hash the combined string...
            $privateKey, // .. using your private dev key to sign it.
            true // (php returns hexits by default; override this)
        );
        // convert to base-64 for transport
        $hmac_b64 = base64_encode($hmac);

        return $hmac_b64;
    }

}




