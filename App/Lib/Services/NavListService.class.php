<?php
class NavListService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('NavList');
    }

    /**
     * ��ȡ���п�������
     * @return mixed
     */
    public function getList(){
        $map = array();
        $map['is_use'] = 1;
        $list = $this->model
                ->field('id,name,type,banner,route,content,template')
                ->where($map)
                ->order('sort ASC')
                ->select();

        return $list;
    }
}