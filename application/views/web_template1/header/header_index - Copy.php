<?php
//dieArray($_COOKIE);
?>
<div class="header">
    <div class="col-md-4 logo margin0">
      <a href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/images/'.$site['WD_Logo']);?>" alt=""></a>
    </div>
    <div class="col-md-8 margin0 pad0">
    <nav class="navbar navbar-default navbar-email">
        <ul class="nav navbar-nav navbar-left head-contact">
            <li><p class="navbar-text navbar-right"><i class="fa fa-envelope"></i> <span class="nav-one"><a href="mailto:reservation@newsite.siamtriandle.com"><?php echo $site['WD_Email']; ?></a></span></p></li>
            <li><p class="navbar-text navbar-right"><i class="fa fa-phone"></i> <span class="nav-one">Tel: <?php echo $site['WD_Tel'];?></span></p></li>
        </ul>
        <form class="navbar-form navbar-left" role="search">
          <div class="dropdown">
            <a href="<?php echo base_url('login');?>" class="btn btn-default btn-login"><i class="fa fa-user"></i> LOGIN</a>
            <button class="btn btn-default btn-login dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <?php 
                if ($_COOKIE['googtrans'] == '/en/en') { 
                  $icon = 'English_icon.png';
                  $lang = 'English';
                } elseif ($_COOKIE['googtrans'] == '/en/th') {
                  $icon = 'thai_icon.png';
                  $lang = 'Thai';
                } elseif ($_COOKIE['googtrans'] == '/en/zh-TW') {
                  $icon = 'Chinese_icon.png';
                  $lang = 'Chinese';
                } elseif ($_COOKIE['googtrans'] == '/en/fr') {
                  $icon = 'French_icon.png';
                  $lang = 'French';
                } elseif ($_COOKIE['googtrans'] == '/en/de') {
                  $icon = 'German_icon.png';
                  $lang = 'German';
                } elseif ($_COOKIE['googtrans'] == '/en/ja') {
                  $icon = 'Japanese_icon.png';
                  $lang = 'Japanese';
                } elseif ($_COOKIE['googtrans'] == '/en/ko') {
                  $icon = 'Korean_icon.png';
                  $lang = 'Korean';
                } elseif ($_COOKIE['googtrans'] == '/en/lo') {
                  $icon = 'Lao_icon.png';
                  $lang = 'Lao';
                } elseif ($_COOKIE['googtrans'] == '/en/ru') {
                  $icon = 'Russian_icon.png';
                  $lang = 'Russian';
                } elseif ($_COOKIE['googtrans'] == '/en/sv') {
                  $icon = 'Swedish_icon.png';
                  $lang = 'Swedish';
                } elseif ($_COOKIE['googtrans'] == '/en/vi') {
                  $icon = 'Vietnamese_icon.png';
                  $lang = 'Vietnamese';
                } else {
                  $icon = '';
                  $lang = '';
                }
              ?>
              <img src="<?php echo base_url('assets/images/'.$icon)?>" alt=""> <?php echo $lang; ?>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" id="translation-links" aria-labelledby="dropdownMenu1">
              <li><a id="en" href="#" onclick="translator('en')"><img src="<?php echo base_url('assets/images/English_icon.png')?>" alt=""> English</a></li>
              <li><a id="th" href="#" onclick="translator('th')"><img src="<?php echo base_url('assets/images/thai_icon.png')?>" alt=""> Thai</a></li>
              <li><a id="en" href="#" onclick="translator('zh-TW')"><img src="<?php echo base_url('assets/images/Chinese_icon.png')?>" alt=""> Chinese</a></li>
              <li><a id="en" href="#" onclick="translator('fr')"><img src="<?php echo base_url('assets/images/French_icon.png')?>" alt=""> French</a></li>
              <li><a id="en" href="#" onclick="translator('de')"><img src="<?php echo base_url('assets/images/German_icon.png')?>" alt=""> German</a></li>
              <li><a id="en" href="#" onclick="translator('ja')"><img src="<?php echo base_url('assets/images/Japanese_icon.png')?>" alt=""> Japanese</a></li>
              <li><a id="en" href="#" onclick="translator('ko')"><img src="<?php echo base_url('assets/images/Korean_icon.png')?>" alt=""> Korean</a></li>
              <li><a id="en" href="#" onclick="translator('lo')"><img src="<?php echo base_url('assets/images/Lao_icon.png')?>" alt=""> Lao</a></li>
              <li><a id="en" href="#" onclick="translator('ru')"><img src="<?php echo base_url('assets/images/Russian_icon.png')?>" alt=""> Russian</a></li>
              <li><a id="en" href="#" onclick="translator('sv')"><img src="<?php echo base_url('assets/images/Swedish_icon.png')?>" alt=""> Swedish</a></li>
              <li><a id="en" href="#" onclick="translator('vi')"><img src="<?php echo base_url('assets/images/Vietnamese_icon.png')?>" alt=""> Vietnamese</a></li>
            </ul>
          </div>
        </form>
    </nav>
    <nav class="navbar navbar-default navbar-manu">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed pull-left btn-menu" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                <a href="<?php echo base_url();?>">HOME<?php if(uri_seg(1)=='' || uri_seg(2)=='main'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a>
                </li>
                <li><a href="<?php echo base_url('specialoffers');?>">SPECIAL OFFERS<?php if(uri_seg(1)=='specialoffers' || uri_seg(1)=='room_detail'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a></li>
                <li><a href="<?php echo base_url('ourresort');?>">OUR RESORT<?php if(uri_seg(1)=='ourresort'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a></li>
                <li><a href="<?php echo base_url('booking/step-1');?>">RESERVATION<?php if(uri_seg(1)=='booking'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a></li>
                <li><a href="<?php echo base_url('service');?>">SURVEY<?php if(uri_seg(1)=='service'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a></li>
                <li><a href="<?php echo base_url('contact');?>">CONTACT<?php if(uri_seg(1)=='contact'){ ?><hr class="pad0 margin0 hr-nav" style="border:2px #c7b999 solid; margin-top:10px; margin-bottom:-20px;"><?php } ?></a></li>
            </ul>
        </div>
    </nav>
    </div>
</div>

<script type="text/javascript">
  $(window).scroll(function() {    
      var scroll = $(window).scrollTop();
      //alert(scroll);
      if (scroll >= 50) {
          $(".navbar-manu").addClass("bg-menu");
      } else {
          $(".navbar-manu").removeClass("bg-menu");
      }
  });
</script>