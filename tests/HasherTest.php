<?php

namespace Omnipay\YiPAY\Tests;

use Omnipay\YiPAY\Hasher;
use PHPUnit\Framework\TestCase;

class HasherTest extends TestCase
{
    public function testMakeHash(): void
    {
        $key = 'zBaw7bzzD8K1THSGoIbev08xEJp5yzyeuv1MWJDR2L0';
        $iv = 'YeQInQjfelvkBcWuyhWDAw==';

        $param = [
            'merchantId' => '1604000006',
            'amount' => '1500',
            'orderNo' => 'YP2016111503353',
            'returnURL' => 'https://gateway-test.yipay.com.tw/demo/return',
            'cancelURL' => 'https://gateway-test.yipay.com.tw/demo/cancel',
            'backgroundURL' => 'https://gateway-test.yipay.com.tw/demo/background',
        ];
        $hasher = new Hasher($key, $iv);

        self::assertEquals('39c57c59f2ee2c71278dc75eebb190e5b4145e1f', $hasher->make($param));
    }
}
