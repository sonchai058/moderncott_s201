<?php 
	$P__ID = $this->db->escape_str($P_ID);
	$row = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P__ID)); 

	$prices = $this->common_model->custom_query(" SELECT * FROM product_stock WHERE P_ID = '$P__ID' AND PS_Allow = '1' ");
	if (count($prices) > 0)
		$price = rowArray($prices); 
	else
		$price['PS_Amount'] = 0;

	// $size_input = array();
	// $size = $this->common_model->getTableOrder('product_size', 'PSI_Order', 'ASC'); 
	// foreach ($size as $key => $sizes) { 
	// 	$size_input[$sizes['PSI_ID']] = $sizes['PSI_Name'].' - '.$sizes['PSI_Note'];
	// }

	// $color_input = array();
	// $color = $this->common_model->getTableOrder('product_color', 'PC_Order', 'ASC'); 
	// foreach ($color as $key => $colors) { 
	// 	$color_input[$colors['PC_ID']] = $colors['PC_Name'];
	// }
?>
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
	  	var js, fjs = d.getElementsByTagName(s)[0];
	  	if (d.getElementById(id)) return;
	  	js = d.createElement(s); js.id = id;
	  	js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=250885448411787";
	  	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div class="product_details">
	<div class="product_heading">
		<h1>รายละเอียดสินค้า</h1>
	</div>
	<div class="product_content">
		<div class="product_content_left">
			<div class="product_images">
				<div class="product_image_main">
					<img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$row['P_Img']); ?>">
				</div>
				<div class="product_image_gallery"> <?php
					$gallery = $this->common_model->custom_query(" SELECT * FROM product_gallery WHERE P_ID = '$P__ID' ORDER BY PG_DateTimeUpdate DESC LIMIT 3 "); 
					foreach ($gallery as $key => $value) { ?>
						<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
							<img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
						</a> <?php
					} ?>
				</div>
			</div>
			<!-- <div class="product_socials_share">
				<div class="share-button fb-share-button" data-href="<?php echo base_url('main/product_details/'.$P__ID); ?>" data-layout="button_count"></div>
				<div class="share-button" style="margin-top:2px"><a class="twitter-follow-button" href="https://twitter.com/TwitterDev" data-show-screen-name="false" data-lang="th">Follow @TwitterDev</a></div>
			</div> -->
		</div>
		<div class="product_content_right">
			<div class="product_name">
				<h1><?php echo $row['P_Name']; ?></h1>
			</div>
			<!-- <div class="product_rating">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>	
			</div> -->
			<div class="product_title">
				<p><?php echo $row['P_Title']; ?></p>
			</div> 
			<div class="product_add_to_cart"> 
				<?php 
					echo form_open('product/add_cart'); 
					echo form_input(array('type' => 'hidden', 'id' => 'id', 		'name' => 'id', 		'value' => $row['P_ID']));
					echo form_input(array('type' => 'hidden', 'id' => 'name', 		'name' => 'name', 		'value' => $row['P_Name']));
					if (isset($price['PS_FullSumPrice']) && $price['PS_FullSumPrice'] !== null) 
						echo form_input(array('type' => 'hidden', 'id' => 'price', 		'name' => 'price', 		'value' => $price['PS_FullSumPrice']));
					else
						echo form_input(array('type' => 'hidden', 'id' => 'price', 		'name' => 'price', 		'value' => 0));
					// echo form_input(array('type' => 'hidden', 'id' => 'ex_price', 	'name' => 'ex_price', 	'value' => '30'));
					echo form_input(array('type' => 'hidden', 'id' => 'code', 		'name' => 'code', 		'value' => $row['P_IDCode']));
				?>
				<table>
					<tr>
						<td>ราคา:</td>
						<td>฿<span class="product_price"><?php if (isset($price['PS_FullSumPrice']) && $price['PS_FullSumPrice'] !== null) echo number_format($price['PS_FullSumPrice'], 2, '.', ','); else echo 0; ?></span></td>
						<td>คงเหลือ: <?php if (isset($price['PS_Amount']) && $price['PS_Amount'] !== null) echo $price['PS_Amount']; else echo 0; ?></td>
					</tr>
					<!-- <tr>
						<td>ขนาด:</td>
						<td><?php echo form_dropdown('size', $size_input, '', 'id="size"'); ?></td>
					</tr> -->
					<!-- <tr>
						<td>ความยาว:</td>
						<td><?php echo form_input(array('type' => 'number', 'id' => 'ex_length', 'name' => 'ex_length', 'min' => '34', 'value' => '34')); ?></td>
					</tr> -->
					<!-- <tr>
						<td>สี:</td>
						<td><?php echo form_dropdown('color', $color_input, '', 'id="color"'); ?></td>
						
					</tr> -->
					<!-- <tr>
						<td>คงเหลือ: </td>
						<td><span class="stock_qty">1</span></td>
					</tr> -->
					<tr>
						<td>จำนวน:</td>
						<?php if (!isset($price['PS_Amount']) || $price['PS_Amount'] === null || $price['PS_Amount'] < 1) $maxQty = 1; else $maxQty = $price['PS_Amount']; ?>
						<td colspan="2"><?php echo form_input(array('type' => 'number', 'id' => 'qty', 'name' => 'qty', 'value' => '1', 'min' => '1', 'max' => $maxQty, 'required' => 'required')); ?></td>
					</tr>
					<tr>
						<td>หมายเหตุ:</td>
						<td colspan="2"><?php echo form_textarea(array('id' => 'note', 'name' => 'note', 'rows' => '3')); ?></td>
					</tr>
					<tr>
						<td colspan="3"><button class="fancybox" <?php if (!isset($price['PS_Amount']) || $price['PS_Amount'] === null || $price['PS_Amount'] < 1) { ?> disabled <?php } ?>><i class="fa fa-cart-plus"></i><span>เพิ่มสินค้า ในตะกร้า<!-- เพิ่มสินค้าสั่งตัด ในตะกร้า --></span></button></td>
					</tr>
				</table> <?php
				echo form_close(); ?>	
			</div>
		</div>
	</div>
	<div class="product_more_information">
		<div class="product_more_info_tab">
			<div id="product_more_info_descript" class="product_more_info_menu active">รายละเอียด</div>
			<div id="product_more_info_gallery" class="product_more_info_menu">อัลบั้มรูปภาพ</div>
		</div>
		<div id="product_more_content" class="product_more_details">
			<div class="product_more_details_content"> <?php 
				if (isset($row['P_Detail']) && $row['P_Detail'] !== '') 
					echo $row['P_Detail']; ?>
			</div>
		</div>
		<div id="product_more_gallery" class="product_more_details" style="display:none">
			<div class="product_more_details_gallery"> <?php
				$gallery = $this->common_model->custom_query(" SELECT * FROM product_gallery WHERE P_ID = '$P__ID' ORDER BY PG_DateTimeUpdate ASC LIMIT 3, 99999999999 "); 
				foreach ($gallery as $key => $value) { ?>
					<a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
						<img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$value['PG_Img']); ?>" title="<?php echo $value['PG_Name']; ?>">
					</a> <?php
				} ?>
			</div>
		</div>
	</div>
</div>
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
		$("#qty").val('1');
	}

	function fancyboxClose_and_offsetTop() {
		$.fancybox.close();
		$("#qty").val('1');
		setTimeout(function() {
			$(".various").click();
		}, 1500);
	}

	window.twttr = (function(d, s, id) {
  		var js, fjs = d.getElementsByTagName(s)[0],
    	t = window.twttr || {};
  		if (d.getElementById(id)) return t;
  		js = d.createElement(s);
  		js.id = id;
  		js.src = "https://platform.twitter.com/widgets.js";
  		fjs.parentNode.insertBefore(js, fjs);
 
  		t._e = [];
  		t.ready = function(f) {
    		t._e.push(f);
  		};
 
  		return t;
	}(document, "script", "twitter-wjs"));



	$(document).ready(function() {
		if ($(".product_add_to_cart").find('button').prop('disabled') === true) {
			$(".product_add_to_cart").find('button').addClass('notallow_addtocart');
		}

		$(".product_add_to_cart").find('button').click(function() {
  			var request = $.ajax({
  				url 	: "<?php echo base_url('product/add_cart'); ?>",
  				method 	: "POST",
  				data 	: { 
  					id 		: $("#id").val(),
  					name 	: $("#name").val(),
  					price 	: $("#price").val(),
  					qty 	: $("#qty").val(),
  					code 	: $("#code").val(),
  					note 	: $("#note").val(),
  				}
			});
			request.done(function(msg) {
  				imgDragToCart();
  				setTimeout(function(){
  					$(".cart_control").find("span").removeClass("null");
  					$(".cart_control").find("span").text(msg);
  				},1200);
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
        							'<span style="display:table-cell;vertical-align:middle;height:50px;width:350px;text-align:center">' + $("#qty").val() + ' x ' + $(".product_name").find('h1').text() + ' เพิ่มในตะกร้าสินค้าแล้ว</span>' +
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
  		});

		// $("#size").change(function() {
		// 	if ($("#size").val() === '1') $("#ex_length").val('34'); $("#ex_length").trigger("keyup");
		// 	if ($("#size").val() === '2') $("#ex_length").val('35'); $("#ex_length").trigger("keyup");
		// 	if ($("#size").val() === '3') $("#ex_length").val('36'); $("#ex_length").trigger("keyup");
		// 	if ($("#size").val() === '4') $("#ex_length").val('37'); $("#ex_length").trigger("keyup");
		// 	if ($("#size").val() === '5') $("#ex_length").val('38'); $("#ex_length").trigger("keyup");
			// $("#color option").each(function() {
   //  			$(this).remove();
			// });
			// var colors = ['แดง', 'ส้ม', 'เหลือง', 'เขียว', 'น้ำเงิน', 'คราม', 'ม่วง'];
			// var x = Math.floor(Math.random() * 8);
			// var y = Math.floor(Math.random() * 8);
			// if (x < y || x === y) var citrus = colors.slice(x, y);
			// else if (x > y) var citrus = colors.slice(y, x);
			// shuffle(citrus);
			// $.each(citrus, function(key, value) {
   //  			$("#color").append('<option value=' + key + '>' + value + '</option>');
			// });
			// $("#color").val("0").trigger("change");
		// });

		// $("#color").change(function() {
		// 	if ($("#color option").length > 0)
		// 		$(".stock_qty").text(Math.floor(Math.random() * 11));
		// 	else if ($("#color option").length <= 0)
		// 		$(".stock_qty").text(0);
		// });

		// $("#size").trigger("change");

		$("#qty").keyup(function() {
			var maxQty = parseInt("<?php echo $price['PS_Amount']; ?>");
			if ($("#qty").val() < 1)
				setTimeout(function(){ 
					$("#qty").val('1'); 
					$("#qty").trigger("keyup"); 
				}, 2000);
			else if ($("#qty").val() > maxQty)
				setTimeout(function(){ 
					$("#qty").val(maxQty); 
					$("#qty").trigger("keyup"); 
				}, 2000);
			else if ($("#qty").val() > 1 && $("#qty").val() <= maxQty) {
				setTimeout(function(){ 
					$(".product_price").text((parseFloat(parseFloat($("#price").val()) * parseInt($("#qty").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
				}, 1000);
			}
			// if ($("#qty").val() > parseInt($(".stock_qty").text()))
			// 	$(".stock_qty").addClass("stock_qty_warn");
			// else if ($("#qty").val() <= parseInt($(".stock_qty").text()))
			// 	$(".stock_qty").removeClass("stock_qty_warn");
			// if ($("#ex_length").val() > 38)
			// 	$(".product_price").text((parseFloat((parseFloat($("#price").val()) + parseFloat($("#ex_price").val())) * parseInt($("#qty").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			// else if ($("#ex_length").val() >= 35 && $("#ex_length").val() <= 38)
			// 	$(".product_price").text((parseFloat(parseFloat($("#price").val()) * parseInt($("#qty").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		});

		// $("#ex_length").keyup(function() {
		// 	setTimeout(function(){ 
		// 		if ($("#ex_length").val() > 38)
		// 			$(".product_price").text((parseFloat((parseFloat($("#price").val()) + parseFloat($("#ex_price").val())) * parseInt($("#qty").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		// 		else if ($("#ex_length").val() >= 34 && $("#ex_length").val() <= 38)
		// 			$(".product_price").text((parseFloat(parseFloat($("#price").val()) * parseInt($("#qty").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		// 		else if ($("#ex_length").val() < 34) {
		// 			$("#ex_length").val('34'); 
		// 			$("#ex_length").trigger("keyup"); 
		// 		}
		// 	}, 1000);
		// });

		$("#product_more_info_descript").click(function() {
			$("#product_more_info_descript").addClass("active");
			$("#product_more_content").fadeIn("fast", function() {
				$("#product_more_content").css("display", "block");
			});
			$("#product_more_info_gallery").removeClass("active");
			$("#product_more_gallery").css("display", "none");
		});

		$("#product_more_info_gallery").click(function() {
			$("#product_more_info_descript").removeClass("active");
			$("#product_more_content").css("display", "none");
			$("#product_more_info_gallery").addClass("active");
			$("#product_more_gallery").fadeIn("fast", function() {
				$("#product_more_gallery").css("display", "block");
			});
		});

		// $(".fancybox").fancybox({
		// 	openEffect	: 'fade',
		// 	closeEffect	: 'fade',
		// 	beforeShow: function () {
  //           	$('<div class="watermark"></div>').bind("contextmenu", function(e) {
  //                   return false;
  //               }).prependTo($.fancybox.wrap);
		// 		$.fancybox.showLoading();
  //       	},
  //       	afterShow: function() {
  //               $.fancybox.hideLoading();
  //           },
		// 	beforeLoad: function() {
		// 		$('.bx-wrapper .bx-controls-direction a').css('z-index', '8010');
		// 	},
		// 	beforeClose: function() {
		// 		$('.bx-wrapper .bx-controls-direction a').css('z-index', '9999');
		// 	},
		// 	helpers : {
		// 		locked 	: true
		// 	}
		// });

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

		$('.product_add_to_cart').find('button.fancybox').on('click', function() {
			imgtodrag = $('.product_image_main').find('img');
    	});

	});
</script>