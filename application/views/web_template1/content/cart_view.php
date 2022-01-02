<?php
    $row = $this->common_model->getTable('provinces');
    if (count($row) <= 0)
        $custom_array = array('' => '');
    else {
        $custom_array = array();
        foreach ($row as $key => $value) {
            $custom_array[$value['Province_ID']] = trim($value['Province_Name']);
        }
    }
?>
<div class="wrap_root" style="width:1180px">
    <div class="wrap_content" style="height:auto">
        <div class="left" style="width:1180px">
            <div class="cart_list" id="shoppingcart">
            	<div class="cart_heading">
                    <h2 align="center">ตะกร้าสินค้า</h2>
                </div>
                <div class="cart_check"> 
                    <span> <?php 
                        $cart_check = $this->cart->contents();
                       	if (empty($cart_check))
                            echo 'ไม่มีสินค้าในตะกร้า'; ?>
                    </span>
                </div> <?php 
                if ($cart = $this->cart->contents()) { 
                    $grand_quantity = 0;
                    foreach ($cart as $itemQty) {
                        $grand_quantity = $grand_quantity + $itemQty['qty'];
                    } ?>
                    <div class="cart_view"> 
                        <table> 
                            <thead>
                                <tr class="cart_view_heading">
                                    <th width="50">ลำดับที่</th>
                                    <th width="60">รูปสินค้า</th>
                                    <th width="">ชื่อสินค้า</th>
                                    <!-- <th width="">ขนาด / สี</th> -->
                                    <th width="">หมายเหตุ</th>
                                    <th width="50">ราคา</th>
                                    <th width="50">จำนวน</th>
                                    <th width="">ราคารวม</th>
                                    <th width="40">ยกเลิก</th>
                                </tr> 
                            </thead> 
                            <tbody> <?php
                                $grand_total = 0;
                                $i = 1;
                                foreach ($cart as $item) { ?>
                                <tr> <?php 
                                    echo form_hidden('cart['.$item['id'].'][id]',               $item['id']);
                                    echo form_hidden('cart['.$item['id'].'][rowid]',            $item['rowid']);
                                    echo form_hidden('cart['.$item['id'].'][name]',             $item['name']);
                                    echo form_hidden('cart['.$item['id'].'][options][code]',    $item['options']['code']);
                                    echo form_hidden('cart['.$item['id'].'][options][note]',    $item['options']['note']); ?>
                                    <td>
                                        <?php 
                                            echo $i++; 
                                            // echo form_hidden('cart['.$item['id'].'][id]', $item['id']);
                                        ?>
                                    </td>
                                    <td class="cart_view_input">
                                        <?php $img = rowArray($this->common_model->get_where_custom('product', 'P_ID', $item['id'])); ?>
                                        <img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$img['P_Img']); ?>" width="50">
                                    </td>
                                    <td>
                                        <?php echo $item['name'].' ('.$item['options']['code'].')'; ?>
                                    </td>
                                    <!-- <td>
                                        <?php 
                                            $size   = rowArray($this->common_model->get_where_custom('product_size',    'PSI_ID',   $item['options']['size'])); 
                                            $color  = rowArray($this->common_model->get_where_custom('product_color',   'PC_ID',    $item['options']['color'])); 
                                            echo $size['PSI_Name'].' - '.$size['PSI_Note'].' / '.$color['PC_Name'];
                                        ?>
                                    </td> -->
                                    <td>
                                        <?php echo $item['options']['note']; ?>
                                    </td>
                                    <td class="cart_view_number">
                                        <?php 
                                            echo form_input(array('type' => 'hidden', 'id' => 'orig_'.$item['id'].'_price', 'name' => 'orig['.$item['id'].'][price]', 'value' => $item['price']));
                                            echo form_input(array('type' => 'hidden', 'id' => 'cart_'.$item['id'].'_price', 'name' => 'cart['.$item['id'].'][price]', 'value' => $item['price']));
                                            echo '<span id="text_'.$item['id'].'_price">฿'.number_format($item['price'], 2, '.', ',').'</span>'; 
                                        ?>
                                    </td>
                                    <td class="cart_view_input">
                                        <?php 
                                            echo form_input(array('type' => 'number', 'class' => 'cart_qttys', 'id' => 'cart_'.$item['id'].'_qty', 'name' => 'cart['.$item['id'].'][qty]', 'value' => $item['qty'], 'min' => '1', 'max' => '99', 'onkeyup' => "quantity_change(this.value, ".$item['id'].")")); 
                                        ?>
                                    </td>
                                    
                                    <td class="cart_view_number">
                                        <?php 
                                            $grand_total    = $grand_total + $item['subtotal']; 
                                            $item_subtotal  = $item['subtotal'];
                                            echo form_input(array('type' => 'hidden', 'class' => 'cart_total', 'id' => 'cart_'.$item['id'].'_total', 'name' => 'cart['.$item['id'].'][total]', 'value' => $item['subtotal']));
                                            echo '฿<span id="text_'.$item['id'].'_total">'.number_format($item['subtotal'], 2, '.', ',').'</span>'; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $path = "<i class='fa fa-remove'></i>";
                                            echo form_button(array('value' => $item['rowid'].','.$item['qty'], 'onclick' => "remove_cart($(this).closest('td').parent()[0], $(this).closest('td').parent()[0].sectionRowIndex, this.value)", 'content' => $path)); 
                                        ?>
                                    </td> 
                                </tr> <?php 
                                } ?>
                            </tbody>  
                            <tfoot>
                                <tr>
                                    <th colspan="3">
                                        <?php echo form_input(array('type' => 'hidden', 'id' => 'cart_grand_total', 'name' => 'cart_grand_total', 'value' => $grand_total)); ?>
                                        <b>ราคารวมทั้งสิ้น: <?php echo '฿<span id="text_grand_total">'.number_format($grand_total, 2, '.', ',').'</span>'; ?></b>
                                    </th>
                                    <th colspan="5">
                                        <input type="button" value="สั่งซื้อ" class="place_order">
                                        <input type="button" value="ล้างตะกร้าสินค้า" onclick="clear_cart()">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div> <?php
                } 
                else {
                    $grand_total    = 0;
                    $grand_quantity = 0; 
                } ?>
            </div>
            <div class="order_info" style="display:none">
                <div class="order_heading">
                    <h2 align="center">ข้อมูลใบสั่งซื้อ</h2>
                </div>
                <div class="order_view">
                    <h1 class="notify-msg" align="center">(*) ข้อมูลที่จำเป็น</h1>
                    <table>
                        <tr>
                            <td>ชื่อ-นามสกุล<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_input(array('name' => 'OD_Name', 'id' => 'OD_Name', 'placeholder' => 'ชื่อ-นามสกุล')); ?></td>
                        </tr>
                        <tr>
                            <td>โทรศัพท์<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_input(array('name' => 'OD_Tel', 'id' => 'OD_Tel', 'placeholder' => 'โทรศัพท์')); ?></td>
                        </tr>
                        <tr>
                            <td>อีเมล์<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_input(array('name' => 'OD_Email', 'id' => 'OD_Email', 'placeholder' => 'อีเมล')); ?></td>
                        </tr>
                        <tr>
                            <td>เลขที่ / ห้อง<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_input(array('name' => 'OD_hrNumber', 'id' => 'OD_hrNumber', 'placeholder' => 'เลขที่ / ห้อง')); ?></td>
                        </tr>
                        <tr>
                            <td>หมู่บ้าน / อาคาร / คอนโด: </td>
                            <td><?php echo form_input(array('name' => 'OD_VilBuild', 'id' => 'OD_VilBuild', 'placeholder' => 'หมู่บ้าน / อาคาร / คอนโด')); ?></td>
                        </tr>
                        <tr>
                            <td>หมู่ที่: </td>
                            <td><?php echo form_input(array('name' => 'OD_VilNo', 'id' => 'OD_VilNo', 'placeholder' => 'หมู่ที่', 'maxlength' => '2')); ?></td>
                        </tr>
                        <tr>
                            <td>ถนน: </td>
                            <td><?php echo form_input(array('name' => 'OD_Street', 'id' => 'OD_Street', 'placeholder' => 'ถนน')); ?></td>
                        </tr>
                        <tr>
                            <td>ตรอก / ซอย: </td>
                            <td><?php echo form_input(array('name' => 'OD_LaneRoad', 'id' => 'OD_LaneRoad', 'placeholder' => 'ตรอก / ซอย')); ?></td>
                        </tr>
                        <tr>
                            <td>จังหวัด<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_dropdown(array('name' => 'Province_ID', 'class' => 'Province_ID chosen-select', 'id' => 'Province_ID'), $custom_array); ?></td>
                        </tr>
                        <tr>
                            <td>เขต / อำเภอ<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_dropdown(array('name' => 'Amphur_ID', 'class' => 'Amphur_ID chosen-select', 'id' => 'Amphur_ID')); ?></td>
                        </tr>
                        <tr>
                            <td>แขวง / ตำบล<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_dropdown(array('name' => 'District_ID', 'class' => 'District_ID chosen-select', 'id' => 'District_ID')); ?></td>
                        </tr>
                        <tr>
                            <td>รหัสไปรษณีย์<span class="notify-msg">*</span> : </td>
                            <td><?php echo form_input(array('name' => 'Zipcode_Code', 'class' => 'Zipcode_Code', 'id' => 'Zipcode_Code', 'maxlength' => '5')); ?></td>
                        </tr>
                        <tr>
                            <td>การจัดส่งพัสดุไปรษณีย์ไทย: </td>
                            <td>
                                <input type="radio" id="reg" class="delivery" name="delivery" value="1" checked> ลงทะเบียน +฿30.00 &nbsp; 
                                <input type="radio" id="ems" class="delivery" name="delivery" value="2"> EMS +฿50.00 &nbsp; 
                                <input type="hidden" id="regems" class="delivery" name="delivery">
                                <span class="notify-msg"> &nbsp; * สินค้า 2 ชิ้นขึ้นไป ฟรีค่าจัดส่งแบบลงทะเบียน</span>
                            </td>
                        </tr>
                        <tr>
                            <td>หมายเหตุ / รายละเอียด: </td>
                            <td><?php echo form_textarea(array('name' => 'OD_Descript', 'id' => 'OD_Descript', 'placeholder' => 'หมายเหตุ / รายละเอียด')); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button" value="ยืนยันข้อมูล" class="submit_order" onclick="save_info()">
                                <input type="button" value="ยกเลิก" class="cancel_order" onclick="cancel_info()">
                            </td>
                        </tr> 
                    </table>
                </div>
            </div>
            <div class="order_confirm" style="display:none">
                <div class="confirm_heading">
                    <h2 align="center">ยืนยันการสั่งซื้อ</h2>
                </div>
                <div class="confirm_view">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="1" width="50">ลำดับที่</th>
                                <th colspan="1" width="">ชื่อสินค้า</th>
                                <!-- <th colspan="1" width="">ขนาด / สี</th> -->
                                <th colspan="1" width="">หมายเหตุ</th>
                                <th colspan="1" width="50">ราคา</th>
                                <th colspan="1" width="50">จำนวน</th>
                                <th colspan="1" width="">ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">ราคารวมทั้งหมด: </th>
                                <th colspan="1">฿<span id="price_total_text"></span></th>
                            </tr>
                            <tr>
                                <th colspan="5">พัสดุไปรษณีย์ไทย: </th>
                                <th colspan="1">฿<span id="regis_or_ems"></span></th>
                            </tr>
                            <tr>
                                <th colspan="5">ราคารวมทั้งสิน: </th>
                                <th colspan="1">฿<span id="grand_total_text"></span></th>
                            </tr>
                            <tr>
                                <th colspan="6">
                                    <input type="button" value="ยืนยันการสั่งซื้อ" class="submit_order" onclick="save_order()">
                                    <input type="button" value="ยกเลิก" class="cancel_order" onclick="cancel_order()">
                                    <span class="order_success">บันทึกใบสั่งซื้อเรียบร้อยแล้ว</span>
                                </th>
                            </tr> 
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var grand_total_new     = parseInt("<?php echo $grand_total; ?>");
    var grand_qttys_new     = parseInt("<?php echo $grand_quantity; ?>");
    var delivery_include    = 0;
    var delivery_feecost    = 0;

    var p_id                = [];
    var odl_amount          = [];
    var odl_price           = [];
    var odl_sum_price       = [];
    var odl_full_sum_price  = [];
    var odl_descript        = [];

    function quantity_change(this_value, this_id) {
        var total_new = parseFloat($("#cart_" + this_id +"_price").val()) * parseInt($("#cart_" + this_id +"_qty").val());
        $("#cart_" + this_id +"_total").val(total_new);
        $("#text_" + this_id +"_total").text((total_new.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        grand_total_new = 0;
        $(".cart_total").each(function(index) {
            grand_total_new += parseFloat($(this).val());
        });
        var grand_qttys_new = 0;
        $(".cart_qttys").each(function(index) {
            grand_qttys_new += parseFloat($(this).val());
        });
        $("#cart_grand_total").val(grand_total_new);
        $("#text_grand_total").text((grand_total_new.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $("#grand_total_text").text(grand_total_new);
    }

    function remove_cart(this_attr, this_rowIndex, this_value) {

        var result = confirm('คุณแน่ใจหรือไม่ว่าต้องการที่จะยกเลิกรายการนี้?');
        if (result) {

            var rowid = this_value.split(",")[0];
            var qtyno = this_value.split(",")[1];
            var request = $.ajax({
                url     : "<?php echo base_url('product/remove_cart'); ?>/" + rowid,
                method  : "POST"
            });
            request.done(function(msg) {
                grand_total_new = parseFloat($("#cart_grand_total").val()) - parseFloat($(".cart_view").find("table tbody tr:eq(" + this_rowIndex + ") td:eq(7) input").val());
                
                $("#text_grand_total").text(((parseFloat($("#cart_grand_total").val()) - parseFloat($(".cart_view").find("table tbody tr:eq(" + this_rowIndex + ") td:eq(7) input").val())).toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $("#cart_grand_total").val(parseFloat($("#cart_grand_total").val()) - parseFloat($(".cart_view").find("table tbody tr:eq(" + this_rowIndex + ") td:eq(7) input").val()));
                
                grand_qttys_new -= parseInt(qtyno);

                if (grand_qttys_new === 0){
                    $(".cart_control").find("span").addClass("null");
                    $(".cart_control").find("span").text('');
                    $(".fancybox-overlay, .fancybox-overlay-fixed").click();

                    setTimeout(function() {
                        $(".various").click();
                    }, 1500);  
                }
                else
                    $(".cart_control").find("span").text(grand_qttys_new);

                this_attr.remove();
                $(".cart_list").find("table tbody tr").each(function(index) {
                    $(this).find("td").eq(0).text(index + 1);
                });
                if ($("#cart_grand_total").val() <= 0) 
                    $(".fancybox-overlay, .fancybox-overlay-fixed").click();
                else {
                    $('.cart_view').css('display', 'none');
                    $('.cart_view').fadeIn('slow');
                }
            });
            request.fail(function(jqXHR, textStatus) {
                // alert("Request failed: " + textStatus);
            });

        }
        else
            return false;

        // var result = confirm('คุณแน่ใจหรือไม่ว่าต้องการที่จะยกเลิกรายการนี้?');
        // if (result) {
            // var rowid = this_value.split(",")[0];
            // var qtyno = this_value.split(",")[1];
            // var request = $.ajax({
            //     url     : "<?php echo base_url('product/remove_cart'); ?>/" + rowid,
            //     method  : "POST"
            // });
            // request.done(function(msg) {
            //     new_grand_quantity -= parseInt(qtyno);
            //     if (new_grand_quantity === 0)
            //         $(".cart_control").find("span").text('ตะกร้าสินค้า');
            //     else
            //         $(".cart_control").find("span").text('สินค้า (' + new_grand_quantity + ')');
            //     $(".cart_view").find("table tbody tr").eq(this_rowIndex).remove();
            //     new_grand_total -= this_price;
            //     if (new_grand_total != 0) {
            //         $(".cart_view").find("table tfoot tr th:first b").text('ราคารวมทั้งสิ้น: ฿' + ((new_grand_total.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")));
            //         $('.cart_view').fadeOut('slow', function() {
            //             $(this).load($(this).fadeIn('slow'));
            //         });
            //     }
            //     else
            //         $(".fancybox-overlay, .fancybox-overlay-fixed").click();
            // });
            // request.fail(function(jqXHR, textStatus) {
            //     // alert("Request failed: " + textStatus);
            // });
        // }
        // else
            // return false;
    }

    function clear_cart() {
        var result = confirm('คุณแน่ใจหรือไม่ว่าต้องการที่จะยกเลิกการสั่งซื้อทั้งหมด?');
        if (result) {
            // window.location = "<?php echo base_url('product/remove_cart/all'); ?>";
            var request = $.ajax({
                url     : "<?php echo base_url('product/remove_cart/all'); ?>",
                method  : "POST"
            });
            request.done(function(msg) {
                $(".cart_control").find("span").addClass("null");
                $(".cart_control").find("span").text('');
                $(".fancybox-overlay, .fancybox-overlay-fixed").click();
            });
            request.fail(function(jqXHR, textStatus) {
                // alert("Request failed: " + textStatus);
            });
        }
        else
            return false;
    }

    function save_info() {
        if ($("#OD_Name").val() == '' || $("#OD_Name").val() == null) {
            $("#OD_Name").focus();
            alert("กรุณาระบุ ชื่อ-นามสกุล");
        }
        else if ($("#OD_Tel").val() == '' || $("#OD_Tel").val() == null) {
            $("#OD_Tel").focus();
            alert("กรุณาระบุ หมายเลขโทรศัพท์");
        }
        else if ($("#OD_Tel").val().length < 9) {
            $("#OD_Tel").focus();
            alert("กรุณาระบุ หมายเลขโทรศัพท์ 9 หลักขึ้นไป");
        }
        else if ($("#OD_Email").val() == '' || $("#OD_Email").val() == null) {
            $("#OD_Email").focus();
            alert("กรุณาระบุ อีเมล");
        }
        else if (/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/.test($("#OD_Email").val()) == false) {
            $("#OD_Email").focus();
            alert("กรุณาระบุ อีเมล์ให้ถูกต้อง");
        }
        else if ($("#OD_hrNumber").val() == '' || $("#OD_hrNumber").val() == null) {
            $("#OD_hrNumber").focus();
            alert("กรุณาระบุ เลขที่ / ห้อง");
        }
        else if ($("#OD_VilNo").val().length > 0 && /[0-9]+$/.test($("#OD_VilNo").val()) == false) {
            $("#OD_VilNo").focus();
            alert("กรุณาระบุ หมู่ที่ด้วยหมายเลข");
        }
        else if ($("#Zipcode_Code").val() == '' || $("#Zipcode_Code").val() == null) {
            $("#Zipcode_Code").focus();
            alert("กรุณาระบุ รหัสไปรษณีย์");
        }
        else if (/[0-9]+$/.test($("#Zipcode_Code").val()) == false) {
            $("#Zipcode_Code").focus();
            alert("กรุณาระบุ รหัสไปรษณีย์ด้วยหมายเลข");
        }
        else {
            $(".order_info").fadeOut("fast");
            $(".order_confirm").fadeIn("slow");
            $(".order_success").css('display', 'none');

            $(".confirm_view").find("table tbody").html('');
            for (var i = 0; i < $(".cart_list").find("table tbody tr").size(); ++i) {
                $(".confirm_view").find("table tbody").append(
                    "<tr>" +
                        "<td colspan='1'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(0)").text() + "</td>" + 
                        "<td colspan='1'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(2)").text() + "</td>" + 
                        "<td colspan='1'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(3)").text() + "</td>" + 
                        // "<td colspan='1'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(4)").text() + "</td>" + 
                        // "<td colspan='1' class='cart_view_number'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(5)").text() + "</td>" + 
                        // "<td colspan='1' class='cart_view_input'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(6) input").val() + "</td>" + 
                        // "<td colspan='1' class='cart_view_number'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(7)").text() + "</td>" + 
                        "<td colspan='1' class='cart_view_number'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(4)").text() + "</td>" + 
                        "<td colspan='1' class='cart_view_input'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(5) input").val() + "</td>" + 
                        "<td colspan='1' class='cart_view_number'>" + $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(6)").text() + "</td>" + 
                    "</tr>"
                );
                p_id[i]                 = $(".cart_list").find("table tbody tr:eq(" + i + ") input:eq(0)").val();
                odl_amount[i]           = $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(5) input").val();
                odl_price[i]            = $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(4) input").val();
                odl_sum_price[i]        = $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(6) input").val();
                odl_full_sum_price[i]   = $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(6) input").val();
                odl_descript[i]         = $(".cart_list").find("table tbody tr:eq(" + i + ") td:eq(3)").text();
            }
        }
    }

    function cancel_info() {
        $(".order_success").css('display', 'none');
        $(".order_info").fadeOut("fast");
        $(".cart_list").fadeIn("slow");
    }

    function save_order() {
        var result = confirm('ตรวจสอบข้อมูลการสั่งซื้อทั้งหมดแล้วใช่หรือไม่?');
        if (result) {
            var full_OD_Descript = '';
            if ($("#reg").prop("checked") == true) 
                full_OD_Descript = $("#OD_Descript").text() + '(ลงทะเบียน)';
            else if ($("#ems").prop("checked") == true) 
                full_OD_Descript = $("#OD_Descript").text() + '(EMS)';
            var request = $.ajax({
                url: "<?php echo base_url('order/order_save'); ?>",
                method: "POST",
                data: {  
                    OD_SumPrice         : parseFloat(grand_total_new), 
                    OD_FullSumPrice     : parseFloat(delivery_include),  

                    OD_Name             : $("#OD_Name").val(),
                    OD_Descript         : full_OD_Descript,
                    OD_Tel              : $("#OD_Tel").val(),
                    OD_Email            : $("#OD_Email").val(),
                    OD_hrNumber         : $("#OD_hrNumber").val(),
                    OD_VilBuild         : $("#OD_VilBuild").val(),
                    OD_VilNo            : $("#OD_VilNo").val(),
                    OD_LaneRoad         : $("#OD_LaneRoad").val(),
                    OD_Street           : $("#OD_Street").val(),
                    Amphur_ID           : $("#Amphur_ID").val(),
                    District_ID         : $("#District_ID").val(),
                    Province_ID         : $("#Province_ID").val(),
                    Zipcode_Code        : $("#Zipcode_Code").val(),

                    P_ID                : p_id,
                    ODL_Amount          : odl_amount,
                    ODL_Price           : odl_price,
                    ODL_SumPrice        : odl_sum_price,
                    ODL_FullSumPrice    : odl_full_sum_price,
                    ODL_Descript        : odl_descript,
                }
            });
            request.done(function(msg) {
                alert(msg);
                $(".cart_control").find("span").text('');
                $(".fancybox-overlay, .fancybox-overlay-fixed").click();
                location.reload();
            });
            request.fail(function(jqXHR, textStatus) {
                // alert("Request failed: " + textStatus);
            });
        }
        else
            return false;
    }

    function cancel_order() {
        $(".order_success").css('display', 'none');
        $(".order_confirm").fadeOut("fast");
        $(".order_info").fadeIn("slow");
    }

    $(document).ready(function() {
        $(".place_order").click(function() {
            $(".cart_list").fadeOut("fast");
            $(".order_info").fadeIn("slow");
            $(".order_success").css('display', 'none');
            $("#price_total_text").text((grand_total_new.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $("#grand_total_text").text((grand_total_new.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#reg').trigger('click');
        });

        $(".Province_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/amphurs_selection'); ?>",
                method: "POST",
                data: { Province_ID : $(this).val() }
            });
            request.done(function(msg) {
                $('.Amphur_ID').find('option').remove().end();
                $.each(JSON.parse(msg), function(i, value) {
                    $('.Amphur_ID').append($('<option>').text(value).attr('value', i));
                });
                $('.Amphur_ID').trigger('change');
                $('#reg').trigger('click');
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".Amphur_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/districts_selection'); ?>",
                method: "POST",
                data: { Amphur_ID : $(this).val() }
            });
            request.done(function(msg) {
                $('.District_ID').find('option').remove().end();
                $.each(JSON.parse(msg), function(i, value) {
                    $('.District_ID').append($('<option>').text(value).attr('value', i));
                });
                $('.District_ID').trigger('change');
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $(".District_ID").change(function() {
            var request = $.ajax({
                url: "<?php echo base_url('main/zipcodes_selection'); ?>",
                method: "POST",
                data: { District_ID : $(this).val() }
            });
            request.done(function(msg) {
                $('.Zipcode_Code').val(msg);
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });

        $('.Province_ID').trigger('change');

        $('#reg').click(function() {
            delivery_include = 0;
            // if (grand_qttys_new <= 1) {
                // delivery_include = parseFloat(grand_total_new + 30);

            if ($('.Province_ID').val() == 1 || $('.Province_ID').val() == 2 || $('.Province_ID').val() == 3 || $('.Province_ID').val() == 4 || $('.Province_ID').val() == 58 || $('.Province_ID').val() == 59) {
                if (grand_total_new > 30000) {
                    delivery_include = parseFloat(grand_total_new + 0);
                    delivery_feecost = 0;
                    $("#regis_or_ems").text(delivery_feecost.toFixed(2));
                }
                else {
                    delivery_include = parseFloat(grand_total_new + 30);
                    delivery_feecost = 30;
                    $("#regis_or_ems").text(delivery_feecost.toFixed(2));
                }
            }
            else {
                delivery_include = parseFloat(grand_total_new + 30);
                delivery_feecost = 30;
                $("#regis_or_ems").text(delivery_feecost.toFixed(2));
            }

                // $("#regis_or_ems").text(30);
                $("#grand_total_text").text((delivery_include.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            // }
            // else {
            //     delivery_include = parseFloat(grand_total_new);
            //     $("#regis_or_ems").text(0);
            //     $("#grand_total_text").text((delivery_include.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            // }
            $('#regems').val($('#reg').val());
        });

        $('#ems').click(function() {
            delivery_include = 0;
            delivery_feecost = 0;

            // delivery_include = parseFloat(grand_total_new + 50);

            if ($('.Province_ID').val() == 1 || $('.Province_ID').val() == 2 || $('.Province_ID').val() == 3 || $('.Province_ID').val() == 4 || $('.Province_ID').val() == 58 || $('.Province_ID').val() == 59) {
                if (grand_total_new > 30000) {
                    delivery_include = parseFloat(grand_total_new + 0);
                    delivery_feecost = 0;
                    $("#regis_or_ems").text(delivery_feecost.toFixed(2));
                }
                else {
                    delivery_include = parseFloat(grand_total_new + 50);
                    delivery_feecost = 50;
                    $("#regis_or_ems").text(delivery_feecost.toFixed(2));
                }
            }
            else {
                delivery_include = parseFloat(grand_total_new + 50);
                delivery_feecost = 50;
                $("#regis_or_ems").text(delivery_feecost.toFixed(2));
            }

            // $("#regis_or_ems").text(50);
            $("#grand_total_text").text((delivery_include.toFixed(2)).toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#regems').val($('#ems').val());
        });
    });
</script>