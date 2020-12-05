<?php
@session_name('xTempMail');
@session_start();

$domain = $_SERVER["HTTP_HOST"];
$ThisEmail = $_SESSION['email'];
$Login = explode("@", $ThisEmail);

$allowed_lang = array('en','fr');
if ((isset($_COOKIE['language']) && $_COOKIE['language'] != '')) {
	if (in_array($_COOKIE['language'], $allowed_lang)) {
		$xlang = $_COOKIE['language'];
	}else{ $xlang = "en"; }
}else{ $xlang = "en"; }

$lang = array(
	'fr' => array(
		'Modifier l\'adresse courriel - Temp Mail',
		'Temp Mail',
		'Permet de modifier votre adresse courriel temporaire sur cette page.',
		'Pour changer l\'adresse e-mail, entrez l\'adresse e-mail souhaitée, puis cliquez sur Enregistrer.',
		'Enregistrer'
	),
	'en' => $lang = array(
		'Change e-mail address - Temp Mail',
		'Temp Mail',
		'provides the ability to change your temporary email address on this page.',
		'To change the email address, please enter the desired E-mail address and then click on Save.',
		'Save'
	)
);
?>
<div id="change">
	<div id="change_title"><?=$lang[$xlang][0]?></div>
	<div id="change_content"><b><?=$lang[$xlang][1]?></b> <?=$lang[$xlang][2]?><br>
	<?=$lang[$xlang][3]?>
	</div>


	<table>
		<tr>
			<td>Login</td>
			<td><input type="text" id="login_change" value="<?=$Login[0]?>"></td>
		</tr>
		<tr>
			<td>Domain</td>
			<td><select id="domain_change">
				<option value="<?=$domain?>"><?=$domain?></option>
				<option value="dashoffer.com">dashoffer.com</option>
			</select></td>
		</tr>
		<tr>
			<td></td>
			<td><button id="save_change"><?=$lang[$xlang][4]?></button></td>
		</tr>
	</table>
</div>