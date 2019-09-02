<?php
return array(
    //basic
	'APP_GROUP_LIST'    => 'Api',       #分组设置
    'DEFAULT_GROUP'     => 'Api',       #默认分组
    'LOAD_EXT_CONFIG'   => 'db,route',  #配置分组
    'LOAD_EXT_FILE'     => 'route,api', #bootstrap
    'URL_MODEL'         => 1,           #URL模式
    'URL_PATHINFO_DEPR' => '/',         #路由默认分隔符
    'URL_ROUTER_ON'     => true,        #开启路由
);