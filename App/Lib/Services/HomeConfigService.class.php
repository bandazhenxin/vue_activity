<?php
class HomeConfigService{
    private $model        = NULL;
    private $upload_model = NULL;
    private $mime_map     = array(); #不同配置mime类型与存储类型映射

    public function __construct(){
        $this->model        = D('HomeConfig');
        $this->upload_model = D('Upload');
        $this->mime_map     = array(
            array(0,1,2,4), #文本类型
            array(3,5),     #json类型
        );
    }

    /**
     * 获取所有配置信息
     * @return array|bool
     */
    public function getAllConfig(){
        //get data
        $config_res  = false;
        $config_list = $this->model->order('id ASC')->getField('conf_key,id,type,title,mime,conf_value,add_time');

        //handle
        if($config_list){
            foreach($config_list as &$config){
                if(1 == $config['type'])
                    $config['conf_value'] = json_decode($config['conf_value'], true);
            }
            $config_res = $config_list;
        }

        return $config_res;
    }

    /**
     * 获取首页渲染配置
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

    /**
     * 根据key获取value
     * @param $key
     * @return bool|mixed|string
     */
    public function getKey($key){
        if(!is_string($key)) return false;

        $res = '';
        $data = $this->model->where(array('conf_key' => $key))->find();
        if($data){
            $res = $data['conf_value'];
            if(json_decode($res, true)) $res = json_decode($res, true);
        }

        return $res;
    }

    public function setConfig($data){
        //validata
        if(!is_array($data)) return false;

        //get config
        $config = $this->getAllConfig();

        //save data construct
        $save = array();
        foreach($data as $data_item){
            if(!isset($data_item['key']) || !isset($data_item['value']) || !isset($config[ $data_item['key'] ]))
                continue;

            $item   = $config[ $data_item['key'] ];
            $save[] = array();
            $save['id']         = $item['id'];
            $save['conf_value'] = $this->valueData($data_item['value'], $item['mime']);
        }
    }

    private function valueData($value = '', $mime = 0){
        if(3 == $mime){
//            $this->upload_model->where()
        }

    }
}