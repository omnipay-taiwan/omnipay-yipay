<?php

namespace Omnipay\YiPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\YiPay\Message\AcceptNotificationRequest;
use Omnipay\YiPay\Message\CompletePurchaseRequest;
use Omnipay\YiPay\Message\FetchTransactionRequest;
use Omnipay\YiPay\Message\GetPaymentInfoRequest;
use Omnipay\YiPay\Message\PurchaseRequest;
use Omnipay\YiPay\Traits\HasYiPay;

/**
 * YiPay Gateway
 */
class Gateway extends AbstractGateway
{
    use HasYiPay;

    public function getName()
    {
        return 'YiPay';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'key' => '',
            'iv' => '',
            'testMode' => false,
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function acceptNotification(array $options = [])
    {
        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function fetchTransaction(array $options = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    public function getPaymentInfo(array $options = [])
    {
        return $this->createRequest(GetPaymentInfoRequest::class, $options);
    }
}
