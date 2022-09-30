<?php
	session_start();
	if(isset($_SESSION)) {
		if(!empty($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
			header("Location: ../mng/");
		}
	} else {
		header("Location: account.php");
	}

	$user_id = $_SESSION['user_id'];
	$user_fullname = $_SESSION['user_fullname'];
	$user_email = $_SESSION['user_email'];
	$user_ref_id = $_SESSION['user_ref_id'];
	$user_referrer = $_SESSION['user_referrer'];

	require("../config/config.php");
	require("../config/templates.php");
	require("template/template.php");

	$update_sql = "UPDATE ".$site_name.".`users` SET `activated`='yes' WHERE `id`=?";
	
	$update_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($update_q, $update_sql);
	mysqli_stmt_bind_param($update_q, 'i', $user_id);
	mysqli_stmt_execute($update_q);

	if(isset($_GET)) {

		if (isset($_GET['fn'])) $fullname = filter_var($_GET['fn'], FILTER_SANITIZE_STRING);
		if(isset($_GET['email'])) $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
		if(isset($_GET['amount'])) $amount = filter_var($_GET['amount'], FILTER_SANITIZE_STRING);
		if(isset($_GET['benefactor'])) $benefactor = filter_var($_GET['benefactor'], FILTER_SANITIZE_STRING);
		if(isset($_GET['reff'])) $referrence = filter_var($_GET['reff'], FILTER_SANITIZE_STRING);

		if($benefactor !== $site_name_b) {

			$get_ben_sql = "SELECT `fullname`, `wallet_balance` FROM ".$site_name.".`users` WHERE `id`=?";
			$get_ben_q = mysqli_stmt_init($dbcon);
			mysqli_stmt_prepare($get_ben_q, $get_ben_sql);
			mysqli_stmt_bind_param($get_ben_q, 'i', $benefactor);

			if(mysqli_stmt_execute($get_ben_q)) {
				$result = mysqli_stmt_get_result($get_ben_q);
				$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$benefactor_fullname = $item['fullname'];
				$benefactor_wallet_balance = $item['wallet_balance'];

				mysqli_free_result($result);
			}

			$benefactor_new_wallet_balance = $benefactor_wallet_balance + 2000;

			$update_ben_sql = "UPDATE ".$site_name.".`users` SET `wallet_balance`=? WHERE `id`=?";
			$update_ben_q = mysqli_stmt_init($dbcon);
			mysqli_stmt_prepare($update_ben_q, $update_ben_sql);
			mysqli_stmt_bind_param($update_ben_q, 'ii', $benefactor_new_wallet_balance, $benefactor);
			mysqli_stmt_execute($update_ben_q);

		}

		$payment_update_sql = "INSERT INTO ".$site_name.".`payments` (`id`, `payed_by`, `email`, `amount`, `benefactor`, `referrence`) VALUES(NULL, ?, ?, ?, ?, ?)";
		$payment_update_q = mysqli_stmt_init($dbcon);
		mysqli_stmt_prepare($payment_update_q, $payment_update_sql);
		mysqli_stmt_bind_param($payment_update_q, 'sssss', $fullname, $email, $amount, $benefactor_fullname, $referrence);
		mysqli_stmt_execute($payment_update_q);

	}

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
	<style type="text/css">
		#main {
			text-align: center;
		}
	</style>
	<title> Payment Success <?php echo $site_name_b; ?></title>
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

		<img src="../media/images/page-img-3.jpg" alt="[IMAGE]" width="200" height="200"><br>

		<button class="print-btn" onclick="printSlip()">Print Payment Slip</button>
		<a href="dashboard.php" class="print-btn">Back To Dashboard</a>

		<div id="thank-you-div">
			<h2 id="heading">Thank You <?php echo $user_fullname; ?>!</h2>
			<h3 id="p-s">Payment Success, Your Account Is Now Activated</h3>
			<h3 class="w-1">Payment Referrence: <?php echo $referrence; ?></h3>
			<h3 class="w-1">Amount: <?php echo $amount; ?> Naira</h3>
			<h3 class="w-1">Email: <?php echo $user_email; ?></h3>
			<h3 class="w-1">Payed To: <?php echo $site_name_b; ?></h3>
			<h5 class="w-1">Contact us <?php echo $site_contact_email; ?></h5>
		</div>

		<script type="text/javascript">
			function printSlip() {
				var slipContent = document.getElementById("thank-you-div").innerHTML;
				var a = window.open('', '', 'height=500, width=500');
				a.document.write("<html><body>");
				a.document.write(slipContent);
				a.document.write("</body></html>");
				a.document.close();
				a.print();
			}
		</script>

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