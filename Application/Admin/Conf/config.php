<?php
return array(
     /*数据库配置*/
	 'DB_TYPE' => 'mysql',   //数据库类型
	 'DB_HOST' => '127.0.0.1',  //数据库地址
	 'DB_NAME' => 'think',    //数据库名称
	 'DB_USER' => 'root',   //用户名
	 'DB_PWD'  => '',      //密码
	 
	 //划分项目前后台模块
    'MODULE_ALLOW_LIST'      =>  array('Home','Admin'),
    //设置系统默认访问路径
    'DEFAULT_MODULE'        =>  'Admin',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Login', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    //设置URL调度模式(默认)
    //设置URL不区分链接大小写
    'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    //设置模板替换标记
    'TMPL_PARSE_STRING'        =>    array(
        '__PUBLIC__' => '/think-demo/Application/Admin/View/Public',
		'__ACTIONURL__' => '/think-demo/Application/Admin/Controller'		
		
    ),
	
	'TMPL_ACTION_SUCCESS'=>'Public:dispatch_jump',
	'TMPL_ACTION_ERROR'=>'Public:dispatch_jump',
	
	/*SESSION和COOKIE配置*/
	'SESSION_PREFIX'  => 'think_admin'


);