<?php if(isset($_GET['msg']) && $_GET['msg']==1):?>
	<div class="updated below-h2" id="message"><p>Shortcode added successfully</p></div>
<?php elseif(isset($_GET['msg']) && $_GET['msg']==2):?>
	<div class="updated below-h2" id="message"><p>Record deleted successfully !</p></div>
<?php endif;?>
<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
<h2>ECT Product Carousel <a class="add-new-h2" href="admin.php?page=ect_prod_add">Add New</a></h2>
<?php 
	global $wpdb;
	$Ch=$wpdb->get_results("select * from ".$wpdb->prefix."options where option_name like 'ect_prod_slide_%' order by option_id desc");
?>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th>Product From</th>
				<th>Shortcodes</th>
				<th>Actions</th>
			</tr>
		</thead>
		<?php if(!empty($Ch)):?>
			<?php foreach($Ch as $s):?>
			<tr>
				<td>
					<?php $frm=unserialize($s->option_value);
					$cat='';
					if($frm['slide_images_from']!='store')
					{
						$SecArr=$wpdb->get_results("select sectionID,sectionName from sections where sectionName like '".ucwords($frm['sec_id'])."'");
						$cat=$SecArr[0]->sectionName.' category';
					}
					echo ($frm['slide_images_from']=='store') ? 'Whole store' : ucwords($frm['sec_id']);
					?>
				</td>
				<?php $p=explode('_',$s->option_name);
				end($p);?>
				<td><code>[product_slider id=<?php echo end($p)?>]</code><?php //echo do_shortcode('[product_slider id='.end($p).']') ?>
				</td>
				<td><a href="javascript:void(0)" onclick="del(<?php echo $s->option_id?>)"><img src="<?php echo plugin_dir_urL(__FILE__)?>img/delete.png" alt="Delete" title="Delete"/></a></td>
			</tr>
			<?php endforeach;?>
		<?php else:?>
			<tr><td colspan="2" align="center">No record found !</td></tr>
		<?php endif;?>
		<tfoot>
			<tr>
				<th>Product From</th>
				<th>Shortcodes</th>
				<th>Actions</th>
			</tr>
		</tfoot>
	</table>	
	<script type="text/javascript">
		function del(id)
		{
			var res=confirm('Do you really want to  delete this ?');
			if(res)
			window.location="admin.php?page=ect_prod&act=del&id="+id;
		}
	</script>
<?php
if(isset($_GET['act']) && $_GET['act']=='del')
{
	global $wpdb;
	$wpdb->query("delete from ".$wpdb->prefix."options where option_id='".$_GET['id']."'");
	echo '<script>window.location="admin.php?page=ect_prod&msg=2"</script>';
}	
echo do_shortcode('[view_add_to_cart id=pc002]');
?>