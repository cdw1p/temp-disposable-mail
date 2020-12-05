<?php
@session_name('xTempMail');
@session_start();

if ((isset($_COOKIE['email']) && $_COOKIE['email'] != '')) {
	$_SESSION['email'] = base64_decode($_COOKIE['email']);
}else{
	include 'inc/create.php';
}

$ThisEmail = $_SESSION['email'];

$allowed_lang = array('en','fr');
if ((isset($_COOKIE['language']) && $_COOKIE['language'] != '')) {
	if (in_array($_COOKIE['language'], $allowed_lang)) {
		$xlang = $_COOKIE['language'];
	}else{ $xlang = "en"; }
}else{ $xlang = "en"; }


$lang = array(
	'fr' => array(
		'Oubliez les courriers indésirables, les envois publicitaires, les piratages et les robots d\'attaque. Gardez votre véritable boîte aux lettres propre et sécurisée. Temp Mail fournit une adresse électronique temporaire, sécurisée, anonyme, gratuite et jetable.',
		'Copie',
		'Rafraîchir',
		'Changement',
		'Effacer'
	),
	'en' => $lang = array(
		'Forget about spam, advertising mailings, hacking and attacking robots. Keep your real mailbox clean and secure. Temp Mail provides temporary, secure, anonymous, free, disposable email address.',
		'Copy',
		'Refresh',
		'Change',
		'Delete'
	)
);


if ($xlang == "en") {
	$lang_btn_flag = 'flag_gb';
	$lang_btn_text = 'English';
}elseif($xlang == "fr"){
	$lang_btn_flag = 'flag_fr';
	$lang_btn_text = 'French';
}


?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
		<title>xTempMail</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/style.css"> 
		<link rel="icon" href="favicon.png" type="image/png"/>
		<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	</head>
	<body>
		<div class="block" id="header">
			<div class="content">
				<div id="logo"></div>
				<div id="email">
					<input type="text" id="email_id" value="<?=$ThisEmail?>" data-value="<?=$ThisEmail?>">
				</div>
				<div id="desc"><?=$lang[$xlang][0]?></div>
				<div id="lang">
					<button id="lang_btn" class="<?=$lang_btn_flag?>"><?=$lang_btn_text?></button>
					<div id="lang_list">
						<div class="lang_item flag_gb" data-lang="en">English</div>
						<div class="lang_item flag_fr" data-lang="fr">French</div>
					</div>
				</div>
			</div>
			<div id="loader">
				<div id="progress"></div>
			</div>
		</div>
		<div class="block">
			<div class="content" id="xbody">
				<div id="sidebar">
					<div class="item" id="item_to_copy" data-target="copy" data-clipboard-text="<?=$ThisEmail?>"><?=$lang[$xlang][1]?></div>
					<div class="item" data-target="refresh"><?=$lang[$xlang][2]?></div>
					<div class="item" data-target="change"><?=$lang[$xlang][3]?></div>
					<div class="item" data-target="delete"><?=$lang[$xlang][4]?></div>
				</div>
				<div id="ajax"></div>
			</div>
		</div>

		<div class="block">
			<div class="content" id="footer">
				U2NyaXB0IGRvd25sb2FkZWQgZnJvbSBDT0RFTElTVC5DQw== | <span id="terms">Privacy & Terms</span> | <span id="faq">FAQ</span> | <span id="contact">Contacts</span>
			</div>
		</div>

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/clipboard.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</body>
</html>