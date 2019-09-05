<?php
class AdminHomeAction extends Action {
    private $service = NULL;

    public function __construct(){
        $this->service = Service('Upload');
    }

    /**
     * 文件上传接口
     */
    public function upload(){
        //上传文件
        $upload_res = $this->service->simpleUpload();
        if(!$upload_res['result'])
            response(500, $upload_res['info']);

        //保存上传信息
        $save_res = $this->service->save($upload_res['info']);
        if(!$save_res['result'])
            response(500, $save_res['info']);

        response(200, 'Successful');
    }
}