<?php

namespace Omnipay\YiPay\Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\YiPay\Message\PurchaseRequest;

class PurchaseRequestTest extends TestCase
{
    public function testGetCreditCardData()
    {
        $options = [
            'type' => '2',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'orderDescription' => 'Order Description',
            'orderNote1' => 'Order Note 1',
            'orderNote2' => 'Order Note 2',
            'notificationEmail' => 'foo@bar.com',
            'timeout' => 28800,
            'validTime' => '202001011330',
            'timeoutURL' => 'https://gateway-test.yipay.com.tw/demo/timeout',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ], $options));
        $request->setReturnUrl('https://gateway-test.yipay.com.tw/demo/return');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');

        self::assertEquals(array_merge($options, [
            'merchantId' => '1604000006',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
        ]), $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testGetCreditCardData
     *
     * @param  array  $results
     */
    public function testSendCreditCardData($results)
    {
        [$response] = $results;

        $redirectData = $response->getRedirectData();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals('https://gateway-test.yipay.com.tw/payment', $response->getRedirectUrl());
        self::assertNotEmpty($redirectData['checkCode']);
    }

    public function testGetCVSData()
    {
        $options = [
            'type' => '3',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'orderDescription' => 'Order Description',
            'orderNote1' => 'Order Note 1',
            'orderNote2' => 'Order Note 2',
            'expirationDay' => '2',
            'notificationEmail' => 'foo@bar.com',
            'timeout' => 28800,
            'validTime' => '202001011330',
            'timeoutURL' => 'https://gateway-test.yipay.com.tw/demo/timeout',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ], $options));
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setPaymentInfoUrl('https://gateway-test.yipay.com.tw/demo/payment-info');

        self::assertEquals(array_merge($options, [
            'merchantId' => '1604000006',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/payment-info',
        ]), $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testGetCVSData
     *
     * @param  array  $results
     */
    public function testSendCVSData($results)
    {
        [$response] = $results;

        $redirectData = $response->getRedirectData();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals('https://gateway-test.yipay.com.tw/payment', $response->getRedirectUrl());
        self::assertNotEmpty($redirectData['checkCode']);
    }

    public function testGetATMData()
    {
        $options = [
            'type' => '4',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'orderDescription' => 'Order Description',
            'orderNote1' => 'Order Note 1',
            'orderNote2' => 'Order Note 2',
            'expirationDay' => '2',
            'notificationEmail' => 'foo@bar.com',
            'timeout' => 28800,
            'validTime' => '202001011330',
            'timeoutURL' => 'https://gateway-test.yipay.com.tw/demo/timeout',
        ];
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ], $options));
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setPaymentInfoUrl('https://gateway-test.yipay.com.tw/demo/payment-info');

        self::assertEquals(array_merge($options, [
            'merchantId' => '1604000006',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/notify',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/payment-info',
        ]), $request->getData());

        return [$request->send(), $options];
    }
}
