<?php
class HomeConfigAction extends Action {
    private $service = NULL;

    public function __construct(){
        $this->service = Service('HomeConfig');
    }

    /**
     * 获取首页配置详情
     */
    public function getDetail(){
        if(!$config = $this->service->getAllConfig())
            response(500, 'Error');

        response(200, 'Successful', $config);
    }

    /**
     * 设置首页配置
     */
    public function setConfig(){

    }
}