<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'YiPAY' instanceof \Omnipay\YiPAY\Gateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'YiPAY' instanceof \Omnipay\YiPAY\Gateway,
      ],
    ];
}
