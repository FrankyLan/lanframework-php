<?php
return [
	// 路由配置
	'router'=>[
	# 0 module/Action/arg1/arg2...
		'urlmode'=>0,
		'module_path'=>'/Application/Controller/',//指向创建模块的目录，不指定默认为框架内Modules文件夹
		'login'=>'login',//指向登陆模块，对非登陆模块进行session认证.值为则login代表module_path下的login模块，即login.php
		'index'=>'/login/index/',//系统入口
	],
	// 数据库配置
	'database'=>[
		'host'=>'127.0.0.1',					// 地址
		'port'=>3306,							// 端口
		'appname'=>'checkup',						// 数据库名称
		'accesskey'=>'root',							// 帐号
		'secretkey'=>'root',						// 密码
		'charset'=>'utf8',						// 数据表编码
	],
	'render'=>[
		#0 直接渲染网页
		#1 返回json数据包
		'mode'=>0
	],
	// 内存缓存
	// 'cache'=>[
	// 	'dsn'=>'memcache://127.0.0.1:11211', 	// dsn字符串形式定义
	// 	'scheme'=>'memcache',					// 缓存类型
	// 	'host'=>'127.0.0.1',					// 地址
	// 	'port'=>11211,							// 端口
	// ],
	// session
	'session'=>[
		'secret'=>'scu',//安全私钥
		'lock'=>'true',//session开关，默认为true
	]
];
