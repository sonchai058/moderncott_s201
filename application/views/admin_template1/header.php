<?php 
    $site = rowArray($this->common_model->custom_query(" SELECT * FROM webconfig ")); 
    // $tran = $this->db->query(" SELECT OT_ID FROM order_transfer ");
    $tran = $this->common_model->custom_query(" SELECT COUNT(OT_ID) AS OTID FROM order_transfer WHERE OT_Allow = '1' ");
    if (count($tran) > 0) {
        $tcnt = rowArray($tran);
        $OTID = $tcnt['OTID'];
    }
    else
        $OTID = 0;
?>
<div class="wrap_top">
    <div class="wrap_profile">
        <a title="<?php echo get_session('M_flName'); ?>">
            <img src="<?php echo base_url('assets/uploads/profile_img/'.get_session('M_Img')); ?>">
        </a>
        <a><span><?php echo get_session('M_flName'); ?></span></a>
        <a class="wrap_profile_show_hide" title="แสดงเมนูผู้ใช้งาน"><div></div></a>
        <a class="wrap_profile_hide_show" title="ซ่อนเมนูผู้ใช้งาน"><div></div></a>
    </div>
    <div class="wrap_profile_edit">
        <a href="<?php echo base_url('member/admin_profile_manage/edit/'.get_session('M_ID')); ?>" title="EDIT PROFILE">
            <div class="profile-menu">
                <div class="profile-menu-icon pm-icon1"></div><div class="profile-menu-text"><span>แก้ไขข้อมูลส่วนตัว</span></div>
            </div>
        </a>
        <a href="<?php echo base_url('logout'); ?>" title="LOGOUT">
            <div class="profile-menu">
                <div class="profile-menu-icon pm-icon2"></div><div class="profile-menu-text"><span>ออกจากระบบ</span></div>
            </div>
        </a>
    </div>
    <div class="wrap_head">
        <div class="wrap_head_menu">
            <ul> <?php 
                if (uri_seg(1) == 'product') { ?>
                    <li <?php if (uri_seg(2) == 'product_management') { ?>      class="active" <?php } ?>><a href="<?php echo base_url('product/product_management'); ?>"       title="PRODUCT">สินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'category_management') { ?>     class="active" <?php } ?>><a href="<?php echo base_url('product/category_management'); ?>"      title="CATEGORY">หมวดหมู่สินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'product_size_manage') { ?>     class="active" <?php } ?>><a href="<?php echo base_url('product/product_size_manage'); ?>"      title="PRODUCT SIZE">ขนาด / รูปทรงสินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'product_type_manage') { ?>     class="active" <?php } ?>><a href="<?php echo base_url('product/product_type_manage'); ?>"      title="PRODUCT TYPE">ชนิดสินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'product_unit_manage') { ?>     class="active" <?php } ?>><a href="<?php echo base_url('product/product_unit_manage'); ?>"      title="PRODUCT UNIT">หน่วยนับสินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'product_color_manage') { ?>    class="active" <?php } ?>><a href="<?php echo base_url('product/product_color_manage'); ?>"     title="PRODUCT COLOR">สีของสินค้า</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'product_gallery_manage') { ?>  class="active" <?php } ?>><a href="<?php echo base_url('product/product_gallery_manage'); ?>"   title="PRODUCT GALLERY">แกลเลอรี่รูปสินค้า</a><div></div></li> <?php
                }
                else if (uri_seg(1) == 'order') { ?>
                    <!-- <li <?php if (uri_seg(2) == 'order_management') { ?>        class="active" <?php } ?>><a href="<?php echo base_url('order/order_management'); ?>"           title="ORDER">ประวัติการซื้อขาย</a><div></div></li>  -->
                    <!-- <li <?php if (uri_seg(2) == 'order_list_manage') { ?>       class="active" <?php } ?>><a href="<?php echo base_url('order/order_list_manage'); ?>"          title="ORDER LIST">ORDER LIST</a><div></div></li>  -->
                    <!-- <li <?php if (uri_seg(2) == 'order_address_manage') { ?>    class="active" <?php } ?>><a href="<?php echo base_url('order/order_address_manage'); ?>"       title="ORDER ADDRESS">ORDER ADDRESS</a><div></div></li>  -->
                    <li <?php if (uri_seg(2) == 'order_transfer_manage') { ?>   class="active" <?php } ?>><a href="<?php echo base_url('order/order_transfer_manage'); ?>"      title="ORDER TRANSFER">การสั่งซื้อ<span><?php echo /* $tran->num_rows(); */ $OTID; ?></span></a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'order_management' || uri_seg(2) == 'order_read') { ?> class="active" <?php } ?>><a href="<?php echo base_url('order/order_management'); ?>"           title="ORDER">ประวัติการซื้อขาย</a><div></div></li> <?php
                }
                else if (uri_seg(1) == 'bank') { ?>
                    <li <?php if (uri_seg(2) == 'bank_management') { ?>         class="active" <?php } ?>><a href="<?php echo base_url('bank/bank_management'); ?>"             title="BANK">ธนาคาร</a><div></div></li> <?php
                }
                else if (uri_seg(1) == 'member' && uri_seg(2) != 'admin_profile_manage' && uri_seg(2) != 'member_profile_manage') { ?>
                    <!-- <li <?php if (uri_seg(2) == 'member_management') { ?>       class="active" <?php } ?>><a href="<?php echo base_url('member/member_management'); ?>"         title="MEMBER">ผู้เข้าใช้งานระบบ</a><div></div></li>  -->
                    <li <?php if (uri_seg(2) == 'admin_management') { ?>        class="active" <?php } ?>><a href="<?php echo base_url('member/admin_management'); ?>"          title="ADMIN">ผู้ดูแลระบบ</a><div></div></li> <?php
                }
                else if (uri_seg(1) == 'report') { ?>
                    <li <?php if (uri_seg(2) == 'view_history') { ?>            class="active" <?php } ?>><a href="<?php echo base_url('report/view_history'); ?>"              title="VIEW HISTORY">ประวัติการเข้าชม</a><div></div></li> 
                    <li <?php if (uri_seg(2) == 'total_sales') { ?>             class="active" <?php } ?>><a href="<?php echo base_url('report/total_sales'); ?>"               title="TOTAL SALES">ยอดการขาย</a><div></div></li> <?php
                }
                else if (uri_seg(2) == 'admin_profile_manage' || uri_seg(2) == 'member_profile_manage') { ?>
                    <li class="active"><a href="<?php echo base_url(''); ?>" title="PROFILE SETTING">แก้ไขข้อมูลส่วนตัว</a><div></div></li> <?php
                }
                else if (uri_seg(1) == 'webconfig') { ?>
                    <li class="active"><a href="<?php echo base_url('webconfig'); ?>" title="SYSTEM SETTING">ตั้งค่าระบบ</a><div></div></li> <?php
                } ?>
            </ul>
        </div>
        <div class="wrap_head_name_logo">
            <!-- <a href="<?php echo base_url('control'); ?>" title="<?php echo $site["WD_Name"].' ('.$site["WD_EnName"].')'; ?>">
                <div>
                    <span><?php echo $site["WD_Name"]; ?></span>
                    <br>
                    <span><?php echo $site["WD_EnName"]; ?></span>
                </div>
            </a> -->
            <a href="<?php echo base_url('control'); ?>" title="<?php echo $site["WD_Name"].' ('.$site["WD_EnName"].')'; ?>">
                <img src="<?php echo base_url('assets/images/'.$site["WD_Logo"]); ?>">
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".wrap_profile_show_hide").click(function() {
            $(".wrap_profile_show_hide").css("display", "none");
            $(".wrap_profile_hide_show").css("display", "block");
            $(".wrap_profile_edit").fadeToggle("fast", "linear");
        });
        $(".wrap_profile_hide_show").click(function() {
            $(".wrap_profile_show_hide").css("display", "block");
            $(".wrap_profile_hide_show").css("display", "none;");
            $(".wrap_profile_edit").fadeToggle("fast", "linear");
        });
    });
</script>