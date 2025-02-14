<?php

namespace Omnipay\YiPAY;

use Omnipay\Common\AbstractGateway;
use Omnipay\YiPAY\Message\AuthorizeRequest;
use Omnipay\YiPAY\Message\CompletePurchaseRequest;
use Omnipay\YiPAY\Message\PurchaseRequest;
use Omnipay\YiPAY\Traits\HasYiPAY;

/**
 * YiPAY Gateway
 */
class Gateway extends AbstractGateway
{
    use HasYiPAY;

    public function getName()
    {
        return 'YiPAY';
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
}
