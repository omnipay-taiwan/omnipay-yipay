<?php

namespace Omnipay\YiPay\Tests;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\YiPay\Gateway;

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
            'checkCode' => '4894f133d4a7f0dc0a5d41c77b0157fe4023dbdd',
        ]);

        $response = $this->gateway->completePurchase([
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
        ])->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('00', $response->getCode());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('YP2016111503353', $response->getTransactionId());
        self::assertEquals('C0216111500000000001', $response->getTransactionReference());
    }


    public function testAcceptNotification()
    {
        $this->getHttpRequest()->request->replace([
            'merchantId' => '1604000006',
            'type' => '4',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'transactionNo' => 'C0216111500000000001',
            'statusCode' => '00',
            'account' => '63167185726653',
            'checkCode' => '1bfe1bd1c8289c65367fa28eeb267b83cc361f91',
        ]);

        $request = $this->gateway->acceptNotification([
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
        ]);

        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals('YP2016111503353', $request->getTransactionId());
        self::assertEquals('C0216111500000000001', $request->getTransactionReference());
        self::assertEquals('OK', $request->getReply());
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
