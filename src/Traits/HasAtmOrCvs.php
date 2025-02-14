<?php

namespace Omnipay\YiPay\Traits;

trait HasAtmOrCvs
{
    /**
     * 設定繳款截止日期
     *
     * @param  int  $value  訂單繳款天數限制，範圍為 1~3 天，如未設定則預設為 2
     */
    public function setExpirationDay($value)
    {
        $this->setParameter('expirationDay', $value);
    }

    /**
     * 取得繳款截止日期
     *
     * @return int|null 繳款截止日期
     */
    public function getExpirationDay()
    {
        return $this->getParameter('expirationDay');
    }
}
