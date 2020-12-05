<?php
$id = $_POST['id'];
$pdo = new PDO("sqlite:xtempmail.db");
$email = $pdo->query("SELECT * FROM `emails` WHERE `id`='$id'")->fetch(PDO::FETCH_ASSOC);

$email_body = base64_decode($email['message']);

$letter_html = "";
$op_getKey = preg_match_all("/boundary=\"(.*)\"/", $email_body, $getKey);
if ($op_getKey) {
	$mailParts = explode("--" . $getKey[1][0], $email_body);
	// $letter_text = str_replace('Content-Type: text/plain; charset="UTF-8"', '', $mailParts[1]);
	// echo $letter_text;





	$the_mail = $mailParts[2];


	$to_replace = array(
		'Content-Type: text/html; charset="UTF-8"',
		'Content-Type: text/html; charset=UTF-8',
		'Content-Type: text/html; charset="utf-8"',
		'Content-Type: text/html; charset=utf-8',
		'Content-Type: text/html; charset="iso-8859-1"',
		'Content-Type: text/html; charset=iso-8859-1',
		'Content-Type: text/html; charset="ISO-8859-1"',
		'Content-Type: text/html; charset=ISO-8859-1',
	);

	foreach ($to_replace as $k => $v) {
		$the_mail = str_replace($to_replace[$k], '', $the_mail);
	}
	
	// $the_mail = str_replace('Content-Type: text/html; charset="UTF-8"', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset=UTF-8', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset="utf-8"', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset=utf-8', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset="iso-8859-1"', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset=iso-8859-1', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset="ISO-8859-1"', '', $the_mail);
	// $the_mail = str_replace('Content-Type: text/html; charset=ISO-8859-1', '', $the_mail);


	if (preg_match_all("/Content-Transfer-Encoding: quoted-printable/", $the_mail, $mailToDecode)) {
		$message_to_decode = str_replace('Content-Transfer-Encoding: quoted-printable', '', $the_mail);
		$letter_html = quoted_printable_decode($message_to_decode);
	}elseif(preg_match_all("/Content-Transfer-Encoding: base64/", $the_mail, $mailToDecode)){
		$message_to_decode = str_replace('\r', '', $the_mail);
		$message_to_decode = str_replace('\n', '', $message_to_decode);
		$message_to_decode = str_replace('Content-Transfer-Encoding: base64', '', $message_to_decode);
		$letter_html = base64_decode($message_to_decode);
		// $letter_html = $message_to_decode;
	} else {
		$letter_html = $the_mail;
	}
	// echo $letter_html;
} else {


	$mailParts = explode("\n\n", $email_body);



	foreach ($mailParts as $k => $v) {
		if ($k > 0) {
			$letter_html .= $v . "\n\n";
		}
	}

	if(preg_match_all("/Content-Transfer-Encoding: base64/", $email_body, $mailToDecode)){
		$message_to_decode = str_replace('\r', '', $letter_html);
		$message_to_decode = str_replace('\n', '', $message_to_decode);
		$letter_html = base64_decode($message_to_decode);
		
		// $letter_html = $message_to_decode;
	}



	
}
?>
<div id="view_head">
	<div id="back_btn" class="btn">Back to list</div>
	<div id="source_btn" class="btn" data-target="<?=$id?>">Source</div>
	<div id="delete_btn" class="btn" data-target="<?=$id?>">Delete</div>
	<div id="download_btn" class="btn" data-target="<?=$id?>">Download</div>
</div>
<div id="view_info">
	<div id="subject_info"><?=htmlentities($email['subject'])?></div>
	<div id="from_info">From: <?=htmlentities($email['from'])?></div>
	<div id="date_info">Date: <?=htmlentities($email['date'])?></div>
</div>
<div id="view_body">
	<?=$letter_html?>
</div>
