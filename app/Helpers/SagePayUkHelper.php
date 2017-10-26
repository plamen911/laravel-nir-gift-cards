<?php

namespace App\Helpers;
use Psr\Log\InvalidArgumentException;

/**
 * Class SagePayUkHelper
 * @package App\Helpers
 * @author Plamen Markov <plamen@lynxlake.org>
 * @description Based on: https://test.sagepay.com/documentation/?php#card-identifiers
 */
class SagePayUkHelper
{
    private $vendorName;
    private $integrationKey;
    private $integrationPassword;

    /**
     * SagePayUkHelper constructor.
     */
    public function __construct()
    {
        $this->vendorName = 'sandbox';
        $this->integrationKey = 'hJYxsw7HLbj40cB8udES8CDRFLhuJ8G54O6rDpUXvE6hYDrria';
        $this->integrationPassword = 'o2iHSrFybYMZpmWOQMuhsXP52V4fBtpuSDshrKDSWsBY1OiN6hwd9Kb12z4j5Us5u';
    }

    /**
     * @param array $params
     * @return \stdClass
     */
    public function processTransaction(array $params)
    {
        // data validation
        $fields = ['cardholderName', 'cardNumber', 'expiryDate', 'securityCode', 'vendorTxCode', 'amount', 'description', 'customerFirstName', 'customerLastName', 'address1', 'city', 'state', 'postalCode', 'country'];
        foreach ($fields as $field) {
            if (empty($params[$field])) {
                throw new InvalidArgumentException('The `' . $field . '` field is missing.');
            }
        }

        try {
            $merchantSessionKey = $this->createMerchantSessionKey();
            $cardIdentifier = $this->createCardIdentifier($merchantSessionKey, $params['cardholderName'], $params['cardNumber'], $params['expiryDate'], $params['securityCode']);
        } catch (\RuntimeException $ex) {
            throw $ex;
        }

        $curl = curl_init();

        $payload = [
            'transactionType' => 'Payment',
            'paymentMethod' => [
                'card' => [
                    'merchantSessionKey' => $merchantSessionKey,
                    'cardIdentifier' => $cardIdentifier,
                    'save' => 'false'
                ]
            ],
            'vendorTxCode' => $params['vendorTxCode'],
            'amount' => (float)$params['amount'],
            'currency' => 'USD',    // USD currency is not supported on this test account.
            'description' => (isset($params['description'])) ? $params['description'] : '',
            'apply3DSecure' => 'UseMSPSetting',
            'customerFirstName' => $params['customerFirstName'],
            'customerLastName' => $params['customerLastName'],
            'billingAddress' => [
                'address1' => $params['address1'],
                'city' => $params['city'],
                'state' => $params['state'],
                'postalCode' => $params['postalCode'],
                'country' => (isset($params['country'])) ? $params['country'] : 'US',
            ],
            'entryMethod' => 'Ecommerce'
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://pi-live.sagepay.com/api/v1/transactions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->integrationKey . ':' . $this->integrationPassword),
                'Cache-Control: no-cache',
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if (!empty($err)) {
            throw new \RuntimeException($err);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ((int)$httpCode !== 201) {
            throw new \RuntimeException($this->getErrorMessage($httpCode, $response), $httpCode);
        }

        curl_close($curl);

        return json_decode($response);
    }

    /**
     * @return string
     */
    private function createMerchantSessionKey()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://pi-live.sagepay.com/api/v1/merchant-session-keys',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{ "vendorName": "' . $this->vendorName . '" }',
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode($this->integrationKey . ':' . $this->integrationPassword),
                'Cache-Control: no-cache',
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if (!empty($err)) {
            throw new \RuntimeException($err);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ((int)$httpCode !== 201) {
            throw new \RuntimeException($this->getErrorMessage($httpCode, $response), $httpCode);
        }

        curl_close($curl);

        $json = json_decode($response);

        return (string)$json->merchantSessionKey;
    }

    /**
     * @param string $merchantSessionKey
     * @param string $cardholderName
     * @param string $cardNumber
     * @param string $expiryDate
     * @param string $securityCode
     * @return string
     * @throws \RuntimeException
     */
    private function createCardIdentifier($merchantSessionKey, $cardholderName, $cardNumber, $expiryDate, $securityCode)
    {
        $curl = curl_init();

        $payload = [
            'cardDetails' => [
                'cardholderName' => $cardholderName,
                'cardNumber' => $cardNumber,
                'expiryDate' => $expiryDate,
                'securityCode' => $securityCode
            ]
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://pi-live.sagepay.com/api/v1/card-identifiers',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $merchantSessionKey,
                'Cache-Control: no-cache',
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if (!empty($err)) {
            throw new \RuntimeException($err);
        }
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ((int)$httpCode !== 201) {
            throw new \RuntimeException($this->getErrorMessage($httpCode, $response), $httpCode);
        }

        curl_close($curl);

        $json = json_decode($response);

        return (string)$json->cardIdentifier;
    }

    /**
     * @param string $httpCode
     * @param string $response
     * @return string
     */
    private function getErrorMessage($httpCode, $response = '')
    {
        if (!empty($response)) {
            $json = json_decode($response);
            if (isset($json->errors[0]->clientMessage)) {
                return $json->errors[0]->clientMessage;
            }
            if (isset($json->statusDetail)) {
                return $json->statusDetail;
            }
        }

        $messages = [
            '200' => 'OK - Success! Everything worked as expected',
            '201' => 'Created - Success! Everything worked as expected and a new resource has been created',
            '202' => 'Accepted - The request has been accepted for processing, but the processing has not been completed',
            '204' => 'No Content - The request has been successfully processed and is not returning any content',
            '400' => 'Bad Request - The request could not be understood, generally a malformed body',
            '401' => 'Unauthorised - Authentication credentials are missing or incorrect',
            '403' => 'Forbidden - The request was formed correctly but is unsuccessful. Usually returned when a transaction request is declined or rejected',
            '404' => 'Not Found - The resource does not exist',
            '405' => 'Method Not Allowed - The method requested is not permitted against this resource',
            '408' => 'Request Timeout - Request timeout',
            '422' => 'Unprocessable Entity - The request was well-formed but contains invalid values or missing properties',
            '500' => 'Server Error - An issue occurred at Sage Pay',
            '502' => 'Bad Gateway - An issue occurred at Sage Pay'
        ];

        return (isset($messages[$httpCode])) ? $messages[$httpCode] . ' (' . $httpCode . ')' : 'Unknown error (' . $httpCode . ')';
    }

}