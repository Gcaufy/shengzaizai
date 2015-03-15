<?php
use yii\rbac\Item;
return [
    // Permission
    'menu.system.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块', 'children' => [
        'menu.system.view',
        'menu.system.feedback.index.view',
        'menu.system.config.index.view',
        'menu.system.region.index.view',
    ]],
    'menu.system.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块'],
    'menu.system.feedback.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-用户反馈'],
    'menu.system.config.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-系统配置'],
    'menu.system.region.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '系统模块-地区配置'],




    'menu.cms.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块', 'children' => [
        'menu.cms.view',
        'menu.cms.category.index.view',
        'menu.cms.article.index.view',
    ]],
    'menu.cms.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块'],
    'menu.cms.category.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块-资讯分类'],
    'menu.cms.article.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '资讯模块-资讯列表'],



    'menu.user.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '个人中心', 'children' => [
        'menu.user.view',
        'menu.user.profile.index.view',
        'menu.user.account.index.view',
    ]],
    'menu.user.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '个人中心'],
    'menu.user.profile.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '个人中心-我的资料'],
    'menu.user.account.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '个人中心-我的账户'],


    'menu.member.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块', 'children' => [
        'menu.member.view',
        'menu.member.member.index.view',
    ]],
    'menu.member.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块'],
    'menu.member.member.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '用户模块-注册用户列表'],

    'menu.hospital.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '医院模块', 'children' => [
        'menu.hospital.view',
        'menu.hospital.hospital.index.view',
    ]],
    'menu.hospital.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医院模块'],
    'menu.hospital.hospital.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医院模块-医院列表'],




    'menu.doctor.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '医生模块', 'children' => [
        'menu.doctor.view',
        'menu.doctor.doctor.index.view',
        'menu.doctor.tag.index.view',
        'menu.doctor.title.index.view',
    ]],
    'menu.doctor.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医生模块'],
    'menu.doctor.doctor.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医生模块-医生列表'],
    'menu.doctor.tag.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医生模块-医生标签列表'],
    'menu.doctor.title.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '医生模块-医生头衔列表'],



    'menu.operation.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '手术模块', 'children' => [
        'menu.operation.view',
        'menu.operation.operation.index.view',
        'menu.operation.hospital.index.view',
    ]],
    'menu.operation.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '手术模块'],
    'menu.operation.operation.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '手术模块-手术列表'],
    'menu.operation.hospital.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '手术模块-医院手术列表'],



    'menu.inspection.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '检查模块', 'children' => [
        'menu.inspection.view',
        'menu.inspection.hospital.index.view',
        'menu.inspection.inspection.index.view',
    ]],
    'menu.inspection.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '检查模块'],
    'menu.inspection.inspection.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '检查模块-检查列表'],
    'menu.inspection.hospital.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '检查模块-医院检查列表'],


    'menu.order.viewall' => ['type' => Item::TYPE_PERMISSION, 'description' => '订单模块', 'children' => [
        'menu.order.view',
        'menu.order.number.index.view',
        'menu.order.order.index.view',
    ]],
    'menu.order.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '订单模块'],
    'menu.order.number.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '订单模块-订单号管理'],
    'menu.order.order.index.view' => ['type' => Item::TYPE_PERMISSION, 'description' => '订单模块-订单管理'],



    // Roles
    'guest' => ['type' => Item::TYPE_ROLE, 'description' => 'Guest'],
    'admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Admin',
        'children' => [
            'menu.system.viewall',
            'menu.cms.viewall',
            'menu.member.viewall',
            'menu.user.viewall',
            'menu.hospital.viewall',
            'menu.doctor.viewall',
            'menu.operation.viewall',
            'menu.inspection.viewall',
            'menu.order.viewall',

            'action.message.note.all',
            'action.academic.homework.all',
            'action.academic.score.all',
        ],
    ],
    'normal' => ['type' => Item::TYPE_ROLE, 'description' => 'Regist User', 'children' => [
        'menu.user.viewall',
    ]],

];