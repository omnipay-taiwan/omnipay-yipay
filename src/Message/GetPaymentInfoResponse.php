<?php

namespace Omnipay\YiPAY\Message;

class GetPaymentInfoResponse extends CompletePurchaseResponse
{
    public function getReply()
    {
        return 'OK';
    }
}
