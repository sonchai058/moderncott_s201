<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

<div class="wrap_head_menu">
	<div class="wrap_logo">
		<!-- <a href="<?php echo base_url('main'); ?>" title="<?php echo $site['WD_Name']; ?>">
			<i class="fa fa-shopping-cart"></i>
		</a> -->
		<a href="<?php echo base_url('main'); ?>" title="<?php echo $site['WD_Name']; ?>">
			<span><img src="<?php echo base_url('assets/images/'.$site['WD_Logo']); ?>" title="<?php echo $site['WD_Name']; ?>"></span>
		</a>
	</div>
	<ul class="wrap_nav">
		<li title="หน้าหลัก">
			<a href="<?php echo base_url('main'); ?>" <?php if ((uri_seg(1) == '' || uri_seg(1) == 'main') && uri_seg(2) == '') { ?> class="under_hover" <?php } ?>>หน้าหลัก</a>
		</li>
		<li title="สินค้า">
			<a href="<?php echo base_url('main/products_view'); ?>" <?php if (uri_seg(1) == 'main' && (uri_seg(2) == 'products_view' || uri_seg(2) == 'product_details' || uri_seg(2) == 'category')) { ?> class="under_hover" <?php } ?>>สินค้า</a>
		</li>
		<li title="วิธีสั่งซื้อ / ชำระเงิน">
			<a href="<?php echo base_url('main/how_to'); ?>" <?php if (uri_seg(1) == 'main' && uri_seg(2) == 'how_to') { ?> class="under_hover" <?php } ?>>วิธีสั่งซื้อ / ชำระเงิน</a>
		</li>
		<li title="อัลบั้มรูปภาพ">
			<a href="<?php echo base_url('main/product_galleries'); ?>" <?php if (uri_seg(1) == 'main' && uri_seg(2) == 'product_galleries') { ?> class="under_hover" <?php } ?>>อัลบั้มรูปภาพ</a>
		</li>
		<li title="ติดต่อเรา">
			<a href="<?php echo base_url('main/contact_us'); ?>" <?php if (uri_seg(1) == 'main' && uri_seg(2) == 'contact_us') { ?> class="under_hover" <?php } ?>>ติดต่อเรา</a>
		</li>
	</ul>
</div>