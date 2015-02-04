<?php

use yii\db\Schema;
use yii\db\Migration;

class m150129_032238_user_token extends Migration
{
    public function up()
    {
        $this->createTable('user_token', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户ID'",
            'access_token' => "varchar(32) DEFAULT NULL",
            'last_login_ip' => "varchar(39) DEFAULT NULL",
            'user_agent' => "varchar(255) DEFAULT NULL",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）'",
            'PRIMARY KEY (`id`)',
            'KEY `user_id` (`user_id`)',
            'KEY `access_token` (`access_token`)',
            'KEY `status` (`status`)',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function down()
    {
        $this->dropTable('user_token');

        return false;
    }
}
