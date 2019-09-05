<?php
import("ORG.Net.UploadFile");

class UploadService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('Upload');
    }

    /**
     * �����ļ��ϴ�
     * @return array
     */
    public function simpleUpload(){
        $upload = new UploadFile();
        $upload->maxSize   = 3145728;
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->autoSub   = true;
        $upload->saveRule  = 'uniqid';
        $upload->savePath  = './Uploads/';
        if(!$upload->upload()){
            return array('result' => false, 'info' => $upload->getErrorMsg());
        }else{
            return array('result' => true, 'info' => $upload->getUploadFileInfo());
        }
    }

    /**
     * �����ϴ�����
     * @param $info
     * @return array
     */
    public function save($info){
        //init
        $data  = array();
        $error = array('result' => true);

        //save
        $this->model->startTrans();
        try{
            foreach($info as $item){
                //������ȷinfo������Щ��Ϣ
            }
            $this->model->addAll($data);
        }catch (Exception $e){
            $this->model->rollback();
            return array('result' => false, 'info' => $e->getMessage());
        }

        return $error;
    }
}