<?php
class AdminHomeAction extends Action {
    private $service = NULL;

    public function __construct(){
        $this->service = Service('Upload');
    }

    /**
     * �ļ��ϴ��ӿ�
     */
    public function upload(){
        //�ϴ��ļ�
        $upload_res = $this->service->simpleUpload();
        if(!$upload_res['result'])
            response(500, $upload_res['info']);

        //�����ϴ���Ϣ
        $save_res = $this->service->save($upload_res['info']);
        if(!$save_res['result'])
            response(500, $save_res['info']);

        response(200, 'Successful');
    }
}