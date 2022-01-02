<!DOCTYPE html>
<html>
<head>
  <?php  $site=rowArray($this->common_model->getTable('webconfig'));?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="<?php echo $site['WD_Descrip']?>">
    <meta name="keywords" content="<?php echo $site['WD_Keyword']?>">
    <meta name="author" content="<?php echo $site['WD_Name']?>">

    <link rel="shortcut icon" href="<?php echo base_url('assets/img/'.$site['WD_Icon']);?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/img/'.$site['WD_Icon']);?>" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fontsset.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/style.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/effects.css');?>"/>

       <script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js');?>"></script>
    <title>Forgot Password ?</title>
    <style type="text/css">
          body{
            background-color: #67adff;
          }   
        .pg_form{
            font-size:24px;
            width:500px;
            margin:100px auto;
        }
        .pg_form input[type="email"]{
            width:200px;
            height:30px;
            font-size:19px;
        }
        .pg_form input[type="submit"]{
            border:0;
            width:60px;
            height:35px;
            cursor:pointer;
            font-size:23px;
        }
        .pg_form a{
            text-decoration: none;
            color:#000;
            font-weight: bold;
            font-size:23px;
        }
        .pg_form a:hover{
            color:#F00;
        }

    </style>
</head>
<body>
    <?php echo form_open('control/fg_pass',"autocomplete='off'");?>
            <div class="pg_form">
                กรอกอีเมล์ของท่าน
                <input type="email" placeholder="Email" name="email" autofocus required> 
                <input type="submit" name="bt_submit" value="Send" title="Send">
                <br/><font color="red">*</font>หากยังไม่ได้รับอีเมล์ตอบกลับกรุณาส่งใหม่อีกครั้ง
                <br/><font color="red">*</font>ระบบจะส่งลิ้งค์พร้อมรหัสผ่านไปยังอีเมล์ของท่าน
                <br/><br/><br/><br/>
                <center><?php echo anchor('login','<< กลับไปหน้าล็อกอิน','title="กลับไปหน้าล็อกอิน"');?></center>
            </div>
    <?php echo form_close();?>
</body>
</html>