<?php

namespace Omnipay\YiPAY\Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\YiPAY\Message\CompletePurchaseRequest;

class CompletePurchaseRequestTest extends TestCase
{
    public function testSendCreditCardData()
    {
        $httpRequest = $this->getHttpRequest();
        $httpRequest->request->replace([
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

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->initialize([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ]);
        $request->setReturnUrl('https://gateway-test.yipay.com.tw/demo/return');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');

        $response = $request->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('00', $response->getCode());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('YP2016111503353', $response->getTransactionId());
        self::assertEquals('C0216111500000000001', $response->getTransactionReference());
    }

    public function testSendCVSData()
    {
        $httpRequest = $this->getHttpRequest();
        $httpRequest->request->replace([
            'merchantId' => '1604000006',
            'type' => '3',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'transactionNo' => 'C0216111500000000001',
            'statusCode' => '00',
            'pinCode' => '1550D0332H2902',
            'checkCode' => 'eef416eec27026d62d0aa519bda9f91e142c8a6d',
        ]);

        $request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ], [
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/payment-info',
        ]));
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setPaymentInfoUrl('https://gateway-test.yipay.com.tw/demo/payment-info');

        $response = $request->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('00', $response->getCode());
        self::assertNull($response->getMessage());
        self::assertEquals('YP2016111503353', $response->getTransactionId());
        self::assertEquals('C0216111500000000001', $response->getTransactionReference());
    }
}
