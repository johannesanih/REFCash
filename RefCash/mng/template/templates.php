<?php

	$page_header_lo = "<header id='top-header'>
		<div id='brand'>
			<img id='logo' src='../".$media_images_directory."CashTop White Logo.png' alt='CashTop Logo'>
			<span id='branding'>
				<h1>".$site_name_b." Admin</h1>
				<span id='motto'>".$site_motto."</span>
			</span>
		</div>
			<span id='menu'>
				<span><a href='index.php'>Home</a></span>
				<span><a href='../contact.php'>Contact</a></span>
			</span>
		</header>";

	$page_header_li = "<header id='top-header'>
		<div id='brand'>
			<img id='logo' src='../".$media_images_directory."CashTop White Logo.png' alt='CashTop Logo'>
			<span id='branding'>
				<h1>".$site_name_b." Admin</h1>
				<span id='motto'>".$site_motto."</span>
			</span>
		</div>
			<span id='menu'>
				<span><a href='index.php'>Home</a></span>
				<span><a href='users.php'>Users</a></span>
				<span><a href='withdrawal requests.php'>Withdrawal Requests</a></span>
				<span><a href='messages.php'>Messages</a></span>
				<span><a href='payments.php'>Payments</a></span>
				<span><a href='../auth/logout.php'>Log Out</a></span>
				<span><a href='../contact.php'>Contact</a></span>
			</span>
		</header>";

	$page_footer_lo = "<footer id='page-footer'>

		<div id='ft-brand'>
			<span id='name'>".$site_name_b." Admin</span>
			<span id='social-media-icons'>
				<a href='<?php echo $facebook_link; ?>'>Facebook</a>
				<a href='<?php echo $instagram_link; ?>'>Instagram</a>
				<a href='<?php echo $twitter_link; ?>'>Twitter</a>
			</span>
		</div>

		<div id='ft-menu'>
			<nav>
				<a href='index.php'>Home</a>
				<a href='../marketing strategy.php'>Strategy</a>
				<a href='../contact.php'>Contact Us</a>
				<a href='../about.php'>About Us</a>
			</nav>
		</div>

		<div id='ft-copyright'>
			<div>".$site_name_b."
				<span>
				</span>
			</div>
		</div>
		
	</footer>";

	$page_footer_li = "<footer id='page-footer'>

		<div id='ft-brand'>
			<span id='name'>".$site_name_b." Admin</span>
			<span id='social-media-icons'>
				<a href='<?php echo $facebook_link; ?>'>Facebook</a>
				<a href='<?php echo $instagram_link; ?>'>Instagram</a>
				<a href='<?php echo $twitter_link; ?>'>Twitter</a>
			</span>
		</div>

		<div id='ft-menu'>
			<nav>
				<a href='index.php'>Home</a>
				<a href='../marketing strategy.php'>Strategy</a>
				<a href='../contact.php'>Contact Us</a>
				<a href='../about.php'>About Us</a>
				<a href='../auth/logout.php'>Log Out</a>
			</nav>
		</div>

		<div id='ft-copyright'>
			<div>".$site_name_b."
				<span>
				</span>
			</div>
		</div>
		
	</footer>";

?>