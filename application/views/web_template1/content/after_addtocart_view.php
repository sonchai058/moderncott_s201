<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="description" content="<?php echo @$site['WD_Descrip']?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']?>">
        <meta name="author" content="<?php echo @$site['WD_Name']?>">
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/js/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancyapps/source/jquery.fancybox.css'); ?>" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugin/chosen/chosen.css'); ?>">
        <script src="<?php echo base_url('assets/js/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugin/fancyapps/source/jquery.fancybox.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugin/chosen/chosen.jquery.js'); ?>"></script>
    </head>
    <body>
        <div class="wrap_root">
            <div class="wrap_content">
                <div class="left">
                    <div class="after_addtocart_popup">
                        <div class="after_addtocart_detail">
                            <div class="after_addtocart_button">
                                <button><span>ซื้อสินค้าต่อ</span></button>
                            </div>
                            <div class="after_addtocart_button">
                                <button><span>ไปที่ตะกร้าสินค้า</span></button>
                            </div>
                        </div>
                        <div class="after_addtocart_detail">
                            <div class="after_addtocart_text">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">

    </script>
</html>