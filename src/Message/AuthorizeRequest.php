<?php

namespace Omnipay\YiPAY\Message;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();

        return $this->getBaseData();
    }
}
