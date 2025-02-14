<?php

namespace Omnipay\YiPay\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\YiPay\Traits\HasYiPay;

class CompletePurchaseRequest extends PurchaseRequest
{
    use HasYiPay;

    /**
     * @throws InvalidResponseException
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $data['merchantId'] = $this->getMerchantId();
        $data = array_merge($data, $this->getUrls($data));

        if (array_key_exists('transactionNo', $data)) {
            $checkCode = $this->checkCode($this->getSignedKeys((int) $data['type']), $data);

            if (! hash_equals($checkCode, $data['checkCode'])) {
                throw new InvalidResponseException('Invalid check code');
            }
        }


        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    private function getSignedKeys(int $type)
    {
        $keys = [
            'merchantId',
            'amount',
            'orderNo',
            'returnURL',
            'cancelURL',
            'backgroundURL',
            'transactionNo',
            'statusCode',
        ];
        $lookup = [3 => 'pinCode', 4 => 'account'];
        $keys[] = array_key_exists($type, $lookup) ? $lookup[$type] : 'approvalCode';

        return $keys;
    }
}
