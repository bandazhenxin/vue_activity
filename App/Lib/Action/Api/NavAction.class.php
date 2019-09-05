<?php
class NavAction extends Action {
    private $service = NULL;

    public function __construct(){
        $this->service = Service('NavList');
    }

    /**
     * 分页获取栏目列表
     */
    public function getList(){

    }

    /**
     * 查询导航栏目详情
     */
    public function getDetail(){

    }

    /**
     * 增加导航栏目
     */
    public function addNav(){

    }

    /**
     * 编辑导航栏目
     */
    public function editNav(){

    }

    /**
     * 查询导航栏目详情
     */
    public function delNav(){

    }
}