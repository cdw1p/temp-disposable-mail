<?php
$pdo = new PDO("sqlite:inc/xtempmail.db");
$email = $pdo->query("SELECT * FROM `emails` WHERE `id`='$source_id'")->fetch(PDO::FETCH_ASSOC);

echo '<pre>'.htmlentities(base64_decode($email['message'])).'</pre>';