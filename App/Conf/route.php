<?php
return setRoute(array(
    //test
    array('xx', 'Api/Test/Index', 'GET'),           #测试
    array('get-token', 'Api/Test/GetToken', 'GET'), #获取token

    //home
    array('api/home-render', 'Api/Home/Render', 'GET'),             #首页初始化接口
    array('api/home-nav-list', 'Api/Home/NavList', 'GET'),          #栏目导航列表
    array('api/spell-group', 'Api/Home/SpellGroup', 'GET'),         #拼团接口
    array('api/goods-render/:type', 'Api/Home/GoodsRender', 'GET'), #首页商品渲染列表

    //admin
    array('api/admin/upload', 'Api/AdminIndex/Upload', 'POST'), #文件上传接口

    //config
    array('api/config/get-detail', 'Api/HomeConfig/GetDetail', 'GET'), #获取首页配置详情
    array('api/config/set-config', 'Api/HomeConfig/SetConfig', 'PUT'), #设置首页配置

    //nav
    array('api/nav/get-list:page', 'Api/Nav/GetList', 'GET'),   #分页获取栏目列表
    array('api/nav/get-detail:id', 'Api/Nav/GetDetail', 'GET'), #查询导航栏目详情
    array('api/nav/add-nav', 'Api/Nav/AddNav', 'POST'),         #增加导航栏目
    array('api/nav/edit-nav', 'Api/Nav/EditNav', 'PUT'),        #编辑导航栏目
    array('api/nav/del-nav:id', 'Api/Nav/DelNav', 'DELETE'),    #查询导航栏目详情
));