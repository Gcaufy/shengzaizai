<?php
return [
    'adminEmail' => 'admin@imnbee.com',
    'deleteStatus'=>[
    	['id'=>'1','v'=>'正常'],
    	['id'=>'-1','v'=>'删除'],
        ['id'=>'9','v'=>'锁定'],
    ],
    'configType'=>[
        ['id'=>'string','v'=>'文本'],
        ['id'=>'bool','v'=>'布尔(是/否)'],
        ['id'=>'bstring','v'=>'多行文本'],
    ],
    'numConfig'=>[
        ['id'=>1,'v'=>'一'],
        ['id'=>2,'v'=>'二'],
        ['id'=>3,'v'=>'三'],
        ['id'=>4,'v'=>'四'],
        ['id'=>5,'v'=>'五'],
        ['id'=>6,'v'=>'六'],
        ['id'=>7,'v'=>'七'],
        ['id'=>8,'v'=>'八'],
        ['id'=>9,'v'=>'九'],
        ['id'=>10,'v'=>'十'],
    ],
    'noteType'=>[
        ['id'=>1,'v'=>'官方通知'],
        ['id'=>2,'v'=>'学校通知'],
    ],
    'rules'=>[
        ['n'=>'系统模块','m'=>'system','i'=>'fa fa-cogs','s'=>[
            /*['n'=>'管理员列表','c'=>'admin','m'=>'index','i'=>'fa fa-user','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'管理员分组','c'=>'group','m'=>'index','i'=>'fa fa-users','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],*/
            ['n'=>'用户反馈','c'=>'feedback','m'=>'index','i'=>'fa fa-mail-reply-all','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            /*['n'=>'修改密码','c'=>'admin','m'=>'password','i'=>'fa fa-unlock-alt'],*/
            ['n'=>'系统配置','c'=>'config','m'=>'index','i'=>'fa fa-cog'],
            ['n'=>'地区配置','c'=>'region','m'=>'index','i'=>'fa fa-map-marker'],
            /*['n'=>'管理操作日志','c'=>'log','m'=>'index','i'=>'fa fa-line-chart'],*/
        ]],
        ['n'=>'个人中心','m'=>'user','i'=>'fa fa-newspaper-o','s'=>[
            ['n'=>'我的资料','c'=>'profile','m'=>'index','i'=>'fa fa-newspaper-o','s'=>[
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
            ]],
            ['n'=>'我的账户','c'=>'account','m'=>'index','i'=>'fa fa-newspaper-o','s'=>[
                ['n'=>'查看','m'=>'view'],
            ]],
            ['n'=>'我的收藏','c'=>'favor','m'=>'index','i'=>'fa fa-newspaper-o','s'=>[
                ['n'=>'查看','m'=>'view'],
            ]],
            /*['n'=>'动态提醒','c'=>'classes','m'=>'index','i'=>'fa fa-random','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'班级信息','c'=>'comment','m'=>'index','i'=>'fa fa-comment-o','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'我的收藏','c'=>'comment','m'=>'index','i'=>'fa fa-comment-o','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],*/
        ]],
        ['n'=>'医院模块','m'=>'hospital','i'=>'fa fa-h-square','s'=>[
            ['n'=>'医院列表','c'=>'hospital','m'=>'index','i'=>'fa fa-hospital-o'],
        ]],
        ['n'=>'医生模块','m'=>'doctor','i'=>'fa fa-h-square','s'=>[
            ['n'=>'医生标签列表','c'=>'tag','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医生头衔列表','c'=>'title','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医生列表','c'=>'doctor','m'=>'index','i'=>'fa fa-hospital-o'],
        ]],
        ['n'=>'手术模块','m'=>'operation','i'=>'fa fa-h-square','s'=>[
            ['n'=>'手术列表','c'=>'operation','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医院手术列表','c'=>'hospital','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医院手术订单号管理','c'=>'doctor','m'=>'index','i'=>'fa fa-hospital-o'],
        ]],
        ['n'=>'检查模块','m'=>'inspection','i'=>'fa fa-h-square','s'=>[
            ['n'=>'检查列表','c'=>'inspection','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医院检查列表','c'=>'hospital','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'医生订单号管理','c'=>'doctor','m'=>'index','i'=>'fa fa-hospital-o'],
        ]],
        ['n'=>'订单模块','m'=>'order','i'=>'fa fa-h-square','s'=>[
            ['n'=>'预约号管理','c'=>'number','m'=>'index','i'=>'fa fa-hospital-o'],
            ['n'=>'订单管理','c'=>'order','m'=>'index','i'=>'fa fa-hospital-o'],
        ]],
        /*['n'=>'消息中心','m'=>'message','i'=>'fa fa-wechat','s'=>[
            ['n'=>'发送短信','c'=>'sms','m'=>'index','i'=>'fa fa-exchange','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'家长留言','c'=>'feedback','m'=>'index','i'=>'fa fa-exchange','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'消息盒子','c'=>'note','m'=>'index','i'=>'fa fa-bullhorn','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
        ]],*/
        /*['n'=>'课业管理','m'=>'academic','i'=>'fa fa-wechat','s'=>[
            ['n'=>'家庭作业','c'=>'homework','m'=>'index','i'=>'fa fa-exchange','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'成绩查询','c'=>'score','m'=>'index','i'=>'fa fa-bullhorn','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'课程表','c'=>'note','m'=>'index','i'=>'fa fa-bullhorn','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
        ]],*/
        /*['n'=>'通知中心','m'=>'notification','i'=>'fa fa-wechat','s'=>[
            ['n'=>'官方通知','c'=>'feedback','m'=>'index','i'=>'fa fa-exchange','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'学校通知','c'=>'note','m'=>'index','i'=>'fa fa-bullhorn','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
        ]],*/
        ['n'=>'资讯模块','m'=>'cms','i'=>'fa fa-newspaper-o','s'=>[
            ['n'=>'资讯分类','c'=>'category','m'=>'index','i'=>'fa fa-random','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'资讯列表','c'=>'article','m'=>'index','i'=>'fa fa-newspaper-o','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            /*['n'=>'评论列表','c'=>'comment','m'=>'index','i'=>'fa fa-comment-o','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],*/
        ]],
        ['n'=>'用户模块','m'=>'member','i'=>'fa fa-users','s'=>[
            ['n'=>'注册用户列表','c'=>'member','m'=>'index','i'=>'fa fa-map-marker'],
            /*['n'=>'客服列表','c'=>'support','m'=>'index','i'=>'fa fa-mortar-board','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'老师列表','c'=>'teacher','m'=>'index','i'=>'fa fa-mortar-board','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'家长列表','c'=>'parent','m'=>'index','i'=>'fa fa-male','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'学生列表','c'=>'student','m'=>'index','i'=>'fa fa-child','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'用户导入','c'=>'import','m'=>'index','i'=>'fa fa-child','s'=>[
            ]],*/
        ]],
        /*['n'=>'学校模块','m'=>'school','i'=>'fa fa-university','s'=>[
            ['n'=>'学校列表','c'=>'school','m'=>'index','i'=>'fa fa-cc','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'班级列表','c'=>'classes','m'=>'index','i'=>'fa fa-cc','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'科目列表','c'=>'subject','m'=>'index','i'=>'fa fa-book','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
            ['n'=>'课程列表','c'=>'course','m'=>'index','i'=>'fa fa-calendar','s'=>[
                ['n'=>'创建','m'=>'create'],
                ['n'=>'查看','m'=>'view'],
                ['n'=>'更新','m'=>'update'],
                ['n'=>'删除','m'=>'delete'],
            ]],
        ]],*/
    ]
];
