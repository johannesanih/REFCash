<?php
	session_start();
	if(isset($_SESSION['user_level'])) {
		if(!empty($_SESSION['user_level']) && $_SESSION['user_level'] !== 1) {
			header("Location: ../auth/");
		}
	} else {
		header("Location: ../auth/account.php");
	}

	require("../config/config.php");
	require("../config/templates.php");
	require("template/templates.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php if(!empty($site_description)) {echo $site_description; } else { echo $site_motto; } ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<link rel="stylesheet" href="../<?php echo $stylesheets['index']; ?>">
	<link rel="icon" href="../<?php echo $site_logo; ?>">
	<title>Admin Office <?php echo $site_name_b; ?></title>
	<style>
		#main>#intro>#img-1 {
			background-image: url('../<?php echo $site_image; ?>');
			background-size: contain;
			background-repeat: no-repeat;
		}
		#main>#howto>#img-2 {
			background-image: url('../media/images/page-img-2.jpg');
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
				<h1>Hello <?php echo $_SESSION['user_fullname']; ?><br></h1>
				How's your time working at <?php echo $site_name_b; ?> through this amazing control panel<br>
				<h2><?php echo $site_name_b; ?> Admin Office Policy, Rules and Regulations</h2>
				<?php echo $staff_rules; ?>
			</div>
		</div>

		<div id="howto">
			<div id="howto-desc">				
				As a staff, your <?php echo $site_name_b; ?> control panel account makes it easier to carry out your work without any technical know how.<br>
				<a href="help.php" id="learnMore-btn" class="btn">Help</a>
			</div>
			<div id="img-2">
			</div>
		</div>

		<!--<div id="final-action">
			<div id="final-action-note">				
				It takes just one click to change your life with <?php echo $site_name_b; ?><br>
				<a href="auth/account.php" id="changeL-btn" class="btn">Change Your Life Now!</a>
			</div>
		</div>-->

	</div>

	<?php

		if($_SESSION) {
			echo $page_footer_li;
		} else {
			echo $page_footer_lo;
		}

	?>

	<script type="text/javascript" src="../<?php echo $scripts['index']; ?>"></script>
	<script>
		addFooterCopyRight();
	</script>
</body>
</html>