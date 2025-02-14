<?php

namespace Omnipay\YiPay\Message;

use Omnipay\YiPay\Traits\HasDefaults;
use Omnipay\YiPay\Traits\HasYiPay;

class FetchTransactionRequest extends AbstractRequest
{
    use HasYiPay;
    use HasDefaults;

    public function getData()
    {
        return [
            'merchantId' => $this->getMerchantId(),
            'type' => $this->getType(),
            'amount' => (string) ((int) $this->getAmount()),
            'orderNo' => $this->getTransactionId(),
        ];
    }

    public function sendData($data)
    {
        $data['checkCode'] = $this->checkCode(['merchantId', 'amount', 'orderNo'], $data);

        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint().'/paymentCheck',
            ['content-type' => 'application/x-www-form-urlencoded'],
            http_build_query($data)
        );

        return $this->response = new CompletePurchaseResponse(
            $this,
            json_decode((string) $response->getBody(), true)
        );
    }
}
