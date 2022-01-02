<!DOCTYPE html>
<html>
    <head>
        <?php 
            $site = $this->webinfo_model->getOnceWebMain(); 

            $WD_Name    = $site['WD_Name'];
            $WD_EnName  = $site['WD_EnName'];

            $site['WD_Descrip'] = @unserialize($site['WD_Descrip']);
            $site['WD_Keyword'] = @unserialize($site['WD_Keyword']);
            $site['WD_Name']    = @unserialize($site['WD_Name']);

        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="description" content="<?php echo $site['WD_Descrip']['TH'].','.$site['WD_Keyword']['EN'];?>">
        <meta name="keywords" content="<?php echo $site['WD_Keyword']['TH'].','.$site['WD_Keyword']['EN'];?>">
        <meta name="author" content="<?php echo $site['WD_Name']['TH'].','.$site['WD_Name']['EN'];?>">

        <link rel="shortcut icon" href="<?php echo base_url('assets/images/'.$site['WD_Icon']); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/'.$site['WD_Icon']); ?>" type="image/x-icon">

        <?php
            echo css_asset('fontsset.css');
            echo css_asset('../admin/css/images_sprites.css');
            echo css_asset('../admin/css/reset.css');
            echo css_asset('../admin/css/login.css');
            echo js_asset('bower_components/jquery/dist/jquery.min.js');
        ?>

        <title><?php echo $title; ?></title>
    </head>

    <body>
        <div class="wrap_login">
            <?php echo form_open('member/admin_access/login',"id='formLogin' autocomplete='off'"); ?>
                <div class="title_login">
                    <img src="<?php echo base_url('assets/images/'.$site['WD_Icon']);?>">
                    <ul class="wrap_name">
                        <li><?php echo $WD_Name;    ?></li>
                        <li><?php echo $WD_EnName;  ?></li>
                    </ul>
                </div>
                <table class="table_data">
                    <tr>
                        <td><input type="text" name="user_id" title="Username" autofocus required placeholder="Username"></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="user_pass" title="Password" value="" required placeholder="Password"></td>
                    </tr>
                </table>
                <ul class="wrap_data">
                    <li><?php echo $captcha;?><br><input type="text" name="captcha" id="user_cap" value=""></li>
                    <li>
                        <a class="loginSubmit" title="Login">
                            <div class="wrap_item">
                                <img src="<?php echo base_url('assets/images/login-256-256.png');?>">
                                <span>Login</span>
                            </div>
                        </a>
                    </li>
                    <li><a class="forgot_link" href="<?php echo base_url('fg_pass'); ?>" title="Forgot Password?">Forgot password?</a></li>
                </ul>
            <?php echo form_close(); ?>
        </div>
    </body>
    
    <script>
        $(document).ready(function() {
            $('input').each(function(index) {
                $(this).keyup(function(event) {
                    if (event.keyCode == 13)
                        $('.loginSubmit').click();
                });
            });
            $("body").hide().fadeIn(380);
            $(".loginSubmit").click(function() {
                $("#formLogin").submit();
            });
        });
    </script>
</html>