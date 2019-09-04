<?php
class HomeAction extends Action {
    private $service        = NULL;
    private $config_service = NULL;
    private $packagetour    = NULL;
    private $goods_server   = NULL;

    public function __construct(){
        $this->service        = Service('NavList');
        $this->config_service = Service('HomeConfig');
        $this->packagetour    = Service('GoodsPackagetour');
        $this->goods_server   = Service('Goods');
    }

    /**
     * ��ҳ��ʼ���ӿ�
     */
    public function render(){
        if(!$config = $this->config_service->getRenderConfig())
            response(500, 'Error');

        response(200, 'Successful', $config);
    }

    /**
     * ��Ŀ�����б�ӿ�
     */
    public function navList(){
        if(!$data = $this->service->getList())
            response(500, 'Error');

        response(200, 'Successful', $data);
    }

    /**
     * ƴ�Žӿ�
     */
    public function spellGroup(){
        //get value
        if(!$ids = $this->config_service->getKey('spell_group_ids'))
            response(500, 'Error');

        //get data
        if(!$data = $this->packagetour->getListByIds($ids))
            response(500, 'Error');

        response(200, 'Successful', $data);
    }

    /**
     * ��Ʒ��Ⱦ�ӿ�
     */
    public function goodsRender(){
        //validata
        $request = getRequest();
        if(empty($request['type']))
            response(401, 'Parameter type cannot be empty');
        $type = $request['type'];

        //get ids
        if((!$group_ids = $this->config_service->getKey('goods_ids')) || !isset($group_ids[$type]))
            response(500, 'Error');
        $ids = $group_ids[$type];

        //get data
        if(!$data = $this->goods_server->getListByIds($ids))
            response(200, 'NULL', array());

        response(200, 'Successful', $data);
    }
}