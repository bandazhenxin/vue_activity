<?php
class GoodsPackagetourService{
    private $model = NULL;

    public function __construct(){
        $this->model = D('GoodsPackagetour');
    }

    public function getListByIds($Ids){
        if(!is_string($Ids)) return false;

        //query
        $field = 'p.act_id,p.cat_id,p.act_name,p.act_desc,p.goods_id,p.is_finished,p.ext_info,p.pake_pepo_number,
                p.packe_price,p.click_count,g.goods_img,p.is_splendid,p.countpac,pik_number,p.is_guess,g.shop_price,
                g.market_price';
        $map   = array();
        $map['p.act_id']      = array('IN',$Ids);
        $map['p.is_finished'] = 1;
        $map['p.act_type']    = 'CART_PACKAGETOUR_GOODS';
        $data = $this->model
                ->alias('p')
                ->field($field)
                ->join('ecs_goods AS g ON p.goods_id =g.goods_id')
                ->where($map)
                ->select();

        //handle

        return $data;
    }
}