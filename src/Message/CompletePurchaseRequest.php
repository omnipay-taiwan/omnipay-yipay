<?php

namespace Omnipay\YiPAY\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\YiPAY\Traits\HasYiPAY;

class CompletePurchaseRequest extends PurchaseRequest
{
    use HasYiPAY;

    public function getData()
    {
        return $this->httpRequest->request->all();
    }

    /**
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
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

        if (! hash_equals($checkCode, $data['checkCode'])) {
            throw new InvalidResponseException('Invalid check code');
        }

        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
