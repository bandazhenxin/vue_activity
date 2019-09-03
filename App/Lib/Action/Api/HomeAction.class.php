<?php
class HomeAction extends Action {
    private $service        = NULL;
    private $config_service = NULL;

    public function __construct(){
        $this->service        = Service('NavList');
        $this->config_service = Service('HomeConfig');
    }

    /**
     * 首页初始化接口
     */
    public function render(){
        if(!$config = $this->config_service->getRenderConfig())
            response(500, 'Error');

        response(200, 'Successful', $config);
    }

    /**
     * 栏目导航列表接口
     */
    public function navList(){
        if(!$data = $this->service->getList())
            response(500, 'Error');

        response(200, 'Successful', $data);
    }
}