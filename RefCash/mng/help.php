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
			background-image: url('../media/images/help-icon.png');
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
				<h1>Hello <?php echo $_SESSION['user_fullname']; ?></h1>
				Here is a quick glance of how the admin office works<br>
				Read Through Below, to know how to use the admin office panel<br>
				Though You will definitely be offer deeper guidance by an administrator.
			</div>
		</div>

		<div id="howto">
			<div id="howto-desc">				
				<h1>Top Menu</h1>
				<p>
					Above this page you can see a menu that holds different sections of the Admin Office, the top menu makes it easy to navigate the Admin office.
					Right from the top menu you can go anywhere around the admin office, the various section you can navigate to are;

					<ul>
						<li>Users</li>
						<li>Withdrawal Requests</li>
						<li>Messages</li>
						<li>Payments</li>
					</ul>
				</p>
				<h1>Users Section</h1>
				<p>
					In the User Section which you can get to by clicking the Users button in the top menu at the top of the page, you can view and retreive user records when needed and also print the full information of a particular user when needed.<br>
					From this section you can see the total number of registered users and also the number of activate and inactive user accounts.
				</p>
				<h1>Withdrawal Requests</h1>
				<p>
					In the withrawal request section, you can view and retrieve withdraw request made by users, the information retrieved is used to make payemnts through bank transfers.<br>
					<strong><em>This would be explained further by an administrator.</em></strong>
				</p>
				<h1>Messages</h1>
				<p>
					The Message section would be used by the customer care unit, from this section you can view messages sent by users who are trying to contact <?php echo $site_name_b; ?>, any message gotten must be promptly replied to.
				</p>
				<h1>Payments</h1>
				<p>
					The Payments section holds the records of all payments made to <?php echo $site_name_b; ?> in order to activate user accounts, so whenever a user activates his/her account their payment is recorded and this record can be retrieved when needed from the payments section.
				</p>
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