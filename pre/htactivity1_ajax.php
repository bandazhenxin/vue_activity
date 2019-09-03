<?php
define('IN_ECS', true);
require_once(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
include_once(ROOT_PATH.'includes/lib_user_svip.php');

$ua = $_SERVER['SERVER_NAME'];
if($ua == "www.guojimami.com")
//if($ua == "localhost")
{
	$isPC = 1;
}
else
{
	$isPC = 0;
}
//$isPC = 1;
if($isPC == 1)
{
	$smarty->template_dir   = ROOT_PATH . 'themesmobile/' . $_CFG['template'];
}


if ($_REQUEST['act'] == 'ajax_goods_huadong')
{

	$smarty->assign('baokuan_goods', get_newyear_goods('baokuan'));
	$smarty->assign('liangfan_goods', get_newyear_goods('liangfan'));
	$smarty->assign('naifen_goods', get_newyear_goods('naifen'));
	$smarty->assign('yingyang_goods', get_newyear_goods('yingyang'));
	$smarty->assign('fushi_goods', get_newyear_goods('fushi'));
	$smarty->assign('diaper_goods', get_newyear_goods('diaper'));
    $smarty->assign('xihu_goods', get_newyear_goods('xihu'));



	$output = $GLOBALS['smarty']->fetch('library/htactivityback.lbi');
	$arrs['index_goods']=$output;
	$json = new JSON;
	echo $json->encode($arrs);
}
if ($_REQUEST['act'] == 'ajax_goods_lieju')
{   
	
	$smarty->assign('weiyang_goods', get_newyear_goods('weiyang'));
	$smarty->assign('tongzhuang_goods', get_newyear_goods('tongzhuang'));
	$smarty->assign('meizhuang_goods', get_newyear_goods('meizhuang'));
	$smarty->assign('yunma_goods', get_newyear_goods('yunma'));
	$smarty->assign('baojian_goods', get_newyear_goods('baojian'));
	$smarty->assign('wanbiao_goods', get_newyear_goods('wanbiao'));


	



	$output = $GLOBALS['smarty']->fetch('library/htactivityback1.lbi');
	$arrs['index_goods']=$output;
	$json = new JSON;
	echo $json->encode($arrs);
}



 /**

 * 按照销量排列,查找各个国家的商品
 *
 * @access  public
 * @param   string  $children
 * @return  array
 */

function get_newyear_goods($goods)
{
	$where=" where is_on_sale=1 and is_alone_sale=1 and is_delete=0 ";

if($goods=='baokuan')
	{
		$where.=" and g.goods_id in(14711,15653,33783,33776,33457,920,26157,7710,20724,17327,33374,23723,14693,33043,14702,19290,5288,5295,2484,30867,30865,33727,8379,994,33600,2684,16563,2482,16482,992,571,22041,22046,18809,4872,21951,21971,5642,747,29611,19278,27853,23725,21957) order by field(g.goods_id,14711,15653,33783,33776,33457,920,26157,7710,20724,17327,33374,23723,14693,33043,14702,19290,5288,5295,2484,30867,30865,33727,8379,994,33600,2684,16563,2482,16482,992,571,22041,22046,18809,4872,21951,21971,5642,747,29611,19278,27853,23725,21957) ";
}	
if($goods=='liangfan')
	{
		$where.=" and g.goods_id in(23405,16357,28332,24479,33036,33034,25799,33376,927,33042,5287,7708,29079,8380,3907,5293,2932,5186,1072,20642,996,22326,19202,5581,19009,29073,16470,1090,22026,584,21986,22022,34076,32954,32672,34041,33653,22043,5641,32835,27607,22872,23316,6689) order by field(g.goods_id,23405,16357,28332,24479,33036,33034,25799,33376,927,33042,5287,7708,29079,8380,3907,5293,2932,5186,1072,20642,996,22326,19202,5581,19009,29073,16470,1090,22026,584,21986,22022,34076,32954,32672,34041,33653,22043,5641,32835,27607,22872,23316,6689) ";
}
if($goods=='naifen')
	{
		$where.=" and g.goods_id in(1074,3415,3416,28458,28460,4848,4904,23813,554,32938,5582,2483,1091,34077,2026,30420,990,1088,2481,22023,586,583,5563,4845,4834,32587,34038,5206,4864,4868,20,1985,746,5639) order by field(g.goods_id,1074,3415,3416,28458,28460,4848,4904,23813,554,32938,5582,2483,1091,34077,2026,30420,990,1088,2481,22023,586,583,5563,4845,4834,32587,34038,5206,4864,4868,20,1985,746,5639) ";
}
if($goods=='yingyang')
	{
		$where.=" and g.goods_id in(24481,16443,24483,25195,16393,7711,19108,33018,33008,9998,33390,25047,14701,16411,7709,16398,33728,20532,25046,16439,33600,16407,18582,26097,33643,33640,34144,26514,27867,30833,16464,27761,27115,21968,19279,18919) order by field(g.goods_id,24481,16443,24483,25195,16393,7711,19108,33018,33008,9998,33390,25047,14701,16411,7709,16398,33728,20532,25046,16439,33600,16407,18582,26097,33643,33640,34144,26514,27867,30833,16464,27761,27115,21968,19279,18919) ";
}
if($goods=='fushi')

	{
		$where.=" and g.goods_id in(14769,23407,17298,33302,16517,33777,33293,14682,3886,33782,21401,26568,25790,23495,28330,33456,33035,33033,33721,10141,16339,24220,33323,33317,16247,23498,25037,33295,29060,17579) order by field(g.goods_id,14769,23407,17298,33302,16517,33777,33293,14682,3886,33782,21401,26568,25790,23495,28330,33456,33035,33033,33721,10141,16339,24220,33323,33317,16247,23498,25037,33295,29060,17579) ";
}
if($goods=='diaper')
	{
		$where.=" and g.goods_id in(2684,30875,5287,5283,5286,29919,5284,30867,5289,30859,2933,5288,5279,5290,5279,5281,5292,5275,5292,5278,5291,8379,8380,5295,5293,5296) order by field(g.goods_id,2684,30875,5287,5283,5286,29919,5284,30867,5289,30859,2933,5288,5279,5290,5279,5281,5292,5275,5292,5278,5291,8379,8380,5295,5293,5296) ";
}
if($goods=='xihu')
	{
		$where.=" and g.goods_id in(23711,23868,19566,23597,20814,23598,2015,18862,25338,12098,1389,32024,32023,22715,27589,32022,19947,15659,32025,4162,19942,19951,30416,1390,2215,27257) order by field(g.goods_id,23711,23868,19566,23597,20814,23598,2015,18862,25338,12098,1389,32024,32023,22715,27589,32022,19947,15659,32025,4162,19942,19951,30416,1390,2215,27257) ";
}
if($goods=='weiyang')
	{
		$where.=" and g.goods_id in(33998,2016,13146,14369,12096,21348,18050,3326,23715,26983,23720,24140,32030,32031,15136,539,27113,27114,22044,22040,14378,20013,9754,331) order by field(g.goods_id,33998,2016,13146,14369,12096,21348,18050,3326,23715,26983,23720,24140,32030,32031,15136,539,27113,27114,22044,22040,14378,20013,9754,331) ";
}
if($goods=='tongzhuang')
	{
		$where.=" and g.goods_id in(25088,25089,20729,29313,29311,25103,20730,25117,22842,23088,27124,27118,20647,26818,27125,19957,23357,25121,22612,25125,14597,15480,11688,13698) order by field(g.goods_id,25088,25089,20729,29313,29311,25103,20730,25117,22842,23088,27124,27118,20647,26818,27125,19957,23357,25121,22612,25125,14597,15480,11688,13698) ";
}

if($goods=='meizhuang')
	{
		$where.=" and g.goods_id in(6938,1744,11185,20458,22592,20465,30415,22886,3285,29344,34016,23310,22255,27502,18035,18038,29343,33125,8256,20010,8717,7030,8426,10928,2000,11569,1618,6917,7337,20073,33847,33398,33359,25000,23323,12598) order by field(g.goods_id,6938,1744,11185,20458,22592,20465,30415,22886,3285,29344,34016,23310,22255,27502,18035,18038,29343,33125,8256,20010,8717,7030,8426,10928,2000,11569,1618,6917,7337,20073,33847,33398,33359,25000,23323,12598) ";
}
if($goods=='yunma')
	{
		$where.=" and g.goods_id in(27167,14761,19814,33118,14749,24486,25963,29068,34045,30413,23694,22701,26003,30336,22959,25961,20293,23698,18249,22946) order by field(g.goods_id,27167,14761,19814,33118,14749,24486,25963,29068,34045,30413,23694,22701,26003,30336,22959,25961,20293,23698,18249,22946) ";
}
if($goods=='baojian')
	{
		$where.=" and g.goods_id in(19662,18840,23134,25989,23631,23677,25210,33393,19763,23670,23668,28657,17923,28642,18854,28667,25410,15045,29071,28714) order by field(g.goods_id,19662,18840,23134,25989,23631,23677,25210,33393,19763,23670,23668,28657,17923,28642,18854,28667,25410,15045,29071,28714) ";
}
if($goods=='wanbiao')
	{
		$where.=" and g.goods_id in(30204,33916,1701,23306,16099,32543,16996,25525,9450,1431,24661,26368,14114,31053,17033,298,13459,22542,22562,9972) order by field(g.goods_id,30204,33916,1701,23306,16099,32543,16996,25525,9450,1431,24661,26368,14114,31053,17033,298,13459,22542,22562,9972) ";
}



/* 获得商品列表 */
    $sql = 'SELECT g.goods_id , g.promote_price , g.goods_name , g.market_price , g.shop_price  , g.goods_brief , g.goods_thumb , g.goods_img , g.goods_gc  , g.goods_ggy , g.goods_number , g.promote_start_date , g.activity_price1 , g.activity_price2 , g.describe1, g.describe2, g.promote_end_date, ' .
                "IFNULL(mp.user_price, g.shop_price) AS shop_price, g.promote_price, g.goods_type, " .
                'g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img , g.salesnum, g.goods_gc, g.zys, g.goods_ggy, g.q_time, g.goods_number  , g.click_count, g.tax, g.tax1,g.vip_discount1,g.vip_discount2 ' .
            'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
            'LEFT JOIN ' . $GLOBALS['ecs']->table('member_price') . ' AS mp ' .
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' AND g.is_on_sale = 1 AND g.is_delete = 0 AND g.goods_number > 0 " . $where  ; 
	$res = $GLOBALS['db']->query($sql);

    $arr = array();
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
	    /*税费及超级会员价计算开始*/
		$shop_price = $row['shop_price'];
		$promote_price_org = $row['promote_price'] > 0 ? $row['promote_price'] : 0;
		//判断税费模板是否生效
		$time = gmtime();
		$tax_id = '';
		if($row['tax'] or $row['tax1'])
		{
			$sql = "SELECT tax_id, tax_start_date, tax_end_date FROM ".$GLOBALS['ecs']->table('taxation')." WHERE tax_id = '$row[tax]' OR tax_id = '$row[tax1]'";
			$tax_date = $GLOBALS['db']->getAll($sql);
			foreach($tax_date as $key=>$val)
			{
				if(($time > $val['tax_start_date']) && ($time < $val['tax_end_date']))
				{
					$tax_id = $val['tax_id'];
				}
				else
				{
					$tax_id = '';
				}
			}
		}
		//该商品是否配置了税费模板,获取税率
		if($tax_id)
		{
			$sql = "SELECT * FROM ".$GLOBALS['ecs']->table('taxation')." WHERE tax_id = '$tax_id'";
			$tax_info = $GLOBALS['db']->getRow($sql);
			//获取该商品税费类型
			if ($tax_info['daijiao'] || $tax_info['butie'])
			{
				$tax_rate = ($tax_info['tax'] / 100);
			}else
			{
				$tax_rate = '';
			}	
		}else
		{
			$tax_rate = '';
		}
		
		//是否享超级会员价
		$is_svip = get_svip_info();
		if ($is_svip)
		{
			//获取正在使用的超级会员模板信息,折扣率在vip_discount表获取

			$vip_discount_info = get_svip_discount($row['vip_discount1'] ,$row['vip_discount2']);
			if ($vip_discount_info)
			{
				$svip_discount = $vip_discount_info / 100;
				//超级会员价
				$row['shop_price'] = number_format(($shop_price * $svip_discount), 2, '.', '');
				$row['promote_price'] = number_format(($promote_price_org * $svip_discount), 2, '.', '');
			}
			else
			{
				$row['shop_price'] = number_format($shop_price * $_SESSION['discount'], 2, '.', '');
				$row['promote_price'] = number_format($promote_price_org * $_SESSION['discount'], 2, '.', '');
			}
		}
		else
		{
			$row['shop_price'] = number_format($shop_price * $_SESSION['discount'], 2, '.', '');
			$row['promote_price'] = number_format($promote_price_org * $_SESSION['discount'], 2, '.', '');
		}
		
		if ($tax_rate)
		{
			//计算税率及商品价格
			$row['shop_price'] = number_format($row['shop_price']/(1+$tax_rate), 0, '.', '');
			$row['promote_price'] = number_format($row['promote_price']/(1+$tax_rate), 0, '.', '');

			$tax_price = number_format(($row['shop_price'] * $tax_rate), 0, '.', '');
			$tax_price_tm = number_format(($row['promote_price'] * $tax_rate), 0, '.', '');
		}
		else
		{  
		  if(floor($row['shop_price'])==$row['shop_price']){
		    $row['shop_price']    = intval($row['shop_price']);
		  }else{
			$row['shop_price']    = number_format($row['shop_price'],1);
			}
		  if(floor($row['promote_price'])==$row['promote_price']){
			$row['promote_price'] = intval($row['promote_price']);
		  }else{
			$row['promote_price'] = number_format($row['promote_price'],1);
			}	
		}
		/*税费及超级会员价计算结束*/	
		
        if ($row['promote_price'] > 0)	
        {
            $promote_price = promotion_templates ($row['goods_id'],$row['promote_price']);

        }
        else
        {
            $promote_price = 0;
        }
		
		//$promote_price	 = $row['promote_price'];
		/*套餐参数,加在url里*/
		$sql = "select pkid from ". $GLOBALS['ecs']->table('product') . " where tc_id = ".$row['goods_id'];
		$pkid = $GLOBALS['db']->getone($sql);
		
        $arr[$row['goods_id']]['goods_id']      = $row['goods_id'];
        if($GLOBALS['display'] == 'grid')
        {
            $arr[$row['goods_id']]['goods_name']       = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
        }
        else
        {
            $arr[$row['goods_id']]['goods_name']       = $row['goods_name'];
        }
		
		/*评论数量*/

		$count = $GLOBALS['db']->getOne("SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('comment') . " where comment_type=0 and id_value = " .$row['goods_id']);
		$sql = "select img_url from ". $GLOBALS['ecs']->table('goods_gallery'). " where  goods_id=" .$row['goods_id'] . " and img_desc = 3"  ;
		$img_desc = $GLOBALS['db']->getOne($sql);
        $arr[$row['goods_id']]['img_desc'] =  $img_desc ;
	
        $arr[$row['goods_id']]['review_count']      = $count;
		$arr[$row['goods_id']]['activity_price1']  = $row['activity_price1'];
		$arr[$row['goods_id']]['activity_price2']  = $row['activity_price2'];
		$arr[$row['goods_id']]['describe1']       = $row['describe1'];
		$arr[$row['goods_id']]['describe2']       = $row['describe2'];
		
        $arr[$row['goods_id']]['market_price']  = intval($row['market_price']);
		$arr[$row['goods_id']]['market_price1']  = intval($row['market_price']);
        $arr[$row['goods_id']]['shop_price']    = $row['shop_price'] ;
		$arr[$row['goods_id']]['shop_price1']    = $row['shop_price'];
        $arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? $row['promote_price']  : '';

        $arr[$row['goods_id']]['promote_price1'] = ($promote_price > 0) ? $row['promote_price'] : '';
		if ($promote_price > 0)
		{
		$arr[$row['goods_id']]['zhekou_price'] = round((($row['promote_price']/$row['market_price'])*10),1);
		}
		else
		{
		$arr[$row['goods_id']]['zhekou_price'] = round((($row['shop_price']/$row['market_price'])*10),1);
		}
		if ($promote_price > 0)
		{
		$arr[$row['goods_id']]['o_price']    = sprintf("%.2f", ($row['promote_price']/7.631));
		}
		else
		{
		$arr[$row['goods_id']]['o_price']    = sprintf("%.2f", ($row['shop_price']/7.631));
		}


        $arr[$row['goods_id']]['goods_brief']   = $row['goods_brief'];
        $arr[$row['goods_id']]['goods_thumb']   = get_image_path($row['goods_id'], $row['goods_thumb'], true);
        $arr[$row['goods_id']]['goods_img']     = get_image_path($row['goods_id'], $row['goods_img']);
        $arr[$row['goods_id']]['url']           = build_uri('goods', array('gid' => $row['goods_id'], 'pkid' => $pkid), $row['goods_name']);
		$arr[$row['goods_id']]['goods_gc']             = $row['goods_gc'];
		if ($row['goods_gc'] > 1)
		{
		$arr[$row['goods_id']]['goods_zj']             = ($promote_price > 0) ? $row['promote_price'] :$row['shop_price'];
		$arr[$row['goods_id']]['goods_zj']       = number_format($arr[$row['goods_id']]['goods_zj'] * $row['goods_gc'],1);
		}
		$arr[$row['goods_id']]['goods_ggy']             = $row['goods_ggy'];
		$arr[$row['goods_id']]['goods_number']             = $row['goods_number'];
	    $sql1= "select count(*)  from ".$GLOBALS['ecs']->table('comment')." where id_value='".$arr[$row['goods_id']]['goods_id']."'  AND status = 1";
        $arr[$row['goods_id']]['goods_plnum'] = $GLOBALS['db']->getOne($sql1);
		$arr[$row['goods_id']]['click_count'] = $row['salesnum'];
		$arr[$row['goods_id']]['cuxiao_sheng_price'] = $row['market_price']-$row['promote_price'];
		$arr[$row['goods_id']]['cuxiao_zhekou_price'] = round(($row['promote_price']/$row['market_price'])*100)/10+"";
		$arr[$row['goods_id']]['goods_goumai']  = 6500 -  $row['goods_number'];
		$arr[$row['goods_id']]['goods_goumai1']  = 6500 -  $row['goods_number'];
		$arr[$row['goods_id']]['goods_goumai2']  = 6500 -  $row['goods_number'];
		$arr[$row['goods_id']]['goods_goumai3']  = 6500 -  $row['goods_number'];
		
		
		
		$sql = "select pkname from " . $GLOBALS['ecs']->table('product') . " where tc_id= " . $row['goods_id'];
		$sftc = $GLOBALS['db']->getOne($sql);
		if ($sftc > 0)
		{
			$arr[$row['goods_id']]['pkname'] = $sftc;
		}
		if (!empty($_SESSION['user_id']))
		{
			$user_id = $_SESSION['user_id'];
			$sql = "select goods_id from ". $GLOBALS['ecs']->table('collect_goods') . " where user_id = $user_id";
			$user_goods = $GLOBALS['db']->query($sql);
			while ($row = $GLOBALS['db']->fetchRow($user_goods))
			{
						if ($row['goods_id'] == $row['goods_id'])
						{
						$arr[$row['goods_id']]['ysc'] = 1;
						}
			}
		}
  
}

    return $arr;
}


?>