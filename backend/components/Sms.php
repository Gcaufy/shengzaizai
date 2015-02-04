<?php

namespace backend\components;

class Sms extends \yii\base\Object
{
    /**
     * @var string 序列号
     */
    public $sn;

    /**
     * @var string 密码
     */
    public $password;

    /**
     * @var string 签名
     */
    public $sign;

    /**
     * encrypt the password
     * @return encrypted password
     */
    private function encyptPassword()
    {
        return strtoupper(md5($this->sn . $this->password));
    }

    /**
     * 查询余额
     * @return 余额
     */
    public function getBalance()
    {
        return $this->post('balance', [
            'sn' => $this->sn,
            'pwd' => $this->encyptPassword(),
        ]);
    }

    /**
     * @param string|array 收信人
     * @param string 内容
     * @param string 扩展码
     * @param integer 定时时间
     * @param string 唯一标识（最长18位，只能由数字和字母组成）
     */
    public function send($mobile, $content, $ext = '', $stime = null, $rrid = null)
    {
        $params = [
            'sn' => $this->sn,
            'pwd' => $this->encyptPassword(),
            'mobile' => implode(',', (array) $mobile),
            'content' => iconv('UTF-8', 'gb2312//IGNORE', "{$content}【{$this->sign}】"),
            'ext' => $ext,
            'stime' => ($stime === null) ? '' : date('Y-m-d H:i:s', $stime),
            'rrid' => '',
        ];
        if ($rrid !== null && strlen($rrid) <= 18 && ctype_alnum($rrid)) {
            $params['rrid'] = $rrid;
        }
        return $this->post('mt', $params);
    }

    /**
     * @param string $service
     * @param array $params
     */
    private function post($service, $params)
    {
        $param = implode('&', array_map(function($key, $value) {
            return $key . '=' . urlencode($value);
        }, array_keys($params), array_values($params)));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sdk2.entinfo.cn:8060/webservice.asmx/{$service}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

}
