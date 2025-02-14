<?php

namespace Omnipay\YiPAY\Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\YiPAY\Message\PurchaseRequest;

class PurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $options = [
            'type' => '2',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'orderDescription' => 'Order Description',
            'orderNote1' => 'Order Note 1',
            'orderNote2' => 'Order Note 2',
            'notificationEmail' => 'foo@bar.com',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/background',
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

        self::assertEquals(array_merge($options, [
            'merchantId' => '1604000006',
        ]), $request->getData());

        return [$request->send(), $options];
    }

    /**
     * @depends testGetData
     *
     * @param  array  $results
     */
    public function testSendData($results)
    {
        [$response] = $results;

        $redirectData = $response->getRedirectData();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals('https://gateway-test.yipay.com.tw/payment', $response->getRedirectUrl());
        self::assertNotEmpty($redirectData['checkCode']);
    }
}
