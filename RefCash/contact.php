<?php
	session_start();

	require("config/config.php");
	require("config/templates.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php if(!empty($site_description)) {echo $site_description; } else { echo $site_motto; } ?>">
	<meta name="keywords" content="<?php echo $site_keywords; ?>">
	<link rel="stylesheet" href="<?php echo $stylesheets['index']; ?>">
	<link rel="icon" href="<?php echo $site_logo; ?>">
	<title>Contact <?php echo $site_name_b; ?></title>
	<style>
		#main>#intro>#img-1 {
			background-image: url('<?php echo $site_image; ?>');
			background-size: contain;
			background-repeat: no-repeat;
		}
		#main>#howto>#img-2 {
			background-image: url('media/images/page-img-4.jpg');
			background-size: cover;
			background-repeat: no-repeat;
		}
		#contact-form {
			text-align: center;
		}
		#contact-form>#heading {
			margin: 0 0 20px 0;
			color: white;
		}
		#contact-form>input, #contact-form>textarea {
			margin: 5px 0;
			padding: 10px;
			font-size: 18px;
			border: none;
			border-radius: 5px;
		}
		#contact-form>textarea {
			width: 400px;
			height: 100px;
			font-family: Helvetica;
		}
		#contact-form>input[type="submit"] {
			padding: 20px;
			font-size: 24px;
			color: white;
			background-color: var(--m-sky-blue);
			transition: var(--m-default-transition);
			cursor: pointer
		}
		#contact-form>input[type="submit"]:hover {
			color: white;
			background-color: var(--m-dark-sky-blue);
			box-shadow: 0px 0px 8px var(--m-dark-blue);
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

		<div id="final-action">
			<div id="final-action-note">				
				Have you got a problem or you just want to say Hi to <?php echo $site_name_b; ?><br>Our 24/7/365 customer service would help whenever you want.
			</div>
		</div>

		<div id="howto">
			<div id="img-2">
			</div>
			<div id="howto-desc">				
				<form id="contact-form" name="contact-form" action="contact.php" method="POST">
					<h3 id="heading">Contact Us</h3>
					<input type="text" name="fullname" placeholder="Fullname" value="<?php if(isset($_POST['fullname'])) echo htmlentities($_POST['fullname'], ENT_QUOTES); ?>"><br>
					<input type="email" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES); ?>"><br>
					<input type="number" name="phone" placeholder="Phone Or Whatsapp Number" value="<?php if(isset($_POST['phone'])) echo htmlentities($_POST['phone'], ENT_QUOTES); ?>"><br>
					<textarea name="message" id="message" placeholder="Your Message Goes Here" value="<?php if(isset($_POST['message'])) echo htmlentities($_POST['message'], ENT_QUOTES); ?>"></textarea><br>
					<input type="submit" name="submitBTN" id="submitBTN" value="Send">
				</form>

				<?php

					if(isset($_GET['res'])) {
						echo "<script>alert('".$_GET['res']."');</script>";
					}

					if($_POST) {

						$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
						$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
						$phone_number = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
						$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

						if(empty($fullname) || empty($email) || empty($phone_number) || empty($message)) {
							header("Location: contact.php?res=Fill Up The Form");
						} else {

							$sql = "INSERT INTO ".$site_name_b.".`messages`(`id`, `fullname`, `email`, `phonenumber`, `message`) VALUES(NULL, ?, ?, ?, ?)";
							$q = mysqli_stmt_init($dbcon);
							mysqli_stmt_prepare($q, $sql);
							mysqli_stmt_bind_param($q, 'ssss', $fullname, $email, $phone_number, $message);
							if(mysqli_stmt_execute($q)) {

								header("Location: contact.php?res=Message Sent Successfully, Expect Reply By Phone Or Email");

							}

						}

					}

				?>

			</div>
		</div>

	</div>

	<?php

		if($_SESSION) {
			echo $page_footer_li;
		} else {
			echo $page_footer_lo;
		}

	?>

	<script type="text/javascript" src="<?php echo $scripts['index']; ?>"></script>
	<script>
		addFooterCopyRight();
	</script>
</body>
</html>