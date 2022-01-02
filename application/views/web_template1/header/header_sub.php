<?php 
	$site = $this->webinfo_model->getOnceWebMain(); 
	if ($cartQty = $this->cart->contents()) {
		$grand_quantity = 0;
		foreach ($cartQty as $itemQty) {
			$grand_quantity = $grand_quantity + $itemQty['qty'];
		}
	}
?>
<div class="wrap_sub_head1">
	<div class="wrap_cart_control">
		<ul class="list">
			<li title="แจ้งโอนเงิน">
				<a href="<?php echo base_url('main/report_transferred'); ?>"><img width="20" height="20" src="<?php echo base_url('assets/images/f-icon4.png');?>"><span>แจ้งโอนเงิน</span></a>
			</li>
			<!-- <li title="ติดตามการสั่งซื้อสินค้า">
				<a href="#">ติดตามการสั่งซื้อ</a>
			</li> -->
		</ul>
		<div class="search" title="ค้นหา">
			<input type="text" class="search" placeholder="ค้นหา">
			<a href="#"><i class="fa fa-search"></i></a>
		</div>
		<!-- <div class="cart_control" title="ตะกร้าสินค้า">
			<a href="<?php echo base_url('main/cart_popup'); ?>" class="various fancybox.ajax">
				<div>
					<img src="<?php echo base_url('assets/images/shopping-cart.png'); ?>" alt="">
					<span><?php if ($cartQty = $this->cart->contents()) echo $grand_quantity; ?></span>
				</div>
			</a>
		</div> -->
		<a href="<?php echo base_url('main/cart_popup'); ?>" class="various fancybox.ajax cart_control" title="ตะกร้าสินค้า">
			<img src="<?php echo base_url('assets/images/shopping-cart.png'); ?>" alt="">

			<span <?php if (!$this->cart->contents()){?>class="null"<?php }?>><?php if ($cartQty = $this->cart->contents()) echo $grand_quantity; ?></span>

			<!-- <span>9999</span> -->
		</a>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
  		$(".various").fancybox({
  			fitToView 	: false,
  			autoSize    : false,
  			width 		: '1200px',
  			height      : '100%',
  			maxWidth 	: '100%',	
  			maxHeight 	: '100%',
			openEffect	: 'fade',
			closeEffect	: 'fade',
			beforeLoad: function() {
				$('.bx-wrapper .bx-controls-direction a').css('z-index', '8010');
				$('.cart_control').css('z-index', '2');
			},
			beforeClose: function() {
				$('.bx-wrapper .bx-controls-direction a').css('z-index', '9999');
				$('.cart_control').css('z-index', '10000');
			},
			helpers : {
				locked: true,
			},
			beforeShow: function() {
                $.fancybox.showLoading();
            },
            afterShow: function() {
                $.fancybox.hideLoading();
            }
		});
	});
</script>