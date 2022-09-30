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
	<title>Admin Office | Messages | <?php echo $site_name_b; ?></title>
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

				$ms_count_sql = "SELECT COUNT(*) FROM ".$site_name.".`messages`";
				$result = $dbcon->query($ms_count_sql);
				$item = mysqli_fetch_array($result, MYSQLI_NUM);
				$number_of_ms = $item[0];
				echo $number_of_ms." Messages";
				mysqli_free_result($result);

			?>
		</div>

		<div id="users-div">
			<h2 id="heading">
				Messages
			</h2>
			<table id="users-table">
				<tr>
					<th>Id</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Message</th>
					<th>Date Sent</th>
				</tr>
				<?php

					$ms_no_of_pages = ceil($number_of_ms/10);
					if(isset($_GET['o'])) $off_set = filter_var($_GET['o']); else $off_set = 0;
					if(isset($_GET['rc'])) $row_count = filter_var($_GET['rc']); else $row_count = 10;

					$ms_sql = "SELECT `id`, `fullname`, `email`, `phonenumber`, `message`, `sent_on` FROM ".$site_name_b.".`messages` ORDER BY `sent_on` DESC LIMIT ".$off_set.", ".$row_count;

					$result = $dbcon->query($ms_sql);

					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

						echo "<tr>";
						echo "<td>".$row['id']."</td>";
						echo "<td>".$row['fullname']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "<td>".$row['phonenumber']."</td>";
						echo "<td>".$row['message']."</td>";
						echo "<td>".$row['sent_on']."</td>";
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
				if($next_page < $ms_no_of_pages) {
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