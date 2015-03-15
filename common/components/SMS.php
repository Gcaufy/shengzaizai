<?php

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class SMS extends \yii\base\Object
{

    public static $baseUrl = 'https://m.5c.com.cn/api/';

    public $username;

    public $password;

    public $apikey;

    public function query()
    {
        return $this->curl_post('query/index.php');
    }

    public function reply()
    {
        $data = $this->curl_post('reply/index.php');
        $keys = ['ext_no', 'msg_id', 'mobile', 'content', 'reply_time'];
        $num_of_keys = count($keys);
        $replies = explode('|||', $data);
        foreach ($replies as &$reply) {
            $reply = explode(',', $reply);
            if (count($reply) === $num_of_keys) {
                $reply = array_combine($keys, $reply);
                $reply['reply_time'] = strtotime($reply['reply_time']);
            }
        }
        array_splice($replies, -1);
        return $replies;
    }

    private function curl_post($url, $fields = array())
    {
        $url = self::$baseUrl . $url;
        $fields = ArrayHelper::merge([
            'username' => $this->username,
            'password' => $this->password,
            'apikey' => $this->apikey,
        ], $fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        curl_setopt($ch, CURLOPT_REFERER, Yii::$app->urlManager->createAbsoluteUrl('www', '/'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}
