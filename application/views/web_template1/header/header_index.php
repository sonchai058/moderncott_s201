<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

<div class="wrap_head">
	<div class="wrap_container">
		<div class="left">
			<ul>
				<li title="Tel: <?php echo $site['WD_Tel']; ?>"><i class="fa fa-phone"></i><span><?php if ($site['WD_Tel'] !== '') echo $site['WD_Tel']; else echo '[Phone Number]'; ?></span></li>
				<li title="E-Mail: <?php echo $site['WD_Email']; ?>"><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo $site['WD_Email']; ?>" <?php if ($site['WD_Email'] !== '') { ?> target="_blank" <?php } ?>><span><?php if ($site['WD_Email'] !== '') echo $site['WD_Email']; else echo '[Email Address]'; ?></span></a></li>
			</ul>
		</div>
		<div class="right">
			<div class="wrap_title">
				<span>Get In Touch</span>
			</div>
			<div class="social_link">
				<ul>
					<li title="Google+">
						<a href="<?php if ($site['WD_Gglink'] !== '')  echo $site['WD_Gglink']; else echo '#'; ?>" <?php if ($site['WD_Gglink'] !== '') { ?> target="_blank" <?php } ?>>
							<img width="100%" height="100%" src="<?php echo base_url('assets/images/social-icons/google+-dark-grey.png'); ?>">
						</a>
					</li>
					<li title="Twitter">
						<a href="<?php if ($site['WD_Twlink'] !== '')  echo $site['WD_Twlink']; else echo '#'; ?>" <?php if ($site['WD_Twlink'] !== '') { ?> target="_blank" <?php } ?>>
							<img width="100%" height="100%" src="<?php echo base_url('assets/images/social-icons/twitter-dark-grey.png'); ?>">
						</a>
					</li>
					<li title="Linkedin">
						<a href="<?php if ($site['WD_Inlink'] !== '')  echo $site['WD_Inlink']; else echo '#'; ?>" <?php if ($site['WD_Inlink'] !== '') { ?> target="_blank" <?php } ?>>
							<img width="100%" height="100%" src="<?php echo base_url('assets/images/social-icons/linkedin-dark-grey.png'); ?>">
						</a>
					</li>
					<li title="Facebook">
						<a href="<?php if ($site['WD_FbLink'] !== '')  echo $site['WD_FbLink']; else echo '#'; ?>" <?php if ($site['WD_FbLink'] !== '') { ?> target="_blank" <?php } ?>>
							<img width="100%" height="100%" src="<?php echo base_url('assets/images/social-icons/facebook-dark-grey.png'); ?>">
						</a>
					</li>
				</ul>	
			</div>
		</div>
	</div>
</div>