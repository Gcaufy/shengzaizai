<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_123438_student_no_and_indices extends Migration
{
    public function up()
    {
        $this->addColumn('user_student', 'student_no', "varchar(255) DEFAULT NULL COMMENT '学号' AFTER `user_id`");
        $this->createIndex('student_no', 'user_student', 'student_no');

        $this->createIndex('cid', 'cms_article', 'cid');

        $this->createIndex('from_user', 'mes_feedback', 'from_user');
        $this->createIndex('to_user', 'mes_feedback', 'to_user');
        $this->createIndex('is_read', 'mes_feedback', 'is_read');

        $this->createIndex('type', 'mes_note', 'type');

        $this->createIndex('user_id', 'mes_note_read', 'user_id');
        $this->createIndex('note_id', 'mes_note_read', 'note_id');
        $this->createIndex('status', 'mes_note_read', 'status');

        $this->createIndex('school_id', 'mes_noteto', 'school_id');
        $this->createIndex('status', 'mes_noteto', 'status');

        $this->createIndex('class_id', 'school_class_teacher_map', 'class_id');
        $this->createIndex('teacher_id', 'school_class_teacher_map', 'teacher_id');

        $this->createIndex('school_id', 'school_classes', 'school_id');

        $this->createIndex('classid', 'school_course', 'classid');
        $this->createIndex('subjectid', 'school_course', 'subjectid');

        $this->createIndex('classid', 'school_homework', 'classid');
        $this->createIndex('subjectid', 'school_homework', 'subjectid');

        $this->createIndex('sid', 'school_score', 'sid');
        $this->createIndex('detail_id', 'school_score', 'detail_id');

        $this->createIndex('classid', 'school_score_desc', 'classid');
        $this->createIndex('step', 'school_score_desc', 'step');
        $this->createIndex('is_published', 'school_score_desc', 'is_published');

        $this->createIndex('desc_id', 'school_score_desc_detail', 'desc_id');
        $this->createIndex('subject_id', 'school_score_desc_detail', 'subject_id');

        $this->createIndex('subject_id', 'user_teacher', 'subject_id');
    }

    public function down()
    {
        $this->dropColumn('user_student', 'student_no');

        $this->dropIndex('cid', 'cms_article');

        $this->dropIndex('from_user', 'mes_feedback');
        $this->dropIndex('to_user', 'mes_feedback');
        $this->dropIndex('is_read', 'mes_feedback');

        $this->dropIndex('type', 'mes_note');

        $this->dropIndex('user_id', 'mes_note_read');
        $this->dropIndex('note_id', 'mes_note_read');
        $this->dropIndex('status', 'mes_note_read');

        $this->dropIndex('school_id', 'mes_noteto');
        $this->dropIndex('status', 'mes_noteto');

        $this->dropIndex('class_id', 'school_class_teacher_map');
        $this->dropIndex('teacher_id', 'school_class_teacher_map');

        $this->dropIndex('school_id', 'school_classes');

        $this->dropIndex('classid', 'school_course');
        $this->dropIndex('subjectid', 'school_course');

        $this->dropIndex('classid', 'school_homework');
        $this->dropIndex('subjectid', 'school_homework');

        $this->dropIndex('sid', 'school_score');
        $this->dropIndex('detail_id', 'school_score');

        $this->dropIndex('classid', 'school_score_desc');
        $this->dropIndex('step', 'school_score_desc');
        $this->dropIndex('is_published', 'school_score_desc');

        $this->dropIndex('desc_id', 'school_score_desc_detail');
        $this->dropIndex('subject_id', 'school_score_desc_detail');

        $this->dropIndex('subject_id', 'user_teacher');

        return true;
    }
}
