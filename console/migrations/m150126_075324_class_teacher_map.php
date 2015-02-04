<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_075324_class_teacher_map extends Migration
{
    public function up()
    {
        $this->createTable('school_class_teacher_map', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'class_id' => "int(11) NOT NULL",
            'teacher_id' => "int(11) NOT NULL",
            'ctime' => "int(10) DEFAULT NULL",
            'utime' => "int(10) DEFAULT NULL",
            'status' => "tinyint(1) NOT NULL DEFAULT '1'",
            'PRIMARY KEY (`id`)',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function down()
    {
        $this->dropTable('school_class_teacher_map');
        return true;
    }
}
