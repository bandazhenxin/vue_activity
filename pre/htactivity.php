 <?php

/**
 * ECSHOP 首页文件
 * ============================================================================
 * 版权所有 2005-2010 上海商派网络科技有限公司,并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 17063 2010-03-25 06:35:46Z liuhui $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH.'includes/lib_user_svip.php');


/*------------------------------------------------------ */
//-- Shopex系统地址转换
/*------------------------------------------------------ */
if (!empty($_GET['gOo']))
{
    if (!empty($_GET['gcat']))
    {
        /* 商品分类。*/
        $Loaction = 'category.php?id=' . $_GET['gcat'];
    }
    elseif (!empty($_GET['acat']))
    {
        /* 文章分类。*/
        $Loaction = 'article_cat.php?id=' . $_GET['acat'];
    }
    elseif (!empty($_GET['goodsid']))
    {
        /* 商品详情。*/
        $Loaction = 'goods.php?id=' . $_GET['goodsid'];
    }
    elseif (!empty($_GET['articleid']))
    {
        /* 文章详情。*/
        $Loaction = 'article.php?id=' . $_GET['articleid'];
    }

    if (!empty($Loaction))
    {
        ecs_header("Location: $Loaction\n");

        exit;
    }
}
if (!empty($_SESSION['user_id']))
{
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$smarty->assign('user_id',       $user_id);
$smarty->assign('user_name',       $user_name);
} 

//判断是否有ajax请求
$action = !empty($_GET['act']) ? $_GET['act'] : '';
$smarty->assign("action",$action);

/*------------------------------------------------------ */
//-- 判断是否存在缓存,如果存在则调用缓存,反之读取相应内容
/*------------------------------------------------------ */
/* 缓存编号 */
$cache_id = sprintf('%X', crc32($_SESSION['user_rank'] . '-' . $_CFG['lang']));

if (!$smarty->is_cached('htactivity.dwt', $cache_id))
{
    assign_template();

    $position = assign_ur_here();
    $smarty->assign('page_title',      $GLOBALS['_CFG']['shop_title']);    // 页面标题
    $smarty->assign('ur_here',         $position['ur_here']);  // 当前位置

    /* meta information */
    $smarty->assign('keywords',        htmlspecialchars($_CFG['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($_CFG['shop_desc']));
    $smarty->assign('flash_theme',     $_CFG['flash_theme']);  // Flash轮播图片模板

    $smarty->assign('feed_url',        ($_CFG['rewrite'] == 1) ? 'feed.xml' : 'feed.php'); // RSS URL

    //$smarty->assign('categories',      get_categories_tree()); // 分类树
    $smarty->assign('helps',           get_shop_help());       // 网店帮助
    //$smarty->assign('top_goods',       get_top10());           // 销售排行
	

    /* 首页主广告设置 */
    $smarty->assign('index_ad',     $_CFG['index_ad']);
    if ($_CFG['index_ad'] == 'cus')
    {
        $sql = 'SELECT ad_type, content, url FROM ' . $ecs->table("ad_custom") . ' WHERE ad_status = 1';
        $ad = $db->getRow($sql, true); 
        $smarty->assign('ad', $ad);
    }

    
    $smarty->assign('data_dir',        DATA_DIR);       // 数据目录

    

    assign_dynamic('index'); 
}

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'login_ornot')
{
	include_once('includes/cls_json.php');

    $json   = new JSON;
    $result    = array('err_msg' => '', 'result' => '');
	/* 未登陆 */
	if (empty($_SESSION['user_id']))
	{
		$result['login'] = 0;
	}
	else
	{
		$result['login'] = 1;
	}
	die($json->encode($result));
}
elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'lingquan')
{
	include_once('includes/cls_json.php');

    $json   = new JSON;
    $result    = array('err_msg' => '', 'result' => '');
	/* 未登陆 */
	if (empty($_SESSION['user_id']))
	{
		$result['login'] = 0;
		die($json->encode($result));

	}
	else
	{
		$result['login'] = 1;
		$user_id = $_SESSION['user_id'];
		if (!empty($_REQUEST['send_type']))
		{
		$send_type = $_REQUEST['send_type'];

		
			/*取得是否有正在发放的红包 send_type=3线下发放的红包*/
			$time = gmtime();
			$sql = "select type_id   from " . $ecs->table('bonus_type')  . " where  send_start_date < $time and send_end_date  > $time  and send_type=$send_type   ";
			$sf_bonus = $db->getAll($sql);
			if($sf_bonus<=0)
			{
				$result['error']=1;
			} 
			else
			{
				foreach($sf_bonus AS $key => $val)
				{
					/*取得正在发放的红包是否有剩余*/
					$sql1 = "select min(bonus_id) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = 0";
					$fw_bonus = $db->getone($sql1);
					/*取得用户是否已经领取过红包了*/
					$sql2 = "select count(*) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = $user_id";
					//$result['error'] = $user_id;
					$lq_bonus = $db->getone($sql2);
					

					if (($fw_bonus <= 0) or ($lq_bonus > 0))
					{	
						$result['error'] = 1;
					}
					else
					{ 
							$result['error'] = 0;
							$db->query('UPDATE ' . $ecs->table('user_bonus') . " SET user_id = $user_id WHERE bonus_id = $fw_bonus");
							$result['hbff'] = 1;
					}
				}
			
			}
			die($json->encode($result));
	
		}
	}

}
elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'lingquan_9')
{
	include('includes/cls_json.php');

    $json   = new JSON;
    $result    = array('err_msg' => '', 'result' => '');
	/* 未登陆 */
	if (empty($_SESSION['user_id']))
	{
		$result['login'] = 0;
		die($json->encode($result));

	}
	else
	{
		$result['login'] = 1;
		$user_id = $_SESSION['user_id'];
		if (!empty($_REQUEST['type_id']))
		{
			$type_id = isset($_REQUEST['type_id']) ? $_REQUEST['type_id'] : 0;

		
			/*取得是否有正在发放的红包 send_type=3线下发放的红包*/
			$time = gmtime();
			$sql = "SELECT type_id FROM " . $ecs->table('bonus_type')  . " WHERE send_start_date <= '$time' AND send_end_date >= '$time' AND type_id = '$type_id' AND send_type = 9 ";
			
			$sf_bonus = $db->getAll($sql);
			if($sf_bonus<=0)
			{
				$result['error']=1;
			} 
			else
			{
				foreach($sf_bonus AS $key => $val)
				{
					/*取得正在发放的红包是否有剩余*/
					$sql1 = "select min(bonus_id) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = 0";
					$fw_bonus = $db->getone($sql1);
					/*取得用户是否已经领取过红包了*/
					$sql2 = "select count(*) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = $user_id";
					//$result['error'] = $user_id;
					$lq_bonus = $db->getone($sql2);
					

					if (($fw_bonus <= 0) or ($lq_bonus > 0))
					{	
						$result['error'] = 1;
					}
					else
					{ 
							$result['error'] = 0;
							$db->query('UPDATE ' . $ecs->table('user_bonus') . " SET user_id = $user_id WHERE bonus_id = $fw_bonus");
							$result['hbff'] = 1;
					}
				}
			
			
			die($json->encode($result));
	
		}
	}
}

}
elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'lingquan_cat')/*按类领*/
{
	include_once('includes/cls_json.php');

    $json   = new JSON;
    $result    = array('err_msg' => '', 'result' => '');
	/* 未登陆 */
	if (empty($_SESSION['user_id']))
	{
		$result['login'] = 0;
		die($json->encode($result));

	}
	else
	{
		$result['login'] = 1;
		$user_id = $_SESSION['user_id'];
		
		$cat = !empty($_REQUEST['cat']) ? $_REQUEST['cat'] : ' 0 ';
		$children = germany_children($cat);

			/*取得是否有正在发放的红包 send_type=3线下发放的红包*/
			$time = gmtime();
			$sql = "select type_id   from " . $ecs->table('bonus_type')  . " where  send_start_date < $time and send_end_date  > $time  and $children  and send_type=9  ";
			$sf_bonus = $db->getAll($sql);
			if($sf_bonus<=0)
			{
				$result['error']=1;
			} 
			else
			{
				foreach($sf_bonus AS $key => $val)
				{
					/*取得正在发放的红包是否有剩余*/
					$sql1 = "select min(bonus_id) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = 0";
					$fw_bonus = $db->getone($sql1);
					/*取得用户是否已经领取过红包了*/
					$sql2 = "select count(*) from " . $ecs->table('user_bonus') . " where bonus_type_id =".$val['type_id']." and user_id = $user_id";
					//$result['error'] = $user_id;
					$lq_bonus = $db->getone($sql2);
					

					if (($fw_bonus <= 0) or ($lq_bonus > 0))
					{	
						$result['error'] = 1;
					}
					else
					{ 
							$result['error'] = 0;
							$db->query('UPDATE ' . $ecs->table('user_bonus') . " SET user_id = $user_id WHERE bonus_id = $fw_bonus");
							$result['hbff'] = 1;
					}
				}
			
			
			die($json->encode($result));
	
		}
	}
}elseif (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'lq_login')
{
	include_once('languages/'. $_CFG['lang']. '/user.php');
	include_once('includes/lib_passport.php');

	$captcha = intval($_CFG['captcha']);
	if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
	{
		if (empty($_POST['captcha']))
		{
			show_message($_LANG['invalid_captcha']);
		}

		/* 检查验证码 */
		include_once('includes/cls_captcha.php');

		$validator = new captcha();
		$validator->session_word = 'captcha_login';
		if (!$validator->check_word($_POST['captcha']))
		{
			show_message($_LANG['invalid_captcha']);
		}
	}
	if (empty($_POST['username']))
	{
		show_message('登陆用户名不能为空', '', 'htactivity.php');
	}
	else
	{
		if (empty($_POST['password']))
		{
		show_message('登陆密码不能为空', '', 'htactivity.php');
		}
		else
		{
			if ($user->login($_POST['username'], $_POST['password'],isset($_POST['remember'])))
			{
			update_user_info();  //更新用户信息
			}
			else
			{
			show_message('登陆失败，错误的用户名或者密码', '', 'htactivity.php');
			}
		}
	}
	
}




//$smarty->assign('pintuan', pac_buy_list('pintuan'));
//$smarty->assign('jingcai_goods', pac_buy_list('jingcai'));

/*smarty->assign('mama_goods', get_newyear_goods('mama'));*/




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
$smarty->assign('isPC',$isPC);
//print_r($ua);




/* 倒计时换首页 20180514
 *
 * 时间是两次活动更新一次
 * 每次写上即将开始的两次活动的时间，当处在第二个活动的时间时再更新成下两次活动的时间
 */
$start_time1 = strtotime($GLOBALS['_CFG']['huodong_start_timej1']);//下一次活动开始时间
$start_time2 = strtotime($GLOBALS['_CFG']['huodong_start_timej2']);//下下一次活动开始时间
$now_time = time();
if($now_time >= $start_time1 && $now_time <= $start_time2) //到达活动时间
{
	if($isPC == 1)
	{
		$smarty->template_dir   = ROOT_PATH . 'themesmobile/' . $_CFG['template'];
		
	}
	

	$smarty->assign('pintuan1', pac_buy_list('pintuan1'));

	$smarty->display('htactivity1.dwt', $cache_id); //下一次活动模板

}
else
{
	if($isPC == 1)
	{
		$smarty->template_dir   = ROOT_PATH . 'themesmobile/' . $_CFG['template'];
		//print_r($smarty->template_dir);
	}
	
	$smarty->assign('pintuan', pac_buy_list('pintuan'));
	//$smarty->display('htactivity.dwt', $cache_id); //下下一次活动模板
	$smarty->display('htactivity.dwt', $cache_id);
}



function pac_buy_list($goods){
if($goods=='pintuan')
	{
		$where.=" and p.act_id in(3250,2801,2827,2832,3261,3135,2251,1705,2254,3129,3124,3336,3072,3057,3058,3060,3062,3064,3215,3121,3071,3666,3069,3070,3499,3074,3659,3114) order by field(p.act_id,3250,2801,2827,2832,3261,3135,2251,1705,2254,3129,3124,3336,3072,3057,3058,3060,3062,3064,3215,3121,3071,3666,3069,3070,3499,3074,3659,3114) ";
}
if($goods=='pintuan1') //1111zimao1模板用
	{
		$where.=" and p.act_id in(3595,3628,3296,3587,3645,2858,3483,2924,2859,2856,3432,2876,2692,2875,2903,1773,2827,2801,2898,2832,3100,2830,3090,3245,3129,2671,3072,3427,3057,3060,3062,3064,3121,3070,3068,3074) order by field(p.act_id,3595,3628,3296,3587,3645,2858,3483,2924,2859,2856,3432,2876,2692,2875,2903,1773,2827,2801,2898,2832,3100,2830,3090,3245,3129,2671,3072,3427,3057,3060,3062,3064,3121,3070,3068,3074) ";
}

    $sql = " SELECT p.act_id,p.cat_id,p.act_name,p.act_desc,p.goods_id,p.is_finished,p.ext_info,p.pake_pepo_number,p.packe_price,p.click_count, ".
           " g.goods_img,p.is_splendid,p.countpac,pik_number,p.is_guess,g.shop_price,g.market_price" .
           " FROM " . $GLOBALS['ecs']->table('goods_packagetour') .
           " as p left join ecs_goods as g on p.goods_id =g.goods_id ". 
		   " where p.is_finished = 1 and p.act_type = '" . CART_PACKAGETOUR_GOODS . "'
		   " . $where;
		   

    $res = $GLOBALS['db']->query($sql);
    while ($group_buy = $GLOBALS['db']->fetchRow($res))
    {
        $ext_info = unserialize($group_buy['ext_info']);
        
        /* 格式化拼团价 */
        $group_buy['formated_deposit'] = price_format($ext_info['deposit'], false);
        $group_buy['group_o_price']    = sprintf("%.2f", ($group_buy['packe_price']/EUR));//拼团换算 欧元
        $group_buy['packe_price']      = number_format($group_buy['packe_price'],0);
        $group_buy['countpac'] = get_group_number($group_buy['act_id'],$group_buy['pake_pepo_number']);
		
		//新添加税费及拼团价20180628
		$re_price = addtax_recalculate_group_price($group_buy['goods_id']);
		$group_buy['packe_price_new'] = number_format($re_price['packe_price'],0);
		$group_buy['group_o_price_new'] = sprintf("%.2f",($re_price['packe_price']/EUR));
		$group_buy['group_tax_price'] = price_format($re_price['tax_price']);
		$group_buy['shop_price1']    = number_format($group_buy['shop_price'],0);
		$group_buy['market_price']    = number_format($group_buy['market_price'],0);
        
        // 获得最新发起拼团未完成 的前2个 必须是付款的
        $packagetour_arry =  userphotolist($group_buy['goods_id']);
        
        if(!empty($packagetour_arry))
        {
            $group_buy['userlist'] =$packagetour_arry;
        }
        
        /* 处理图片 */
        if (empty($group_buy['goods_img']))
        {
            $group_buy['goods_img'] = get_image_path($group_buy['goods_id'], $group_buy['goods_img'], true);
        }
         
        unset($group_buy['ext_info']);
        $gb_list[] = $group_buy;
    }

    return $gb_list;
}

/**
 * 获得最新发起拼团未完成 的前2个 必须是付款的
 * @param  $goods_id 商品id
 */
function userphotolist($goods_id){

    // 获得最新发起拼团未完成 的前2个 必须是付款的  xujinbo  20170207
    $sql=" select o.pac_id,o.act_id,o.order_id,o.user_id ".
         " from   " . $GLOBALS['ecs']->table('order_packagetour') ." as o " .
         " left join " . $GLOBALS['ecs']->table('goods_packagetour') ." as g on o.act_id = g.act_id ".
         " left join " . $GLOBALS['ecs']->table('order_info') ." as p on p.order_id = o.order_id ".
         " where o.goods_id = $goods_id and p.pay_status =2 and o.pac_prent_id = 0 and o.is_finished = 1 ".
         " and  o.pake_pepo_number <> o.people_number_sum  order by p.pay_time asc limit 3 ";

    $packagetour_arry = $GLOBALS['db']->getAll($sql);

    foreach($packagetour_arry  as $key=>$val )
    {
        $sql =" select photo from   " . $GLOBALS['ecs']->table('users') ." where user_id = ".$packagetour_arry[$key]['user_id'] ;
        $packagetour_arry[$key]['user_photo'] = $GLOBALS['db']->getOne($sql);

        $packagetour_arry[$key]['user_photo'] = empty($packagetour_arry[$key]['user_photo'])?'data/images/Head@2x.png':$packagetour_arry[$key]['user_photo'];

    }

    if(!empty($packagetour_arry))
    {
        return $packagetour_arry;
    }
    else
    {
        $packagetour_arry= array();
        return  $packagetour_arry;
    }
    
}



/**
 * 获得最新发起拼团未完成 的前2个 必须是付款的
 * @param  $goods_id 商品id
 */
function get_grouplist($goods_id){
  
    // 获得最新发起拼团未完成 的前2个 必须是付款的  xujinbo  20170207
    $sql=" select o.pac_id,o.act_id,o.order_id,o.goods_number,o.goods_name,o.is_finished,o.pake_pepo_number,o.packe_price,".
         " o.start_add_time,o.user_id, o.par_start_user_name, o.people_number_sum,o.pay_status,o.prentoid ,".
         " g.end_time,p.pay_status,g.act_name  from   " . $GLOBALS['ecs']->table('order_packagetour') ." as o " .
         " left join " . $GLOBALS['ecs']->table('goods_packagetour') ." as g on o.act_id = g.act_id ".
         " left join " . $GLOBALS['ecs']->table('order_info') ." as p on p.order_id = o.order_id ".
         " where o.goods_id = $goods_id and p.pay_status =2 and o.pac_prent_id = 0 and o.is_finished = 1 ".
         " and  o.pake_pepo_number <> o.people_number_sum  order by p.pay_time asc limit 2 ";
    
    $group = $GLOBALS['db']->getAll($sql);
    
    foreach($group  as $key=>$val )
    {
        $sql =" select nick_name,photo from   " . $GLOBALS['ecs']->table('users') ." where user_id = ".$group[$key]['user_id'] ;
        $photo = $GLOBALS['db']->getRow($sql);
        $group[$key]['user_photo'] = $photo['photo'];
        $nick_name  = $photo['nick_name'];
      
        $phonenumber = $group[$key]['par_start_user_name'];
        //判断是手机号 隐藏4位 20171024
        if(preg_match("/^1[34578]{1}\d{9}$/",$phonenumber) && empty($nick_name)) 
        { 
           $group[$key]['par_start_user_name'] = substr_replace($group[$key]['par_start_user_name'],'****',2,6);
        }
        else 
        {
            if(empty($phonenumber)){
                $group[$key]['par_start_user_name'] =$nick_name;
            }
            else{
                $group[$key]['par_start_user_name'] =$phonenumber;
           }
        }
        
       
        $group[$key]['user_photo'] = empty($group[$key]['user_photo'])?'data/images/Head@2x.png':$group[$key]['user_photo'];
        $cc = $group[$key]['pake_pepo_number']- $group[$key]['people_number_sum'];
        $group[$key]['str_cc'] = '还差'.$cc.'人';
        $group[$key]['poor'] = $cc;
        $group[$key]['end_add_time'] = $group[$key]['start_add_time'] + (24*3600);//开团默认时间加一天
        
        if($group[$key]['end_add_time'] > $group[$key]['end_time'])
        {
            $group[$key]['end_add_time'] = $group[$key]['end_time'];
        }

    }
    
    return $group;
}
 /**
  * 拼团件数  后台手动填一个数，乘以单个拼团人数 +已经成团的件数  
  * @param unknown $act_id  活动id
  * @param unknown $ppn     拼团最大人数
  * @return int pac_pelpo   拼团件数
  */
 function  get_group_number($act_id,$ppn){
     
     $pac_pelpo =0;
     $sql =" select count(*) from   " . $GLOBALS['ecs']->table('order_packagetour') ." where is_finished = 2 and pac_prent_id =0 and act_id =  ".$act_id;
     $pac_pelpo =  $GLOBALS['db']->getOne($sql);
     $pac_pelpo = $pac_pelpo * $ppn;
     if(empty($pac_pelpo)){
         $sql2 =" select countpac from  " .  $GLOBALS['ecs']->table('goods_packagetour') ." where act_id =  ".$act_id ;
         $pac_pelpo =  $GLOBALS['db']->getOne($sql2);
         $pac_pelpo  = $pac_pelpo *$ppn;
     }
     else{
         $sql2 =" select countpac from  " .  $GLOBALS['ecs']->table('goods_packagetour') ." where act_id =  ".$act_id ;
         $pac_pelpo2 =  $GLOBALS['db']->getOne($sql2);
         $pac_pelpo2  = $pac_pelpo2 *$ppn;
         $pac_pelpo +=$pac_pelpo2;
     }
     
     return $pac_pelpo;
 }





?>