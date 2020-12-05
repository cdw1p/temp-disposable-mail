<?php
@session_name('xTempMail');
@session_start();
$domain = $_SERVER["HTTP_HOST"];
$RemoveEmail = $_SESSION['email'];
if (file_exists('inc/xtempmail.db')) {
    $pdo = new PDO("sqlite:inc/xtempmail.db");
}else{
    $pdo = new PDO("sqlite:xtempmail.db");
}

if ($create_new == true) {
    $pdo->query("DELETE FROM `emails` WHERE `to` LIKE '%$RemoveEmail%'");
}
$emailNotEmpty = true;
function getUser() {
    $letters   = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $rand_user = "";
    for ($i = 0; $i < 10; $i++) {
        $c_rnd     = rand(0, 35);
        $rand_user = $rand_user . $letters[$c_rnd];
    }
    return $rand_user;
}

while ($emailNotEmpty) {
    $tryEmail = getUser() . "@" . $domain;
    $counter  = $pdo->query("SELECT count(id) FROM `emails` WHERE `to`='$tryEmail'")->fetchColumn();
    if ($counter == 0) {
        $_SESSION['email'] = $tryEmail;
        if ((isset($_COOKIE['email']) && $_COOKIE['email'] != '')) {
        	setcookie('email', base64_encode($tryEmail), time() + (86400 * 30), "/");
		}else{
		    // setcookie('email', "", time() - (86400 * 5), "/");
        	setcookie('email', base64_encode($tryEmail), time() + (86400 * 30), "/");
		}
        $emailNotEmpty     = false;
        // echo $tryEmail;
    }
}
?>