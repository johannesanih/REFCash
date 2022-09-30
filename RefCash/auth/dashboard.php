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

	$und_sql = "SELECT `no_of_downlines` FROM ".$site_name.".`users` WHERE `id`=?";

	$und_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($und_q, $und_sql);
	mysqli_stmt_bind_param($und_q, 'i', $user_id);

	if(mysqli_stmt_execute($und_q)) {
		$result = mysqli_stmt_get_result($und_q);
		$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$user_no_of_downlines = $item['no_of_downlines'];

		mysqli_free_result($result);
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

	$ben_sql = "SELECT `referrer_id` FROM ".$site_name.".`users` WHERE `id`=?";

	$ben_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($ben_q, $ben_sql);
	mysqli_stmt_bind_param($ben_q, 'i', $user_id);

	if(mysqli_stmt_execute($ben_q)) {
		$result = mysqli_stmt_get_result($ben_q);
		$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$benefactor = $item['referrer_id'];

		mysqli_free_result($result);

		if($benefactor !== $site_name_b) {

			$ben_id_sql = "SELECT `id` FROM ".$site_name.".`users` WHERE `ref`=?";

			$ben_id_q = mysqli_stmt_init($dbcon);
			mysqli_stmt_prepare($ben_id_q, $ben_id_sql);
			mysqli_stmt_bind_param($ben_id_q, 's', $benefactor);

			if(mysqli_stmt_execute($ben_id_q)) {

				$result = mysqli_stmt_get_result($ben_id_q);
				$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

				$benefactor = $item['id'];

			}

		}

	}

	$user_level = $_SESSION['user_level'];

	$actv_sql = "SELECT `activated` FROM ".$site_name.".`users` WHERE `id`=?";
	$actv_q = mysqli_stmt_init($dbcon);
	mysqli_stmt_prepare($actv_q, $actv_sql);
	mysqli_stmt_bind_param($actv_q, 's', $user_id);

	if(mysqli_stmt_execute($actv_q)) {
		$result = mysqli_stmt_get_result($actv_q);
		$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

		$user_activated = $item['activated'];
	}

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
	<title> Dashboard <?php echo $site_name_b; ?></title>
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
	?>

	<?php

		if(isset($_GET['res'])) {
			echo "<script>alert('".$_GET['res']."');</script>";
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
							<h2 id='h3-1'>Pay 3000 NGN To Join Network, Click the button below</h2>
							<form>
							  <script src='https://js.paystack.co/v1/inline.js'></script>
							  <button type='button' class='pay-btn' onclick='payWithPaystack()'> Pay With Card </button> 
							</form>
							<script>
							  function payWithPaystack(){
							    var handler = PaystackPop.setup({
							      key: '".PAYSTACK_TEST_KEY."',
							      email: '".$user_email."',
							      amount: 300000,
							      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
							      metadata: {
							         custom_fields: [
							            {
							                display_name: 'Mobile Number',
							                variable_name: 'mobile_number',
							                value: '+2348012345678'
							            }
							         ]
							      },
							      callback: function(response){
							          alert('success. transaction ref is ' + response.reference);
							          var reference = response.reference;
							          window.location.href = '".ROOT_PATH."auth/payment success.php?fn=".$user_fullname."&email=".$user_email."&amount=3000&benefactor=".$benefactor."&reff='+reference;
							      },
							      onClose: function(){
							          alert('window closed');
							      }
							    });
							    handler.openIframe();
							  }
							</script>
						</div>
					</div>
				";

				echo $mrkp;

			} else if($user_activated == 'yes') {

				$downlineTabledata = "";

				$team_sql = "SELECT * FROM ".$site_name.".`users` WHERE `referrer_id`=? LIMIT 0, 10";
				$team_q = mysqli_stmt_init($dbcon);
				mysqli_stmt_prepare($team_q, $team_sql);
				mysqli_stmt_bind_param($team_q, 's', $user_ref_id);

				if(mysqli_stmt_execute($team_q)) {
					$result = mysqli_stmt_get_result($team_q);
					$downlineTabledata .= "<tr>";

					$downlineTabledata .= "<th>Name</th>";
					$downlineTabledata .= "<th>Downlines</th>";
					$downlineTabledata .= "<th>Earnings</th>";

					$downlineTabledata .= "</tr>";
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						$downlineTabledata .= "<tr>";

						$downlineTabledata .= "<td>";
						$downlineTabledata .= $row['fullname'];
						$downlineTabledata .= "</td>";

						$downlineTabledata .= "<td>";
						$downlineTabledata .= $row['no_of_downlines'];
						$downlineTabledata .= "</td>";

						$downlineTabledata .= "<td>";
						$downlineTabledata .= $row['wallet_balance'];
						$downlineTabledata .= "</td>";

						$downlineTabledata .= "</tr>";
					}
					mysqli_free_result($result);
				} else {
					$downlineTabledata .= "<td>Unable to fetch your downlines</td>";
				}

				echo "<style>";
				echo "#main {display: block;}";
				echo "</style>";
				$mrkp = "
					<div class='main-in' id='main-in-1'>
						<h1 id='h1-1'>Welcome ".$user_fullname." you have ".$user_no_of_downlines." team members</h1>
						<div id='tools'>
							<h2 id='h3-1'>Wallet Balance</h2>
							<div id='info'>
								<span id='balance'>".$user_wallet_balance." NGN</span>
							</div>
							<div id='set-account-details'>
								<a href='bank details.php' class='btn'>Set Bank Account Details</a>
								<a href='withdraw.php' class='btn'>Request Withdrawal &#187;</a>
							</div>
						</div>
					</div>
					<div class='main-in' id='main-in-2'>
						<div id='tools'>
							<h2 id='h3-1'>Your Referral Link</h2>
							<div id='info'>
								<span id='ref_link'>".$web_address."/auth/account.php?r=yes&ref=".$user_ref_id."</span>
							</div>
						</div>
					</div>
					<div class='main-in' id='main-in-3'>
						<div id='tools'>
							<h2 id='h3-1'>Your Team</h2>
							<div id='info'>
								<table style='width: 100%; height: auto;'>
									<tbody>".$downlineTabledata."</tbody>
								</table>
							</div>
						</div>
					</div>
				";

				echo $mrkp;

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