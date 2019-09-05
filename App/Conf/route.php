<?php
return setRoute(array(
    //test
    array('xx', 'Api/Test/Index', 'GET'),           #����
    array('get-token', 'Api/Test/GetToken', 'GET'), #��ȡtoken

    //home
    array('api/home-render', 'Api/Home/Render', 'GET'),             #��ҳ��ʼ���ӿ�
    array('api/home-nav-list', 'Api/Home/NavList', 'GET'),          #��Ŀ�����б�
    array('api/spell-group', 'Api/Home/SpellGroup', 'GET'),         #ƴ�Žӿ�
    array('api/goods-render/:type', 'Api/Home/GoodsRender', 'GET'), #��ҳ��Ʒ��Ⱦ�б�

    //admin
    array('api/admin/upload', 'Api/AdminIndex/Upload', 'POST'), #�ļ��ϴ��ӿ�

    //config
    array('api/config/get-detail', 'Api/HomeConfig/GetDetail', 'GET'), #��ȡ��ҳ��������
    array('api/config/set-config', 'Api/HomeConfig/SetConfig', 'PUT'), #������ҳ����

    //nav
    array('api/nav/get-list:page', 'Api/Nav/GetList', 'GET'),   #��ҳ��ȡ��Ŀ�б�
    array('api/nav/get-detail:id', 'Api/Nav/GetDetail', 'GET'), #��ѯ������Ŀ����
    array('api/nav/add-nav', 'Api/Nav/AddNav', 'POST'),         #���ӵ�����Ŀ
    array('api/nav/edit-nav', 'Api/Nav/EditNav', 'PUT'),        #�༭������Ŀ
    array('api/nav/del-nav:id', 'Api/Nav/DelNav', 'DELETE'),    #��ѯ������Ŀ����
));