    
    <!--
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/fontsset.css');?>">
  
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/images_sprites.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/reset.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/main.css');?>"/>

    <script src="<?=base_url('assets/js/bower_components/jquery/dist/jquery.min.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/js/bower_components/font-awesome/css/font-awesome.min.css');?>"/>
    -->
  
    <?php 
      echo css_asset('fontsset.css');
      echo css_asset('../admin/css/images_sprites.css');
      echo css_asset('../admin/css/reset.css');
      echo css_asset('../admin/css/main.css');
    ?>

    <script src="<?=base_url('assets/js/bower_components/jquery/dist/jquery.min.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('assets/js/bower_components/font-awesome/css/font-awesome.min.css');?>"/>

    <?php
      if(isset($this->template->js_assets_head))
      foreach ($this->template->js_assets_head as $key => $data) {
        echo $data;
      }
    ?>
    <?php
      if(isset($this->template->css_assets_head))
      foreach ($this->template->css_assets_head as $key => $data) {
        echo $data;
      }
    ?>
