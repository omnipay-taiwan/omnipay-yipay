<?php

namespace Omnipay\YiPAY\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\YiPAY\Traits\HasYiPAY;

class CompletePurchaseRequest extends PurchaseRequest
{
    use HasYiPAY;

    public function getData()
    {
        $data = $this->httpRequest->request->all();
        $data['merchantId'] = $this->getMerchantId();

        return array_merge($data, $this->getUrls($data));
    }

    /**
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        $type = (int) $data['type'];
        if ($type === 3) {
            $checkCode = $this->checkCode([
                'merchantId',
                'amount',
                'orderNo',
                'returnURL',
                'cancelURL',
                'backgroundURL',
                'transactionNo',
                'statusCode',
                'pinCode',
            ], $data);
        } else {
            $checkCode = $this->checkCode([
                'merchantId',
                'amount',
                'orderNo',
                'returnURL',
                'cancelURL',
                'backgroundURL',
                'transactionNo',
                'statusCode',
                'approvalCode',
            ], $data);
        }

        if (! hash_equals($checkCode, $data['checkCode'])) {
            throw new InvalidResponseException('Invalid check code');
        }

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
