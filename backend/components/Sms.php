<?php

namespace backend\components;

use Yii;
use yii\base\ErrorException;
use backend\modules\system\models\SmsLog;

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
     * @var object 发送日志
     */
    private static $_log;

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
    public function send($mobile, $content, $ext = '', $stime = null, $rrid = null, $is_cron = false)
    {
        self::log((array) $mobile, $content, $is_cron);
        $params = [
            'sn' => $this->sn,
            'pwd' => $this->encyptPassword(),
            'mobile' => implode(',', (array) $mobile),
            'content' => $this->encodeContent($content),
            'ext' => $ext,
            'stime' => ($stime === null) ? '' : date('Y-m-d H:i:s', $stime),
            'rrid' => '',
            'msgfmt' => 15,
        ];
        if ($rrid !== null && strlen($rrid) <= 18 && ctype_alnum($rrid)) {
            $params['rrid'] = $rrid;
        }
        return $this->post('mdsmssend', $params);
    }

    /**
     * @param array 收件人
     * @param array 内容
     * @param string 扩展码
     * @param integer 定时时间
     * @param string 唯一标识（最长18位，只能由数字和字母组成）
     */
    public function gxsend($mobiles, $contents, $ext = '', $stime = null, $rrid = null)
    {
        self::log($mobiles, implode(',', $contents));
        $mobile = implode(',', $mobiles);
        $content = implode(',', array_map([$this, 'encodeContent'], $contents));

        $params = [
            'sn' => $this->sn,
            'pwd' => $this->encyptPassword(),
            'mobile' => $mobile,
            'content' => $content,
            'ext' => $ext,
            'stime' => ($stime === null) ? '' : date('Y-m-d H:i:s', $stime),
            'rrid' => '',
            'msgfmt' => 15,
        ];
        if ($rrid !== null && strlen($rrid) <= 18 && ctype_alnum($rrid)) {
            $params['rrid'] = $rrid;
        }
        return $this->post('mdgxsend', $params);
    }

    /**
     * @param string original content in UTF-8
     * @return string encoded content
     */
    private function encodeContent($content)
    {
        return urlencode("{$content}【{$this->sign}】");
    }

    /**
     * @param  array $mobiles
     * @param  string $content
     */
    private static function log($mobiles, $content, $is_cron = false)
    {
        self::$_log = new SmsLog();
        self::$_log->count = count($mobiles);
        self::$_log->mobiles = implode(',', $mobiles);
        self::$_log->content = $content;
        self::$_log->is_cron = $is_cron;
        self::$_log->save();
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
        curl_setopt($ch, CURLOPT_URL, "http://sdk.entinfo.cn:8061/webservice.asmx/{$service}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function getError($code)
    {
        $error = null;
        try {
            $xml = simplexml_load_string($code);
            if ($xml !== false) {
                $code = (string) $xml;
                if (isset(self::$_log) && ctype_digit($code) && strlen($code) <= 18) {
                    self::$_log->rrid = $code;
                }
            }
        } catch (ErrorException $e) {
            // failed to load xml object, it's an error string
            $error = $code;
        }
        $errors = self::getErrors();
        if (array_key_exists($code, $errors)) {
            $error = $errors[$code];
        } elseif (substr($code, 0, 1) === '-') {
            $error = '未知';
        }
        self::$_log->error = $error;
        self::$_log->save();
        self::$_log = null;
        return $error;
    }

    public function setError($message)
    {
        if (isset(self::$_log)) {
            self::$_log->error = $message;
            self::$_log->save();
        }
    }

    private static function getErrors()
    {
        return [
            '-2' => '帐号/密码不正确',
            '-4' => '余额不足支持本次发送',
            '-5' => '数据格式错误',
            '-6' => '参数有误',
            '-7' => '权限受限',
            '-8' => '流量控制错误',
            '-9' => '扩展码权限错误',
            '-10' => '内容长度过长',
            '-11' => '内部数据库错误',
            '-12' => '序列号状态错误',
            '-14' => '服务器写文件失败',
            '-17' => '没有权限',
            '-19' => '禁止同时使用多个接口地址',
            '-20' => '相同手机号，相同内容重复提交',
            '-21' => 'IP 鉴权失败',
            '-22' => 'IP 鉴权失败',
            '-23' => '缓存无此序列号信息',
            '-601' => '参数错误 - 序列号为空',
            '-602' => '参数错误 - 序列号格式错误',
            '-603' => '参数错误 - 密码为空',
            '-604' => '参数错误 - 手机号码为空',
            '-605' => '参数错误 - 内容为空',
            '-606' => '参数错误 - ext 长度大于9',
            '-607' => '参数错误 - 扩展码非数字',
            '-608' => '参数错误 - 定时时间非日期格式',
            '-609' => '参数错误 - rrid 长度大于18',
            '-610' => '参数错误 - rrid 非数字',
            '-611' => '参数错误 - 内容编码不符合规范',
            '-623' => '手机个数与内容个数不匹配',
            '-624' => '扩展个数与手机个数不匹配',
            '-644' => 'rrid 个数与手机个数不匹配',
        ];
    }

}
