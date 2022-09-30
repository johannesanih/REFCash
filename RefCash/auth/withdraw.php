<?php
	session_start();
	if(isset($_SESSION)) {
		if(!empty($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
			header("Location: ../mng/");
		}
	} else {
		header("Location: account.php");
	}

	require("../config/config.php");
	require("../config/templates.php");
	require("template/template.php");
	
	$user_id = $_SESSION['user_id'];
	$user_fullname = $_SESSION['user_fullname'];
	$user_email = $_SESSION['user_email'];
	$user_ref_id = $_SESSION['user_ref_id'];
	$user_referrer = $_SESSION['user_referrer'];

	$bank_sql = "SELECT `acct_no`, `acct_name`, `bank_name` FROM ".$site_name.".`users` WHERE `id`=?";

	$bank_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($bank_q, $bank_sql);
	mysqli_stmt_bind_param($bank_q, 'i', $user_id);

	if(mysqli_stmt_execute($bank_q)) {
		$result = mysqli_stmt_get_result($bank_q);
		$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$account_number = $item['acct_no'];
		$account_name = $item['acct_name'];
		$bank_name = $item['bank_name'];

		mysqli_free_result($result);
	}

	if(empty($account_number) || empty($account_name) || empty($bank_name)) {
		header("Location: bank details.php");
		exit();
	}

	$wb_sql = "SELECT `wallet_balance` FROM ".$site_name.".`users` WHERE `id`=?";

	$wb_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($wb_q, $wb_sql);
	mysqli_stmt_bind_param($wb_q, 'i', $user_id);

	if(mysqli_stmt_execute($wb_q)) {
		$result = mysqli_stmt_get_result($wb_q);
		$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$user_wallet_balance = $item['wallet_balance'];

		mysqli_free_result($result);
	}

	$user_level = $_SESSION['user_level'];
	$user_activated = $_SESSION['user_activated'];
	$user_registration_date = $_SESSION['user_registration_date'];

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
	<link rel="stylesheet" href="../<?php echo $stylesheets['dashboard']; ?>">
	<link rel="icon" href="../<?php echo $site_logo; ?>">
	<title> Withdraw <?php echo $site_name_b; ?></title>
	<style>
		<?php 
			$avatar_image_link = "../media/images/avatar-".rand(1, 4).".jpg";
		?>
		#main>#profile-summary>#profile-pic {
			margin: 10px;
			width: 200px;
			height: 200px;
			background-image: url('<?php echo $avatar_image_link; ?>');
			background-size: contain;
			border-radius: 50%;
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

		if(isset($_GET['res'])) {
			echo "<script>";
			echo "alert('".$_GET['res']."');";
			echo "</script>";
		}

	?>

	<div id="main">

		<?php
			if($user_activated == 'no') {
				echo "<style>";
				echo "#main {display: block;}";
				echo "</style>";
				$mrkp = "
					<div id='main-in-1'>
						<h1 id='h1-1'>".$user_fullname." You Are Almost There!</h1>
						<div id='pay-pers'>
							<h2 id='h3-1'>Pay 3000 NGN To Join Network</h2>
							<div id='pay-link'>
								<a href=''>Pay With Card</a>
							</div>
						</div>
					</div>
				";

				echo $mrkp;

			} else if($user_activated == 'yes') {

				echo "<style>";
				echo "#main {display: block;}";
				echo "</style>";
				$mrkp = "
					<form method='POST' action='withdraw.php' name='bank_details_form' id='bank_details_form'>

						<h2 id='heading'>Withdraw - Minimum of 5000 NGN</h2>

						<input type='number' min='5000' step='1000' name='amt' id='amt' placeholder='Amount To Withdraw' value=''><br>

						<input type='submit' name='submitBTN' id='submitBTN' value='Withdraw'>

					</form>
				";

				echo $mrkp;

			}

			if($_POST) {

				$amt = filter_var($_POST['amt'], FILTER_SANITIZE_STRING);

				if($user_wallet_balance < 5000) {
					header("Location: withdraw.php?res=Insufficient Funds You Can Withdraw A Minimum Of 5000");
					exit();
				} else {
					$new_wallet_balance = $user_wallet_balance - $amt;
				}

				$amt = filter_var($_POST['amt'], FILTER_SANITIZE_STRING);

				$sql = "UPDATE ".$site_name.".`users` SET `wallet_balance`=? WHERE `id`=?";

				$q = mysqli_stmt_init($dbcon);
				mysqli_stmt_prepare($q, $sql);
				mysqli_stmt_bind_param($q, 'ii', $new_wallet_balance, $user_id);
				if(mysqli_stmt_execute($q)) {

					try {

						$wdr_sql = "INSERT INTO ".$site_name.".`withdrawal_request` (`id`, `amount`, `made_by`) VALUES(NULL, ?, ?)";
						$wdr_q = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($wdr_q, $wdr_sql);
						mysqli_stmt_bind_param($wdr_q, 'ss', $amt, $user_fullname);
						mysqli_stmt_execute($wdr_q);

						header("Location: withdraw.php?res=Withdrawal Request Sent Successfully");
							

					}
					catch(Error $e) {
						echo $e;
					}
					catch(Exception $e) {
						echo $e;
					}

				} else {
					header("Location: withdraw.php?res=Unable To Send Withdrawal Request");
				}

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