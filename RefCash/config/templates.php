<?php
	
	$web_address = "localhost/CashTop";

	$site_name_b = "REFCash";
	$site_name = "id19585098_refcash";
	$site_motto = "Earn by just referring";
	$site_description = "Having a better life is easy if you know how, If you don't it may cost you much that's why ".$site_name_b." wants to make it easy for you, with our comprehensive marketing system, you can give you and your family a better life";
	$operation_summary = "Our network marketing model is simple to understand and to execute, it was specially designed to give you zero stress and fetch you a lot of money within a short time and with little effort";
	$site_contact_email = "ibukunanih@gmail.com";
	$site_keywords = "";
	$site_logo_name = "Cashtop Logo.png";
	$site_image_name = "page-img-1.png";

	$staff_rules = "
		<ul>
			<li>Do not reveal your admin account password to anyone except your administrator.</li>
			<li>Do not reveal to anyone how to access the admin office.</li>
			<li>Do not reveal to anyone the link to the admin office.</li>
			<li>Do not reveal to anyone any data or information stored in ".$site_name_b." records and databases, If this rule is disobeyed, offender is laible to go to jail for violating privacy of affected victim.</li>
			<li>Do not reveal any information or record to any security organization, whether Police, Army and the likes without permission from your administrator who must verify a warrant signed by a judge from the security operative.</li>
			<li>Do not reveal any information or record to any organization or institution of any sort, offender is liable to go to jail, for committing or aiding an espionage.</li>
			<li>Do not tamper with any data or information on the records, offender is laible to go to jail.</li>
		</ul>
	";

	$media_images_directory = 'media/images/';

	$site_logo = $media_images_directory.$site_logo_name;
	$site_image = $media_images_directory.$site_image_name;


	$facebook_link = "https://www.facebook.com/";
	$instagram_link = "https://www.instagram.com/";
	$twitter_link = "https://www.twitter.com/";


	$stylesheets = array();
	$stylesheets['index'] = 'css/index.css';
	$stylesheets['accounts'] = 'css/accounts.css';
	$stylesheets['dashboard'] = 'css/dashboard.css';
	$stylesheets['mng'] = 'css/mng_style.css';

	$scripts = array();
	$scripts['index'] = 'js/index.js';
	$scripts['account'] = 'js/account.js';

	$page_header_lo = "<header id='top-header'>
		<div id='brand'>
			<img id='logo' src='".$media_images_directory."CashTop White Logo.png' alt='CashTop Logo'>
			<span id='branding'>
				<h1>".$site_name_b."</h1>
				<span id='motto'>".$site_motto."</span>
			</span>
		</div>
			<span id='menu'>
				<span><a href='index.php'>Home</a></span>
				<span><a href='auth/account.php'>Sign In</a></span>
				<span><a href='contact.php'>Contact</a></span>
			</span>
		</header>";

	$page_header_li = "<header id='top-header'>
		<div id='brand'>
			<img id='logo' src='".$media_images_directory."CashTop White Logo.png' alt='CashTop Logo'>
			<span id='branding'>
				<h1>".$site_name_b."</h1>
				<span id='motto'>".$site_motto."</span>
			</span>
		</div>
			<span id='menu'>
				<span><a href='index.php'>Home</a></span>
				<span><a href='auth/dashboard.php'>Dashboard</a></span>
				<span><a href='auth/logout.php'>Log Out</a></span>
				<span><a href='auth/contact.php'>Contact</a></span>
			</span>
		</header>";

	$page_footer_lo = "<footer id='page-footer'>

		<div id='ft-brand'>
			<span id='name'>".$site_name_b."</span>
			<span id='social-media-icons'>
				<a href='".$facebook_link."'>Facebook</a>
				<a href='".$instagram_link."'>Instagram</a>
				<a href='".$twitter_link."'>Twitter</a>
			</span>
		</div>

		<div id='ft-menu'>
			<nav>
				<a href='index.php'>Home</a>
				<a href='marketing strategy.php'>Strategy</a>
				<a href='contact.php'>Contact Us</a>
				<a href='marketing strategy.php#final-action-note'>About Us</a>
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
			<span id='name'>".$site_name_b."</span>
			<span id='social-media-icons'>
				<a href=".$facebook_link.">Facebook</a>
				<a href=".$instagram_link.">Instagram</a>
				<a href=".$twitter_link.">Twitter</a>
			</span>
		</div>

		<div id='ft-menu'>
			<nav>
				<a href='index.php'>Home</a>
				<a href='marketing strategy.php'>Strategy</a>
				<a href='contact.php'>Contact Us</a>
				<a href='marketing strategy.php#final-action-note'>About Us</a>
				<a href='auth/dashboard.php'>Dashboard</a>
				<a href='auth/logout.php'>Log Out</a>
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