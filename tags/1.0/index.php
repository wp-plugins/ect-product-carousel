<?php 
/*
	Plugin Name:ECT Product Carousel
	Description:This plugin will show a product carousel
	Author:Andy Chapman
	Author URI:http://www.ecommercetemplates.com
	Version:1.0
*/

add_action('admin_menu','ect_prod_nav');
function ect_prod_nav()
{
	add_menu_page('ECT Product Carousel','ECT Product Carousel','manage_options','ect_prod','ect_prod_fun',plugin_dir_url(__FILE__).'img/ect28x28.png',1009);
	add_submenu_page('ect_prod','Add New','Add New','manage_options','ect_prod_add','ect_add_prod');
	add_submenu_page('ect_prod','Settings','Settings','manage_options','ect_prod_set','ect_set_prod');
}
register_activation_hook(__FILE__,'act_fun_ect');
function act_fun_ect()
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
function ect_set_prod()
{
	$auto=get_option('ect_prod_sett_autoplay');
	$vi=get_option('ect_prod_sett_visible_prod');
	$list_prod=get_option('ect_prod_sett_list_prod');
	$animated_speed=get_option('ect_prod_sett_animated_speed');
	$autoPlaySpeed=get_option('ect_prod_sett_autoPlaySpeed');
	$pauseonhover=get_option('ect_prod_sett_pauseonhover');
	$enable_break=get_option('ect_prod_sett_enable_break');
	$port_chg=get_option('ect_prod_sett_port_chg');
	$port_visi=get_option('ect_prod_sett_port_visi');
	$land_chg=get_option('ect_prod_sett_land_chg');
	$land_visi=get_option('ect_prod_sett_land_visi');
	$tab_chg=get_option('ect_prod_sett_tab_chg');
	$tab_visi=get_option('ect_prod_sett_tab_visi');
$css_style=get_option('ect_prod_sett_css_style');
?>
	<h2>Carousel Settings</h2>
	<?php if(isset($_GET['msg']) && $_GET['msg']==1):?>
		<div class="updated below-h2" id="message"><p>Settings updated !</p></div>
	<?php endif;?>
	<form method="post">
		<ul class="add_prod">
			<li><label>Autoplay</label>
			<input type="checkbox" name="autoplay" <?php echo !empty($auto) ? 'checked="checked"' :''?>/>
			</li>
<li>
				<label>List products</label>
				<input type="text" name="opt[list_prod]" value="<?php echo !empty($list_prod) ? $list_prod :'10'?>"/>
			</li>			
<li>
				<label>Show products</label>
				<input type="text" name="opt[visible_prod]" value="<?php echo !empty($vi) ? $vi :'5'?>"/>
			</li>
			<li>
				<label>Animation speed</label>
				<input type="text" name="opt[animated_speed]" value="<?php echo !empty($animated_speed) ? $animated_speed :'1000'?>"/>
			</li>
			<li>
				<label>Auto play speed</label>
				<input type="text" name="opt[autoPlaySpeed]" value="<?php echo !empty($autoPlaySpeed) ? $autoPlaySpeed :'3000'?>"/>
			</li>
			<li>
				<label>Pause on hover</label>
				<input type="checkbox" name="pauseonhover" <?php echo !empty($pauseonhover) ? 'checked="checked"' : '';?>/>
			</li>	
			<li>
				<label>Enable breakpoints</label>
				<input type="checkbox" name="enable_break" <?php echo !empty($enable_break) ? 'checked="checked"' : '';?>/>
			</li>
			<li>
				<ul>
					<li>
						<label>Portrait</label>
						ChangePoint:<input type="text" name="opt[port_chg]" value="<?php echo !empty($port_chg) ? $port_chg :'480'?>"/>
						&nbsp;&nbsp;VisibleItems: <input type="text" name="opt[port_visi]" value="<?php echo !empty($port_visi) ? $port_visi :'1'?>"/>
					</li>
					<li>
						<label>Landscape</label>
						ChangePoint:<input type="text" name="opt[land_chg]" value="<?php echo !empty($land_chg) ? $land_chg :'640'?>"/>
						&nbsp;&nbsp;visibleItems: <input type="text" name="opt[land_visi]" value="<?php echo !empty($land_visi) ? $land_visi :'2'?>"/>
					</li>
					<li>
						<label>Tablet</label>
						ChangePoint:<input type="text" name="opt[tab_chg]" value="<?php echo !empty($tab_chg) ? $tab_chg :'768'?>"/>
						&nbsp;&nbsp;VisibleItems: <input type="text" name="opt[tab_visi]" value="<?php echo !empty($tab_visi) ? $tab_visi :'3'?>"/>
					</li>
				</ul>	
			</li>
<h2>CSS Settings</h2>
<li>
	<label>CSS Class</label>
<input type="text" name="opt[css_style]" value="<?php echo !empty($css_style) ? $css_style :''?>"/>
</li>			
			<li><input type="submit" accesskey="p" value="Save" class="btn button-primary button-large" id="publish" name="publish"></li>
		</ul>
	</form>	
	<style>
	.add_prod li label
	{
		width:150px;
		display:inline-block;
		font-weight:bold;
	}
	.add_prod li
	{
		line-height:36px;
	}
	.add_prod li input[type=text]
	{
		width:260px;
	}
	.btn
	{
		font-size: 20px !important;
		height: 40px !important;
		line-height: 40px !important;
		padding: 0 12px 2px !important;
		width: 98px !important;
	}
	</style>
	
<?php
	if(!empty($_POST))
	{
$v1=isset($_POST['pauseonhover']) ? 1 : 0;
$v2=isset($_POST['enable_break']) ? 1 : 0;

$v3=isset($_POST['autoplay']) ? 1 : 0;
update_option('ect_prod_sett_pauseonhover',$v1);
update_option('ect_prod_sett_enable_break',$v2);
update_option('ect_prod_sett_autoplay',$v3);
		foreach($_POST['opt'] as $k=>$v){

			update_option('ect_prod_sett_'.$k,$v);
}
		echo '<script type="text/javascript">window.location="admin.php?page=ect_prod_set&msg=1"</script>';
	}
}
function ect_add_prod()
{
	require_once 'add_ect_prod.php';
}
add_action('init','inst_foot');
function inst_foot()
{	wp_enqueue_style('ect-css',plugin_dir_url(__FILE__).'css/style.css');	
wp_enqueue_script('jquery');
	wp_enqueue_script('ect-jq1',plugin_dir_url(__FILE__).'js/jquery.flexisel.js');
}
function ect_prod_fun(){	require_once 'ect_list.php';}
add_shortcode('product_slider','prod_ect_slider');
function prod_ect_slider($atts)
{
		@include_once '../vsadmin/db_conn_open.php';

	$dbh=@mysql_connect($db_host, $db_username, $db_password);

	@mysql_select_db($db_name); 


	$ID=$atts['id'];
	$Dat=get_option('ect_prod_slide_'.$ID);
	
	$cond=$inn='';
	if($Dat['slide_images_from']=='cate')
	{
		$cond=' and s.sectionName like "'.$Dat['sec_id'].'"';	
		$inn='INNER JOIN '.$db_name.'.sections AS s ON s.sectionID = p1.pSection';
	}
	global $wpdb;
	$str='';
$list_prod=get_option('ect_prod_sett_list_prod');
$vi=get_option('ect_prod_sett_visible_prod');
$Q=mysql_query("select p1.pID,p1.pName,p1.pSection,p2.imageSrc from ".$db_name.".products as p1 inner join ".$db_name.".productimages as p2 on p1.pID=p2.imageProduct $inn where p2.imageType=0 $cond limit $list_prod ");
$css_class=get_option('ect_prod_sett_css_style');
	if(@mysql_num_rows($Q)>0)
	{
		$str.='<ul id="flexiselDemo3_'.$ID.'" style="list-style:none">';
		while($prod=mysql_fetch_object($Q))
		{ 
			$str.='<li><a href="'.site_url('/').'proddetail.php?prod='.$prod->pID.'"><img src="'.site_url('/').$prod->imageSrc.'" alt="'.$prod->pName.'" class="'.$css_class.'"/></a></li>';	
		} 
		$str.='</ul>';
	    
	$auto=get_option('ect_prod_sett_autoplay');
	$auto=empty($auto) ? 'false' : 'true';
	
	
	$animated_speed=get_option('ect_prod_sett_animated_speed');
	$autoPlaySpeed=get_option('ect_prod_sett_autoPlaySpeed');
	
	$pauseonhover=get_option('ect_prod_sett_pauseonhover');
	$pauseonhover=empty($pauseonhover) ? 'false' : 'true';
	
	$enable_break=get_option('ect_prod_sett_enable_break');
	$enable_break=empty($enable_break) ? 'false' : 'true';
	$port_chg=get_option('ect_prod_sett_port_chg');
	$port_visi=get_option('ect_prod_sett_port_visi');
	$land_chg=get_option('ect_prod_sett_land_chg');
	$land_visi=get_option('ect_prod_sett_land_visi');
	$tab_chg=get_option('ect_prod_sett_tab_chg');
	$tab_visi=get_option('ect_prod_sett_tab_visi');
	
	$str.='<script type="text/javascript">
	jQuery(window).load(function() {
	jQuery("#flexiselDemo3_'.$ID.'").flexisel({
		visibleItems: '.$vi.',
		animationSpeed: '.$animated_speed.',
		autoPlay: '.$auto.',
		autoPlaySpeed: '.$autoPlaySpeed.',    		
		pauseOnHover: '.$pauseonhover.',
		enableResponsiveBreakpoints: '.$enable_break.',
    	responsiveBreakpoints: { 
    		portrait: { 	
    			changePoint:'.$port_chg.',
    			visibleItems: '.$port_visi.'
    		}, 
    		landscape: { 
    			changePoint:'.$land_chg.',
    			visibleItems: '.$land_visi.'
    		},
    		tablet: { 
    			changePoint:'.$tab_chg.',
    			visibleItems: '.$tab_visi.'
    		}
    	}
    });
    
	});
	</script>';
	return $str;
	}
}

//	echo do_shortcode('[product_slider id=57661299]');
?>