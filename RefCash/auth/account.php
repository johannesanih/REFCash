<?php
	session_start();
	if(isset($_SESSION)) {
		if(!empty($_SESSION['user_level']) && $_SESSION['user_level'] == 0) {
			header("Location: dashboard.php?res=You are Already Logged In, Log Out Before Creating Another Account");
		} elseif(!empty($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
			header("Location: ../mng/");
		}
	}

	require("../config/config.php");
	require("../config/templates.php");
	require("template/template.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php if(!empty($site_description)) {echo $site_description; } else { echo $site_motto; } ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<link rel="stylesheet" href="../<?php echo $stylesheets['index']; ?>">
	<link rel="stylesheet" href="../<?php echo $stylesheets['accounts']; ?>">
	<link rel="icon" href="../<?php echo $site_logo; ?>">
	<title> Sign In <?php echo $site_name_b; ?></title>
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

		<div id="signup-div">

			<h2 id="name">Register</h2>


			<form id="signup-form" name="signup-form" action="register.php" method="POST">
				<div id="fullname-div">
					<label for="fullname">Full name</label>
					<input type="text" id="fullname" name="fullname" value="<?php if(isset($_POST['fullname'])) echo htmlentities($_POST['fullname'], ENT_QUOTES); ?>">
				</div>
				<div id="email-div">
					<label for="email">Email 
						<span style="color: red;"><?php if(isset($_GET['emailErrorR'])) echo $_GET['emailErrorR']; ?></span>
					</label>
					<input type="email" id="email" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES); ?>">
				</div>
				<div id="phone-div">
					<label for="phone">Phone Number
						<span style="color: red;"><?php if(isset($_GET['phoneErrorR'])) echo $_GET['phoneErrorR']; ?></span>
					</label>
					<input type="text" id="phone" name="phone" value="<?php if(isset($_POST['phone'])) echo htmlentities($_POST['phone'], ENT_QUOTES); ?>">
				</div>
				<div id="ref-div">
					<label for="referral_id">Referral</label>
					<input type="text" id="referral_id" name="referral_id" value="<?php if(isset($_GET['ref'])) echo htmlentities($_GET['ref'], ENT_QUOTES); else echo $site_name_b ?>">
				</div>
				<div id="password-div">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password'], ENT_QUOTES); ?>">
				</div>
				<div id="submit-div">
					<input type="submit" id="submit-btn" name="submit-btn" value="Register">
					<span id="account-o-c-r">Already have an account? <a href="javascript:void(0)">Log In</a></span>
				</div>
			</form>

		</div>

		<div id="login-div">

			<h2 id="name">Login</h2>

			<form id="login-form" name="login-form" action="login.php" method="POST">
				<div id="email-div">
					<label for="email">Email
						<span style="color: red;"><?php if(isset($_GET['emailMissingError'])) echo $_GET['emailMissingError']; ?></span>
					</label>
					<input type="email" id="email" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES); ?>">
				</div>
				<div id="password-div">
					<label for="password">Password
						<span style="color: red;"><?php if(isset($_GET['passwordIncorrectError'])) echo $_GET['passwordIncorrectError']; ?></span>
					</label>
					<input type="password" id="password" name="password" value="<?php if(isset($_POST['password'])) echo htmlentities($_POST['password'], ENT_QUOTES); ?>">
				</div>
				<div id="submit-div">
					<input type="submit" id="submit-btn" name="submit-btn" value="Login"><br>
					<span id="account-o-c-l">Don't yet have an account? <a href="javascript:void(0)">Register</a></span>
				</div>
			</form>

		</div>

		<?php
			if(isset($_GET['r']) && $_GET['r'] == 'yes') {
				echo "<script>";
				echo "document.getElementById('signup-div').style.display = 'block';";
				echo "document.getElementById('login-div').style.display = 'none';";
				echo "</script>";
			} else if(isset($_GET['l']) && $_GET['l'] == 'yes') {
				echo "<script>";
				echo "document.getElementById('signup-div').style.display = 'none';";
				echo "document.getElementById('login-div').style.display = 'block';";
				echo "</script>";
			}
			if(isset($_GET['loginError']) && !(empty($_GET['loginError']))) {

				echo "<script>";
				echo "alert('".$_GET['loginError']."');";
				echo "</script>";

			}
			if(isset($_GET['regError']) && !(empty($_GET['regError']))) {

				echo "<script>";
				echo "alert('".$_GET['regError']."');";
				echo "</script>";

			}
			if(isset($_GET['qError']) && !(empty($_GET['qError']))) {

				echo "<script>";
				echo "alert('".$_GET['qError']."');";
				echo "</script>";

			}
		?>

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
	<script type="text/javascript" src="../<?php echo $scripts['account']; ?>"></script>
</body>
</html>