<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'YiPay' instanceof \Omnipay\YiPay\Gateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'YiPay' instanceof \Omnipay\YiPay\Gateway,
      ],
    ];
}
