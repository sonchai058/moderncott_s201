<?php $tab_menu = array('recommend', 'popular', 'bestseller'); ?>
<div class="wrap_content_tab">
	<div class="wrap_content_tab_head">
		<img src="<?php echo base_url('assets/images/all-product-icon.png'); ?>" alt="">
		<i class="fa fa-chevron-right"></i>
		<h1>
			<span>สินค้า</span>&nbsp;
			<span>(ทั้งหมด)</span>
		</h1>
	</div> <?php 
	$row = $this->common_model->getTableOrder('product_type', 'PT_Order', 'ASC'); 
	if (count($row) > 0) { 
		foreach ($row as $key => $value) { ?>
			<div id="<?php echo $tab_menu[$key]; ?>" class="wrap_content_tab_menu <?php if ($key === 0) { ?> active <?php } ?>"><a><?php echo $value['PT_Name']; ?> ></a></div> <?php
		}
	} 
	else { ?>
		<div id="<?php echo $tab_menu[0]; ?>" class="wrap_content_tab_menu active"><a>ทั้งหมด</a></div> <?php
	} ?>
</div> 
<div class="wrap_content_grid"> <?php
	$tabs = 0;
	echo form_input(array('type' => 'hidden', 'id' => 'current_page')); 
	echo form_input(array('type' => 'hidden', 'id' => 'show_per_page'));
	while ($tabs < count($row)) { ?>
	    <div id="wrap_content_<?php echo $tab_menu[$tabs]; ?>" class="wrap_content_row" <?php if ($tabs > 0) { ?> style="display:none;" <?php } ?>> <?php 
	    	$tabs += 1;
	    	$PT_ID = $this->db->escape_str($tabs);
	    	$rows = $this->common_model->custom_query(" SELECT * FROM product WHERE PT_ID = '$PT_ID' AND P_Allow = '1' ORDER BY P_DateTimeUpdate DESC "); 
			foreach ($rows as $key => $value) { 
				list($width, $height) = getimagesize(base_url('assets/uploads/user_uploads_img/'.$value['P_Img']));
	    		if ($width > $height) 	$layout = 'landscape';
	    		if ($width < $height) 	$layout = 'portrait';
	    		if ($width == $height)	$layout = 'square'; ?>
		        <div class="wrap_content_col">
					<a href="<?php echo base_url('main/product_details/'.$value['P_ID']); ?>" title="<?php echo $value['P_Name']; ?>">
						<div class="wrap_content_img">
							<div class="<?php echo $layout; ?>">
								<img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['P_Img']); ?>" title="<?php echo $value['P_Name']; ?>">
							</div>
						</div>
						<div class="wrap_content_title">
							<?php echo $value['P_Name']; ?>
						</div>
						<div class="wrap_content_price">
							฿<?php 
								$P_ID = $value['P_ID'];
								$PS_Price = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$P_ID' AND PS_Allow = '1' ORDER BY PS_DateTimeUpdate DESC LIMIT 1 "); 
								if (count($PS_Price)) {
									$prices = rowArray($PS_Price);
									$price 	= $prices['PS_Price'];
								}
								else $price = 0;
								echo number_format($price, 2, '.', ',');
							?>
						</div>
					</a>
					<div class="wrap_cart_or_detail">
						<div>
							<?php
				        		echo form_input(array('type' => 'hidden', 'id' => 'id', 		'name' => 'id', 		'value' => $value['P_ID']));
								echo form_input(array('type' => 'hidden', 'id' => 'name', 		'name' => 'name', 		'value' => $value['P_Name']));
								echo form_input(array('type' => 'hidden', 'id' => 'price', 		'name' => 'price', 		'value' => $price));
								echo form_input(array('type' => 'hidden', 'id' => 'code', 		'name' => 'code', 		'value' => $value['P_IDCode']));
				        		// echo form_input(array('type' => 'hidden', 'id' => 'length', 	'name' => 'length', 	'value' => '1'));
				        		echo form_input(array('type' => 'hidden', 'id' => 'note', 		'name' => 'note', 		'value' => ''));
				        	?>
							<!-- <select id="size" name="size">  -->
								<?php
								// $size = $this->common_model->getTableOrder('product_size', 'PSI_Order', 'ASC'); 
								// foreach ($size as $key => $sizes) { ?>
									<!-- <option value="<?php echo $sizes['PSI_ID']; ?>"><?php echo $sizes['PSI_Name']; ?></option>  -->
									<?php
								// } ?>
							<!-- </select> -->
							<!-- <select id="color" name="color">  -->
								<?php
								// $color = $this->common_model->getTableOrder('product_color', 'PC_Order', 'ASC'); 
								// foreach ($color as $key => $colors) { ?>
									<!-- <option value="<?php echo $colors['PC_ID']; ?>"><?php echo $colors['PC_Name']; ?></option>  -->
									<?php
								// } ?>
							<!-- </select> -->
						</div>
						<div>
							<button title="เพิ่มสินค้า" class="fancybox"><i class="fa fa-cart-plus"></i>เพิ่มสินค้า</button>
						</div>
						<div>
							<button title="รายละเอียด" onclick="location.href='<?php echo base_url('main/product_details/'.$value['P_ID']); ?>';"><i class="fa fa-search"></i>รายละเอียด</button>
						</div>
					</div>
				</div> <?php 
			} ?>
		</div> <?php
	} ?>
	<div class="pagination"><ul></ul></div>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/pagination_custom.js'); ?>"></script>
<script type="text/javascript">
	var imgtodrag = null;

	function imgDragToCart() {
		var cart = $('.cart_control');
    	if (imgtodrag) {
    		var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');

       		setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
    	}
	}

	function fancyboxClose_and_offsetContent() {
		$.fancybox.close();
		imgDragToCart();
		$("#qty").val('1');
		setTimeout(function() {
			// $("html, body").animate({ 
			// 	scrollTop: $("html, body").offset().top 
			// }, 1000);
		}, 1500);
	}

	function fancyboxClose_and_offsetTop() {
		$.fancybox.close();
		imgDragToCart();
		$("#qty").val('1');
		setTimeout(function() {
			// $("html, body").animate({ 
			// 	scrollTop: $("html, body").offset().top 
			// }, 1000);
			$(".various").click();
		}, 1500);
	}

	$(document).ready(function() {
		$(".wrap_content_col").mouseover(function() {
			$(this).find(".wrap_cart_or_detail").fadeIn("fast", function() {
   				$(this).find("div:nth-child(2)").animate({ display: 'table' }, 0);
   				$(this).find("div:last-child").animate({ display: 'table' }, 0);
   				// $(this).find("div:first-child").animate({ marginTop: '120px', opacity: 1 }, 250);
   				$(this).find("div:nth-child(2)").animate({ marginLeft: '34.375px', marginRight: '18.125px', opacity: 1 }, 250);
   				$(this).find("div:last-child").animate({ marginRight: '34.375px', marginLeft: '18.125px', opacity: 1 }, 250);
  			});
  		}).mouseleave(function() {
  			$(this).find(".wrap_cart_or_detail").fadeOut("fast", function() {
  				// $(this).find("div:first-child").animate({ marginTop: '-64px', opacity: 0 }, 250);
  				$(this).find("div:nth-child(2)").animate({ marginLeft: '-64px', marginRight: '-64px', opacity: 0 }, 250);
   				$(this).find("div:last-child").animate({ marginRight: '-64px', marginLeft: '-64px', opacity: 0 }, 250);
   				$(this).find("div:nth-child(2)").animate({ display: 'none' }, 0);
   				$(this).find("div:last-child").animate({ display: 'none' }, 0);
  			});
  		});

  	// 	$(".wrap_cart_or_detail").find('#size').change(function() {
  	// 		console.log($(this).closest('div').parent());
  	// 		var closest_parent = $(this).closest('div').parent();
  	// 		var request = $.ajax({
  	// 			url 	: "<?php echo base_url('product/product_size_get'); ?>",
  	// 			method 	: "POST",
  	// 			data 	: { PSI_Length : closest_parent.find("#size").val() }
			// });
			// request.done(function(msg) {
  	// 			closest_parent.find("#length").val(msg);
			// });
			// request.fail(function(jqXHR, textStatus) {
  	// 			// alert( "Request failed: " + textStatus );
			// });
  	// 	});

  		// $(".wrap_cart_or_detail").find('#size').each(function(index) {
  		// 	$(this).trigger("change");
  		// });

  		$(".wrap_cart_or_detail").find('button.fancybox').click(function() {
  			var closest_parent = $(this).closest('div').parent();
  			// if (closest_parent.find("#size").val()  != '' && closest_parent.find("#size").val()  != null &&
  			// 	closest_parent.find("#color").val() != '' && closest_parent.find("#color").val() != null) {
	  			var request = $.ajax({
	  				url 	: "<?php echo base_url('product/add_cart'); ?>",
	  				method 	: "POST",
	  				data 	: { 
	  					id 		: closest_parent.find("#id").val(),
	  					name 	: closest_parent.find("#name").val(),
	  					price 	: closest_parent.find("#price").val(),
	  					qty 	: 1,
	  					code 	: closest_parent.find("#code").val(),
	  					// size 	: closest_parent.find("#size").val(),
	  					// length 	: closest_parent.find("#length").val(),
	  					// color 	: closest_parent.find("#color").val(),
	  					note 	: closest_parent.find("#note").val()
	  				}
				});
				request.done(function(msg) {
	  				$(".cart_control").find("span").text('สินค้า (' + msg + ')');
	  				// closest_parent.find("#size option").eq(0).prop("selected", true);
	  				// closest_parent.find("#color option").eq(0).prop("selected", true);
				});
				request.fail(function(jqXHR, textStatus) {
	  				// alert( "Request failed: " + textStatus );
				});

	  			$(".fancybox").fancybox({
	    			openEffect  : 'fade',
	    			closeEffect : 'fade',
	    			beforeLoad: function() {
						$('.bx-wrapper .bx-controls-direction a').css('z-index', '8010');
					},
					beforeClose: function() {
						$('.bx-wrapper .bx-controls-direction a').css('z-index', '9999');
					},
	    			beforeShow : function(){
	 					$(".fancybox-inner").find("button").addClass("popup_button");
	 					$(".fancybox-inner").find("span").addClass("popup_text");
					},
	    			afterLoad   : function() {
	        			this.content = '' +
	        				'<div style="width:350px;height:100px">' +
	        					'<div style="height:50px;width:350px">' +
	        						'<div style="display:table;height:50px;width:350px">' +
	        							'<span style="display:table-cell;vertical-align:middle;height:50px;width:350px;text-align:center">1 x ' + closest_parent.find("#name").val() + ' เพิ่มในตะกร้าสินค้าแล้ว</span>' +
	        						'</div>' +
	        					'</div>' +
	        					'<div style="height:50px;width:350px">' +
	        						'<div style="float:left;width:50%">' +
	        							'<button onclick="fancyboxClose_and_offsetContent();" style="cursor:pointer;width:95%;margin-right:5%;padding:10px 20px">ซื้อสินค้าต่อ</button>' +
	        						'</div>' +
	        						'<div style="float:left;width:50%">' +
	        							'<button onclick="fancyboxClose_and_offsetTop();" style="cursor:pointer;width:95%;margin-left:5%;padding:10px 20px">ไปที่ตะกร้าสินค้า</button>' +
	        						'</div>' +
	        					'</div>' +
	        				'</div>';
	    			}
				});
			// }
			// else
			// 	alert("กรุณาเลือกขนาด และสี");
  		});

		$('.wrap_content_col').find('.wrap_cart_or_detail button.fancybox').on('click', function() {
			imgtodrag = $(this).closest('.wrap_content_col').find('.wrap_content_img img');
    	});

	});
</script>