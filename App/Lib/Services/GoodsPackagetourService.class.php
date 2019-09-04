<?php
class GoodsPackagetourService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('GoodsPackagetour');
    }

    /**
     * 根据id集合获取数据
     * @param $ids
     * @return bool|mixed
     */
    public function getListByIds($ids){
        if(!is_string($ids)) return false;

        //query
        $field = 'p.act_id,p.cat_id,p.act_name,p.act_desc,p.goods_id,p.is_finished,p.ext_info,p.pake_pepo_number,
                p.packe_price,p.click_count,g.goods_img,p.is_splendid,p.countpac,pik_number,p.is_guess,g.shop_price,
                g.market_price';
        $map   = array();
        $map['p.act_id']      = array('IN',$ids);
        $map['p.is_finished'] = 1;
        $map['p.act_type']    = 7;
        $data = $this->model
                ->alias('p')
                ->field($field)
                ->join('ecs_goods AS g ON p.goods_id =g.goods_id')
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
        foreach($data as &$goods){
            $goods['market_price']    = number_format($goods['market_price'],0);
            $goods['countpac']        = $goods['countpac'] * $goods['pake_pepo_number'];
            $goods['packe_price_new'] = number_format($goods['packe_price'],0);
            $goods['market_price']    = number_format($goods['market_price'],0);
        }

        return $data;
    }
}