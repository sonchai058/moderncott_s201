<?php 
	$site = $this->webinfo_model->getOnceWebMain(); 
	$rows = $this->common_model->getTable('category'); 
	if (uri_seg(2) === 'product_details') {
		$cate = rowArray($this->common_model->get_where_custom('product', 'P_ID', uri_seg(3))); 
		$category = $cate['C_ID'];
	}
	else
		$category = uri_seg(3);
?>

<div class='category'>
	<div class="head">
		<div class="head_text"><span>หมวดหมู่สินค้า<!-- Category --></span></div>
		<div class="head_logo"><img src="<?php echo base_url('assets/images/category-icon.png'); ?>" alt=""></div>
	</div>
	<ul>
		<?php 
			foreach ($rows as $key => $value) { ?>
				<li <?php if ($value['C_ID'] === $category) { ?> class="active" <?php } ?> title="<?php echo $value['C_Name']; ?>"><a href="<?php echo base_url('main/category/'.$value['C_ID']); ?>"><i class="fa fa-chevron-right"></i><span><?php echo $value['C_Name']; ?></span></a></li> <?php
			}
		?>
	</ul>
</div>