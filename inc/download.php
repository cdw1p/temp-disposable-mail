<?php
$pdo = new PDO("sqlite:inc/xtempmail.db");
$email = $pdo->query("SELECT * FROM `emails` WHERE `id`='$source_id'")->fetch(PDO::FETCH_ASSOC);

$filename = $email['id'].'_'.preg_replace('/[^a-z0-9\-\_\.]/i','',$email['subject']);

header("Cache-Control: ");
header("Content-type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'.txt"');

echo base64_decode($email['message']);

?>