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

	if(isset($_GET['id'])) {

		$user_id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

		$get_user_sql = "SELECT * FROM ".$site_name.".`users` WHERE `id`=?";
		$get_user_q = mysqli_stmt_init($dbcon);
		mysqli_stmt_prepare($get_user_q, $get_user_sql);
		mysqli_stmt_bind_param($get_user_q, 'i', $user_id);

		if(mysqli_stmt_execute($get_user_q)) {

			$result = mysqli_stmt_get_result($get_user_q);
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

				$page_string = "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset='utf-8'>
					<title>".$row['fullname']." | ".$row['email']." | REFCash User Info</title>
					<style>
						body {
							font-family: sans-serif;
						}
						table {
							margin: 20px;
							border-spacing: 5px;
						}
						tr, td {
							padding: 10px;
						}
						tr {
							border: 1px solid black;
						}
						#printer {
							padding: 10px;
							text-align: center;
						}
						#printer>button {
							padding: 10px;
							font-size: 18px;
							width: 100%;
							background-color: blue;
							color: white;
							border: none;
							transition: ease-in-out 0.3s;
						}
						#printer>button:hover,
						#printer>button:active {
							background-color: #3395f7;
							color: black;
							box-shadow: 0px 0px 8px #333;
						}
					</style>
				</head>
				<body>
					<table name='dataTable'>
						
			";

			echo $page_string;

				$data_string = "
					<caption><strong>CashTop Data Of ".$row['fullname']."</strong></caption>
					<tr>
						<th>Id: </th>
						<td>".$row['id']."</td>
					</tr>
					<tr>
						<th>Full Name: </th>
						<td>".$row['fullname']."</td>
					</tr>
					<tr>
						<th>Email: </th>
						<td>".$row['email']."</td>
					</tr>
					<tr>
						<th>Phone Number: </th>
						<td>".$row['phonenumber']."</td>
					</tr>
					<tr>
						<th>Bank Account Number: </th>
						<td>".$row['acct_no']."</td>
					</tr>
					<tr>
						<th>Bank Account Name: </th>
						<td>".$row['acct_name']."</td>
					</tr>
					<tr>
						<th>Bank: </th>
						<td>".$row['bank_name']."</td>
					</tr>
					<tr>
						<th>CashTop Wallet Balance: </th>
						<td>".$row['wallet_balance']."</td>
					</tr>
					<tr>
						<th>Number of Downlines: </th>
						<td>".$row['no_of_downlines']."</td>
					</tr>
					<tr>
						<th>Activated: </th>
						<td>".$row['activated']."</td>
					</tr>
					<tr>
						<th>Referral Code: </th>
						<td>".$row['ref']."</td>
					</tr>
					<tr>
						<th>Brought In Through: </th>
						<td>".$row['referrer_id']."</td>
					</tr>";

					echo $data_string;

			}

			$bottom_string = "
					</table>
					<div id='printer'>
						<button onclick='window.print();'>Print</button>
					</div>
				</body>
				</html>
			";

			echo $bottom_string;

			mysqli_free_result($result);

		}

	}

?>