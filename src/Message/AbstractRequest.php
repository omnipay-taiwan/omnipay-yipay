<?php

namespace Omnipay\YiPay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://gateway.yipay.com.tw/payment';

    protected $testEndpoint = 'https://gateway-test.yipay.com.tw/payment';

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
