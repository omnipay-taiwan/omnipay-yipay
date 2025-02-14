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
            'notifyUrl' => 'https://gateway-test.yipay.com.tw/demo/notify',
        ])->send();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
    }

    public function testCompletePurchase()
    {
        $this->getHttpRequest()->request->replace([
            'merchantId' => '1604000006',
            'type' => '2',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'transactionNo' => 'C0216111500000000001',
            'statusCode' => '00',
            'statusMessage' => '成功',
            'approvalCode' => '629540',
            'last4CardNumber' => '2222',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
            'checkCode' => 'd1bae877675e505b806a7fbd6f9f5105e495640b',
        ]);

        $response = $this->gateway->completePurchase()->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('00', $response->getCode());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('YP2016111503353', $response->getTransactionId());
        self::assertEquals('C0216111500000000001', $response->getTransactionReference());
    }

    public function testGetPaymentInfo()
    {
        $this->getHttpRequest()->request->replace([
            'merchantId' => '1604000006',
            'type' => '3',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'transactionNo' => 'C0216111500000000001',
            'statusCode' => '00',
            'pinCode' => '1550D0332H2902',
            'checkCode' => 'eef416eec27026d62d0aa519bda9f91e142c8a6d',
        ]);
        $response = $this->gateway->getPaymentInfo([
            'notifyUrl' => 'https://gateway-test.yipay.com.tw/demo/notify',
            'cancelUrl' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'paymentInfoUrl' => 'https://gateway-test.yipay.com.tw/demo/payment-info',
        ])->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('OK', $response->getReply());
    }
}
