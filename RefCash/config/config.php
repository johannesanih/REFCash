<?php
	require("templates.php");

	$db_host = "localhost";
	$db_user = "id19585098_ainatec";
	$db_pass = "&T8sJ1C*}E@BTbu4";
	$db_name = $site_name;

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$dbcon = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if($dbcon->connect_error) die($dbcon->connect_error);

	function createTable($tablename, $query) {
		global $dbcon;
		$sql = "CREATE TABLE IF NOT EXISTS $tablename".$query;
		if($dbcon->query($sql)) {
			return true;
		} else {
			die("Unable to create table ".$tablename);
		}
	}

	createTable(

		"users",
		"(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`fullname` VARCHAR(100) DEFAULT NULL,
		`email` VARCHAR(100) DEFAULT NULL,
		`phonenumber` VARCHAR(100) DEFAULT NULL,
		`password` VARCHAR(100) NOT NULL,
		`acct_no` VARCHAR(60) DEFAULT NULL,
		`acct_name` VARCHAR(60) DEFAULT NULL,
		`bank_name` VARCHAR(60) DEFAULT NULL,
		`wallet_balance` INT UNSIGNED DEFAULT 0,
		`ref` VARCHAR(20) DEFAULT NULL,
		`referrer_id` VARCHAR(20) DEFAULT NULL,
		`no_of_downlines` INT UNSIGNED DEFAULT 0,
		`user_level` INT UNSIGNED DEFAULT 0,
		`activated` ENUM('yes', 'no') DEFAULT 'no',
		`reg_date` DATETIME DEFAULT CURRENT_TIMESTAMP)"

	);

	createTable(

		"payments",
		"(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`payed_by` VARCHAR(100) DEFAULT NULL,
		`email` VARCHAR(100) DEFAULT NULL,
		`amount` VARCHAR(100) DEFAULT NULL,
		`benefactor` VARCHAR(100) DEFAULT NULL,
		`referrence` VARCHAR(100) DEFAULT NULL,
		`payed_on` DATETIME DEFAULT CURRENT_TIMESTAMP)"

	);

	createTable(

		"withdrawal_request",
		"(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`amount` VARCHAR(100) DEFAULT NULL,
		`made_by` VARCHAR(100) DEFAULT NULL,
		`made_on` DATETIME DEFAULT CURRENT_TIMESTAMP)"

	);

	createTable(

		"messages",
		"(`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`fullname` VARCHAR(100) DEFAULT NULL,
		`email` VARCHAR(100) DEFAULT NULL,
		`phonenumber` VARCHAR(100) DEFAULT NULL,
		`message` LONGTEXT DEFAULT NULL,
		`sent_on` DATETIME DEFAULT CURRENT_TIMESTAMP)"

	);

	DEFINE("PAYSTACK_PUBLIC_KEY", "pk_live_ba2b69ab5a1c73349e15ad5b9f1f25e81d095ebf");
	DEFINE("PAYSTACK_TEST_KEY", "pk_test_ca3432a388a91213f861b99cfeefc4f417b0909c");
	DEFINE("ROOT_PATH", "https://refcash.000webhostapp.com/");

?>