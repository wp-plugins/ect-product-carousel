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
		global $wpdb;
	$ProductsArr=$wpdb->get_results("select sectionID,sectionName from  sections order by sectionName");

	?>
	<h2>ECT Product Carousel</h2>
	<form method="post">
		<ul class="add_prod">
			<li>
				<label>Use product from:</label>
				<input type="radio" name="slide_images_from" value="store"  class="rdo"/>Whole Store
				&nbsp;
				<input type="radio" name="slide_images_from" value="cate" class="rdo"/>Selected Category
				&nbsp;
				<input type="radio" name="slide_images_from" value="recom" class="rdo"/>Recommended Products
			</li>
			<li class="hid_clsn" style="display:none;">
				<label>Category name</label>
				<input type="text" name="sec_id" />
			</li>
			<!-- <li class="hid_clsn" style="display:none;">
				<label>Category</label>
				<select name="sec_id">
					<?php if(!empty($ProductsArr)):?>
						<?php foreach($ProductsArr as $s):?>
						<option value="<?php echo $s->sectionID?>"><?php echo $s->sectionName?></option>
						<?php endforeach;?>
					<?php endif;?>
				</select>
			</li> -->
			<li><input type="submit" accesskey="p" value="Save" class="btn button-primary button-large" id="publish" name="publish"></li>
		</ul>
	</form>
	
	<script type="text/javascript">
		jQuery('.rdo').click(function(){
			if(jQuery(this).val()=='cate')
				jQuery('.hid_clsn').show();
			else
				jQuery('.hid_clsn').hide();
		});
	</script>
<?php
if(!empty($_POST))
	{
		global $wpdb;
		update_option('ect_prod_slide_'.rand(),$_POST);
		echo '<script>window.location="admin.php?page=ect_prod&msg=1"</script>';
	}
?>	