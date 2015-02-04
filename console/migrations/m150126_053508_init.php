<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_053508_init extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('cms_acclaim', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'tid' => "int(11) NOT NULL DEFAULT '0' COMMENT '老师ID'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '家长ID'",
            'aid' => "int(11) NOT NULL DEFAULT '0' COMMENT '文章ID'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='用户点赞表'");

        $this->createTable('cms_article', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'cid' => "int(3) NOT NULL DEFAULT '0'",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '发布时间'",
            'acclaim' => "int(11) NOT NULL DEFAULT '0' COMMENT '赞的次数'",
            'comment' => "int(11) NOT NULL DEFAULT '0' COMMENT '评论次数'",
            'title' => "varchar(60) NOT NULL DEFAULT '' COMMENT '标题'",
            'thumb' => "varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图'",
            'description' => "varchar(200) NOT NULL DEFAULT '' COMMENT '描述'",
            'content' => "text NOT NULL COMMENT '内容'",
            'url' => "varchar(255) DEFAULT NULL COMMENT '详情链接'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='资讯文章表'");

        $this->createTable('cms_class', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'classname' => "varchar(4) NOT NULL DEFAULT '' COMMENT '分类名称'",
            'thumb' => "varchar(200) NOT NULL DEFAULT '' COMMENT '缩略图'",
            'desscription' => "varchar(250) NOT NULL DEFAULT '' COMMENT '分类描述'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='资讯分类'");

        $this->createTable('cms_comment', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '评论时间'",
            'aid' => "int(11) NOT NULL DEFAULT '0' COMMENT '资讯ID'",
            'tid' => "int(11) NOT NULL DEFAULT '0' COMMENT '老师ID'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '家长ID'",
            'comment' => "varchar(140) NOT NULL DEFAULT '' COMMENT '评论内容'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='评论表'");

        $this->createTable('cnt_device', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'ip' => "varchar(15) DEFAULT NULL",
            'mobile' => "tinyint(1) DEFAULT NULL",
            'system' => "varchar(20) DEFAULT NULL",
            'agent' => "varchar(200) DEFAULT NULL",
            'count' => "int(11) DEFAULT '1'",
            'first_time' => "int(11) DEFAULT NULL",
            'last_time' => "int(11) DEFAULT NULL",
            'PRIMARY KEY (`id`)',
        ], $tableOptions);

        $this->createTable('mes_feedback', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'from_user' => "int(11) NOT NULL COMMENT '来自用户'",
            'to_user' => "int(11) NOT NULL COMMENT '发往用户'",
            'content' => "varchar(150) NOT NULL DEFAULT '' COMMENT '内容'",
            'is_read' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读'",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='老师家长反馈表'");

        $this->createTable('mes_note', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'type' => "int(1) NOT NULL DEFAULT '0' COMMENT '通知类型(官方通知=1,学校通知=2)'",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '通知时间'",
            'utime' => "int(10) DEFAULT NULL",
            'content' => "varchar(255) NOT NULL DEFAULT '' COMMENT '通知内容'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='通知表'");

        $this->createTable('mes_note_read', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID'",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户ID'",
            'note_id' => "int(11) unsigned DEFAULT NULL COMMENT '通知ID'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'",
            'uid' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新人'",
            'utime' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'cid' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建人'",
            'ctime' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='通知已读状态'");

        $this->createTable('mes_noteto', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'type' => "int(1) NOT NULL DEFAULT '0' COMMENT '通知类型(官方通知=1,学校通知=2)'",
            'note_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '通知ID'",
            'school_id' => "int(11) DEFAULT '0' COMMENT '学校ID'",
            'class_id' => "int(11) DEFAULT '0' COMMENT '班级ID'",
            'status' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态'",
            'cid' => "int(11) DEFAULT NULL",
            'ctime' => "int(11) DEFAULT NULL",
            'uid' => "int(11) DEFAULT NULL",
            'utime' => "int(11) DEFAULT NULL",
            'PRIMARY KEY (`id`)',
            'KEY `nid` (`note_id`)',
            'KEY `classid` (`class_id`)',
        ], $tableOptions . " COMMENT='通知对应表'");

        $this->createTable('school', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '学生ID'",
            'name' => "varchar(200) NOT NULL COMMENT '学校名'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'",
            'uid' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新人'",
            'utime' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'cid' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建人'",
            'ctime' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='学校列表'");

        $this->createTable('school_classes', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '班级ID'",
            'school_id' => "int(11) DEFAULT NULL COMMENT '学校ID'",
            'countuser' => "int(11) NOT NULL DEFAULT '0' COMMENT '学生数量'",
            'headid' => "int(11) NOT NULL DEFAULT '0' COMMENT '班主任ID'",
            'classname' => "varchar(60) NOT NULL DEFAULT '' COMMENT '班级名称'",
            'schoolname' => "varchar(60) NOT NULL DEFAULT '' COMMENT '学校名称'",
            'description' => "varchar(250) NOT NULL DEFAULT '' COMMENT '班级描述'",
            'headteacher' => "varchar(10) NOT NULL DEFAULT '' COMMENT '班主任姓名'",
            'PRIMARY KEY (`id`)',
            'KEY `headid` (`headid`)',
        ], $tableOptions . " COMMENT='班级表'");

        $this->createTable('school_course', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'week' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '星期(星期一=1,星期二=2,星期三=3,星期四=4,星期五=5)'",
            'section' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '几节(第一节=1,第二节=2,第八节=8)'",
            'classid' => "int(11) NOT NULL DEFAULT '0' COMMENT '班级ID'",
            'subjectid' => "int(11) NOT NULL DEFAULT '0' COMMENT '课程ID'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='课程表'");

        $this->createTable('school_homework', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'atime' => "int(10) NOT NULL DEFAULT '0' COMMENT '布置时间'",
            'stime' => "int(10) NOT NULL DEFAULT '0' COMMENT '需提交时间'",
            'classid' => "int(11) NOT NULL DEFAULT '0' COMMENT '班级ID'",
            'subjectid' => "int(11) NOT NULL DEFAULT '0' COMMENT '科目ID'",
            'tid' => "int(11) NOT NULL DEFAULT '0' COMMENT '老师ID'",
            'content' => "text NOT NULL COMMENT '作业内容'",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='家庭作业表'");

        $this->createTable('school_score', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'sid' => "int(11) NOT NULL DEFAULT '0' COMMENT '学生ID'",
            'detail_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '成绩描述细节ID'",
            'score' => "int(3) NOT NULL DEFAULT '0' COMMENT '分数'",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='学生成绩表'");

        $this->createTable('school_score_desc', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'classid' => "int(11) NOT NULL DEFAULT '0' COMMENT '班级ID'",
            'name' => "varchar(20) NOT NULL DEFAULT '' COMMENT '名称'",
            'step' => "int(11) NOT NULL DEFAULT '1' COMMENT '步骤'",
            'is_published' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '已否发布成绩'",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='成绩描述表'");

        $this->createTable('school_score_desc_detail', [
            'id' => "int(11) unsigned NOT NULL AUTO_INCREMENT",
            'desc_id' => "int(11) NOT NULL COMMENT '成绩描述ID'",
            'subject_id' => "int(11) NOT NULL COMMENT '科目ID'",
            'full_score' => "int(11) NOT NULL DEFAULT '100' COMMENT '满分'",
            'ctime' => "int(10) DEFAULT NULL COMMENT '创建时间'",
            'utime' => "int(10) DEFAULT NULL COMMENT '更新时间'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions);

        $this->createTable('school_subject', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'color' => "char(7) NOT NULL DEFAULT '#000000' COMMENT '颜色'",
            'subjectname' => "varchar(10) NOT NULL DEFAULT '' COMMENT '科目名称'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='科目表'");

        $this->createTable('sys_admin', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员ID'",
            'status' => "int(2) NOT NULL DEFAULT '0' COMMENT '状态(正常=1,删除=-1,锁定=9)'",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'groupid' => "int(11) NOT NULL DEFAULT '0' COMMENT '分组ID'",
            'authkey' => "char(32) NOT NULL DEFAULT '' COMMENT '检验码'",
            'password' => "char(60) NOT NULL DEFAULT '' COMMENT '密码'",
            'username' => "varchar(20) NOT NULL DEFAULT '' COMMENT '用户名'",
            'rules' => "text COMMENT '权限规则'",
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `username_UNIQUE` (`username`)',
        ], $tableOptions . " COMMENT='管理员列表'");

        $this->createTable('sys_config', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'groupid' => "smallint(6) NOT NULL DEFAULT '0' COMMENT '分组ID'",
            'varname' => "varchar(20) NOT NULL DEFAULT '' COMMENT '变量名'",
            'info' => "varchar(200) NOT NULL DEFAULT '' COMMENT '变量说明'",
            'type' => "varchar(10) DEFAULT '' COMMENT '类型'",
            'value' => "text COMMENT '变量值'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='系统配置表'");

        $this->createTable('sys_feedback', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'tid' => "int(11) NOT NULL DEFAULT '0' COMMENT '老师ID'",
            'pid' => "int(11) NOT NULL DEFAULT '0' COMMENT '家长ID'",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '时间'",
            'message' => "text NOT NULL COMMENT '内容'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='系统反馈表'");

        $this->createTable('sys_group', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'groupname' => "varchar(20) NOT NULL DEFAULT '' COMMENT '分组名称'",
            'description' => "varchar(100) NOT NULL DEFAULT '' COMMENT '分组描述'",
            'rules' => "text COMMENT '权限规则'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='管理分组表'");

        $this->createTable('sys_logs', [
            'id' => "char(16) NOT NULL COMMENT '日志ID'",
            'ctime' => "int(10) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'adminid' => "int(11) NOT NULL DEFAULT '0' COMMENT '管理员ID'",
            'url' => "varchar(50) NOT NULL DEFAULT '' COMMENT '操作URL'",
            'content' => "varchar(250) NOT NULL DEFAULT '' COMMENT '说明'",
            'PRIMARY KEY (`id`)',
        ], $tableOptions . " COMMENT='操作日志表'");

        $this->createTable('sys_user', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID'",
            'username' => "varchar(20) NOT NULL DEFAULT '' COMMENT '用户名'",
            'realname' => "varchar(10) DEFAULT '' COMMENT '真实姓名'",
            'gender' => "tinyint(1) NOT NULL DEFAULT '0' COMMENT '姓别'",
            'qq' => "varchar(15) DEFAULT '' COMMENT 'QQ号码'",
            'mobile' => "char(11) DEFAULT '' COMMENT '手机号码'",
            'tel' => "varchar(20) DEFAULT '' COMMENT '联系座机'",
            'email' => "varchar(45) DEFAULT '' COMMENT '电子邮件'",
            'birth' => "char(10) DEFAULT '' COMMENT '生日'",
            'portrait' => "varchar(200) NOT NULL DEFAULT '' COMMENT '头像'",
            'authkey' => "char(32) NOT NULL DEFAULT '' COMMENT '检验码'",
            'password' => "char(60) NOT NULL DEFAULT '' COMMENT '密码'",
            'note' => "varchar(200) DEFAULT NULL COMMENT '备注'",
            'role' => "int(11) NOT NULL DEFAULT '1' COMMENT '角色'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'",
            'uid' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新人'",
            'utime' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'cid' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建人'",
            'ctime' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `username_UNIQUE` (`username`)',
        ], $tableOptions . " COMMENT='用户列表'");

        $this->createTable('user_student', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '学生ID'",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户ID'",
            'class_id' => "int(11) unsigned DEFAULT NULL COMMENT '班级ID'",
            'parent_id' => "int(11) unsigned DEFAULT NULL COMMENT '家长ID'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'",
            'uid' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新人'",
            'utime' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'cid' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建人'",
            'ctime' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'PRIMARY KEY (`id`)',
            'KEY `user_id` (`user_id`)',
            'KEY `class_id` (`class_id`)',
            'KEY `parent_id` (`parent_id`)',
        ], $tableOptions . " COMMENT='学生列表'");

        $this->createTable('user_teacher', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT COMMENT '学生ID'",
            'user_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '用户ID'",
            'subject_id' => "int(11) NOT NULL DEFAULT '0' COMMENT '科目ID'",
            'desc' => "text COMMENT '老师简介'",
            'status' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态'",
            'uid' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新人'",
            'utime' => "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'cid' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建人'",
            'ctime' => "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'PRIMARY KEY (`id`)',
            'KEY `user_id` (`user_id`)',
        ], $tableOptions . " COMMENT='老师列表'");

        $this->createTable('user_wechat', [
            'open_id' => "varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''",
            'user_id' => "int(11) DEFAULT NULL",
            'bind_param' => "char(40) COLLATE utf8_unicode_ci DEFAULT NULL",
            'ctime' => "int(11) DEFAULT NULL",
            'utime' => "int(11) DEFAULT NULL",
            'PRIMARY KEY (`open_id`)',
            'KEY `user_id` (`user_id`)',
            'KEY `bind_param` (`bind_param`)',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m150126_053508_init cannot be reverted.\n";

        return false;
    }
}
