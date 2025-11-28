<?php

namespace Omnipay\YiPay\Traits;

trait HasAtmOrCvs
{
    /**
     * 設定繳款截止日期
     *
     * @param  int  $value  訂單繳款天數限制
     *                      超商代碼繳費(type=3): 1~3 天，預設 2 天
     *                      ATM虛擬帳號(type=4): 1~7 天，預設 7 天
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
