<?php

use yii\db\Schema;
use yii\db\Migration;

class m150127_121207_remove_school_and_teacher_name_from_class extends Migration
{
    public function up()
    {
        $this->dropColumn('school_classes', 'schoolname');
        $this->dropColumn('school_classes', 'headteacher');
    }

    public function down()
    {
        $this->addColumn('school_classes', 'schoolname', "varchar(60) NOT NULL DEFAULT '' COMMENT '学校名称'");
        $this->addColumn('school_classes', 'headteacher', "varchar(10) NOT NULL DEFAULT '' COMMENT '班主任姓名'");

        return true;
    }
}
