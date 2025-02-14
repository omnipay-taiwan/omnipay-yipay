<?php

namespace Omnipay\YiPAY\Message;

use Omnipay\YiPAY\Traits\HasCVS;
use Omnipay\YiPAY\Traits\HasDefaults;
use Omnipay\YiPAY\Traits\HasYiPAY;

class PurchaseRequest extends AbstractRequest
{
    use HasYiPAY;
    use HasDefaults;
    use HasCVS;

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
            'timeout' => $this->getTimeout(),
            'validTime' => $this->getValidTime(),
            'timeoutURL' => $this->getTimeoutUrl(),
        ];

        if ($type === 3) {
            $data['expirationDay'] = $this->getExpirationDay();
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
