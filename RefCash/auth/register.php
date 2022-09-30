<?php
	
	require("../config/config.php");
	require("../config/templates.php");

	$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$phonenumber = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$referrer = filter_var($_POST['referral_id'], FILTER_SANITIZE_STRING);

	$alphabets = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

	$ref_id = '';

	for($i = 0; $i < rand(5, 8); $i++) {

		$alphaIndex = rand(0, 52);
		$numIndex = rand(0, 9);

		$ref_id .= $alphabets[$alphaIndex].$numbers[$numIndex];

	}

	$errors = array();

	if(empty($fullname)) {
		$errors = "Full Name Missing";
	}
	if(empty($email) && !(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
		$errors = "Email Missing Or Incorrect";
	}
	if(empty($phonenumber)) {
		$errors = "Phone number is missing";
	}
	if(empty($password)) {
		$errors = "Password Missing";
	}
	if(empty($referrer)) {
		$referrer = $site_name;
	}

	if(empty($errors)) {

		$check_email_query = "SELECT * FROM ";
		$check_email_query .= $site_name.".`users` WHERE `email`=?";
		$check_email_q = mysqli_stmt_init($dbcon);
		mysqli_stmt_prepare($check_email_q, $check_email_query);
		mysqli_stmt_bind_param($check_email_q, 's', $email);
		mysqli_stmt_execute($check_email_q);

		$result = mysqli_stmt_get_result($check_email_q);
		if(mysqli_num_rows($result) == 1) {

			$email_error = "This Email has already been taken";
			header("Location: account.php?r=yes&emailErrorR=".$email_error);
			exit();

		} else {

			$check_ref_sql = "SELECT * FROM ".$site_name.".`users` WHERE `ref`=?";
			$check_ref_q = mysqli_stmt_init($dbcon);
			mysqli_stmt_prepare($check_ref_q, $check_ref_sql);
			mysqli_stmt_bind_param($check_ref_q, 's', $referrer);
			mysqli_stmt_execute($check_ref_q);
			$result = mysqli_stmt_get_result($check_ref_q);
			$items = mysqli_fetch_array($result, MYSQLI_ASSOC);

			if($items['ref'] !== $referrer) {
				$referrer == $site_name;
			}

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$sql = "INSERT INTO ";
			$sql .= $site_name.".`users` (`id`, `fullname`, `email`, `phonenumber`, `password`, `ref`, `referrer_id`) ";
			$sql .= "VALUES (NULL, ?, ?, ?, ?, ?, ?)";

			$q = mysqli_stmt_init($dbcon);
			mysqli_stmt_prepare($q, $sql);
			mysqli_stmt_bind_param($q, 'ssssss', $fullname, $email, $phonenumber, $hashed_password, $ref_id, $referrer);
			mysqli_stmt_execute($q);

			if(mysqli_affected_rows($dbcon) == 1) {

				$login_sql = "SELECT * FROM ";
				$login_sql .= $site_name.".`users` WHERE `email`=?";

				$login_q = mysqli_stmt_init($dbcon);
				mysqli_stmt_prepare($login_q, $login_sql);
				mysqli_stmt_bind_param($login_q, 's', $email);

				if(mysqli_stmt_execute($login_q)) {
					$result = mysqli_stmt_get_result($login_q);
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

					session_start();
					$_SESSION['user_id'] = (int) $row['id'];
					$_SESSION['user_fullname'] = $row['fullname'];
					$_SESSION['user_email'] = $row['email'];
					$_SESSION['user_wallet_balance'] = (int) $row['wallet_balance'];
					$_SESSION['user_ref_id'] = $row['ref'];
					$_SESSION['user_referrer'] = $row['referrer_id'];
					$_SESSION['user_no_of_downlines'] = (int) $row['no_of_downlines'];
					$_SESSION['user_level'] = (int) $row['user_level'];
					$_SESSION['user_activated'] = $row['activated'];
					$_SESSION['user_registration_date'] = $row['reg_date'];

					if($referrer !== $site_name) {

						$get_downline_sql = "SELECT `no_of_downlines` FROM ".$site_name.".`users` WHERE `ref`=?";
						$get_downline_q = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($get_downline_q, $get_downline_sql);
						mysqli_stmt_bind_param($get_downline_q, 's', $referrer);

						if(mysqli_stmt_execute($get_downline_q)) {
							$result = mysqli_stmt_get_result($get_downline_q);
							$item = mysqli_fetch_array($result, MYSQLI_ASSOC);

							$ref_no_of_downlines = $item['no_of_downlines'];

							mysqli_free_result($result);
						}

						$ref_new_no_of_downlines = $ref_no_of_downlines + 1;

						$upd_downline_sql = "UPDATE ".$site_name.".`users` SET `no_of_downlines`=? WHERE `ref`=?";
						$upd_downline_q = mysqli_stmt_init($dbcon);
						mysqli_stmt_prepare($upd_downline_q, $upd_downline_sql);
						mysqli_stmt_bind_param($upd_downline_q, 'is', $ref_new_no_of_downlines, $referrer);
						mysqli_stmt_execute($upd_downline_q);

					}

					header("Location: dashboard.php");
					exit();

				} else {

					$login_error = "Unable To Log You In";
					header("Location: account.php?r=yes&loginError=".$login_error);
					exit();
				}


			} else {

				$reg_error = "System Error, Try Again";
				header("Location: account.php?r=yes&regError=".$reg_error);
				exit();

			}

		}

	} else {

		$q_error = "Please Check the form for errors";
		header("Location: account.php?r=yes&qError=".$q_error);
		exit();

	}

?>