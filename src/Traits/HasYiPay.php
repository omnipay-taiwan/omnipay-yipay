<?php

namespace Omnipay\YiPay\Traits;

use Omnipay\YiPay\Hasher;

trait HasYiPay
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

    public function getIv()
    {
        return $this->getParameter('iv');
    }

    public function setIv($value)
    {
        return $this->setParameter('iv', $value);
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

    protected function getUrls($data)
    {
        $type = (int) $data['type'];
        $cancelUrl = $this->getCancelUrl() ?: $this->getReturnUrl();

        if (in_array($type, [3, 4], true) && ! empty($this->getPaymentInfoUrl())) {
            return [
                'returnURL' => $this->getNotifyUrl(),
                'cancelURL' => $cancelUrl,
                'backgroundURL' => $this->getPaymentInfoUrl(),
            ];
        }

        return [
            'returnURL' => $this->getReturnUrl(),
            'cancelURL' => $cancelUrl,
            'backgroundURL' => $this->getNotifyUrl(),
        ];
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
