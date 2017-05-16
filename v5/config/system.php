<?php


/**
 * 系统配置文件
 */

return array(

	'SYS_LOG'                       => 1, //后台操作日志开关
	'SYS_KEY'                       => '24b16fede9a67c9251d3e7c7161c83ac', //安全密钥
	'SYS_DEBUG'                     => 0, //调试器开关
	'SYS_EMAIL'                     => '', //系统收件邮箱，用于接收系统信息
	'SYS_AUTO_CACHE'                => 1, //自动缓存
	'SITE_ADMIN_CODE'               => 0, //后台登录验证码开关
	'SITE_ADMIN_PAGESIZE'           => 8, //后台数据分页显示数量
	'SYS_CACHE_INDEX'               => 0, //站点首页静态化
	'SYS_CACHE_MSHOW'               => 0, //模型内容缓存期
	'SYS_CACHE_MSEARCH'             => 0, //模型搜索缓存期
	'SYS_CACHE_LIST'                => 0, //List标签查询缓存
	'SYS_CACHE_MEMBER'              => 0, //会员信息缓存期
	'SYS_CACHE_ATTACH'              => 0, //附件信息缓存期
	'SYS_CACHE_FORM'                => 0, //表单内容缓存期
	'SYS_CACHE_TAG'                 => 0, //Tag内容缓存期

);