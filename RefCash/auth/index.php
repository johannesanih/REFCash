<?php
	session_start();
	if(isset($_SESSION)) {
		if($_SESSION['user_level'] == 1) {
			header("Location: ../mng/");
			exit();
		} else {
			header("Location: dashboard.php");
		}
	} else {
		header("Location: account.php");
	}

?>