<?php

namespace Omnipay\YiPAY;

use phpseclib3\Crypt\AES;

class Hasher
{
    /** @var AES */
    private $cipher;

    public function __construct(string $key, string $iv)
    {
        $this->cipher = new AES('cbc');
        $this->cipher->setKey(base64_decode($key));
        $this->cipher->setIV(base64_decode($iv));
    }

    public function make(array $parameters): string
    {
        return sha1(base64_encode($this->cipher->encrypt(json_encode(
            $parameters,
            JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ))));
    }
}
