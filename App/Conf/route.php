<?php
return setRoute(array(
    //test
    array('xx', 'Api/Test/Index', 'GET'),           #����
    array('get-token', 'Api/Test/GetToken', 'GET'), #��ȡtoken

    //home
    array('api/home-render', 'Api/Home/Render', 'GET'),     #��ҳ��ʼ���ӿ�
    array('api/home-nav-list', 'Api/Home/NavList', 'GET'),  #��Ŀ�����б�
    array('api/spell-group', 'Api/Home/SpellGroup', 'GET'), #ƴ�Žӿ�
));