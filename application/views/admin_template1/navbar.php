<div class="wrap_nav">
    <ul>
        <li <?php if (uri_seg(1) == 'control') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('control'); ?>" title="DASHBOARD"><div class="nav-menu-icon1"></div></a>
        	<a href="<?php echo base_url('control'); ?>" title="DASHBOARD">หน้าหลัก</a>
        </li>
        <li <?php if (uri_seg(1) == 'product') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('product/product_management'); ?>" title="PRODUCT"><div class="nav-menu-icon2"></div></a>
        	<a href="<?php echo base_url('product/product_management'); ?>" title="PRODUCT">สินค้า</a>
        </li>
        <li <?php if (uri_seg(1) == 'order') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('order/order_management'); ?>" title="ORDER"><div class="nav-menu-icon3"></div></a>
        	<a href="<?php echo base_url('order/order_management'); ?>" title="ORDER">การซื้อขาย</a>
        </li>
        <li <?php if (uri_seg(1) == 'bank') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('bank/bank_management'); ?>" title="BANK"><div class="nav-menu-icon4"></div></a>
            <a href="<?php echo base_url('bank/bank_management'); ?>" title="BANK">รายชื่อธนาคาร</a>
        </li>
        <li <?php if (uri_seg(1) == 'member' && uri_seg(2) != 'admin_profile_manage') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('member/member_management'); ?>" title="MEMBER"><div class="nav-menu-icon5"></div></a>
        	<a href="<?php echo base_url('member/member_management'); ?>" title="MEMBER">สมาชิก</a>
        </li>
        <li <?php if (uri_seg(1) == 'report') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('report/view_history'); ?>" title="REPORT"><div class="nav-menu-icon6"></div></a>
        	<a href="<?php echo base_url('report/view_history'); ?>" title="REPORT">รายงาน / สถิติ</a>
        </li>
        <li <?php if (uri_seg(1) == 'webconfig') { ?> class="active" <?php } ?>>
            <a href="<?php echo base_url('webconfig/index/edit/1'); ?>" title="SETTING"><div class="nav-menu-icon7"></div></a>
        	<a href="<?php echo base_url('webconfig/index/edit/1'); ?>" title="SETTING">ตั้งค่าระบบ</a>
        </li>
    </ul>
</div>