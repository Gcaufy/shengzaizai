<?php

use yii\db\Schema;
use yii\db\Migration;

class m150128_063007_ctime_utime_and_status extends Migration
{
    public function up()
    {
        $this->addColumn('cms_acclaim', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `aid`");
        $this->addColumn('cms_acclaim', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('cms_acclaim', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->alterColumn('cms_article', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `url`");
        $this->addColumn('cms_article', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('cms_article', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->renameColumn('cms_class', 'desscription', 'description');
        $this->addColumn('cms_class', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `description`");
        $this->addColumn('cms_class', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('cms_class', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->alterColumn('cms_comment', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `comment`");
        $this->addColumn('cms_comment', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('cms_comment', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('mes_feedback', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->alterColumn('mes_note', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `content`");
        $this->alterColumn('mes_note', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('mes_note', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->alterColumn('mes_noteto', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_classes', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `description`");
        $this->addColumn('school_classes', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('school_classes', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_course', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `subjectid`");
        $this->addColumn('school_course', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('school_course', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_homework', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_score', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_score_desc', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_score_desc_detail', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('school_subject', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `subjectname`");
        $this->addColumn('school_subject', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('school_subject', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('sys_admin', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('sys_config', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `value`");
        $this->addColumn('sys_config', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('sys_config', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->alterColumn('sys_feedback', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `message`");
        $this->addColumn('sys_feedback', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('sys_feedback', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('sys_group', 'ctime', "int(10) DEFAULT NULL COMMENT '创建时间' AFTER `rules`");
        $this->addColumn('sys_group', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `ctime`");
        $this->addColumn('sys_group', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('sys_logs', 'utime', "int(10) DEFAULT NULL COMMENT '更新时间' AFTER `content`");
        $this->addColumn('sys_logs', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('user_excel', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");
        $this->addColumn('user_wechat', 'status', "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0为正常，1为已删除）' AFTER `utime`");

        $this->createIndex('status', 'cms_acclaim', 'status');
        $this->createIndex('status', 'cms_article', 'status');
        $this->createIndex('status', 'cms_class', 'status');
        $this->createIndex('status', 'cms_comment', 'status');
        $this->createIndex('status', 'mes_feedback', 'status');
        $this->createIndex('status', 'mes_note', 'status');
        $this->createIndex('status', 'school', 'status');
        $this->createIndex('status', 'school_class_teacher_map', 'status');
        $this->createIndex('status', 'school_classes', 'status');
        $this->createIndex('status', 'school_course', 'status');
        $this->createIndex('status', 'school_homework', 'status');
        $this->createIndex('status', 'school_score', 'status');
        $this->createIndex('status', 'school_score_desc', 'status');
        $this->createIndex('status', 'school_score_desc_detail', 'status');
        $this->createIndex('status', 'school_subject', 'status');
        $this->createIndex('status', 'sys_admin', 'status');
        $this->createIndex('status', 'sys_config', 'status');
        $this->createIndex('status', 'sys_feedback', 'status');
        $this->createIndex('status', 'sys_group', 'status');
        $this->createIndex('status', 'sys_logs', 'status');
        $this->createIndex('status', 'sys_user', 'status');
        $this->createIndex('status', 'user_excel', 'status');
        $this->createIndex('status', 'user_student', 'status');
        $this->createIndex('status', 'user_teacher', 'status');
        $this->createIndex('status', 'user_wechat', 'status');
    }

    public function down()
    {
        $this->dropColumn('cms_acclaim', 'ctime');
        $this->dropColumn('cms_acclaim', 'utime');
        $this->dropColumn('cms_acclaim', 'status');
        $this->alterColumn('cms_article', 'ctime', "int(10) NOT NULL DEFAULT '0' COMMENT '发布时间' AFTER `cid`");
        $this->dropColumn('cms_article', 'utime');
        $this->dropColumn('cms_article', 'status');
        $this->renameColumn('cms_class', 'description', 'desscription');
        $this->dropColumn('cms_class', 'ctime');
        $this->dropColumn('cms_class', 'utime');
        $this->dropColumn('cms_class', 'status');
        $this->alterColumn('cms_comment', 'ctime', "int(10) NOT NULL DEFAULT '0' COMMENT '评论时间' AFTER `id`");
        $this->dropColumn('cms_comment', 'utime');
        $this->dropColumn('cms_comment', 'status');
        $this->dropColumn('mes_feedback', 'status');
        $this->alterColumn('mes_note', 'ctime', "int(10) NOT NULL DEFAULT '0' COMMENT '通知时间' AFTER `type`");
        $this->alterColumn('mes_note', 'utime', "int(10) DEFAULT NULL AFTER `ctime`");
        $this->dropColumn('mes_note', 'status');
        $this->alterColumn('mes_noteto', 'status', "tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态' AFTER `class_id`");
        $this->dropColumn('school_classes', 'ctime');
        $this->dropColumn('school_classes', 'utime');
        $this->dropColumn('school_classes', 'status');
        $this->dropColumn('school_course', 'ctime');
        $this->dropColumn('school_course', 'utime');
        $this->dropColumn('school_course', 'status');
        $this->dropColumn('school_homework', 'status');
        $this->dropColumn('school_score', 'status');
        $this->dropColumn('school_score_desc', 'status');
        $this->dropColumn('school_score_desc_detail', 'status');
        $this->dropColumn('school_subject', 'ctime');
        $this->dropColumn('school_subject', 'utime');
        $this->dropColumn('school_subject', 'status');
        $this->dropColumn('sys_admin', 'utime');
        $this->dropColumn('sys_config', 'ctime');
        $this->dropColumn('sys_config', 'utime');
        $this->dropColumn('sys_config', 'status');
        $this->alterColumn('sys_feedback', 'ctime', "int(10) NOT NULL DEFAULT '0' COMMENT '时间' AFTER `pid`");
        $this->dropColumn('sys_feedback', 'utime');
        $this->dropColumn('sys_feedback', 'status');
        $this->dropColumn('sys_group', 'ctime');
        $this->dropColumn('sys_group', 'utime');
        $this->dropColumn('sys_group', 'status');
        $this->dropColumn('sys_logs', 'utime');
        $this->dropColumn('sys_logs', 'status');
        $this->dropColumn('user_excel', 'status');
        $this->dropColumn('user_wechat', 'status');

        $this->dropIndex('status', 'school');
        $this->dropIndex('status', 'school_class_teacher_map');
        $this->dropIndex('status', 'sys_admin');
        $this->dropIndex('status', 'sys_user');
        $this->dropIndex('status', 'user_student');
        $this->dropIndex('status', 'user_teacher');

        return true;
    }
}
