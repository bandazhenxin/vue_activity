<?php
return setRoute(array(
    //test
    array('xx', 'Api/Test/Index', 'GET'),           #测试
    array('get-token', 'Api/Test/GetToken', 'GET'), #获取token

    //home
    array('api/home-render', 'Api/Home/Render', 'GET'),     #首页初始化接口
    array('api/home-nav-list', 'Api/Home/NavList', 'GET'),  #栏目导航列表
    array('api/spell-group', 'Api/Home/SpellGroup', 'GET'), #拼团接口
));