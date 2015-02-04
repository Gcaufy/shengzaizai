<?php

namespace common\components;

use Yii;

class MutilpleDomainUrlManager extends \yii\web\UrlManager
{
    public $domains = array();

    public function createUrl($domain, $params = array()) {
        if (func_num_args() === 1) {
            $params = $domain;
            $domain = false;
        }
        $bak = $this->getBaseUrl();
        if ($domain) {
            if (!isset($this->domains[$domain])) {
                throw new \yii\base\InvalidConfigException('Please configure UrlManager of domain "' . $domain . '".');
            }
            $this->setBaseUrl($this->domains[$domain]);
        }
        $url = parent::createUrl($params);
        $this->setBaseUrl($bak);
        return $url;
    }

    public function createAbsoluteUrl($domain, $params = [], $scheme = null)
    {
        $argc = func_num_args();
        switch ($argc) {
            case 1:
                $params = $domain;
                $domain = false;
                break;
            case 2:
                if (!is_array($params) && !(is_string($params) && strpos($params, '/') !== false)) {
                    $scheme = $params;
                    $params = $domain;
                    $domain = false;
                }
                break;
        }
        $url = parent::createAbsoluteUrl($params, $scheme);
        if (is_string($domain) && isset($this->domains[$domain])) {
            $domain = $this->domains[$domain];
        } else {
            $domain = '$2'; // remain unchanged
        }
        $url = preg_replace('/^(\w+\:)(\/\/[\w\.]+)(?:\/\/[^\/]+?)?(\/.*)$/', "\$1{$domain}\$3", $url);
        return $url;
    }
}
