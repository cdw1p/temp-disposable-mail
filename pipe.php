#!/usr/bin/php -q
<?php
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}
fclose($fd);


// $email = file_get_contents("pipe.txt");




$op_getReceiver = preg_match_all("/To: (.*)/", $email, $getReceiver);
$_Receiver = $getReceiver[1][0];

$op_getSender = preg_match_all("/From: (.*)\n/", $email, $getSender);
$_Sender = $getSender[1][0];

$op_getDate = preg_match_all("/Date: (.*)/", $email, $getDate);
$_Date = $getDate[1][0];

$op_getSubject = preg_match_all("/Subject: (.*)\n/", $email, $getSubject);
$_Subject = $getSubject[1][0];

// $email = htmlentities($email);


/*
$op_getKey = preg_match_all("/Content-Type: multipart\/alternative; boundary=\"(.*?)\"/", $email, $getKey);
if ($op_getKey) {
	$mailParts = explode("--" . $getKey[1][0], $email);
	$letter_text = str_replace('Content-Type: text/plain; charset="UTF-8"', '', $mailParts[1]);
	// echo $letter_text;
	if (preg_match_all("/Content-Transfer-Encoding: quoted-printable/", $mailParts[2], $mailToDecode)) {
		$message_to_decode = $mailParts[2];
		$$message_to_decode = str_replace('Content-Transfer-Encoding: quoted-printable', '', $message_to_decode);
		$letter_html = quoted_printable_decode($message_to_decode);
	} else {
		$letter_html = str_replace('Content-Type: text/html; charset="UTF-8"', '', $mailParts[2]);
	}

	// echo $letter_html;
} else {
	$mailParts = explode("\n\n", $email);
	foreach ($mailParts as $k => $v) {
		if ($k > 0) {
			echo $v . "\n\n";
		}
	}
}
*/




// $handler=fopen('pipe.txt','w');
// fwrite($handler,$email);
// fclose($handler);
// #!/usr/local/bin/php -q
// #!/usr/bin/php -q


$pdo = new PDO("sqlite:inc/xtempmail.db");
$_Email = base64_encode($email);
$execute=$pdo->query("INSERT INTO `emails` VALUES (NULL,'$_Receiver','$_Sender','$_Subject','$_Date','$_Email')");
if (!$execute) {
	$handler=fopen('error.txt','a');
	fwrite($handler,$_Email."\n\n\n-------------------------------------------\n\n\n");
	fclose($handler);
}

// $this_prepare = $pdo->prepare("INSERT INTO `emails` VALUES (NULL,':xReceiver',':xSender',':xSubject',':xDate',':xEmail')");
// $this_execute = $this_prepare->execute(array(':xReceiver' => $_Receiver,':xSender' => $_Sender,':xSubject' => $_Subject,':xDate' => $_Date,':xEmail' => base64_encode($email)));
// if (!$this_execute) {
// 	$handler=fopen('error.txt','a');
// 	fwrite($handler,$email."\n\n\n-------------------------------------------\n\n\n");
// 	fclose($handler);
// }


// $statt_vbv = $pdo->query("SELECT count(id) FROM `creditcards` WHERE `vbv_holder`!=''")->fetchColumn();
// $statt_vbv_all = $pdo->query("SELECT `cc` FROM `creditcards`")->fetchAll(PDO::FETCH_ASSOC);

?>