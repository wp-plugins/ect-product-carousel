<?php 

/*

	Plugin Name:ECT HOME PAGE PRODUCTS

	Description:This plugin will show products on home page

	Author:Andy Chapman

	Author URI:http://www.ecommercetemplates.com

	Version:1.3

*/



add_action('admin_menu','ect_homep_nav');

function ect_homep_nav()

{

	add_menu_page('ECT Homepage Product','ECT Homepage Product','manage_options','ect_homepage_prod','ect_homepage_prod_fun',plugin_dir_url(__FILE__).'img/ect28x28.png',1019);

	add_submenu_page('ect_homepage_prod','Add New','Add New','manage_options','ect_homepage_prod_add','ect_add_homepage_prod');

}

register_activation_hook(__FILE__,'install_homep_tbls');

function install_homep_tbls()

{

	add_option('ect_prod_sett_autoplay','true');

	add_option('ect_prod_sett_visible_prod',5);

	add_option('ect_prod_sett_list_prod',10);

	add_option('ect_prod_sett_animated_speed',1000);

	add_option('ect_prod_sett_autoPlaySpeed',3000);

	add_option('ect_prod_sett_pauseonhover','true');

	add_option('ect_prod_sett_enable_break','true');

	add_option('ect_prod_sett_port_chg',480);

	add_option('ect_prod_sett_port_visi',1);

	add_option('ect_prod_sett_land_chg',640);

	add_option('ect_prod_sett_land_visi',2);

	add_option('ect_prod_sett_tab_chg',768);

	add_option('ect_prod_sett_tab_visi',3);

	

}



function ect_add_homepage_prod()

{

	if(!isset($_GET['_id']))

		require_once 'add_hprod.php';

	else

		require_once 'edit_hprod.php';

	//echo do_shortcode('[ect_homepage_prod id=5204]');

}



function ect_homepage_prod_fun()

{

	require_once 'ect_list.php';

}

add_shortcode('ect_homepage_prod','ect_homepage_prod_fun1');

function ect_homepage_prod_fun1($atts)

{

	$Data=get_option('ect_homepage_prod_'.$atts['id']);

	global $ECTWPDB;

	if(!$ECTWPDB)

	{

		global $db_username,$db_password,$db_name,$db_host;

		include "vsadmin/db_conn_open.php";

		$ECTWPDB=new wpdb($db_username, $db_password, $db_name, $db_host);

	} 

	

if($ECTWPDB)

	{



$CondCheckStock='';

$AdminStockMgt=$ECTWPDB->get_results('select adminStockManage from admin where adminID=1');

if(!empty($AdminStockMgt) && !empty($AdminStockMgt[0]->adminStockManage))

$CondCheckStock='and p.pInStock >0';



	$ID=$atts['id'];

 	$Dat=get_option('ect_homepage_prod_'.$ID);

	$cond=$inn='';

	$list_prod=empty($Data['show_prod_count']) ? 5 : $Data['show_prod_count'];

	if($Data['homepage_prod_from']=='spec_cat')

	{

		$Q=$ECTWPDB->get_results("select s.sectionID,p.pID,p.pName,p.pDescription,p.pPrice,p.pListPrice,p.pDisplay,p.pInStock,pi.imageSrc from sections as s inner join products as p on s.sectionID=p.pSection left join productimages as pi on p.pID=pi.imageProduct where s.sectionName like '".$Data['sec_id']."%' $CondCheckStock and p.pDisplay=1 and pi.imageType=0 group by p.pID limit $list_prod");

		

	}

	elseif($Data['homepage_prod_from']=='recom')

	{

		$Q=$ECTWPDB->get_results("select s.sectionID,p.pID,p.pName,p.pDescription,p.pPrice,p.pListPrice,p.pDisplay,p.pInStock,pi.imageSrc from sections as s inner join products as p on s.sectionID=p.pSection left join productimages as pi on p.pID=pi.imageProduct where s.sectionName like '".$Data['sec_id']."%'  $CondCheckStock and p.pDisplay=1 and p.pRecommend=1 and pi.imageType=0 group by p.pID limit $list_prod");

	}

	elseif($Data['homepage_prod_from']=='spec_manu')

	{

		$Q=$ECTWPDB->get_results("select s.mfID,p.pID,p.pName,p.pDescription,p.pPrice,p.pListPrice,p.pDisplay,p.pInStock,pi.imageSrc from  manufacturer as s inner join products as p on s.mfID=p.pManufacturer left join productimages as pi on p.pID=pi.imageProduct where s.mfName like '".$Data['sec_id']."%'  $CondCheckStock and p.pDisplay=1 and pi.imageType=0 group by p.pID limit $list_prod");

	

}

	elseif($Data['homepage_prod_from']=='lat_prod')

	{

		$Q=$ECTWPDB->get_results("select p.pID,p.pName,p.pDescription,p.pPrice,p.pListPrice,p.pDisplay,p.pInStock,pi.imageSrc from products as p left join productimages as pi on p.pID=pi.imageProduct where   p.pDisplay=1 $CondCheckStock and pi.imageType=0 group by p.pID order by p.pDateAdded desc limit $list_prod");

//p.pInStock >0 and

	}

	elseif($Data['homepage_prod_from']=='best_sell')

	{ 

		$LastThirty=date('Y-m-d H:i:s',mktime(date('H'),date('i'),date('s'),date('m'),date('d')-30,date('Y')));

		$Q=$ECTWPDB->get_results("select cartSessionID,cartProdID,count(cartProdID) as t,p.pID,p.pName,p.pDescription,p.pPrice,p.pListPrice,p.pDisplay,p.pInStock,pi.imageSrc from cart inner join products as p on p.pID=cart.cartProdID left join productimages as pi on p.pID=pi.imageProduct where cart.cartDateAdded between '".$LastThirty."' and '".date('Y-m-d H:i:s')."' $CondCheckStock and p.pDisplay=1 and pi.imageType=0 group by cart.cartProdID order by t desc limit $list_prod");

	

}	

	if($Dat['slide_images_from']=='cate')

	{

		$cond=' and s.sectionName like "'.$Dat['sec_id'].'"';	

		$inn='INNER JOIN '.$db_name.'.sections AS s ON s.sectionID = p1.pSection';

	}

	global $wpdb;

	 

	$str='';

	

	$css_class=get_option('ect_prod_sett_css_style');

	if(!empty($Q))

	{

		/*$str.='<div style="float: left; width: auto;"><ul id="flexiselDemo3_'.$ID.'" class="flxs" style="list-style:none">';*/

		$str.='<div class="products ecthpproduct">';

		foreach($Q as $prod)

		{ 

			$PName=$prod->pName;

			$pPrice=number_format($prod->pPrice,2,'.',',');

			//if(isset($Data['show_prod_list_p']))

			//	$pPrice=$prod->pListPrice;

			

			$PN=!isset($Data['show_prod_name']) ? '' : '<div class="prodname ecthpprodname"><a href="'.site_url('/').'proddetail.php?prod='.$prod->pID.'" class="ectlink">'.$prod->pName.'</a></div>';

			

			$SHOWLIST=!isset($Data['show_prod_list_p']) ? '' : '<div class="listprice ecthplistprice"><span style="color:#999999;font-weight:bold">List Price: <span style="text-decoration:line-through">$'.number_format($prod->pListPrice,2,'.',',').'</span></span><br><br></div>';

			

			$PP=!isset($Data['show_prod_price']) ? '' : '<div class="prodprice ecthpprodprice"><strong>Price:</strong> <span id="pricediv0" class="price">$'.$pPrice.'</span></div>';

			

			$BuyBtn=!isset($Data['show_prod_buy']) ? '' : '<div class="p_name ecthpp_name" style="margin-bottom:5px !important">

			

			<form method="post" action="'.site_url('/').'cart.php">

				<input type="hidden" name="id" value="'.$prod->pID.'" />

				<input type="hidden" name="mode" value="add" />

				<input type="submit" value="Add to cart" class="buybutton ecthpbuybutton" />

			</form>

		

			

			</div>';

			

			$Text=!isset($prod->pDescription) ? '' : '<div class="proddescription ecthpproddescription"><p>'.$prod->pDescription.'</p></div>';

			

			$str.='<div class="product ecthpproduct">

							<div class="prodimage ecthpprodimage"><a href="'.site_url('/').'proddetail.php?prod='.$prod->pID.'" class="ectlink"><img alt="'.$PName.'" style="border:0" src="'.site_url('/').$prod->imageSrc.'" class="prodimage" id="prodimage0"></a></div>

							'.$PN.'

							'.$Text.'

							'.$SHOWLIST.'

							'.$PP.'

							'.$BuyBtn.'

					</div>';

		} 

		$str.='</div>';



		return $str;

	}

}

}

add_action('init','inst_foot_home');

function inst_foot_home()

{

	wp_enqueue_style('ect-css',plugin_dir_url(__FILE__).'css/style.css');

	wp_enqueue_script('jquery');

}

?>