<?php
	session_start();

	require("config/config.php");
	require("config/templates.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php if(!empty($site_description)) {echo $site_description; } else { echo $site_motto; } ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<link rel="stylesheet" href="<?php echo $stylesheets['index']; ?>">
	<link rel="icon" href="<?php echo $site_logo; ?>">
	<title>Marketing Strategy <?php echo $site_name_b; ?></title>
	<style>
		#main>#intro>#img-1 {
			background-image: url('media/images/CashTop Marketing Strategy 1.png');
			background-size: contain;
			background-repeat: no-repeat;
		}
		#main>#howto>#img-2 {
			background-image: url('media/images/CashTop Chain Network.png');
			background-size: contain;
			background-repeat: no-repeat;
		}
	</style>
</head>
<body>
	<?php
		if($_SESSION) {
			echo $page_header_li;
		} else {
			echo $page_header_lo;
		}
	?>

	<div id="main">

		<div id="intro">
			<div id="img-1">
			</div>
			<div id="intro-desc">				
				The Mode Of Operation that <?php echo $site_name_b; ?> uses, is a straight forward approach that would fetch you a lot of money within a short time, we've experimented with most of the popular earning sites in the world and we know what people want, They want it Stress Free, Fast and Plenty, And We Are Giving You Just That.<br>
				<a href="auth/account.php?r=yes" id="getStarted-btn" class="btn">Get Started</a>
			</div>
		</div>

		<div id="howto">
			<div id="howto-desc">				
				<strong>3 Things Defines What You Do At <?php echo $site_name_b; ?></strong><br><br><strong>Refer<br>Earn<br>Sleep</strong><br><br><em><strong>Make We RES Jor!</strong></em><br>
				<a href="auth/account.php?r=yes" id="learnMore-btn" class="btn">Get Started</a>
			</div>
			<div id="img-2">
			</div>
		</div>

		<div id="final-action">
			<div id="final-action-note">				
				<strong>About Us</strong><br><br>
				At <?php echo $site_name_b; ?>, we are all about you, what you think and what you want, about how to increase and invest your income and also teaching you how to survive in a difficult economic situaion.<br>
				<a href="auth/account.php?r=yes" id="changeL-btn" class="btn">Change Your Life Now!</a>
			</div>
		</div>

	</div>

	<?php

		if($_SESSION) {
			echo $page_footer_li;
		} else {
			echo $page_footer_lo;
		}

	?>

	<script type="text/javascript" src="<?php echo $scripts['index']; ?>"></script>
	<script>
		addFooterCopyRight();
	</script>
</body>
</html>