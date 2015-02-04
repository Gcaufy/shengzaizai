<?php

use yii\db\Schema;
use yii\db\Migration;

class m150127_031831_import_user extends Migration
{
    public function up()
    {
        $this->createTable('user_excel', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'file_id' => "int(11) NOT NULL",
            'ctime' => "int(10) DEFAULT NULL",
            'utime' => "int(10) DEFAULT NULL",
            'PRIMARY KEY (`id`)',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function down()
    {
        $this->dropTable('user_excel');

        return true;
    }
}
