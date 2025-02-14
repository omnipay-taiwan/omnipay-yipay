<?php

namespace Omnipay\YiPay\Tests\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Tests\TestCase;
use Omnipay\YiPay\Message\AcceptNotificationRequest;

class AcceptNotificationRequestTest extends TestCase
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

        $request = new AcceptNotificationRequest($this->getHttpClient(), $httpRequest);
        $request->initialize([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ]);
        $request->setReturnUrl('https://gateway-test.yipay.com.tw/demo/return');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');

        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('YP2016111503353', $request->getTransactionId());
        self::assertEquals('C0216111500000000001', $request->getTransactionReference());
        self::assertEquals('OK', $request->getReply());
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

        $request = new AcceptNotificationRequest($this->getHttpClient(), $httpRequest);
        $request->initialize([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ]);
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setPaymentInfoUrl('https://gateway-test.yipay.com.tw/demo/payment-info');

        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals('YP2016111503353', $request->getTransactionId());
        self::assertEquals('C0216111500000000001', $request->getTransactionReference());
        self::assertEquals('OK', $request->getReply());
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
            'checkCode' => '23b685ff8857b5d1c9e7e29bc81d19db09c328a3',
        ]);

        $request = new AcceptNotificationRequest($this->getHttpClient(), $httpRequest);
        $request->initialize([
            'merchantId' => '1604000006',
            'key' => 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0',
            'iv' => 'YeQInQjfelvkBcWuyhWDAw==',
            'testMode' => true,
        ]);
        $request->setNotifyUrl('https://gateway-test.yipay.com.tw/demo/notify');
        $request->setCancelUrl('https://gateway-test.yipay.com.tw/demo/cancel');
        $request->setPaymentInfoUrl('https://gateway-test.yipay.com.tw/demo/payment-info');

        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals('YP2016111503353', $request->getTransactionId());
        self::assertEquals('C0216111500000000001', $request->getTransactionReference());
        self::assertEquals('OK', $request->getReply());
    }
}
