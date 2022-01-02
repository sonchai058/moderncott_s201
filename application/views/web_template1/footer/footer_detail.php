<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

<div class="content">
	<div class="content_main">
		<div class="main_seg">
			<div class="first_seg">
				<h1>เกี่ยวกับเรา<!-- About Us --></h1>
				<div class="detail">
					<?php if ($site['WD_Descrip'] !== '') echo $site['WD_Descrip']; else echo ''; ?>
				</div>
				<br>
				<span>โทรศัพท์<!-- Phone -->: <?php echo $site['WD_Tel']; ?></span>
				<br>
				<span>โทรสาร<!-- Fax -->: <?php echo $site['WD_Fax']; ?></span>
			</div>
			<div class="next_seg">
				<h1>ลิงค์ที่เกี่ยวข้อง<h1>
				<ul class="link">
					<li title="หน้าหลัก"><a href='<?php echo base_url('main'); ?>'>หน้าหลัก</a></li>
					<li title="สินค้า"><a href='<?php echo base_url('main/products_view'); ?>'>สินค้า</a></li>
					<li title="วิธีสั่งซื้อ / ชำระเงิน"><a href='<?php echo base_url('main/how_to'); ?>'>วิธีสั่งซื้อ / ชำระเงิน</a></li>
					<li title="อัลบั้มรูปภาพ"><a href='<?php echo base_url('main/product_galleries'); ?>'>อัลบั้มรูปภาพ</a></li>
					<li title="ติดต่อเรา"><a href='<?php echo base_url('main/contact_us'); ?>'>ติดต่อเรา</a></li>
				</ul>
			</div>
			<div class="next_seg">
				<h1>หมวดหมู่สินค้า<h1>
				<ul class="link"> <?php
					$categories = $this->common_model->getTable('category');
					foreach ($categories as $key => $value) { ?>
						<li title="<?php echo $value['C_Name']; ?>"><a href='<?php echo base_url('main/category/'.$value['C_ID']); ?>'><?php echo $value['C_Name']; ?></a></li> <?php
					} ?>
				</ul>
				<button class="showFooterLink" onclick="showFooterLink();">ทั้งหมด <i class="fa fa-level-down"></i></button>
			</div>
			<div class="wrap_fb">
				<h1>Facebook Fanpage<h1> 
				<?php 
				if ($site['WD_FbLink'] !== '') { ?>
					<div class="fb-page" data-href="<?php echo $site['WD_FbLink']; ?>" data-width="300" data-height="250" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $site['WD_FbLink']; ?>"><a href="<?php echo $site['WD_FbLink']; ?>"><?php echo $site['WD_Name']; ?></a></blockquote></div></div> 
					<?php
				} 
				else { ?>
					<div class="fb-page" data-href="https://www.facebook.com/ServiceTechnologyConsultant" data-width="290" data-height="160" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ServiceTechnologyConsultant"><a href="https://www.facebook.com/ServiceTechnologyConsultant">Service Technology Consultant Co.,Ltd.</a></blockquote></div></div> 
					<?php
				} ?>
			</div>
		</div>
		<div class="foo">
			<span>Copyright © 2015 All Rights Reserved Powered by <a href="https://www.facebook.com/ServiceTechnologyConsultant/" title="Service Technology Consultant" target="_blank">Service Technology Consultant Co., Ltd.</a></span>
		</div>
	</div>
</div>
<script type="text/javascript">
	function showFooterLink() {
		if ($('.next_seg:nth-child(3) ul').css('overflow-y') === 'hidden') {
			$('.next_seg:nth-child(3) ul').css('overflow-y', 'scroll');
			$('.showFooterLink').html('ทั้งหมด <i class="fa fa-level-up"></i>');
		}
		else if ($('.next_seg:nth-child(3) ul').css('overflow-y') === 'scroll') {
			$('.next_seg:nth-child(3) ul').css('overflow-y', 'hidden');
			$('.showFooterLink').html('ทั้งหมด <i class="fa fa-level-down"></i>');
		}
	}
</script>