<?php

namespace Omnipay\YiPay\Message;

class GetPaymentInfoResponse extends CompletePurchaseResponse
{
    public function getReply()
    {
        return 'OK';
    }
}
