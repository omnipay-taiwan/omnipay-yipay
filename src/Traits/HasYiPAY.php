<?php

namespace Omnipay\YiPAY\Traits;

use Omnipay\YiPAY\Hasher;

trait HasYiPAY
{
    /**
     * 取得商家編號
     *
     * @return ?string 商家編號
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    /**
     * 設定商家編號
     *
     * @param  string  $value  商家於 YiPay 系統的代號 (Int, 長度: 10)
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    public function setIv($value)
    {
        return $this->setParameter('iv', $value);
    }

    public function getIv()
    {
        return $this->getParameter('iv');
    }

    public function checkCode($keys, $data)
    {
        $signed = [];
        foreach ($keys as $key) {
            $signed[$key] = $data[$key];
        }

        return (new Hasher($this->getKey(), $this->getIv()))->make($signed);
    }
}
