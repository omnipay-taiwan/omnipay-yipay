<?php

namespace Omnipay\YiPAY\Tests\Message;

use Omnipay\Common\CreditCard;
use Omnipay\YiPAY\Message\AuthorizeRequest;
use Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /**
     * @var AuthorizeRequest
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'amount' => '10.00',
            'currency' => 'USD',
            'card' => $this->getValidCard(),
        ]);
    }

    public function testGetData()
    {
        $card = new CreditCard($this->getValidCard());
        $card->setStartMonth(1);
        $card->setStartYear(2000);

        $this->request->setCard($card);
        $this->request->setTransactionId('abc123');

        $data = $this->request->getData();

        $this->assertSame('abc123', $data['transaction_id']);

        $this->assertSame($card->getExpiryDate('mY'), $data['expire_date']);
        $this->assertSame('012000', $data['start_date']);
    }
}
