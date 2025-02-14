<?php

namespace Omnipay\YiPAY\Message;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getCode() === '00';
    }

    public function getCode()
    {
        return $this->data['statusCode'];
    }

    public function getMessage()
    {
        return $this->data['statusMessage'];
    }

    public function getTransactionId()
    {
        return $this->data['orderNo'];
    }

    public function getTransactionReference()
    {
        return $this->data['transactionNo'];
    }
}
