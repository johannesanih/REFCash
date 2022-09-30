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
	<title><?php echo $site_name_b; ?></title>
	<style>
		#main>#intro>#img-1 {
			background-image: url('<?php echo $site_image; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			animation-name: img_1_slide;
			animation-iteration-count: 1;
			animation-duration: 3s;
		}
		#main>#howto>#img-2 {
			background-image: url('media/images/page-img-2.jpg');
			background-size: contain;
			background-repeat: no-repeat;
		}
		.img-2-animation {
			animation-name: img_2_slide;
			animation-iteration-count: 1;
			animation-duration: 3s;
			animation-timing-function: ease-in-out;
		}
		@keyframes img_1_slide {
			0% {
				margin-right: 400px;
				opacity: 0;
			}
			100% {
				margin-right: 0;
				opacity: 1;
			}
		}
		@keyframes img_2_slide {
			0% {
				margin-right: 400px;
				opacity: 0;
			}
			100% {
				margin-right: 0;
				opacity: 1;
			}
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
				<?php echo $site_description; ?><br>
				<a href="auth/account.php?r=yes" id="getStarted-btn" class="btn">Get Started</a>
			</div>
		</div>

		<div id="howto">
			<div id="howto-desc">				
				<?php echo $operation_summary; ?><br>
				<a href="marketing strategy.php" id="learnMore-btn" class="btn">Learn More</a>
			</div>
			<div id="img-2">
			</div>
		</div>

		<div id="final-action">
			<div id="final-action-note">				
				It takes just one click to change your life with <?php echo _b; ?><br>
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