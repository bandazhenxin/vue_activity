<?php
class HomeConfigService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('HomeConfig');
    }

    /**
     * 获取首页配置
     * @return array|bool
     */
    public function getRenderConfig(){
        //get data
        $config_res = false;
        $condition  = array();
        $condition['conf_key'] = array('IN', 'home_banner,activity_deadline,home_background');
        $config_list = $this->model->where($condition)->getField('conf_key,type,conf_value');

        //handle
        if($config_list && 3 == count($config_list)){
            $config_res = array();
            foreach($config_list as $config_key => $config){
                $value = 1 == $config['type'] ? json_decode($config['conf_value'], true) : $config['conf_value'];
                $config_res[$config_key] = $value;
            }
        }

        return $config_res;
    }

    public function getKey($key){
        if(!is_string($key)) return false;

        $res = '';
        $data = $this->model->where(array('conf_key' => $key))->find();
        if($data) $res = $data['conf_value'];

        return $res;
    }
}