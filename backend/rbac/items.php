<?php
use yii\rbac\Item;
return [
    // Permission
    'menu.system.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块', 'children' => [
        'menu.system.view',
        'menu.system.admin.index.view',
        'menu.system.group.index.view',
        'menu.system.feedback.index.view',
        'menu.system.admin.password.view',
        'menu.system.config.index.view',
        'menu.system.log.index.view',
    ]],
    'menu.system.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块'],
    'menu.system.admin.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-管理员列表'],
    'menu.system.group.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-管理员分组'],
    'menu.system.feedback.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-用户反馈'],
    'menu.system.admin.password.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-修改密码'],
    'menu.system.config.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-系统配置'],
    'menu.system.log.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-管理操作日志'],



    'menu.cms.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块', 'children' => [
        'menu.cms.view',
        'menu.cms.classes.index.view',
        'menu.cms.article.index.view',
        'menu.cms.comment.index.view',
    ]],
    'menu.cms.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块'],
    'menu.cms.classes.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块-资讯分类'],
    'menu.cms.article.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块-资讯列表'],
    'menu.cms.comment.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块-评论列表'],



    'menu.user.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块', 'children' => [
        'menu.user.view',
        'menu.user.support.index.view',
        'menu.user.teacher.index.view',
        'menu.user.parent.index.view',
        'menu.user.student.index.view',
        'menu.user.import.index.view',
    ]],
    'menu.user.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块'],
    'menu.user.support.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-客服列表'],
    'menu.user.teacher.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-老师列表'],
    'menu.user.parent.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-家长列表'],
    'menu.user.student.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-学生列表'],
    'menu.user.import.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-用户导入'],



    'menu.school.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块', 'children' => [
        'menu.school.view',
        'menu.school.school.index.view',
        'menu.school.classes.index.view',
        'menu.school.subject.index.view',
        'menu.school.course.index.view',
    ]],
    'menu.school.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块'],
    'menu.school.school.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块-学校列表'],
    'menu.school.classes.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块-班级列表'],
    'menu.school.subject.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块-科目列表'],
    'menu.school.course.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '学校模块-课程列表'],



    'menu.message.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息模块', 'children' => [
        'menu.message.view',
        'menu.message.sms.index.view',
        'menu.message.note.index.view',
        'menu.message.feedback.index.view',
    ]],
    'menu.message.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息模块'],
    'menu.message.sms.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息模块-发送短信'],
    'menu.message.note.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息模块-通知列表'],
    'menu.message.feedback.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息模块-老师家长反馈'],

    'action.message.note.all' => ['type' => Item::TYPE_PERMISSION, 'description' => '消息所有权限', 'children' => [
        'action.message.note.create',
        'action.message.note.update',
        'action.message.note.delete',
        'action.message.note.view',
    ]],
    'action.message.note.create' => ['type' => Item::TYPE_PERMISSION, 'description' => '创建消息'],
    'action.message.note.update' => ['type' => Item::TYPE_PERMISSION, 'description' => '修改消息'],
    'action.message.note.delete' => ['type' => Item::TYPE_PERMISSION, 'description' => '删除消息'],
    'action.message.note.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '查看消息'],

    'menu.academic.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '课业管理',
        'children' => [
            'menu.academic.view',
            'menu.academic.homework.index.view',
            'menu.academic.score.index.view',
        ],
    ],
    'menu.academic.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '课业管理'],
    'menu.academic.homework.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '家庭作业'],
    'menu.academic.score.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '成绩查询'],

    'action.academic.homework.all' => ['type' => Item::TYPE_PERMISSION, 'description' => '家庭作业所有权限', 'children' => [
        'action.academic.homework.create',
        'action.academic.homework.view',
        'action.academic.homework.update',
        'action.academic.homework.delete',
    ]],
    'action.academic.homework.create' => ['type' => Item::TYPE_PERMISSION, 'description' => '创建家庭作业'],
    'action.academic.homework.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '查看家庭作业'],
    'action.academic.homework.update' => ['type' => Item::TYPE_PERMISSION, 'description' => '修改家庭作业'],
    'action.academic.homework.delete' => ['type' => Item::TYPE_PERMISSION, 'description' => '删除家庭作业'],

    'action.academic.score.all' => ['type' => Item::TYPE_PERMISSION, 'description' => '成绩所有权限', 'children' => [
        'action.academic.score.update',
        'action.academic.score.view',
        'action.academic.score.delete',
    ]],
    'action.academic.score.update' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩', 'children' => [
        'action.academic.score.stepone',
        'action.academic.score.steptwo',
        'action.academic.score.stepthree',
        'action.academic.score.stepfour',
        'action.academic.score.stepfive',
        'action.academic.score.publish',
    ]],
    'action.academic.score.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '修改成绩'],
    'action.academic.score.delete' => ['type' => Item::TYPE_PERMISSION, 'description' => '删除成绩'],
    'action.academic.score.stepone' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩第一步'],
    'action.academic.score.steptwo' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩第二步'],
    'action.academic.score.stepthree' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩第三步'],
    'action.academic.score.stepfour' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩第四步'],
    'action.academic.score.stepfive' => ['type' => Item::TYPE_PERMISSION, 'description' => '发布成绩第五步'],
    'action.academic.score.publish' => ['type' => Item::TYPE_PERMISSION, 'description' => '已发布成绩'],

    // Roles
    'guest' => ['type' => Item::TYPE_ROLE, 'description' => 'Guest'],
    'admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Admin',
        'children' => [
            'teacher',
            'parent',

            'menu.system.viewall',
            'menu.cms.viewall',
            'menu.user.viewall',
            'menu.school.viewall',
            'menu.message.viewall',

            'action.message.note.all',
            'action.academic.homework.all',
            'action.academic.score.all',
        ],
    ],
    'teacher' => ['type' => Item::TYPE_ROLE, 'description' => 'Teacher', 'children' => [
        'menu.system.view',
        'menu.system.admin.password.view',
        'menu.academic.viewall',
        'menu.message.view',
        'menu.message.note.index.view',
        'menu.message.feedback.index.view',

        'action.message.note.view',
        'action.academic.homework.all',
        'action.academic.score.all',
    ]],
    'parent' => ['type' => Item::TYPE_ROLE, 'description' => 'Admin', 'children' => [
        'menu.system.view',
        'menu.system.admin.password.view',
        'menu.academic.viewall',
        'menu.message.view',
        'menu.message.note.index.view',
        'menu.message.feedback.index.view',

        'action.message.note.view',
        'action.academic.homework.view',
        'action.academic.score.view',
    ]],
    'support' => ['type' => Item::TYPE_ROLE, 'description' => 'Support', 'children' => [
        'menu.system.view',
        'menu.system.admin.password.view',

        'menu.user.view',
        'menu.user.teacher.index.view',
        'menu.user.parent.index.view',
        'menu.user.student.index.view',
        'menu.user.import.index.view',

        'menu.school.view',
        'menu.school.school.index.view',
        'menu.school.classes.index.view',
    ]],
];