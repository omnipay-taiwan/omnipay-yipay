<?php

namespace Omnipay\YiPay\Tests\Message;

use Omnipay\Tests\TestCase;
use Omnipay\YiPay\Message\GetPaymentInfoRequest;

class GetPaymentInfoRequestTest extends TestCase
{
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

        $request = new GetPaymentInfoRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
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
        self::assertEquals('OK', $response->getReply());
    }

    public function testSendATMData()
    {
        $httpRequest = $this->getHttpRequest();
        $httpRequest->request->replace([
            'merchantId' => '1604000006',
            'type' => '4',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'transactionNo' => 'C0216111500000000001',
            'statusCode' => '00',
            'account' => '63167185726653',
            'bankCode' => '822',
            'bankName' => '中國信託商業銀行',
            'bankBranchCode' => '0015',
            'bankBranchName' => '商業銀行敦北分行',
            'expirationDate' => '2025-01-01',
            'checkCode' => '23b685ff8857b5d1c9e7e29bc81d19db09c328a3',
        ]);

        $request = new GetPaymentInfoRequest($this->getHttpClient(), $httpRequest);
        $request->initialize(array_merge([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
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
        self::assertEquals('OK', $response->getReply());
    }
}
