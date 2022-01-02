<div class="wrap_content_gallery">
	<div class="wrap_content_heading">
		<h1>อัลบั้มรูปภาพสินค้า (ทั้งหมด)</h1>
	</div> 
	<?php
		echo form_input(array('type' => 'hidden', 'id' => 'current_page')); 
		echo form_input(array('type' => 'hidden', 'id' => 'show_per_page')); 
	?>
    <div id="wrap_content_row" class="wrap_content_row"> <?php 
    	$row = $this->common_model->custom_query(" SELECT * FROM product_gallery LEFT JOIN product ON product_gallery.P_ID = product.P_ID ORDER BY PG_DateTimeUpdate DESC "); 
		foreach ($row as $key => $value) { 
			list($width, $height) = getimagesize(base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']));
    		if ($width > $height) 	$layout = 'landscape';
    		if ($width < $height) 	$layout = 'portrait';
    		if ($width == $height)	$layout = 'square'; ?>
	        <div class="wrap_content_col">
				<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
					<div class="wrap_content_img">
						<div class="<?php echo $layout; ?>">
							<img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
						</div>
					</div>
				</a>
			</div> <?php 
		} ?>
	</div>
	<div class="pagination"><ul></ul></div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/pagination_custom.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		if ($(".wrap_content").height() > 1200)
			var wrap_content_height = 0;
		else
			var wrap_content_height = 160;
		// $('html, body').animate({
  //   		scrollTop: $(".wrap_content").offset().top - ($(".wrap_content").height() + wrap_content_height)
		// }, 1000);
		$(".fancybox-thumb").fancybox({
			prevEffect	: 'elastic',
			nextEffect	: 'elastic',
			openEffect	: 'fade',
			closeEffect	: 'fade',
			beforeShow: function () {
            	$('<div class="watermark"></div>').bind("contextmenu", function(e) {
                    return false;
                }).prependTo($.fancybox.wrap);
            	setTimeout(function() {
            		$('#fancybox-thumbs li').find('img').on('contextmenu', function(e) {
						return false;
					});
				}, 500);
				$.fancybox.showLoading();
        	},
        	afterShow: function() {
                $.fancybox.hideLoading();
            },
			beforeLoad: function() {
				$('.bx-wrapper .bx-controls-direction a').css('z-index', '8010');
				$('.cart_control').css('z-index', '2');
			},
			beforeClose: function() {
				$('.bx-wrapper .bx-controls-direction a').css('z-index', '9999');
				$('.cart_control').css('z-index', '10000');
			},
			helpers : {
				locked 	: true,
				thumbs	: {
					width	: 50,
					height	: 50
				}
			}
		});
	});
</script>