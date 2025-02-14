<?php

namespace Omnipay\YiPay\Message;

class GetPaymentInfoRequest extends CompletePurchaseRequest
{
    public function sendData($data)
    {
        return $this->response = new GetPaymentInfoResponse($this, $data);
    }
}
