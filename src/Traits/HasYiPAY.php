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

    /**
     * 取得背景回傳網址
     *
     * @return string|null 背景回傳網址
     */
    public function getBackgroundURL()
    {
        return $this->getNotifyUrl();
    }

    /**
     * 設定背景回傳網址
     *
     * @param  string  $value  交易完成後 YiPay 以背景方式 POST 回傳結果的網址
     */
    public function setBackgroundURL($value)
    {
        return $this->setNotifyUrl($value);
    }

    public function setPaymentInfoUrl($value)
    {
        $this->setParameter('paymentInfoUrl', $value);
    }

    public function getPaymentInfoUrl()
    {
        return $this->getParameter('paymentInfoUrl');
    }

    public function checkCode($keys, $data)
    {
        $signed = [];
        foreach ($keys as $key) {
            $signed[$key] = $data[$key];
        }

        return (new Hasher($this->getKey(), $this->getIv()))->make($signed);
    }

    protected function getUrls($data)
    {
        $type = (int) $data['type'];

        if ($type === 3) {
            return [
                'returnURL' => $this->getNotifyUrl(),
                'cancelURL' => $this->getCancelUrl(),
                'backgroundURL' => $this->getPaymentInfoUrl(),
            ];
        }

        return [
            'returnURL' => $this->getReturnUrl(),
            'cancelURL' => $this->getCancelUrl(),
            'backgroundURL' => $this->getNotifyUrl(),
        ];
    }
}
