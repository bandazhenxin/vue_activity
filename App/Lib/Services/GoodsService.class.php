<?php
class GoodsService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('Goods');
    }

    /**
     * 根据id集合获取数据
     * @param $ids
     * @return bool|mixed
     */
    public function getListByIds($ids){
        if(!is_string($ids)) return false;

        //query
        $field = 'g.goods_id,g.promote_price,g.goods_name,g.market_price,g.shop_price,g.goods_number,g.goods_thumb,g.goods_gc,p.pkid';
        $map   = array();
        $map['g.goods_id']     = array('IN',$ids);
        $map['g.is_on_sale']   = 1;
        $map['g.is_delete']    = 0;
        $map['g.goods_number'] = array('GT', 0);
        $data = $this->model
                ->alias('g')
                ->field($field)
                ->join('ecs_member_price AS mp ON mp.goods_id = g.goods_id')
                ->join('ecs_product AS p ON p.tc_id = g.goods_id')
                ->where($map)
                ->select();

        return $this->handle($data);
    }

    /**
     * 数据处理
     * @param $data
     * @return mixed
     */
    private function handle($data){
        $suffix     = '.html';
        $suffix_map = array(
            'm.guojimami.com' => '.htm',
            'app.guojimami.com' => '.shtml'
        );
        isset($suffix_map[ $_SERVER['SERVER_NAME'] ]) && $suffix = $suffix_map[ $_SERVER['SERVER_NAME'] ];

        foreach($data as &$goods){
            $goods['url'] = 'goods-' . $goods['goods_id'] . '-t' . $goods['pkid'] . $suffix;
            $goods['final_price'] = empty($goods['promote_price']) ? $goods['shop_price'] : $goods['promote_price'];
        }

        return $data;
    }
}