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
	<link rel="stylesheet" href="../<?php echo $stylesheets['mng']; ?>">
	<link rel="icon" href="../<?php echo $site_logo; ?>">
	<title>Admin Office | Users | <?php echo $site_name_b; ?></title>
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

		<div class="no_of_users">
			<?php

				$user_count_sql = "SELECT COUNT(*) FROM ".$site_name.".`users` WHERE `user_level` = '0'";
				$result = $dbcon->query($user_count_sql);
				$item = mysqli_fetch_array($result, MYSQLI_NUM);
				$number_of_users = $item[0];
				echo $number_of_users." Users Registered";
				mysqli_free_result($result);

			?>
		</div>

		<div class="no_of_users">
			<?php

				$activated_user_count_sql = "SELECT COUNT(*) FROM ".$site_name.".`users` WHERE `activated` = 'yes'";
				$result = $dbcon->query($activated_user_count_sql);
				$item = mysqli_fetch_array($result, MYSQLI_NUM);
				$number_of_activated_users = $item[0];
				if($number_of_activated_users == 1) $hlpv = 'Is'; else $hlpv = 'Are';
				echo $number_of_activated_users." User Accounts ".$hlpv." Activated";
				mysqli_free_result($result);

			?>
		</div>

		<div class="no_of_users">
			<?php

				$Inactivated_user_count_sql = "SELECT COUNT(*) FROM ".$site_name.".`users` WHERE `activated` = 'no' AND `user_level` = '0'";
				$result = $dbcon->query($Inactivated_user_count_sql);
				$item = mysqli_fetch_array($result, MYSQLI_NUM);
				$number_of_Inactivated_users = $item[0];
				if($number_of_Inactivated_users == 1) $hlpvi = 'Is'; else $hlpvi = 'Are';
				echo $number_of_Inactivated_users." User Accounts ".$hlpvi." Not Activated";
				mysqli_free_result($result);

			?>
		</div>

		<div id="search-div">
			<h2 id="heading">
				Search Users
			</h2>
			<form method="POST" action="users.php" id="user_searcher" name="user_searcher">
				<input type="text" name="user_email" id="user_email" placeholder="User Email"><br>
				<input type="submit" name="searchBtn" id="searchBtn" value="Search">
			</form>
			<?php

				if($_POST) {

					$email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL);

					if(!(empty($email)) && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

						$user_search_sql = "SELECT `id` FROM ".$site_name.".`users` WHERE `email`=?";
						$users_search_q = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($users_search_q, $user_search_sql);
						mysqli_stmt_bind_param($users_search_q, 's', $email);

						if(mysqli_stmt_execute($users_search_q)) {
							$result = mysqli_stmt_get_result($users_search_q);
							$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
							$user_id_s = $item['id'];

							header("Location: show_user.php?id=".$user_id_s);
						} else {
							$echo_string = "<script>
								alert('Unable To Fetch User Data');
							</script>";
							echo $echo_string;
						}

					}

				}

			?>
		</div>

		<div id="users-div">
			<h2 id="heading">
				Recent Users
			</h2>
			<table id="users-table">
				<tr>
					<th>Id</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Wallet Balance</th>
					<th>Downline Number</th>
					<th>Activation Status</th>
					<th>Date Registered</th>
				</tr>
				<?php

					$user_no_of_pages = ceil($number_of_users/10);
					if(isset($_GET['o'])) $off_set = filter_var($_GET['o']); else $off_set = 0;
					if(isset($_GET['rc'])) $row_count = filter_var($_GET['rc']); else $row_count = 10;

					$users_sql = "SELECT `id`, `fullname`, `email`, `phonenumber`, `wallet_balance`, `no_of_downlines`, `activated`, `reg_date` FROM ".$site_name_b.".`users` WHERE `user_level` = '0' ORDER BY reg_date DESC LIMIT ".$off_set.", ".$row_count;

					$result = $dbcon->query($users_sql);

					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

						echo "<tr>";
						echo "<td>".$row['id']."</td>";
						echo "<td>".$row['fullname']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['phonenumber']."</td>";
						echo "<td>".$row['wallet_balance']."</td>";
						echo "<td>".$row['no_of_downlines']."</td>";
						echo "<td>".$row['activated']."</td>";
						echo "<td>".$row['reg_date']."</td>";
						echo "</tr>";

					}

				?>
			</table>

			<?php

				$off_set_p = ceil($off_set - 10);
				$off_set_n = $off_set + 10;
				$next_page = ceil($off_set_n/10);

				if($off_set > 0) {
					echo "<a class='pn-btn' href='messages.php?o=".$off_set_p."&rc=10'>&laquo; Prev</a>";
				}
				if($next_page < $user_no_of_pages) {
					echo "<a class='pn-btn' href='messages.php?o=".$off_set_n."&rc=10'>Next &raquo;</a>";
				}

			?>
			
		</div>

	</div>

	<?php

		if($_SESSION) {
			echo $page_footer_li;
		} else {
			echo $page_footer_lo;
		}

	?>

	<script type="text/javascript" src="../<?php echo $scripts['index']; ?>"></script>
	<script type="text/javascript" src="js/index.js"></script>
	<script>
		addFooterCopyRight();
	</script>
</body>
</html>