<?php
class HomeConfigAction extends Action {
    private $service = NULL;

    public function __construct(){
        $this->service = Service('HomeConfig');
    }

    /**
     * ��ȡ��ҳ��������
     */
    public function getDetail(){
        if(!$config = $this->service->getAllConfig())
            response(500, 'Error');

        response(200, 'Successful', $config);
    }

    /**
     * ������ҳ����
     */
    public function setConfig(){

    }
}