<?php

namespace Omnipay\YiPAY\Tests;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\YiPAY\Gateway;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    private $options = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        ];
    }

    public function testAuthorize()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1234', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
