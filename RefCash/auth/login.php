<?php
	
	require("../config/config.php");
	require("../config/templates.php");

	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

	$errors = array();

	if(empty($email) && !(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {
		$errors = "Email Missing Or Incorrect";
	}
	if(empty($password)) {
		$errors = "Password Missing";
	}

	if(empty($errors)) {

		$login_sql = "SELECT * FROM ";
		$login_sql .= $site_name.".`users` WHERE `email`=?";

		$login_q = mysqli_stmt_init($dbcon);
		mysqli_stmt_prepare($login_q, $login_sql);
		mysqli_stmt_bind_param($login_q, 's', $email);

		if(mysqli_stmt_execute($login_q)) {

			$result = mysqli_stmt_get_result($login_q);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if(empty($row['email'])) {

				$email_missing_error = "An account with this email does not exist";
				header("Location: account.php?l=yes&emailMissingError=".$email_missing_error);

			} else {

				if(password_verify($password, $row['password'])) {

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

					header("Location: dashboard.php");
					exit();

				} else {

					$password_incorrect_error = "Incorrect Password";
					header("Location: account.php?l=yes&passwordIncorrectError=".$password_incorrect_error);
					exit();

				}

			}

		} else {

			$login_error = "Unable To Log You In";
			header("Location: account.php?l=yes&loginError=".$login_error);
			exit();
		}

	} else {

		$q_error = "Please Check the form for errors";
		header("Location: account.php?l=yes&qError=".$q_error);
		exit();

	}

?>