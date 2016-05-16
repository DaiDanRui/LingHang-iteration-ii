<?php
return array(
	//'配置项'=>'配置值'

    'SESSION_AUTO_STAR' => true,

    'URL_MODEL'=>1,
    /**路由配置*/
    'URL_ROUTER_ON'   => true,

    'URL_ROUTE_RULES'=>array(
        'user/loginPage'=>'user/loginPage',
        'user/login'=>'user/login',
        'user/registerPage'=>'user/registerPage',
        'user/register'=>'user/register',


        'skill/browse' => 'commodity/skill',
        'reward/browse' => 'commodity/reward',
        'commodity/browse' => 'commodity/skill',
        'skill/browse/page/:page' => 'commodity/browse',
        'reward/browse/page/:page' => 'commodity/browse',
        'commodity/browse/page/:page' => 'commodity/browse',

        'skill/details/id/:id' => 'commodity/details',
        'reward/details/id/:id' => 'commodity/details',
        'commodity/details/id/:id' => 'commodity/details',
        'commodity/upload' => 'commodity/upload',
        'uploadSkill' => 'commodity/uploadSkill',
        'skill/upload' => 'commodity/uploadSkill',
        'uploadReward' => 'commodity/uploadReward',
        'reward/upload' => 'commodity/uploadReward',

        'commodity/buy' => 'commodity/buy',

        'myCommodity/skill/page/:page'=>'myCommodity/publishSkill',
        'myCommodity/reward'=>'myCommodity/publishReward',
        'my-accepted/skill'=>'myCommodity/publishSkill',
        'my-accepted/reward'=>'myCommodity/publishReward',
//        'skill/details' => 'skill/details',

        'transaction/accept/skill/page/:page'=>'transaction/transactionSkill',
        'transaction/accept/reward/page/:page'=>'transaction/transactionReward',
        'transaction/accepted/reward/page/:page'=>'transaction/transactionAcceptedReward',
        'transaction/accepted/skill/page/:page'=>'transaction/transactionAcceptedSkill',


        'transaction/create/id/:id/phone/:phone'=>'transaction/create',



        'star/add/commodity_id/:commodity_id'=>'star/add',
        'myStarReward'=>'star/myStarReward',
        'myStarSkill'=>'star/myStarSkill',
        'evaluation/reward/page/:page'=>'evaluation/myEvaluatedReward',
        'evaluation/skill/page/:page'=>'evaluation/myEvaluatedSkill',

        'my-main'=>'mySetting/myPage',
        'mySetting/myPage'=>'mySetting/myPage',
        'my-account/income'=>'budget/income',
        'my-account/outcome'=>'budget/outcome',

    ),

    /** 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'LGdreamer_linghang',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'tbl_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号

    'PAGE_SIZE'             => 10,


    'TMPL_L_DELIM'          =>  '<{',            // 模板引擎普通标签开始标记
    'TMPL_R_DELIM'          =>  '}>',            // 模板引擎普通标签结束标记
);