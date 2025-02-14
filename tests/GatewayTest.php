<?php

namespace Omnipay\YiPAY\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\YiPAY\Gateway;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ]);
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase([
            'amount' => '1500',
            'transaction_id' => 'YP2016111503353',
            'returnUrl' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelUrl' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'notifyUrl' => 'https://gateway-test.yipay.com.tw/demo/background',
        ])->send();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
    }
}
