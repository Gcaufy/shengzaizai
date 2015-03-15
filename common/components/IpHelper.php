<?php
namespace common\components;

use Yii;

class IpHelper
{
    public static function ip2int($ip) {
        list($ip1, $ip2, $ip3, $ip4) = explode(".", $ip);
        return ($ip1 << 24) | ($ip2 << 16) | ($ip3 << 8 ) | ($ip4);
    }

    public static function chk_ip($ip) {
        return !(ip2long($ip) == "-1");

    }
}
