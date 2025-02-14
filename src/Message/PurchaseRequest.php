<?php

namespace Omnipay\YiPAY\Message;

use Omnipay\YiPAY\Traits\HasYiPAY;

class PurchaseRequest extends AbstractRequest
{
    use HasYiPAY;

    /**
     * 取得付款方式
     *
     * @return int|null 付款方式
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * 設定付款方式
     *
     * 1 信用卡付款
     * 2 信用卡 3D 付款
     * 3 超商代碼繳費
     * 4 ATM 虛擬帳號繳款
     *
     * @param  int  $value  付款方式 (Int, 長度: 1, 參閱《附錄 C. 付款方式》)
     */
    public function setType($value)
    {
        $this->setParameter('type', $value);
    }

    /**
     * 取得商家訂單編號
     *
     * @return string|null 商家訂單編號
     */
    public function getOrderNo()
    {
        return $this->getTransactionId();
    }

    /**
     * 設定商家訂單編號
     *
     * @param  string  $value  商家自訂的訂單編號 (String, 長度: 20, 唯一值不可重複)
     */
    public function setOrderNo($value)
    {
        $this->setTransactionId($value);
    }

    /**
     * 取得交易內容
     *
     * @return string|null 交易內容
     */
    public function getOrderDescription()
    {
        return $this->getDescription();
    }

    /**
     * 設定交易內容
     *
     * @param  string  $value  消費者購買內容 (String, 長度: 200)
     */
    public function setOrderDescription($value)
    {
        $this->setDescription($value);
    }

    /**
     * 取得交易備註 1
     *
     * @return string|null 交易備註 1
     */
    public function getOrderNote1()
    {
        return $this->getParameter('orderNote1');
    }

    /**
     * 設定交易備註 1
     *
     * @param  string  $value  商家自定義 1 (String, 長度: 200)
     */
    public function setOrderNote1($value)
    {
        $this->setParameter('orderNote1', $value);
    }

    /**
     * 取得交易備註 2
     *
     * @return string|null 交易備註 2
     */
    public function getOrderNote2()
    {
        return $this->getParameter('orderNote2');
    }

    /**
     * 設定交易備註 2
     *
     * @param  string  $value  商家自定義 2 (String, 長度: 200)
     */
    public function setOrderNote2($value)
    {
        $this->setParameter('orderNote2', $value);
    }

    public function getNotificationEmail()
    {
        return $this->getParameter('notificationEmail');
    }

    // 設置與獲取 notificationEmail

    /**
     * 設定成功交易 Email 通知
     *
     * 當交易成功時將交易結果寄送至商家指定的 Email，若有多筆 Email 以分號「;」區隔。請 注意此處為通知商家消費者已完成交易用
     *
     * @param  string  $value  成功交易 Email (String, 長度: 200)
     */
    public function setNotificationEmail($value)
    {
        $this->setParameter('notificationEmail', $value);
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

    /**
     * 取得交易逾時秒數
     *
     * @return int|null 交易逾時秒數
     */
    public function getTimeout()
    {
        return $this->getParameter('timeout');
    }

    /**
     * 設定交易逾時秒數
     *
     * @param  int  $value  交易逾時秒數，範圍 90 ~ 28800，無限制為 0
     */
    public function setTimeout($value)
    {
        $this->setParameter('timeout', $value);
    }

    /**
     * 取得進入頁面有效時間
     *
     * @return string|null 交易有效時間
     */
    public function getValidTime()
    {
        return $this->getParameter('validTime');
    }

    /**
     * 設定進入頁面有效時間
     *
     * @param  string  $value  交易有效時間 (格式: yyyyMMddHHmm)
     */
    public function setValidTime($value)
    {
        $this->setParameter('validTime', $value);
    }

    /**
     * 取得逾時返回網址
     *
     * @return string|null 逾時返回網址
     */
    public function getTimeoutUrl()
    {
        return $this->getParameter('timeoutURL');
    }

    /**
     * 設定逾時返回網址
     *
     * @param  string  $value  交易逾時時返回商家指定的網址
     */
    public function setTimeoutURL($value)
    {
        $this->setParameter('timeoutURL', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'transactionId', 'returnUrl');

        return array_filter([
            'merchantId' => $this->getMerchantId(),
            'type' => $this->getType() ?: 2,
            'amount' => (string) ((int) $this->getAmount()),
            'orderNo' => $this->getTransactionId(),
            'orderDescription' => $this->getDescription(),
            'orderNote1' => $this->getOrderNote1(),
            'orderNote2' => $this->getOrderNote2(),
            'notificationEmail' => $this->getNotificationEmail(),
            'returnURL' => $this->getReturnUrl(),
            'cancelURL' => $this->getCancelUrl(),
            'backgroundURL' => $this->getNotifyUrl(),
            'timeout' => $this->getTimeout(),
            'validTime' => $this->getValidTime(),
            'timeoutURL' => $this->getTimeoutUrl(),
        ], static function ($value) {
            return $value !== null;
        });
    }

    public function sendData($data)
    {
        $data['checkCode'] = $this->checkCode([
            'merchantId', 'amount', 'orderNo', 'returnURL', 'cancelURL', 'backgroundURL',
        ], $data);

        return $this->response = new PurchaseResponse($this, $data);
    }
}
