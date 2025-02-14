<?php

namespace Omnipay\YiPay\Message;

use Omnipay\YiPay\Traits\HasAtmOrCvs;
use Omnipay\YiPay\Traits\HasDefaults;
use Omnipay\YiPay\Traits\HasYiPay;

class PurchaseRequest extends AbstractRequest
{
    use HasYiPay;
    use HasDefaults;
    use HasAtmOrCvs;

    public function getData()
    {
        $this->validate('amount', 'transactionId');

        $type = (int) ($this->getType() ?: 2);
        $data = [
            'merchantId' => $this->getMerchantId(),
            'type' => $type,
            'amount' => (string) ((int) $this->getAmount()),
            'orderNo' => $this->getTransactionId(),
            'orderDescription' => $this->getDescription(),
            'orderNote1' => $this->getOrderNote1(),
            'orderNote2' => $this->getOrderNote2(),
            'notificationEmail' => $this->getNotificationEmail(),
            'timeout' => $this->getTimeout() ?: '0',
            'validTime' => $this->getValidTime(),
            'timeoutURL' => $this->getTimeoutUrl(),
        ];

        if (in_array($type, [3, 4], true)) {
            $data['expirationDay'] = $this->getExpirationDay() ?: '2';
        }

        return array_filter(array_merge($data, $this->getUrls($data)), static function ($value) {
            return $value !== null;
        });
    }

    public function sendData($data)
    {
        $data['checkCode'] = $this->checkCode([
            'merchantId', 'amount', 'orderNo', 'returnURL', 'cancelURL', 'backgroundURL',
        ], $data);

        return $this->response = new PurchaseResponse($this, $data);
    }
}
