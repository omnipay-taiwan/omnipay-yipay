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

    public function testCompletePurchase()
    {
        // 1 merchantId 商家編號 Int
        // 2 type 付款方式 Int 參閱《附錄 C. 付款方式》
        // 3 amount 交易金額 Int
        // 4 orderNo 商家訂單編號 String 商家傳送至乙禾的自訂訂單編號
        // 5 transactionNo 交易編號 String 乙禾系統的交易編號
        // 6 statusCode 交易回覆代碼 String 00 代表成功，其餘皆為失敗
        // 7 statusMessage 交易回覆訊息 String 授權代碼說明
        // 8 approvalCode 授權碼 String
        // 9 last4CardNumber 卡號末四碼 Int 信用卡號末四碼
        // 10 checkCode 檢查碼 String 參閱下方檢查碼組成參數
        // 序號 名稱 描述 範例
        // 1 merchantId 商家編號 1604000006
        // 2 amount 交易金額 1500
        // 3 orderNo 商家訂單編號 YP2016111503353
        // 8 乙禾網絡有限公司

        $this->getHttpRequest()->request->add([
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
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/background',
            'checkCode' => '5a39b9c01f1f6dec16c692034081759b4d37c9aa',
        ]);

        $response = $this->gateway->completePurchase()->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('00', $response->getCode());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('YP2016111503353', $response->getTransactionId());
        self::assertEquals('C0216111500000000001', $response->getTransactionReference());
    }
}
